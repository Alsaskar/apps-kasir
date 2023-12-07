<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Owner extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(['AuthModel', 'OwnerModel','NotaModel','KasirModel']);

		// jika belum login, tdk bisa kesini
		if (!isset($_SESSION['logged_in'])) {
			redirect('/');
		}
	}

	// ini untuk halaman admin, hanya admin yang bisa akses halaman ini
	public function list(){
		$data['title'] = "Data Owner";
		$data['getUser'] = $this->AuthModel->getDataLoggedIn($_SESSION['id_user']);

		// jika bukan admin yg login, maka tdk bisa kesini
		if ($data['getUser']->role != 'admin')
			redirect('dashboard');

		$this->load->view('templates/dashboard/head', $data);
		$this->load->view('templates/dashboard/navbar', $data);

		$data['sidebar'] = $this->load->view('templates/dashboard/sidebarAdmin', $data, true);
		$this->load->view('pages/owner/list', $data);

		$this->load->view('templates/dashboard/footer');
	}

	// API LIST -> Server Side Datatable
	public function listApi(){
		$list = $this->OwnerModel->get_datatables();
		$data = array();
		$no = $_POST['start'];

		foreach($list as $owner){
			$no++;
			$row = array();

			$row[] = $no;
			$row[] = $owner->firstname." ".$owner->lastname;
			$row[] = $owner->email;
			$row[] = $owner->nama_toko;

			$row[] = '-';

			$data[] = $row;
		}

		$output = array(
	        "draw" => $_POST['draw'],
	        "recordsTotal" => $this->OwnerModel->count_all(),
	        "recordsFiltered" => $this->OwnerModel->count_filtered(),
	        "data" => $data,
	    );

	    //output to json format
        echo json_encode($output);
	}

	public function listTransaksi(){
		$data['title'] = "Data Transaksi";
		$data['getUser'] = $this->AuthModel->getDataLoggedIn($_SESSION['id_user']);

		// jika bukan admin yg login, maka tdk bisa kesini
		if ($data['getUser']->role != 'owner')
			redirect('dashboard');

		$this->load->view('templates/dashboard/head', $data);
		$this->load->view('templates/dashboard/navbar', $data);
		$data['list'] = $this->OwnerModel->showTransaction('transaksi');
		$data['date1'] = $this->OwnerModel->getDate('min','transaksi');
		$data['date2'] = $this->OwnerModel->getDate('max','transaksi');
		$data['sidebar'] = $this->load->view('templates/dashboard/sidebarOwner', $data, true);
		$this->load->view('pages/owner/listTransaksi', $data);
		$this->load->view('templates/dashboard/footer');
	}

	public function searchTransaksi(){
        $key = $this->input->post('key');
		$start = date('Y-m-d', strtotime(str_replace('-', '/', $this->input->post('start'))));
		$end = date('Y-m-d', strtotime(str_replace('-', '/', $this->input->post('end'))));


        $list = $this->OwnerModel->searchTransaksi(array('key' => $key,'start' => $start,'end' => $end));
		$data = array();
        $no = 0;
        foreach($list->result() as $detail){
			$no++;
			$rowColorClass = ($no % 2 == 0) ? 'background-color: #FFFFFF;' : 'background-color: #F2F2F2;';
			$url = base_url('kasir/detail-transaksi/'.$detail->no_transaksi);
            $total_bayar = number_format($detail->total_biaya, 0, '.', ',');
            $diskon = number_format($detail->diskon, 0, '.', ',');
			$row = array();
            $row = array(
				'no' => $no,
				'color' => $rowColorClass,
				'url' => $url,
                'no_transaksi' => $detail->no_transaksi,
                'cashier' => $detail->cashier,
                'tanggal_pesanan' => $detail->tanggal_pesanan,
                'total_biaya' => $total_bayar,
                'diskon' => $diskon,
                'metode_pembayaran' => $detail->metode_pembayaran,
				'status' => $detail->status
            );

            $data[] = $row;
		}
        
        $output = array(
	        "data" => $data
	    );
        echo json_encode($output);
	}


	public function listNota(){
		$data['title'] = "Data Nota Teknisi";
		$data['getUser'] = $this->AuthModel->getDataLoggedIn($_SESSION['id_user']);

		// jika bukan admin yg login, maka tdk bisa kesini
		if ($data['getUser']->role != 'owner')
			redirect('dashboard');

		$this->load->view('templates/dashboard/head', $data);
		$this->load->view('templates/dashboard/navbar', $data);
		$data['list'] = $this->OwnerModel->showTransaction('nota_teknisi');
		$data['date1'] = $this->OwnerModel->getDate('min','nota_teknisi');
		$data['date2'] = $this->OwnerModel->getDate('max','nota_teknisi');
		$data['sidebar'] = $this->load->view('templates/dashboard/sidebarOwner', $data, true);
		$this->load->view('pages/owner/listNota', $data);
		$this->load->view('templates/dashboard/footer');
	}

	public function searchNota(){
        $key = $this->input->post('key');
		$start = $this->input->post('start');
		$end = $this->input->post('end');

        $list = $this->OwnerModel->searchNota(array('key' => $key,'start' => $start,'end' => $end));
		$data = array();
        $no = 0;
        foreach($list->result() as $detail){
			$no++;
			$rowColorClass = ($no % 2 == 0) ? 'background-color: #FFFFFF;' : 'background-color: #F2F2F2;';
			$url = base_url('nota/detail/'.$detail->no_invoice);
			$row = array();
            $row = array(
				'no' => $no,
				'color' => $rowColorClass,
				'url' => $url,
                'no_invoice' => $detail->no_invoice,
                'nama_customer' => $detail->nama_customer,
                'tanggal_masuk' => $detail->tanggal_masuk,
                'status_nota' => $detail->status_nota,
                'status_pembayaran' => $detail->status_pembayaran,
            );

            $data[] = $row;
		}
        
        $output = array(
	        "data" => $data
	    );
        echo json_encode($output);
	}

	public function detailNota($id){
		$data['title'] = "Data Nota";
		$data['getUser'] = $this->AuthModel->getDataLoggedIn($_SESSION['id_user']);
		$data['getOwner'] = $this->OwnerModel->getById($_SESSION['id_user']);
		$data['getNota'] = $this->NotaModel->getById($id);
		$data['invoice'] = $id;
		$data['lastHistory'] = $this->NotaModel->getLastHistory($id);

        if($data['getNota']->ownerId != $_SESSION['id_user'])
            redirect('dashboard');

		$this->load->view('templates/dashboard/head', $data);
		$this->load->view('templates/dashboard/navbar', $data);
		$data['sidebar'] = $this->load->view('templates/dashboard/sidebarOwner', $data, true);
		$this->load->view('pages/nota/detail_owner', $data);
		$this->load->view('templates/dashboard/footer');
	}

	public function notaActivity($id){
		$data['title'] = "Data Nota";
		$data['getUser'] = $this->AuthModel->getDataLoggedIn($_SESSION['id_user']);
		$data['getOwner'] = $this->OwnerModel->getById($_SESSION['id_user']);
		$data['getNota'] = $this->NotaModel->getById($id);
		$data['invoice'] = $id;
		$data['getHistory'] = $this->NotaModel->getHistory($id);
		$data['lastHistory'] = $this->NotaModel->getLastHistory($id);

		if($data['getNota']->ownerId != $_SESSION['id_user'])
            redirect('dashboard');

		$this->load->view('templates/dashboard/head', $data);
		$this->load->view('templates/dashboard/navbar', $data);
		$data['sidebar'] = $this->load->view('templates/dashboard/sidebarOwner', $data, true);
		$this->load->view('pages/nota/activity', $data);
		$this->load->view('templates/dashboard/footer');
	}

	public function detailTransaksi($id){
		$data['title'] = "Detail Transaksi";
		$data['getUser'] = $this->AuthModel->getDataLoggedIn($_SESSION['id_user']);
        $data['detail'] = $this->KasirModel->getDetailTransaction($id);
        $data['transaksi'] = $this->KasirModel->getTransaction($id);
        $data['getOwner'] = $this->OwnerModel->getById($_SESSION['id_user']);

		// jika bukan admin yg login, maka tdk bisa kesini
		if ($data['transaksi']->ownerId != $_SESSION['id_user'])
			redirect('dashboard');

		$this->load->view('templates/dashboard/head', $data);
		$this->load->view('templates/dashboard/navbar', $data);

		$data['sidebar'] = $this->load->view('templates/dashboard/sidebarOwner', $data, true);
		$this->load->view('pages/transaksi/detail', $data);

		$this->load->view('templates/dashboard/footer');
	}
	

}