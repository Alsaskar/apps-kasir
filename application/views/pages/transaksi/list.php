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
                  <h3>Data Transaksi</h3>
                  <div>Dibawah ini adalah data nota yang pernah dibuat</div><hr/>

                  <div class="alert alert-primary">
                    <h5>Info</h5>
                    <div>- Tanda centang hijau (<font color="green"><i class="fas fa-check"></i></font>) disebelah kiri berarti service telah selesai</div>
                    <div>- Tanda silang merah (<font color="red"><i class="fas fa-times"></i></font>) disebelah kiri berarti service dibatalkan</div>
                  </div>

                    <table id="table" class="table text-center table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>No Transaksi</th>
                          <th>Tanggal Transaksi</th>
                          <th>Cashier</th>
                          <th>Total Biaya</th>
                          <th>Diskon</th>
                          <th>Status</th>
                          <th>Opsi</th>
                        </tr>
                      </thead>
                      <tbody id="showdata" class="text-center"></tbody>
                    </table>
                  </div>
                  
          </div>

	    	</div>
	    </section>
	</div>
</div>

<script src="<?= base_url('assets/library/datatables/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/library/datatables/js/dataTables.min.js') ?>"></script>
<script type="text/javascript">
$('#table').DataTable({

"processing": true,
"serverSide": true,
"order": [],
"ajax": {
  "url": "<?php echo site_url('Kasir/listApi') ?>",
  "type": "POST"
},

"columnDefs": [
  {
    "targets": [0],
    "ordertable": false
  }
]

});
</script>