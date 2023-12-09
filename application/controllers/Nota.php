<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nota extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(['AuthModel', 'UserModel', 'KaryawanModel', 'NotaModel', 'OwnerModel']);

		// jika belum login, tdk bisa kesini
		if (!isset($_SESSION['logged_in'])) {
			redirect('/');
		}
	}

	public function edit($id){
        $data['title'] = "Edit Nota";
		$data['getUser'] = $this->AuthModel->getDataLoggedIn($_SESSION['id_user']);
		$data['getKaryawan'] = $this->KaryawanModel->getById($_SESSION['id_user']);
		$data['getNota'] = $this->NotaModel->getById($id);
		$data['lastHistory'] = $this->NotaModel->getLastHistory($id);

        if($data['getKaryawan']->status_karyawan != 'customer service')
            redirect('dashboard');

		$this->form_validation->set_rules('namaCustomer', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		$this->form_validation->set_rules('noHp', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		$this->form_validation->set_rules('alamat', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		$this->form_validation->set_rules('namaBarang', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		$this->form_validation->set_rules('imei', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		$this->form_validation->set_rules('kerusakan', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		$this->form_validation->set_rules('hargaService', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		$this->form_validation->set_rules('uangPanjar', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		$this->form_validation->set_rules('perbaikan', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		
		if($this->form_validation->run()){
			$namaCustomer = htmlspecialchars($this->input->post('namaCustomer'));
			$noHp = htmlspecialchars($this->input->post('noHp'));
			$alamat = htmlspecialchars($this->input->post('alamat'));
			$namaBarang = htmlspecialchars($this->input->post('namaBarang'));
			$imei = htmlspecialchars($this->input->post('imei'));
			$kerusakan = nl2br($this->input->post('kerusakan'));
			$hargaService = htmlspecialchars($this->input->post('hargaService'));
			$uangPanjar = htmlspecialchars($this->input->post('uangPanjar'));
			$perbaikan = htmlspecialchars($this->input->post('perbaikan'));
			$statusPembayaran = htmlspecialchars($this->input->post('statusPembayaran'));
			$statusNota = 'Nota Teknisi di Perbarui Oleh ' . $data['getUser']->firstname.' '.$data['getUser']->lastname.' sebagai '.$statusPembayaran;
			$this->NotaModel->update(array(
				'no_invoice' => $id,
				'userId' => $_SESSION['id_user'],
				'nama_customer' => $namaCustomer,
				'no_hp' => $noHp,
				'alamat' => $alamat,
				'nama_barang' => $namaBarang,
				'serial_number' => $imei,
				'kerusakan' => $kerusakan,
				'perbaikan' => $perbaikan,
				'harga_service' => $hargaService,
				'uang_muka' => $uangPanjar,
				'status_pembayaran' => $statusPembayaran
			));
			$this->NotaModel->addHistory(array(
				'no_invoice' => $id,
				'status' => $statusNota,
				'keterangan' => $data['lastHistory']->keterangan
			));
			$this->session->set_flashdata('msg_sweetalert', '<script>Swal.fire({
				title: "Berhasil",
				text: "Nota telah diUpdate",
				icon: "success",})</script>'
			);

            redirect('nota/list');
		}else{
			$this->load->view('templates/dashboard/head', $data);
			$this->load->view('templates/dashboard/navbar', $data);
			$data['sidebar'] = $this->load->view('templates/dashboard/sidebarKaryawan', $data, true);
			$this->load->view('pages/nota/edit', $data);
			$this->load->view('templates/dashboard/footer');
		}
    }

    public function add(){
        $data['title'] = "Tambahkan Nota";
		$data['getUser'] = $this->AuthModel->getDataLoggedIn($_SESSION['id_user']);
		$data['getKaryawan'] = $this->KaryawanModel->getById($_SESSION['id_user']);

        if($data['getKaryawan']->status_karyawan != 'customer service')
            redirect('dashboard');

		$this->form_validation->set_rules('namaCustomer', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		$this->form_validation->set_rules('noHp', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		$this->form_validation->set_rules('alamat', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		$this->form_validation->set_rules('namaBarang', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		$this->form_validation->set_rules('imei', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		$this->form_validation->set_rules('kerusakan', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		$this->form_validation->set_rules('hargaService', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		$this->form_validation->set_rules('uangPanjar', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		$this->form_validation->set_rules('perbaikan', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		$this->form_validation->set_rules('keterangan', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		
		if($this->form_validation->run()){
			$namaCustomer = htmlspecialchars($this->input->post('namaCustomer'));
			$noHp = htmlspecialchars($this->input->post('noHp'));
			$alamat = htmlspecialchars($this->input->post('alamat'));
			$namaBarang = htmlspecialchars($this->input->post('namaBarang'));
			$imei = htmlspecialchars($this->input->post('imei'));
			$kerusakan = nl2br($this->input->post('kerusakan'));
			$hargaService = htmlspecialchars($this->input->post('hargaService'));
			$uangPanjar = htmlspecialchars($this->input->post('uangPanjar'));
			$perbaikan = htmlspecialchars($this->input->post('perbaikan'));
			$keterangan = nl2br($this->input->post('keterangan'));
			$statusPembayaran = htmlspecialchars($this->input->post('statusPembayaran'));
			$statusNota = 'Nota Teknisi dibuat Oleh ' . $data['getUser']->firstname.' '.$data['getUser']->lastname;
			$invoice = rand().'-'. time();
			$dataKaryawan = $this->KaryawanModel->getById($_SESSION['id_user']);

			$this->NotaModel->add(array(
				'no_invoice' => $invoice,
				'userId' => $_SESSION['id_user'],
				'nama_customer' => $namaCustomer,
				'no_hp' => $noHp,
				'alamat' => $alamat,
				'nama_barang' => $namaBarang,
				'serial_number' => $imei,
				'kerusakan' => $kerusakan,
				'perbaikan' => $perbaikan,
				'harga_service' => $hargaService,
				'uang_muka' => $uangPanjar,
				'status_nota' => 'Menunggu Teknisi',
				'status_pembayaran' => $statusPembayaran,
				'ownerId' => $dataKaryawan->ownerId
			));
			$this->NotaModel->addHistory(array(
				'no_invoice' => $invoice,
				'status' => $statusNota,
				'keterangan' => $keterangan
			));
			$this->session->set_flashdata('msg_sweetalert', '<script>Swal.fire({
				title: "Berhasil",
				text: "Nota telah dibuat",
				icon: "success",})</script>'
			);

            redirect('nota/list');
		}else{
			$this->load->view('templates/dashboard/head', $data);
			$this->load->view('templates/dashboard/navbar', $data);
			$data['sidebar'] = $this->load->view('templates/dashboard/sidebarKaryawan', $data, true);
			$this->load->view('pages/nota/add', $data);
			$this->load->view('templates/dashboard/footer');
		}
    }

	public function list(){
        $data['title'] = "Data Nota";
		$data['getUser'] = $this->AuthModel->getDataLoggedIn($_SESSION['id_user']);
		$data['getKaryawan'] = $this->KaryawanModel->getById($_SESSION['id_user']);

        if($data['getKaryawan']->status_karyawan != 'customer service')
            redirect('dashboard');

		$this->load->view('templates/dashboard/head', $data);
		$this->load->view('templates/dashboard/navbar', $data);
		$data['sidebar'] = $this->load->view('templates/dashboard/sidebarKaryawan', $data, true);
		$this->load->view('pages/nota/list', $data);
		$this->load->view('templates/dashboard/footer');
    }

	// API LIST -> Server Side Datatable
	public function listApi(){
		$data['getKaryawan'] = $this->KaryawanModel->getById($_SESSION['id_user']);
		$list = $this->NotaModel->get_datatables($data['getKaryawan']->userId);
		$data = array();
		$no = $_POST['start'];

        foreach($list as $nota){
			$no++;
			$row = array();
			
			$row[] = $nota->no_invoice;
			$row[] = $nota->tanggal_masuk;
			$row[] = $nota->nama_customer;
			$row[] = $nota->status_nota;
			$row[] = $nota->status_pembayaran;
			
			if($nota->status_nota == 'dibatalkan' || $nota->status_nota == 'diambil Customer'){
				$row[] = "
            	<a href='".base_url('nota/detail/'.$nota->no_invoice)."' class='btn btn-secondary btn-sm'>Detail</a>
            ";
			}else{
				$row[] = "
				<a href='".base_url('nota/edit/'.$nota->no_invoice)."' class='btn btn-primary btn-sm'>Edit</a>
            	<a href='".base_url('nota/detail/'.$nota->no_invoice)."' class='btn btn-secondary btn-sm'>Detail</a>
            ";
			}
			$data[] = $row;
		}

		$output = array(
	        "draw" => $_POST['draw'],
	        "recordsTotal" => $this->NotaModel->count_all(),
	        "recordsFiltered" => $this->NotaModel->count_filtered(),
	        "data" => $data,
	    );

	    //output to json format
        echo json_encode($output);
	}

	public function activity($id){
		$data['title'] = "Data Nota";
		$data['getUser'] = $this->AuthModel->getDataLoggedIn($_SESSION['id_user']);
		$data['getKaryawan'] = $this->KaryawanModel->getById($_SESSION['id_user']);
		$data['getOwner'] = $this->OwnerModel->getById($data['getKaryawan']->ownerId);
		$data['getNota'] = $this->NotaModel->getById($id);
		$data['invoice'] = $id;
		$data['getHistory'] = $this->NotaModel->getHistory($id);
		$data['lastHistory'] = $this->NotaModel->getLastHistory($id);

		if($data['getKaryawan']->status_karyawan != 'customer service' && $data['getKaryawan']->status_karyawan != 'teknisi')
            redirect('dashboard');

		$this->load->view('templates/dashboard/head', $data);
		$this->load->view('templates/dashboard/navbar', $data);
		$data['sidebar'] = $this->load->view('templates/dashboard/sidebarKaryawan', $data, true);
		$this->load->view('pages/nota/activity', $data);
		$this->load->view('templates/dashboard/footer');
	}

	public function detail($id){
		$data['title'] = "Data Nota";
		$data['getUser'] = $this->AuthModel->getDataLoggedIn($_SESSION['id_user']);
		$data['getKaryawan'] = $this->KaryawanModel->getById($_SESSION['id_user']);
		$data['getOwner'] = $this->OwnerModel->getById($data['getKaryawan']->ownerId);
		$data['getNota'] = $this->NotaModel->getById($id);
		$data['invoice'] = $id;
		$data['lastHistory'] = $this->NotaModel->getLastHistory($id);

        if($data['getKaryawan']->status_karyawan != 'customer service' && $data['getKaryawan']->status_karyawan != 'teknisi' && $data['getNota']->ownerId != $_SESSION['id_user'])
            redirect('dashboard');

		if(isset($_GET['status'])){
			if($_GET['status'] == 'selesai'){
				$this->NotaModel->updateStatus($id, $_GET['status']);

				$this->session->set_flashdata('msg_sweetalert', '<script>Swal.fire({
					title: "Berhasil",
					text: "Service telah diselesaikan",
					icon: "success",})</script>'
				);
			}else if($_GET['status'] == 'batal'){
				$this->NotaModel->updateStatus($id, $_GET['status']);

				$this->session->set_flashdata('msg_sweetalert', '<script>Swal.fire({
					title: "Berhasil",
					text: "Service telah dibatalkan",
					icon: "success",})</script>'
				);
			}

            redirect('nota/list');
		}

		$this->load->view('templates/dashboard/head', $data);
		$this->load->view('templates/dashboard/navbar', $data);
		$data['sidebar'] = $this->load->view('templates/dashboard/sidebarKaryawan', $data, true);
		$this->load->view('pages/nota/detail', $data);
		$this->load->view('templates/dashboard/footer');
	}

	public function qrcode($id){
		qrCode($id);
	}
	
	public function getHistory($id){
		$history = $this->NotaModel->getHistoryById($id);
		$output = array(
			'keterangan' => $history->keterangan,
			'status' => $history->status
		);
        echo json_encode($output);
	}

	public function scan(){
		$data['title'] = "Scan Nota";
		$data['getUser'] = $this->AuthModel->getDataLoggedIn($_SESSION['id_user']);
		$data['getKaryawan'] = $this->KaryawanModel->getById($_SESSION['id_user']);
		$data['getOwner'] = $this->OwnerModel->getById($data['getKaryawan']->ownerId);

		if($data['getKaryawan']->status_karyawan != 'customer service')
            redirect('dashboard');

		$this->load->view('templates/dashboard/head', $data);
		$this->load->view('templates/dashboard/navbar', $data);
		$data['sidebar'] = $this->load->view('templates/dashboard/sidebarKaryawan', $data, true);
		$this->load->view('pages/nota/scan', $data);
		$this->load->view('templates/dashboard/footer');
	}

	public function scanNota(){
		$kode = $this->input->post('kode');
		$karyawan = $this->KaryawanModel->getById($_SESSION['id_user']);
		$owner = $this->OwnerModel->getById($karyawan->ownerId);
		$invoiceQr = base_url('nota/qrcode/'.$kode);
		$nota = $this->NotaModel->getById($kode);
		$sisa = intval($nota->harga_service) - intval($nota->uang_muka) - intval($nota->pembayaran);
		$lastHistory = $this->NotaModel->getLastHistory($kode);
		$url = base_url('nota/activity/'.$kode);
		if($nota){
			if($owner->photo_toko == ""){
				$image = base_url('assets/images/no-image.png');
			}else{
				$image = base_url('assets/images/logo-toko/'.$owner->photo_toko);
			}
			if($nota->teknisiId == 0){
				$take = true;
			}else{
				$take = false;
			}
			$output = array(
				'nota' => true,
				'image' => $image,
				'id' => $kode,
				'take' => $take,
				'namaToko' => $owner->nama_toko,
				'tipe_toko' => $owner->tipe_toko,
				'alamat_toko' => $owner->alamat_toko,
				'no_hp' => $owner->no_hp,
				'invoice' => $invoiceQr,
				'bankName' => $owner->bankName,
				'bankBranch' => $owner->bankBranch,
				'bankAccountNumber' => $owner->bankAccountNumber,
				'bankAccountName' => $owner->bankAccountName,
				'nama_customer' => $nota->nama_customer,
				'no_hp' => $nota->no_hp,
				'alamat' => $nota->alamat,
				'pembayaran' => rupiah($nota->pembayaran),
				'status_pembayaran' => $nota->status_pembayaran,
				'serial_number' => $nota->serial_number,
				'nama_barang' => $nota->nama_barang,
				'kerusakan' => $nota->kerusakan,
				'status_nota' => $nota->status_nota,
				'url' => $url,
				'bayar' => $nota->pembayaran,
				'perbaikan' => $nota->perbaikan,
				'harga_service' => rupiah($nota->harga_service),
				'uang_muka' => rupiah($nota->uang_muka),
				'sisa' => rupiah($sisa),
				'sisaSystem' => $sisa,
				'lastStatus' => $lastHistory->status,
				'lastKeterangan' => str_replace(['<br />','<br>','/r' ,'/n'], '', $lastHistory->keterangan)
			);
		}else{
			$output = array(
				'nota' => false
			);
		}
        echo json_encode($output);
	}

	public function scanTeknisi(){
		$data['title'] = "Scan Nota";
		$data['getUser'] = $this->AuthModel->getDataLoggedIn($_SESSION['id_user']);
		$data['getKaryawan'] = $this->KaryawanModel->getById($_SESSION['id_user']);
		$data['getOwner'] = $this->OwnerModel->getById($data['getKaryawan']->ownerId);

		if($data['getKaryawan']->status_karyawan != 'teknisi')
            redirect('dashboard');

		$this->load->view('templates/dashboard/head', $data);
		$this->load->view('templates/dashboard/navbar', $data);
		$data['sidebar'] = $this->load->view('templates/dashboard/sidebarKaryawan', $data, true);
		$this->load->view('pages/nota/scanTeknisi', $data);
		$this->load->view('templates/dashboard/footer');
	}

	
	public function working($id){
		$data['title'] = "Working Nota";
		$data['getUser'] = $this->AuthModel->getDataLoggedIn($_SESSION['id_user']);
		$data['getKaryawan'] = $this->KaryawanModel->getById($_SESSION['id_user']);
		$data['getOwner'] = $this->OwnerModel->getById($data['getKaryawan']->ownerId);
		$data['getNota'] = $this->NotaModel->getById($id);
		$data['invoice'] = $id;
		$data['lastHistory'] = $this->NotaModel->getLastHistory($id);
		if($data['getKaryawan']->status_karyawan != 'teknisi' || $data['getNota']->teknisiId != $_SESSION['id_user'])
            redirect('dashboard');

		$this->load->view('templates/dashboard/head', $data);
		$this->load->view('templates/dashboard/navbar', $data);
		$data['sidebar'] = $this->load->view('templates/dashboard/sidebarKaryawan', $data, true);
		$this->load->view('pages/nota/working', $data);
		$this->load->view('templates/dashboard/footer');
	}

	public function workingList(){
		$data['title'] = "Working List";
		$data['getUser'] = $this->AuthModel->getDataLoggedIn($_SESSION['id_user']);
		$data['getKaryawan'] = $this->KaryawanModel->getById($_SESSION['id_user']);

		if($data['getKaryawan']->status_karyawan != 'teknisi')
            redirect('dashboard');

		$this->load->view('templates/dashboard/head', $data);
		$this->load->view('templates/dashboard/navbar', $data);
		$data['sidebar'] = $this->load->view('templates/dashboard/sidebarKaryawan', $data, true);
		$this->load->view('pages/nota/workinglist', $data);
		$this->load->view('templates/dashboard/footer');
	}

	public function takeNota(){
		$id = $this->input->post('kode');
		$data['getUser'] = $this->AuthModel->getDataLoggedIn($_SESSION['id_user']);
		$statusNota = 'Nota Sedang diKerjakan Oleh ' . $data['getUser']->firstname.' '.$data['getUser']->lastname;
		$data['lastHistory'] = $this->NotaModel->getLastHistory($id);
		$this->NotaModel->addHistory(array(
			'no_invoice' => $id,
			'status' => $statusNota,
			'keterangan' => $data['lastHistory']->keterangan
		));
		$this->NotaModel->takeNote(array(
			'no_invoice' => $id,
			'status_nota' => 'Sedang diKerjakan',
			'teknisiId' => $_SESSION['id_user']
		));
		echo json_encode($id);
	}

	public function updateNota(){
		$data['getUser'] = $this->AuthModel->getDataLoggedIn($_SESSION['id_user']);
		$status = $this->input->post('status');
		$keterangan =  nl2br($this->input->post('keterangan'));
		$invoice = $this->input->post('kode');
		$statusNota = 'Nota Telah diKerjakan Oleh ' . $data['getUser']->firstname.' '.$data['getUser']->lastname.' dengan Kondisi '.$status;
		if($status == 'Tidak Selesai'){
			$teknisiId = 0;
		}else{
			$teknisiId = $_SESSION['id_user'];
		}
		$this->NotaModel->update(array(
			'no_invoice' => $invoice,
			'status_nota' => $status,
			'teknisiId' => $teknisiId
		));
		$this->NotaModel->addHistory(array(
			'no_invoice' => $invoice,
			'status' => $statusNota,
			'keterangan' => $keterangan
		));
		echo json_encode($invoice);
	}

	public function cancelNota(){
		$data['getUser'] = $this->AuthModel->getDataLoggedIn($_SESSION['id_user']);
		$keterangan =  nl2br($this->input->post('keterangan'));
		$invoice = $this->input->post('kode');
		$statusNota = 'Nota Telah dibatalkan Oleh ' . $data['getUser']->firstname.' '.$data['getUser']->lastname;

		$this->NotaModel->update(array(
			'no_invoice' => $invoice,
			'status_nota' => 'dibatalkan',
		));
		$this->NotaModel->addHistory(array(
			'no_invoice' => $invoice,
			'status' => $statusNota,
			'keterangan' => $keterangan
		));
		echo json_encode($invoice);
	}

	public function bayarNota(){
		$data['getUser'] = $this->AuthModel->getDataLoggedIn($_SESSION['id_user']);
		$keterangan =  nl2br($this->input->post('keterangan'));
		$invoice = $this->input->post('kode');
		$status = $this->input->post('statusNota');
		$pembayaran = $this->input->post('pembayaranNota');
		$statusNota = 'Nota Telah dibayar, Melalui Customer Service ' . $data['getUser']->firstname.' '.$data['getUser']->lastname;

		$this->NotaModel->update(array(
			'no_invoice' => $invoice,
			'status_nota' => $status,
			'pembayaran' => $pembayaran,
			'status_pembayaran' => 'lunas'
		));
		$this->NotaModel->addHistory(array(
			'no_invoice' => $invoice,
			'status' => $statusNota,
			'keterangan' => $keterangan
		));
		echo json_encode($invoice);
	}

	public function listWorking(){
		$data['getKaryawan'] = $this->KaryawanModel->getById($_SESSION['id_user']);
		$list = $this->NotaModel->get_datatablesWorking($data['getKaryawan']->userId);
		$data = array();
		$no = $_POST['start'];

        foreach($list as $nota){
			$no++;
			$row = array();
			
			$row[] = $nota->no_invoice;
			$row[] = $nota->tanggal_masuk;
			$row[] = $nota->nama_customer;
			$row[] = $nota->status_nota;
			$row[] = $nota->status_pembayaran;

			if($nota->status_nota == 'Selesai' || $nota->status_nota == 'dibatalkan' || $nota->status_nota == 'diambil Customer' || $nota->status_nota == 'Menunggu Customer'){
				$row[] = "
            	<a href='".base_url('nota/detail/'.$nota->no_invoice)."' class='btn btn-primary btn-sm'>Detail</a>
            	";
			}else{
				$row[] = "
				<a href='".base_url('nota/detail/'.$nota->no_invoice)."' class='btn btn-primary btn-sm'>Detail</a>
            	<a href='".base_url('nota/working/'.$nota->no_invoice)."' class='btn btn-secondary btn-sm'>Kerjakan</a>
		";
			}
			$data[] = $row;
		}

		$output = array(
	        "draw" => $_POST['draw'],
	        "recordsTotal" => $this->NotaModel->count_all(),
	        "recordsFiltered" => $this->NotaModel->count_filtered(),
	        "data" => $data,
	    );

	    //output to json format
        echo json_encode($output);
	}
}