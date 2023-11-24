<?php 

class NotaModel extends CI_Model{
    public $table = 'nota_service';

    public $column_order = array(null, 'tglMasuk', 'tglPengambilan', 'namaCustomer', 'tipeHp', 'kerusakan', 'hargaService');
    public $column_search = array('namaCustomer', 'tipeHp', 'kerusakan');
    public $order = array('id' => 'desc');
    
    public function add($data = array()){
        $this->db->insert($this->table, $data);
    }

    public function _get_datatables_query($teknisiId){
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

    public function count_filtered(){
        $this->_get_datatables_query($_SESSION['id_user']);
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function count_all(){
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('teknisiId', $_SESSION['id_user']);

        return $this->db->count_all_results();
    }

    public function getById($id){
        return $this->db->get_where($this->table, array('id' => $id))->row();
    }

    // update status service
    public function updateStatus($id, $status){
        $this->db->where('id', $id);
        return $this->db->update($this->table, array('status' => $status));
    }

    // count total service by status
    public function countServiceByStatus($status, $teknisiId){
        $this->db->where('teknisiId', $teknisiId);
        $this->db->where('status', $status);
        $this->db->select('id');
        $this->db->from($this->table);
        return $this->db->get()->num_rows();
    }
}