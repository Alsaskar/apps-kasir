<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nota extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(['AuthModel', 'UserModel', 'KaryawanModel', 'NotaModel']);

		// jika belum login, tdk bisa kesini
		if (!isset($_SESSION['logged_in'])) {
			redirect('/');
		}
	}

    public function add(){
        $data['title'] = "Tambahkan Nota";
		$data['getUser'] = $this->AuthModel->getDataLoggedIn($_SESSION['id_user']);
		$data['getKaryawan'] = $this->KaryawanModel->getById($_SESSION['id_user']);

        if($data['getKaryawan']->status_karyawan != 'teknisi')
            redirect('dashboard');

		$this->form_validation->set_rules('tglPengambilan', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		$this->form_validation->set_rules('namaCustomer', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		$this->form_validation->set_rules('noHp', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		$this->form_validation->set_rules('alamat', '', 'required', array(
			'required' => 'Tidak boleh kosong',
		));
		$this->form_validation->set_rules('tipeHp', '', 'required', array(
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
			$tglPengambilan = htmlspecialchars($this->input->post('tglPengambilan'));
			$namaCustomer = htmlspecialchars($this->input->post('namaCustomer'));
			$noHp = htmlspecialchars($this->input->post('noHp'));
			$alamat = htmlspecialchars($this->input->post('alamat'));
			$tipeHp = htmlspecialchars($this->input->post('tipeHp'));
			$imei = htmlspecialchars($this->input->post('imei'));
			$kerusakan = htmlspecialchars($this->input->post('kerusakan'));
			$hargaService = htmlspecialchars($this->input->post('hargaService'));
			$uangPanjar = htmlspecialchars($this->input->post('uangPanjar'));
			$perbaikan = htmlspecialchars($this->input->post('perbaikan'));
			$keterangan = htmlspecialchars($this->input->post('keterangan'));

			$this->NotaModel->add(array(
				'tglMasuk' => date('Y-m-d'),
				'tglPengambilan' => $tglPengambilan,
				'namaCustomer' => $namaCustomer,
				'noHp' => $noHp,
				'alamat' => $alamat,
				'tipeHp' => $tipeHp,
				'imei' => $imei,
				'kerusakan' => $kerusakan,
				'hargaService' => $hargaService,
				'uangPanjar' => $uangPanjar,
				'perbaikan' => $perbaikan,
				'keterangan' => $keterangan,
				'teknisiId' => $data['getKaryawan']->id,
				'status' => 'proses'
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

        if($data['getKaryawan']->status_karyawan != 'teknisi')
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
		$list = $this->NotaModel->get_datatables($data['getKaryawan']->id);
		$data = array();
		$no = $_POST['start'];

        foreach($list as $nota){
			$no++;
			$row = array();

			$row[] = $no;
			$row[] = formatTanggal($nota->tglMasuk);
			$row[] = formatTanggal($nota->tglPengambilan);
			$row[] = $nota->namaCustomer;
			$row[] = $nota->tipeHp;
			$row[] = $nota->kerusakan;
			$row[] = rupiah($nota->hargaService);
			
			// $row[] = "
            // 	<a class='btn btn-primary' href='$edit'>Edit</a>
            // 	<a class='btn btn-danger ml-2' href='$hapus'>Hapus</a>
            // ";

			$row[] = "
            	-
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

}