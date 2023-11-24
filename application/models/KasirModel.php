<?php 

/*

karyawan Model

Fungsi :
- Menampilkan Data karyawan
- Mengedit Data karyawan
- Menghapus Data karyawan
- Menampilkan Profil karyawan

*/

class KasirModel extends CI_Model{
    public $table = 'transaksi';

    public $column_order = array(null, 'no_transaksi', 'userId', 'tanggal_pesanan', 'total_biaya','metode_pembayaran','status');
    public $column_search = array('no_transaksi', 'userId', 'tanggal_pesanan', 'total_biaya','metode_pembayaran','status');
    public $order = array('tanggal_pesanan' => 'asc');

    public function getTransactions(){
        $result = $this->db->get_where('transaksi', array('userId' => $_SESSION['id_user'], 'status' => 'draft'))->row();

        // Mengecek apakah data ditemukan atau tidak
        if ($result) {
            return $result;
        } else {
            return 0;
        }
    }

    public function transferCacheToDetail() {
        // Ambil data dari cache_transaksi berdasarkan userId
        $this->db->where('userId', $_SESSION['id_user']);
        $this->db->where('status', 'draft');

        $dataTransaksi = $this->db->get('transaksi')->row();


        $this->db->where('userId', $_SESSION['id_user']);
        $cacheData = $this->db->get('cache_transaksi')->result();

        if (!empty($cacheData)) {
            // Pindahkan data dari cache_transaksi ke detail_transaksi
            foreach ($cacheData as $cacheRow) {
                $detailData = array(
                    'no_transaksi' => $dataTransaksi->no_transaksi,
                    'barangId'        => $cacheRow->barangId,
                    'nama_barang'        => $cacheRow->nama_barang,
                    'harga_satuan'        => $cacheRow->harga_satuan,
                    'jumlah'        => $cacheRow->jumlah_barang
                );
                // Insert data ke detail_transaksi
                $this->db->insert('detail_transaksi', $detailData);

                $this->db->where('userId', $_SESSION['id_user']);

            }

            // Hapus data dari cache_transaksi setelah dipindahkan
            $this->db->where('userId', $_SESSION['id_user']);
            $this->db->delete('cache_transaksi');

            $this->db->where('no_transaksi',$dataTransaksi->no_transaksi);
            $this->db->update('transaksi', array('status' => 'submitted'));
            
        }
    }

    public function saveTransaction($dataTransaksi){
        $this->db->where('status', $dataTransaksi['status']);
        $existingTransaksi = $this->db->get_where('transaksi', array('userId' => $dataTransaksi['userId']))->row();
    
        // Hitung nilai uang kembalian
        $totalBiaya = $existingTransaksi ? $existingTransaksi->total_biaya : 0;
        $uangPelanggan = $dataTransaksi['uang_pelanggan'];
        $uangKembalian = $uangPelanggan - $totalBiaya;
    
        // Tambahkan nilai uang kembalian ke dalam array dataTransaksi
        $dataTransaksi['uang_kembalian'] = $uangKembalian;
    
        if ($existingTransaksi) {
            // Jika transaksi sudah ada, lakukan proses update
            $this->db->where('status', $dataTransaksi['status']);
            $this->db->where('userId', $dataTransaksi['userId']);
            $this->db->update('transaksi', $dataTransaksi);
        } else {
            // Jika belum ada, lakukan proses insert
            $this->db->insert('transaksi', $dataTransaksi);
        }
    }
    

    public function addcache($dataCache = array(), $dataTransaksi = array()) {
        // Cek apakah user ID sudah ada di tabel transaksi
        $existingTransaksi = $this->db->get_where('transaksi', array('userId' => $dataTransaksi['userId'], 'status' => 'draft'))->row();
    
        if ($existingTransaksi) {
           
        } else {
            // Jika belum ada, lakukan proses insert
            $this->db->insert('transaksi', $dataTransaksi);
        }
    
        // Cek apakah barang ID sudah ada di tabel cache_transaksi
        $existingCache = $this->db->get_where('cache_transaksi', array('barangId' => $dataCache['barangId']))->row();
    
        if ($existingCache) {
            // Jika sudah ada, tambahkan jumlah_barang dari nilai sebelumnya
            $dataCache['jumlah_barang'] += $existingCache->jumlah_barang;
            $this->db->where('barangId', $dataCache['barangId']);
            $this->db->update('cache_transaksi', $dataCache);
        } else {
            // Jika belum ada, lakukan proses insert
            $this->db->insert('cache_transaksi', $dataCache);
        }
    }
    
    public function getBarang($id) {
        $this->db->where('userId',$id);
        $this->db->limit(3);
        $query = $this->db->get('barang');
        return $query;
    }
    
    public function getDate($type){
        if($type == 'min'){
            $this->db->where('userId',$_SESSION['id_user']);
            $this->db->select_min('tanggal_pesanan', 'earliest_date');
            $query = $this->db->get('transaksi');
    
            // Periksa apakah query berhasil
            if ($query->num_rows() > 0) {
                return $query->row()->earliest_date;
            } else {
                return null;
            }
        }elseif($type == 'max'){
            $this->db->where('userId',$_SESSION['id_user']);
            $this->db->select_max('tanggal_pesanan', 'latest_date');
            $query = $this->db->get('transaksi');

            // Periksa apakah query berhasil dieksekusi
            if ($query->num_rows() > 0) {
                return $query->row()->latest_date;
            } else {
                return null;
            }
        }
    }

    public function getcache() {
        $this->db->where('userId',$_SESSION['id_user']);
        $query = $this->db->get('cache_transaksi');
        return $query;
    }

    public function getDetailTransaction($id) {
        $this->db->where('no_transaksi',$id);
        $query = $this->db->get('detail_transaksi');
        return $query;
    }

    public function getTransaction($id) {
        $this->db->where('no_transaksi',$id);
        $query = $this->db->get('transaksi');
        return $query->row();
    }

    public function updateTransaksi($dataTransaksi) {
        // Contoh: Update transaksi berdasarkan ID transaksi
        $this->db->where('userId', $dataTransaksi['userId']);
        $this->db->where('status', $dataTransaksi['status']);
        $this->db->update('transaksi', $dataTransaksi);
        
        // Ambil nilai total_biaya setelah update
        $this->db->select('total_biaya');
        $this->db->where('userId', $dataTransaksi['userId']);
        $this->db->where('status', $dataTransaksi['status']);
        $result = $this->db->get('transaksi');

        if ($result->num_rows() > 0) {
            // Ambil nilai total_biaya dari hasil query
            $row = $result->row();
            return $row->total_biaya;
        } else {
            // Return nilai default jika tidak ada hasil
            return 0;
        }
    }

    public function validasiJumlahBarang() {
        // Ambil data jumlah barang dari cache_transaksi
        $this->db->where('userId', $_SESSION['id_user']);
        $cacheBarang = $this->db->select('barangId, jumlah_barang')->get('cache_transaksi')->result_array();

        // Inisialisasi array untuk menyimpan jumlah barang dari tabel barang
        $barangJumlah = array();

        // Ambil data jumlah barang dari tabel barang
        $barang = $this->db->select('id, stok')->get('barang')->result_array();

        // Ubah format data barang untuk kemudahan pencarian
        foreach ($barang as $row) {
            $barangJumlah[$row['id']] = $row['stok'];
        }

        // Periksa apakah jumlah barang dari cache_transaksi lebih besar atau sama dengan jumlah barang dari tabel barang
        foreach ($cacheBarang as $row) {
            $barangId = $row['barangId'];
            $jumlahCache = $row['jumlah_barang'];

            if (!isset($barangJumlah[$barangId]) || $jumlahCache > $barangJumlah[$barangId]) {
                // Jika jumlah barang dari cache_transaksi lebih besar dari tabel barang, kembalikan false
                return false;
            }
        }
        // Jika semua jumlah barang dari cache_transaksi lebih kecil atau sama dengan tabel barang, kembalikan true
        return true;
    }

    public function kurangiJumlahBarang() {
        // Ambil data jumlah barang dari cache_transaksi
        $this->db->where('userId', $_SESSION['id_user']);
        $cacheBarang = $this->db->select('barangId, jumlah_barang')->get('cache_transaksi')->result_array();

        foreach ($cacheBarang as $row) {
            $barangId = $row['barangId'];
            $jumlahCache = $row['jumlah_barang'];
            // Kurangi jumlah barang di tabel 'barang' berdasarkan jumlah di cache_transaksi
            $this->db->set('stok', 'stok - ' . $jumlahCache, false);
            $this->db->where('id', $barangId);
            $this->db->update('barang');
        }
    }
    
    public function deleteCache($id) {
        $this->db->where('id', $id);
        $this->db->delete('cache_transaksi');
    }

    public function searchBarang($key, $kode_owner) {
        $this->db->like('nama_barang', $key);
        $this->db->or_like('deskripsi', $key);
        $this->db->or_like('stok', $key);
        $this->db->or_like('id', $key);
        $this->db->or_like('harga', $key);
        $this->db->where('userId', $kode_owner);
        $query = $this->db->get('barang');
        return $query;
    }

    public function _get_datatables_query(){
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('userId', $_SESSION['id_user']);

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
        $this->db->where('userId', $_SESSION['id_user']);

        return $this->db->count_all_results();
    }

    public function countAllTransasction(){
        $this->db->where('userId', $_SESSION['id_user']);
        $query = $this->db->get('transaksi');
        // Kembalikan jumlah baris
        return $query->num_rows();
    }

    public function countTransactionByDate(){
        $currentDate = date('Y-m-d');
        $this->db->where('userId', $_SESSION['id_user']);
        $this->db->where('tanggal_pesanan', $currentDate);
        $query = $this->db->get('transaksi');
        // Kembalikan jumlah baris
        return $query->num_rows();
    }

    public function konfirmasi($totalBayar){
        $this->db->where('userId', $_SESSION['id_user']);
        $this->db->where('status', 'draft');

        // Mendapatkan hasil query dari tabel 'transaksi'
        $result = $this->db->get('transaksi')->row();

        // Periksa apakah query berhasil dieksekusi
        if ($result->total_biaya <= $totalBayar) {
            return true;
        } elseif ($result->total_biaya > $totalBayar) {
            return false;
        }
    }

    public function showTransaction(){
        $this->db->where('userId', $_SESSION['id_user']);
        $result = $this->db->get('transaksi');
        if ($result->num_rows() > 0) {
            return $result->result();
        } else {
            return array();
        }
    }

}