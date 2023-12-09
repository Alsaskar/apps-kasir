<?php 

class NotaModel extends CI_Model{
    public $table = 'nota_teknisi';

    public $column_order = array(null, 'no_invoice', 'tanggal_masuk', 'nama_customer', 'serial_number', 'kerusakan', 'harga_service');
    public $column_search = array('nama_customer', 'nama_barang', 'kerusakan','status_nota','status_pembayaran','tanggal_masuk','no_invoice');
    public $order = array('id' => 'desc');
    
    public function add($data = array()){
        $this->db->insert($this->table, $data);
    }

    public function update($data = array()) {
        $this->db->where('no_invoice', $data['no_invoice']);
        $this->db->update($this->table, $data); 
    }

    public function addHistory($data = array()){
        $this->db->insert('riwayat_nota_teknisi', $data);
    }

    public function _get_datatables_query($teknisiId){
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('userId', $teknisiId);

        $i = 0;

        foreach($this->column_search as $item){ // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                }else{
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); // close bracket
            }

            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function _get_datatables_queryWorking($teknisiId){
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('teknisiId', $teknisiId);

        $i = 0;

        foreach($this->column_search as $item){ // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                }else{
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); // close bracket
            }

            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_datatables($teknisiId){
        $this->_get_datatables_query($teknisiId);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();

        return $query->result();
    }

    public function get_datatablesWorking($teknisiId){
        $this->_get_datatables_queryWorking($teknisiId);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();

        return $query->result();
    }

    public function count_filtered(){
        $this->_get_datatables_query($_SESSION['id_user']);
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function count_all(){
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('userId', $_SESSION['id_user']);

        return $this->db->count_all_results();
    }

    public function getById($id){
        return $this->db->get_where($this->table, array('no_invoice' => $id))->row();
    }

    // update status service
    public function updateStatus($id, $status){
        $this->db->where('id', $id);
        return $this->db->update($this->table, array('status_pembayaran' => $status));
    }

    public function takeNote($data = array()){
        $this->db->where('no_invoice', $data['no_invoice']);
        $this->db->update('nota_teknisi',$data);
    }

    // count total service by status
    public function countServiceByStatus($status, $teknisiId,$role){
        if($role == 'teknisi'){
            $this->db->where('teknisiId', $teknisiId);
            $this->db->where('status_nota', $status);
            $this->db->select('no_invoice');
            $this->db->from($this->table);
            return $this->db->get()->num_rows();
        }elseif($role == 'customer service'){
            $this->db->where('userId', $teknisiId);
            $this->db->where('status_nota', $status);
            $this->db->select('no_invoice');
            $this->db->from($this->table);
            return $this->db->get()->num_rows();
        }
       
    }

    public function getLastHistory($no_invoice) {
        // Mengambil data terakhir berdasarkan tanggal terbaru
        $this->db->where('no_invoice', $no_invoice);
        $this->db->order_by('tanggal', 'desc');
        $this->db->limit(1);
        $query = $this->db->get('riwayat_nota_teknisi');

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return null;
        }
    }

    public function getHistoryById($id){
        $this->db->where('id', $id);
        $query = $this->db->get('riwayat_nota_teknisi');

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return array();
        }
    }

    public function getHistory($no_invoice) {
        $this->db->where('no_invoice', $no_invoice);
        $this->db->order_by('tanggal', 'desc');
        $query = $this->db->get('riwayat_nota_teknisi');

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array(); // Jika tidak ada data
        }
    }

}