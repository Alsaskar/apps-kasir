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

        $this->form_validation->set_rules('barcodeInput', '', 'required', array(
            'required' => 'Tidak boleh kosong',
        ));

        if($this->form_validation->run()){

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
                redirect('barang/add-proses/'.$kode);
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

        $this->form_validation->set_rules('barcodeInput', '', 'required', array(
            'required' => 'Tidak boleh kosong',
        ));

        if($this->form_validation->run()){

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
                redirect('barang/add-proses/'.$kode);
            }
        }
		$this->load->view('pages/barang/qr', $data);
    }

    public function addProses($id){

        $data['title'] = "Tambah Barang Baru";
		$data['getUser'] = $this->AuthModel->getDataLoggedIn($_SESSION['id_user']);
        $data['barang'] = $this->BarangModel->getBarang($_SESSION['id_user']);

        if ($data['getUser']->role != 'owner')
			redirect('dashboard');

        $this->form_validation->set_rules('barCode', '', 'required', array(
            'required' => 'Tidak boleh kosong',
        ));
        $this->form_validation->set_rules('namaBarang', '', 'required', array(
            'required' => 'Tidak boleh kosong',
        ));
        $this->form_validation->set_rules('harga', '', 'required', array(
            'required' => 'Tidak boleh kosong',
            'is_unique' => 'Tidak boleh kosong',
        ));
        $this->form_validation->set_rules('stok', '', 'required', array(
            'required' => 'Tidak boleh kosong',
        ));
        $this->form_validation->set_rules('deskripsi', '', 'required', array(
            'required' => 'Tidak boleh kosong',
        ));
        $this->form_validation->set_rules('customFile', '', 'callback_checkThumbnail');

        if($this->form_validation->run()){

            $this->session->set_flashdata('msg_sweetalert', '<script>Swal.fire({
                title: "Berhasil",
                text: "Data Barang diTambahkan",
                icon: "success",})</script>'
            );

            $config['upload_path']   = 'assets/images/barang/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size']      = 3000000; // 3mb
            $config['file_name']     = time() . '_' . rand();
            $this->load->library('upload', $config);
         
            $this->upload->do_upload('customFile');
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
            
            redirect('barang/create');
        }else{
            $this->load->view('templates/dashboard/head', $data);
            $this->load->view('templates/dashboard/navbar', $data);
    
    
            $data['sidebar'] = $this->load->view('templates/dashboard/sidebarOwner', $data, true);
            $this->load->view('pages/barang/add', $data);
    
            $this->load->view('templates/dashboard/footer');
        }
    }

    public function prosesUpdate($id){
        redirect('dashboard');

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

    public function checkThumbnail($str){
        $allowed_mime_type_arr = array('image/jpeg', 'image/png');
        $mime = get_mime_by_extension($_FILES['customFile']['name']);
        $maxsize = 3000000; // 3 mb
 
        if (isset($_FILES['customFile']['name']) && $_FILES['customFile']['name'] != "") {
            if (in_array($mime, $allowed_mime_type_arr)) {
                if ($_FILES['customFile']['size'] >= $maxsize) {
                    $this->form_validation->set_message('checkThumbnail', 'Terlalu besar. Maximal 3 MB');
                    return false;
                }else{
                    return true;
                }
            }else{
                $this->form_validation->set_message('checkThumbnail', 'Harus berupa jpg atau png');
                return false;
            }
        }else{
            $this->form_validation->set_message('checkThumbnail', 'Tidak boleh kosong');
            return false;
        }
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
                'id' => $this->input->post('id'),
                    'stok' => $stok,
                    'gambar' => $thumbnail['file_name'],
                    'deskripsi' => nl2br($deskripsi)
                );
                
                $this->BarangModel->updateBarang($dataBarang);
        
                $this->session->set_flashdata('msg_sweetalert', '<script>Swal.fire({
                    title: "Berhasil",
                    text: "Data Barang di Update",
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
                'id' => $this->input->post('id'),
                'stok' => $stok,
                'deskripsi' => nl2br($deskripsi)
            );
            
            $this->BarangModel->updateBarang($dataBarang);
    
            $this->session->set_flashdata('msg_sweetalert', '<script>Swal.fire({
                title: "Berhasil",
                text: "Data Barang Berhasil diUpdate",
                icon: "success",})</script>'
            );
        }

        redirect('barang/daftar-barang');

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