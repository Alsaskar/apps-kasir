<body class="hold-transition py-5 sidebar-mini layout-fixed">

<?php 

$message = $this->session->flashdata('msg_sweetalert');

if (isset($message)) {
  echo $message;
  $this->session->unset_userdata('msg_sweetalert');
}

?>

<!-- https://source.unsplash.com/600x401/?nutmeg -->


<div class="wrapper">
  <!-- Sidebar -->
  <?= $sidebar ?>

    <div class="mt-5 container py-4">
    <div class="card">
        <div class="card-body">
        <h2>Data Barang </h2>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <img src="<?php echo base_url('assets/images/barang/'.$barang->gambar)?>" class="card-img-top" alt="Gambar Barang">
                </div>
            </div>
            <div class="col-md-6">
                <h2 class="mb-4"><?=$barang->nama_barang?></h2>
                <p class="lead font-weight-bold">Rp.<?php echo number_format($barang->harga,0,',','.');?></p>
                <hr class="my-4">
                <h3 class="mb-3">Deskripsi Produk</h3>
                <p><?=$barang->deskripsi?></p>
            </div>
        </div>
        </div>
    </div>
</div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>