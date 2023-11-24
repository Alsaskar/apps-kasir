<?php 

/*

karyawan Model

Fungsi :
- Menampilkan Data karyawan
- Mengedit Data karyawan
- Menghapus Data karyawan
- Menampilkan Profil karyawan

*/

class KaryawanModel extends CI_Model{
    public $table = 'karyawan';

    public $column_order = array(null, 'user.firstname', 'user.lastname', 'user.email', 'karyawan.nama_karyawan', 'karyawan.no_hp', 'karyawan.status_karyawan');
    public $column_search = array('user.firstname', 'user.lastname', 'user.email', 'karyawan.nama_karyawan', 'karyawan.no_hp', 'karyawan.status_karyawan');
    public $order = array('karyawan.id' => 'desc');

    public function add($data = array()){
        return $this->db->insert($this->table, $data);
    }

   public function _get_datatables_query(){
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('karyawan.ownerId', $_SESSION['id_user']);
        $this->db->join('user', 'karyawan.userId = user.id');
        $this->db->where('user.role', 'karyawan');

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

    public function get_datatables(){
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();

        return $query->result();
    }

    public function count_filtered(){
        $this->_get_datatables_query();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function count_all(){
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('karyawan.ownerId', $_SESSION['id_user']);
        $this->db->join('user', 'karyawan.userId = user.id');
        $this->db->where('user.role', 'karyawan');

        return $this->db->count_all_results();
    }

    //update
    
    public function addkaryawan($dataKaryawan = array()){
        $this->db->insert($this->table, $dataKaryawan);
    }

    public function updateKaryawan($dataKaryawan = array()){
        $this->db->where('userId', $dataKaryawan['userId']);
        $this->db->update($this->table, $dataKaryawan);
    }

    public function deleteData($id){
        $this->db->where('userId', $id);
        $this->db->delete('karyawan');
    }

    public function updateProfile($data = array()){
        $this->db->where('userId', $data['userId']);
        $this->db->update($this->table, $data);
    }

    public function delete_image($file_name) {
        $image_path = FCPATH . 'assets/images/profile/' . $file_name;
        if (file_exists($image_path)) {
            unlink($image_path);
        } 
    }
    

    public function getLastId($table,$field) {
        $this->db->select_max($field);
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->id;
        }
        return null;
    }

    public function getById($id){
        return $this->db->get_where($this->table, array('userId' => $id))->row();
    }

}