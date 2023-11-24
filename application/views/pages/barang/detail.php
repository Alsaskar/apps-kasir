<body class="hold-transition sidebar-mini layout-fixed">

<?php 

$message = $this->session->flashdata('msg_sweetalert');

if (isset($message)) {
  echo $message;
  $this->session->unset_userdata('msg_sweetalert');
}

?>

<div class="wrapper">
  <!-- Sidebar -->
  <?= $sidebar ?>

  	<!-- Content Wrapper. Contains page content -->
  	<div class="content-wrapper pb-3">
	    <section class="content">
	    	<div class="container-fluid">
	    		
		    	<div class="card">
                    <div class="card-body">
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
	    </section>
	</div>
</div>