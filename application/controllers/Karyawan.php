<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(['AuthModel', 'KaryawanModel', 'UserModel']);

		// jika belum login, tdk bisa kesini
		if (!isset($_SESSION['logged_in'])) {
			redirect('/');
		}
	}

	// ini untuk halaman admin, hanya admin yang bisa akses halaman ini
	public function list(){
		$data['title'] = "Data Karyawan";
		$data['getUser'] = $this->AuthModel->getDataLoggedIn($_SESSION['id_user']);

		// jika bukan admin yg login, maka tdk bisa kesini
		if ($data['getUser']->role != 'owner')
			redirect('dashboard');

		$this->load->view('templates/dashboard/head', $data);
		$this->load->view('templates/dashboard/navbar', $data);

		$data['sidebar'] = $this->load->view('templates/dashboard/sidebarOwner', $data, true);
		$this->load->view('pages/karyawan/daftar', $data);

		$this->load->view('templates/dashboard/footer');
	}

	// API LIST -> Server Side Datatable
	public function listApi(){
		$list = $this->KaryawanModel->get_datatables();
		$data = array();
		$no = $_POST['start'];

        foreach($list as $karyawan){
			$no++;
			$row = array();

			$row[] = $no;
			$row[] = $karyawan->firstname." ".$karyawan->lastname;
			$row[] = $karyawan->email;
			$row[] = $karyawan->no_hp;
			$row[] = $karyawan->status_karyawan;
			
			$edit = base_url("karyawan/edit/".$karyawan->userId);
			$hapus = base_url("karyawan/delete/".$karyawan->userId);
			$row[] = "<div>
            <a class='btn btn-primary' href='$edit'>Edit</a>
            <a class='btn btn-danger ml-2' href='$hapus'>Hapus</a>
            ";
			$data[] = $row;
		}

		$output = array(
	        "draw" => $_POST['draw'],
	        "recordsTotal" => $this->KaryawanModel->count_all(),
	        "recordsFiltered" => $this->KaryawanModel->count_filtered(),
	        "data" => $data,
	    );

	    //output to json format
        echo json_encode($output);
	}


	//update 

	public function addkaryawan(){
		$data['title'] = "Tambah Karyawan";
		$data['getUser'] = $this->AuthModel->getDataLoggedIn($_SESSION['id_user']);

		if($data['getUser']->role != 'owner')
			redirect('dashboard');

		$this->form_validation->set_rules('firstName', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		$this->form_validation->set_rules('lastName', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		$this->form_validation->set_rules('email', '', 'required|is_unique[user.email]', array(
			'required' => 'Tidak boleh kosong',
			'is_unique' => 'Email telah digunakan',
		));
		$this->form_validation->set_rules('password', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		$this->form_validation->set_rules('statusKaryawan', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		$this->form_validation->set_rules('phoneNumber', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));

		if($this->form_validation->run()){
			
			$this->session->set_flashdata('msg_sweetalert', '<script>Swal.fire({
				title: "Berhasil",
				text: "Pegawai Berhasil diTambahkan",
				icon: "success",})</script>'
			);

			redirect('/karyawan/add-karyawan');
		}else{
			$this->load->view('templates/dashboard/head', $data);
			$this->load->view('templates/dashboard/navbar', $data);

			$data['sidebar'] = $this->load->view('templates/dashboard/sidebarOwner', $data, true);
			$this->load->view('pages/karyawan/tambah', $data);

			$this->load->view('templates/dashboard/footer');
		}
	}
    
    public function edit($id){
        $data['title'] = "Detail Karyawan";
		$data['getUser'] = $this->AuthModel->getDataLoggedIn($_SESSION['id_user']);
        $data['karyawan'] = $this->KaryawanModel->getbyId($id);
        $data['user'] = $this->UserModel->getbyId($id);

		// jika bukan admin yg login, maka tdk bisa kesini
		if ($data['getUser']->role != 'owner')
			redirect('dashboard');

		$this->load->view('templates/dashboard/head', $data);
		$this->load->view('templates/dashboard/navbar', $data);

		$data['sidebar'] = $this->load->view('templates/dashboard/sidebarOwner', $data, true);
		$this->load->view('pages/karyawan/detail', $data);
        
		$this->load->view('templates/dashboard/footer');

        if(isset($_POST['simpan'])){

            if(!empty($_POST['password'])) { // dengan password 
                $password = $_POST['password'];
            }else { // tidak dengan password
                $password = $_POST['password_lama'];
            }
            $file = $_FILES["profilePictureInput"];
            $profile = $_POST['profilePictureInput_lama'];

            if(!empty($file['name'])) { // dengan profile

                $file_name = $_FILES['profilePictureInput']['name'];
                $file_tmp = $_FILES['profilePictureInput']['tmp_name'];
                
                $ekstensiGambarValid = ['jpg','jpeg','png'];
                $ekstensiGambar = explode('.',$file_name);
                $ekstensiGambar = strtolower(end($ekstensiGambarValid));

                $imageSize = getimagesize($file["tmp_name"]);
                if ($imageSize === false) {
                    $this->session->set_flashdata('msg_sweetalert', '<script>Swal.fire({
                        title: "Gagal",
                        text: "yang Anda Masukkan Bukan Gambar",
                        icon: "error",})</script>'
                    );
                    redirect("/karyawan/edit/".$id);
                }
                
                $maxFileSize = 5 * 1024 * 1024;
                // Periksa ukuran file
                if ($file["size"] > $maxFileSize) {
                    $this->session->set_flashdata('msg_sweetalert', '<script>Swal.fire({
                        title: "Gagal",
                        text: "File Berukuran Lebih dari 5Mb",
                        icon: "error",})</script>'
                    );
                    redirect("/karyawan/edit/".$id);
                }

                //nama file baru
                $namaFileBaru = uniqid();
                $namaFileBaru .='.';
                $namaFileBaru .= $ekstensiGambar;
                $this->KaryawanModel->delete_image($_POST['profilePictureInput_lama']);
                $url = FCPATH . 'assets/images/profile/';
				
                if(move_uploaded_file($file_tmp, $url . $namaFileBaru)){
                    $profile = $namaFileBaru;
                    $data = array(
                        'userId' => $id,
                        'photo_karyawan' => $namaFileBaru
                    );
                    $this->KaryawanModel->updateProfile($data);
                }else{
                    $this->session->set_flashdata('msg_sweetalert', '<script>Swal.fire({
                        title: "Gagal",
                        text: "Terjadi Kesalahan dalam Proses Upload Gambar",
                        icon: "error",})</script>'
                    );
                    redirect("/karyawan/edit/".$id);
                }
               
            }

            $dataUser = array(
				'id' => $id,
                'firstname' => $_POST['firstName'],
                'lastname' => $_POST['lastName'],
                'email' => $_POST['email'],
                'password' => $password,
                'verified_email' => $_POST['status_aktif']
            );

            $dataKaryawan = array(
                'userId' => $id,
                'nama_karyawan' => $_POST['firstName'] . $_POST['lastName'],
                'status_karyawan' => $_POST['jabatan'],
                'no_hp' => $_POST['phone']
            );

            $this->KaryawanModel->updateKaryawan($dataKaryawan);
            $this->UserModel->updateUser($dataUser);
                $this->session->set_flashdata('msg_sweetalert', '<script>Swal.fire({
                    title: "Berhasil",
                    text: "Data Karyawan diPerbarui",
                    icon: "success",})</script>'
                );
                redirect("/karyawan/edit/".$id);
        }
		
    }

	public function deleteData($id){
		$dataKaryawan = $this->KaryawanModel->getById($id);
		$this->KaryawanModel->delete_image($dataKaryawan->photo_karyawan);
		$this->KaryawanModel->deleteData($id);
		$this->UserModel->deleteData($id);
		redirect('karyawan/list');
	}

	public function delete($id){
		$data['title'] = "Hapus Karyawan";
		$data['getUser'] = $this->AuthModel->getDataLoggedIn($_SESSION['id_user']);
		$data['karyawan'] = $this->KaryawanModel->getbyId($id);
		$data['id'] = $id;
		$data['user'] = $this->UserModel->getbyId($id);

		// jika bukan admin yg login, maka tdk bisa kesini
		if ($data['getUser']->role != 'owner')
			redirect('dashboard');

		$this->load->view('templates/dashboard/head', $data);
		$this->load->view('templates/dashboard/navbar', $data);

		$data['sidebar'] = $this->load->view('templates/dashboard/sidebarOwner', $data, true);
		$this->load->view('pages/karyawan/hapus', $data);
		
		$this->load->view('templates/dashboard/footer');

	}


}