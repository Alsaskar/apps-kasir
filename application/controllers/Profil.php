<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*

Profil Controller

# semua yang berhubungan dengan profil
# Profil Kasir, Profil Owner Toko, dan Profil Teknisi

*/

class Profil extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(['AuthModel', 'UserModel', 'KaryawanModel', 'OwnerModel']);

		// jika belum login, tdk bisa kesini
		if (!isset($_SESSION['logged_in'])) {
			redirect('/');
		}
	}

    public function teknisi(){
        $data['title'] = "Profil";
		$data['getUser'] = $this->AuthModel->getDataLoggedIn($_SESSION['id_user']);
        $data['getKaryawan'] = $this->KaryawanModel->getById($_SESSION['id_user']);

		// jika bukan teknisi yg login, maka tdk bisa kesini
		if ($data['getKaryawan']->status_karyawan != 'teknisi')
			redirect('dashboard');

		// jika tombol upload foto di klik
		if(isset($_POST['uploadFoto'])){
			$config['upload_path']   = 'assets/images/profile/';
			$config['allowed_types'] = 'jpg|png';
			$config['max_size']      = 3000000; // 3mb
			$config['file_name']	 = time().'_'.rand(); // random filename
			$this->load->library('upload', $config);

			$this->upload->do_upload('fotoProfil');
			$foto = $this->upload->data();

			$this->KaryawanModel->updateKaryawan(array(
				'userId' => $_SESSION['id_user'],
				'photo_karyawan' => $foto['file_name'],
			));

			$this->session->set_flashdata('msg_sweetalert', '<script>Swal.fire({
				title: "",
				text: "Foto berhasil di upload",
				icon: "success",})</script>'
			);

            redirect('teknisi/profil');
		}

		$this->load->view('templates/dashboard/head', $data);
		$this->load->view('templates/dashboard/navbar', $data);

		$data['sidebar'] = $this->load->view('templates/dashboard/sidebarKaryawan', $data, true);
		$this->load->view('pages/karyawan/profilTeknisi', $data);

		$this->load->view('templates/dashboard/footer');
    }

	// profil owner atau pemilik toko
	public function owner(){
		$data['title'] = "Profil";
		$data['getUser'] = $this->AuthModel->getDataLoggedIn($_SESSION['id_user']);
        $data['getOwner'] = $this->OwnerModel->getByUserId($_SESSION['id_user']);

		// jika bukan owner yg login, maka tdk bisa kesini
		if ($data['getUser']->role != 'owner')
			redirect('dashboard');

		$this->form_validation->set_rules('firstname', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		$this->form_validation->set_rules('lastname', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		$this->form_validation->set_rules('nama_toko', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		$this->form_validation->set_rules('no_hp', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		$this->form_validation->set_rules('tipe_toko', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		$this->form_validation->set_rules('slogan_toko', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		$this->form_validation->set_rules('alamat_toko', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		$this->form_validation->set_rules('bankName', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		$this->form_validation->set_rules('bankBranch', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		$this->form_validation->set_rules('bankAccountNumber', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		$this->form_validation->set_rules('bankAccountName', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));

		// jika tombol upload foto di klik
		if(isset($_POST['uploadFoto'])){
			$config['upload_path']   = 'assets/images/logo-toko/';
			$config['allowed_types'] = 'jpg|png';
			$config['max_size']      = 3000000; // 3mb
			$config['file_name']	 = time().'_'.rand(); // random filename
			$this->load->library('upload', $config);

			$this->upload->do_upload('fotoProfil');
			$foto = $this->upload->data();

			$this->OwnerModel->updateProfil($_SESSION['id_user'], array(
				'photo_toko' => $foto['file_name'],
			));

			$this->session->set_flashdata('msg_sweetalert', '<script>Swal.fire({
				title: "",
				text: "Foto berhasil di upload",
				icon: "success",})</script>'
			);

            redirect('owner/profil');
		}

		if($this->form_validation->run()){
			$firstname = htmlspecialchars($this->input->post('firstname'));
			$lastname = htmlspecialchars($this->input->post('lastname'));
			$nama_toko = htmlspecialchars($this->input->post('nama_toko'));
			$no_hp = htmlspecialchars($this->input->post('no_hp'));
			$tipe_toko = htmlspecialchars($this->input->post('tipe_toko'));
			$slogan_toko = htmlspecialchars($this->input->post('slogan_toko'));
			$alamat_toko = htmlspecialchars($this->input->post('alamat_toko'));
			$bankName = htmlspecialchars($this->input->post('bankName'));
			$bankBranch = htmlspecialchars($this->input->post('bankBranch'));
			$bankAccountNumber = htmlspecialchars($this->input->post('bankAccountNumber'));
			$bankAccountName = htmlspecialchars($this->input->post('bankAccountName'));

			// update user
			$this->UserModel->updateUser(array(
				'id' => $_SESSION['id_user'],
				'firstname' => $firstname,
				'lastname' => $lastname
			));

			// update owner
			$this->OwnerModel->updateProfil($_SESSION['id_user'], array(
				'nama_toko' => $nama_toko,
				'no_hp' => $no_hp,
				'tipe_toko' => $tipe_toko,
				'slogan_toko' => $slogan_toko,
				'alamat_toko' => $alamat_toko,
				'bankName' => $bankName,
				'bankBranch' => $bankBranch,
				'bankAccountNumber' => $bankAccountNumber,
				'bankAccountName' => $bankAccountName,
			));

			$this->session->set_flashdata('msg_sweetalert', '<script>Swal.fire({
				title: "",
				text: "Profil berhasil di ubah",
				icon: "success",})</script>'
			);

            redirect('owner/profil');
		}else{
			$this->load->view('templates/dashboard/head', $data);
			$this->load->view('templates/dashboard/navbar', $data);

			$data['sidebar'] = $this->load->view('templates/dashboard/sidebarOwner', $data, true);
			$this->load->view('pages/owner/profil', $data);

			$this->load->view('templates/dashboard/footer');
		}
	}

}