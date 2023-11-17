<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(['AuthModel', 'UserModel','KaryawanModel', 'OwnerModel', 'NotaModel']);

		// jika belum login, tdk bisa kesini
		if (!isset($_SESSION['logged_in'])) {
			redirect('/');
		}
	}

	public function index(){
        $_SESSION['index1'] = 1;
		$data['title'] = "Dashboard BaDag";
		$data['getUser'] = $this->AuthModel->getDataLoggedIn($_SESSION['id_user']);
		

		$this->load->view('templates/dashboard/head', $data);
		$this->load->view('templates/dashboard/navbar', $data);

		if ($data['getUser']->role == 'admin') { // jika admin

			$data['sidebar'] = $this->load->view('templates/dashboard/sidebarAdmin', $data, true);
			$this->load->view('pages/dashboard/admin', $data);
			
		}else if ($data['getUser']->role == 'karyawan') { // jika karyawan

			$data['getKaryawan'] = $this->KaryawanModel->getById($_SESSION['id_user']);
			$data['getOwner'] = $this->OwnerModel->getById($data['getKaryawan']->ownerId);

			// status service
			$data['serviceProses'] = $this->NotaModel->countServiceByStatus('proses', $data['getKaryawan']->id);
			$data['serviceBatal'] = $this->NotaModel->countServiceByStatus('batal', $data['getKaryawan']->id);
			$data['serviceSelesai'] = $this->NotaModel->countServiceByStatus('selesai', $data['getKaryawan']->id);

			$data['sidebar'] = $this->load->view('templates/dashboard/sidebarKaryawan', $data, true);
			$this->load->view('pages/dashboard/karyawan', $data);

		}else if ($data['getUser']->role == 'owner') { // jika owner

			$data['sidebar'] = $this->load->view('templates/dashboard/sidebarOwner', $data, true);
			$this->load->view('pages/dashboard/owner', $data);

		}

		$this->load->view('templates/dashboard/footer');
	}

	public function change_pass(){
		$data['title'] = "Ganti Password";
		$data['getUser'] = $this->AuthModel->getDataLoggedIn($_SESSION['id_user']);
		$data['getKaryawan'] = $this->KaryawanModel->getById($_SESSION['id_user']);

		$this->form_validation->set_rules('pass_old', '', 'required', array(
			'required' => 'password lama tidak boleh kosong',
		));
		$this->form_validation->set_rules('pass_new', '', 'required|min_length[5]|max_length[30]', array(
			'required' => 'password baru tidak boleh kosong',
			'min_length' => 'password baru terlalu pendek. minimal 5 karakter',
			'max_length' => 'password baru terlalu panjang. Maximal 15 karakter'
		));
		$this->form_validation->set_rules('confirm_pass_new', '', 'required|min_length[5]|max_length[30]', array(
			'required' => 'konfirmasi password baru tidak boleh kosong',
			'min_length' => 'konfirmasi password baru terlalu pendek. minimal 5 karakter',
			'max_length' => 'konfirmasi password baru terlalu panjang. Maximal 15 karakter'
		));

		if ($this->form_validation->run()) {
			$pass_old = htmlspecialchars($this->input->post('pass_old'));
			$pass_new = htmlspecialchars($this->input->post('pass_new'));
			$confirm_pass_new = htmlspecialchars($this->input->post('confirm_pass_new'));

			if (password_verify($pass_old, $data['getUser']->password)) { // jika pass lama sesuai di db
				if ($pass_new == $confirm_pass_new) { // jika pass new = confir pass new

					$this->load->model('UserModel');
					$this->UserModel->changePass(password_hash($pass_new, PASSWORD_DEFAULT), $_SESSION['id_user']);

					$this->session->set_flashdata('msg_sweetalert', '<script>Swal.fire({
		  				title: "",
		  				text: "Password telah berhasil di ubah. Silahkan login kembali.",
		  				icon: "success",})</script>'
		  			);

		  			// mematikan session
		  			unset($_SESSION['id_user']);
		  			unset($_SESSION['role']);
		  			unset($_SESSION['logged_in']);

		  			redirect('/');
				}else{ // jika tidak sama dengan
					$this->session->set_flashdata('msg_sweetalert', '<script>Swal.fire({
		  				title: "",
		  				text: "Password baru tidak sama dengan kofirmasi password.",
		  				icon: "error",})</script>'
		  			);

		  			redirect('change-pass');
				}
			}else{ // jika tidak sesuai
				$this->session->set_flashdata('msg_sweetalert', '<script>Swal.fire({
	  				title: "",
	  				text: "Password lama tidak cocok.",
	  				icon: "error",})</script>'
	  			);
 
	  			redirect('change-pass');
			}
		}else{
			$this->load->view('templates/dashboard/head', $data);
			$this->load->view('templates/dashboard/navbar', $data);

			if ($data['getUser']->role == 'admin') {
				$data['sidebar'] = $this->load->view('templates/dashboard/sidebarAdmin', $data, true);
				$this->load->view('pages/dashboard/change_pass', $data);
			}else if ($data['getUser']->role == 'karyawan') {
				$data['sidebar'] = $this->load->view('templates/dashboard/sidebarKaryawan', $data, true);
				$this->load->view('pages/dashboard/change_pass', $data);
			}else if ($data['getUser']->role == 'owner') {
				$data['sidebar'] = $this->load->view('templates/dashboard/sidebarOwner', $data, true);
				$this->load->view('pages/dashboard/change_pass', $data);
			}


			$this->load->view('pages/dashboard/change_pass', $data);
			$this->load->view('templates/dashboard/footer');
		}
	}

	public function logout(){
		session_destroy();
		redirect('/');
	}

}
