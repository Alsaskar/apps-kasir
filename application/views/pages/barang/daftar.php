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
                        <h1 class="">Daftar Barang</h1> <hr/>

                        <?php if($barang->num_rows() > 0){ ?>
                            <div class="row">

                            <?php foreach ($barang->result() as $item): ?>
                            
                            <div class="col-md-3">
                                
                                <div class="card mb-4">
                                    <img src="<?php echo base_url('assets/images/barang/'.$item->gambar); ?>" class="card-img-top" style="height:250px;" alt="<?php echo $item->nama_barang; ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $item->nama_barang; ?></h5>
                                        <p class="card-text">Rp.<?php echo number_format($item->harga,0,',','.');?></p>
                                        <a href="<?php echo base_url('/barang/detail/'.$item->id)?>" class="btn btn-primary">Detail</a>
                                    </div>
                                </div>
                            </div>

                            <?php endforeach; ?>

                            </div>

                        <?php }else{ ?>

                        <h4>Belum ada barang</h4>

                        <?php } ?>

                    </div>
                </div>

	    	</div>
	    </section>
	</div>
</div>