<?php 

class BarangModel extends CI_Model{
    public $table = 'barang';
    
    public function addbarang($data = array()){
        $this->db->insert($this->table, $data);
    }

    public function getBarang($id) {
        $this->db->where('userId',$id);
        $query = $this->db->get('barang');
        return $query;
    }

    public function deleteImage($file_name) {
        $image_path = FCPATH . 'assets/images/barang/' . $file_name;
        if (file_exists($image_path)) {
            unlink($image_path);
        } 
    }

    public function updateBarang($data) {
        $this->db->where('id', $data['id']);
        $this->db->where('userId', $_SESSION['id_user']);
        $this->db->update('barang', $data);
    }

    public function tambahStok($id) {
        // Ambil stok sekarang
        $this->db->select('stok');
        $this->db->where('id', $id);
        $this->db->where('userId', $_SESSION['id_user']);
        $query = $this->db->get('barang');
        $result = $query->row();

        if ($result) {
            // Stok sekarang
            $currentStok = $result->stok;

            // Tambah 1 ke stok
            $newStok = $currentStok + 1;

            // Update stok di database
            $this->db->where('id', $id);
            $this->db->update('barang', array('stok' => $newStok));

            return $newStok;
        }
        return false;
    }

    public function getById($id){
        $this->db->where('userId', $_SESSION['id_user']);
        return $this->db->get_where($this->table, array('id' => $id))->row();
    }

    public function isIdRegistered($id) {
        // Query ke database untuk mengecek apakah ID terdaftar
        $this->db->where('id', $id);
        $this->db->where('userId', $_SESSION['id_user']);
        $query = $this->db->get($this->table);

        // Periksa apakah ada baris dengan ID yang dicari
        if ($query->num_rows() > 0) {
            return true; // ID terdaftar
        } else {
            return false; // ID tidak terdaftar
        }
    }

}