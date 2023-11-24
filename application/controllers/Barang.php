<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(['AuthModel', 'BarangModel']);

		// jika belum login, tdk bisa kesini
		if (!isset($_SESSION['logged_in'])) {
			redirect('/');
		}
	}

	public function index(){
        $data['title'] = "Daftar Barang";
		$data['getUser'] = $this->AuthModel->getDataLoggedIn($_SESSION['id_user']);
        $data['barang'] = $this->BarangModel->getBarang($_SESSION['id_user']);
		// jika bukan admin yg login, maka tdk bisa kesini
		if ($data['getUser']->role != 'owner')
			redirect('dashboard');

		$this->load->view('templates/dashboard/head', $data);
		$this->load->view('templates/dashboard/navbar', $data);

		$data['sidebar'] = $this->load->view('templates/dashboard/sidebarOwner', $data, true);
		$this->load->view('pages/barang/daftar', $data);

		$this->load->view('templates/dashboard/footer');
	}

    public function add(){
        $data['title'] = "Tambah Barang";
		$data['getUser'] = $this->AuthModel->getDataLoggedIn($_SESSION['id_user']);

		// jika bukan admin yg login, maka tdk bisa kesini
		if ($data['getUser']->role != 'owner')
			redirect('dashboard');

		$this->load->view('templates/dashboard/head', $data);
		$this->load->view('templates/dashboard/navbar', $data);

		$data['sidebar'] = $this->load->view('templates/dashboard/sidebarOwner', $data, true);
        $data['display'] = $this->load->view('templates/barang/default', $data, true);

		$this->load->view('templates/dashboard/footer');

        if(isset($_POST['checkProduct'])){
            $kode = $this->input->post('barcodeInput');
            if (strpos($kode, '(') !== false || strpos($kode, ')') !== false) {
                redirect('barang/add');
            }
		    $_SESSION['barcode'] = $kode;
            $isRegistered = $this->BarangModel->isIdRegistered($kode);
            if ($isRegistered) {
                $this->cekDanJalankanAksi($kode);
                $data['barang'] = $this->BarangModel->getbyId($kode);
		        $data['display'] = $this->load->view('templates/barang/detail', $data, true);
            } else {
                $data['display'] = $this->load->view('templates/barang/add', $data, true);
            }
        }
		$this->load->view('pages/barang/qr', $data);
    }

    public function Create(){
        $data['title'] = "Buat atau Edit Barang";
		$data['getUser'] = $this->AuthModel->getDataLoggedIn($_SESSION['id_user']);

		// jika bukan admin yg login, maka tdk bisa kesini
		if ($data['getUser']->role != 'owner')
			redirect('dashboard');

		$this->load->view('templates/dashboard/head', $data);
		$this->load->view('templates/dashboard/navbar', $data);

		$data['sidebar'] = $this->load->view('templates/dashboard/sidebarOwner', $data, true);
        $data['display'] = $this->load->view('templates/barang/defaultcreate', $data, true);

		$this->load->view('templates/dashboard/footer');

        if(isset($_POST['checkProduct'])){
            $kode = $this->input->post('barcodeInput');
            if (strpos($kode, '(') !== false || strpos($kode, ')') !== false) {
                redirect('barang/create');
            }
		    $_SESSION['barcode'] = $kode;
            $isRegistered = $this->BarangModel->isIdRegistered($kode);
            if ($isRegistered) {
                $data['barang'] = $this->BarangModel->getbyId($kode);
		        $data['display'] = $this->load->view('templates/barang/detail', $data, true);
            } else {
                $data['display'] = $this->load->view('templates/barang/add', $data, true);
            }
        }
		$this->load->view('pages/barang/qr', $data);
    }

    public function cekDanJalankanAksi($produkId) {
        if (!isset($_SESSION['produk_counter'])) {
            $_SESSION['produk_counter'] = array();
        }
        // Mengecek apakah produkId sudah ada dalam array
        if (isset($_SESSION['produk_counter'][$produkId])) {
            // Produk telah diperiksa sebanyak dua kali
            $_SESSION['produk_counter'][$produkId]++;
            if ($_SESSION['produk_counter'][$produkId] === 2) {
                // Menjalankan fungsi tertentu karena produk diperiksa dua kali
                $this->BarangModel->tambahStok($_SESSION['barcode']);
                $_SESSION['produk_counter'][$produkId] = 1;
            }
        } else {
            // Produk baru diperiksa pertama kali
            $_SESSION['produk_counter'][$produkId] = 1;
        }
    }
    
    public function detail($id){
        $data['title'] = "Detail Barang";
		$data['getUser'] = $this->AuthModel->getDataLoggedIn($_SESSION['id_user']);
        $data['barang'] = $this->BarangModel->getbyId($id);

		// jika bukan admin yg login, maka tdk bisa kesini
		if ($data['getUser']->role != 'owner')
			redirect('dashboard');

		$this->load->view('templates/dashboard/head', $data);
		$this->load->view('templates/dashboard/navbar', $data);

		$data['sidebar'] = $this->load->view('templates/dashboard/sidebarOwner', $data, true);
		$this->load->view('pages/barang/detail', $data);

		$this->load->view('templates/dashboard/footer');
    }

    public function tambah(){
        $config['upload_path']   = 'assets/images/barang/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size']      = 3000000; // 3mb
        $config['file_name']     = time() . '_' . rand(); // random filename
        $this->load->library('upload', $config);
    
        if ($this->upload->do_upload('customFile')) {
            $thumbnail = $this->upload->data();
    
            $namaBarang = $this->input->post('namaBarang');      
            $harga = $this->input->post('harga');
            $stok = $this->input->post('stok');
            $deskripsi = $this->input->post('deskripsi');
    
            $dataBarang = array(
                'userId' => $_SESSION['id_user'],
                'nama_barang' => $namaBarang,
                'harga' => $harga,
                'id' => isset($_SESSION['barcode']) ? $_SESSION['barcode'] : null,
                'stok' => $stok,
                'gambar' => $thumbnail['file_name'],
                'deskripsi' => nl2br($deskripsi)
            );
    
            $this->BarangModel->addBarang($dataBarang);
            $this->session->set_flashdata('msg_sweetalert', '<script>Swal.fire({
                title: "Berhasil",
                text: "Data Barang diTambahkan",
                icon: "success",})</script>'
            );
        } else {
            // Gagal unggah, berikan pesan kesalahan
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('msg_sweetalert', '<script>Swal.fire({
                title: "Gagal",
                text: "Error: ' . $error . '",
                icon: "error",})</script>'
            );
        }
    
        redirect('barang/add');
    }

    public function edit(){
        $customFile = $_FILES['customFile'];

        if (!empty($customFile['name'])) {
            $config['upload_path']   = 'assets/images/barang/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size']      = 3000000; // 3mb
            $config['file_name']     = time() . '_' . rand(); // random filename
            $this->load->library('upload', $config);
        
            if ($this->upload->do_upload('customFile')) {
                $thumbnail = $this->upload->data();
        
                $namaBarang = $this->input->post('namaBarang');      
                $harga = $this->input->post('harga');
                $stok = $this->input->post('stok');
                $deskripsi = $this->input->post('deskripsi');
                
                $this->BarangModel->deleteImage($this->input->post('old-img'));
                $dataBarang = array(
                    'userId' => $_SESSION['id_user'],
                    'nama_barang' => $namaBarang,
                    'harga' => $harga,
                    'id' => isset($_SESSION['barcode']) ? $_SESSION['barcode'] : null,
                    'stok' => $stok,
                    'gambar' => $thumbnail['file_name'],
                    'deskripsi' => nl2br($deskripsi)
                );
                
                $this->BarangModel->updateBarang($dataBarang);
        
                $this->session->set_flashdata('msg_sweetalert', '<script>Swal.fire({
                    title: "Berhasil",
                    text: "Data Barang diTambahkan",
                    icon: "success",})</script>'
                );
            } else {
                // Gagal unggah, berikan pesan kesalahan
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('msg_sweetalert', '<script>Swal.fire({
                    title: "Gagal",
                    text: "Error: ' . $error . '",
                    icon: "error",})</script>'
                );
            }
        } else {
            $namaBarang = $this->input->post('namaBarang');      
            $harga = $this->input->post('harga');
            $stok = $this->input->post('stok');
            $deskripsi = $this->input->post('deskripsi');
            $dataBarang = array(
                'userId' => $_SESSION['id_user'],
                'nama_barang' => $namaBarang,
                'harga' => $harga,
                'id' => isset($_SESSION['barcode']) ? $_SESSION['barcode'] : null,
                'stok' => $stok,
                'deskripsi' => nl2br($deskripsi)
            );
            
            $this->BarangModel->updateBarang($dataBarang);
    
            $this->session->set_flashdata('msg_sweetalert', '<script>Swal.fire({
                title: "Berhasil",
                text: "Data Barang diTambahkan",
                icon: "success",})</script>'
            );
        }
        redirect('barang/add');

    }

    public function checkGambar($str){
        $allowed_mime_type_arr = array('image/jpeg', 'image/png');
        $mime = get_mime_by_extension($_FILES['gambar']['name']);
        $maxsize = 3000000; // 3 mb
 
        if (isset($_FILES['gambar']['name']) && $_FILES['gambar']['name'] != "") {
            if (in_array($mime, $allowed_mime_type_arr)) {
                if ($_FILES['gambar']['size'] >= $maxsize) {
                    $this->form_validation->set_message('checkGambar', 'Terlalu besar. Maximal 3 MB');
                    return false;
                }else{
                    return true;
                }
            }else{
                $this->form_validation->set_message('checkGambar', 'Harus berupa jpg atau png');
                return false;
            }
        }else{
            $this->form_validation->set_message('checkGambar', 'Tidak boleh kosong');
            return false;
        }
    }

}