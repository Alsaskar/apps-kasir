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
	    		
				<!-- Teknisi -->
		    	<?php if($getKaryawan->status_karyawan == 'teknisi'){ ?>

				<h3>Hai, <?= $getUser->firstname.' '.$getUser->lastname?></h3>
				<h6>Anda adalah Teknisi di <?= $getOwner->nama_toko ?></h6><hr/>

				<div class="row">
					<div class="col-md-4">
						<div class="card">
							<div class="card-body">
								<h3>Service</h3>
								<div>Total service yang masih diproses</div><hr/>
								
								<h2 align="center"><?= $serviceProses ?></h2>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card">
							<div class="card-body bg-success">
								<h3><i class="fas fa-check"></i> Service</h3>
								<div>Total service yang telah selesai</div><hr/>
								
								<h2 align="center"><?= $serviceSelesai ?></h2>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card">
							<div class="card-body bg-danger">
								<h3><i class="fas fa-times"></i> Service</h3>
								<div>Total service yang dibatalkan</div><hr/>
								
								<h2 align="center"><?= $serviceBatal ?></h2>
							</div>
						</div>
					</div>
				</div>

				<?php }else if($getKaryawan->status_karyawan == 'customer service'){ ?>
				
					<h3>Hai, <?= $getUser->firstname.' '.$getUser->lastname?></h3>
				<h6>Anda adalah Customer Service di <?= $getOwner->nama_toko ?></h6><hr/>

				<div class="row">
					<div class="col-md-4">
						<div class="card">
							<div class="card-body">
								<h3>Service</h3>
								<div>Total service yang masih diproses</div><hr/>
								
								<h2 align="center"><?= $serviceProses ?></h2>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card">
							<div class="card-body bg-success">
								<h3><i class="fas fa-check"></i> Service</h3>
								<div>Total service yang telah selesai</div><hr/>
								
								<h2 align="center"><?= $serviceSelesai ?></h2>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card">
							<div class="card-body bg-danger">
								<h3><i class="fas fa-times"></i> Service</h3>
								<div>Total service yang dibatalkan</div><hr/>
								
								<h2 align="center"><?= $serviceBatal ?></h2>
							</div>
						</div>
					</div>
				</div>


				<?php }else if($getKaryawan->status_karyawan == 'cashier'){ ?>
					<h3>Hai, <?= $getUser->firstname.' '.$getUser->lastname ?></h3>
					<h6>Anda adalah Cashier di <?= $getOwner->nama_toko ?></h6><hr/>

					<div class="row">
						<div class="col-md-4">
							<div class="card">
								<div class="card-body">
									<h3>Total Transaksi</h3>
									<div>Total Transaksi yang telah dibuat</div><hr/>
									
									<h2 align="center"><?= $totalTransaksi?></h2>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="card">
								<div class="card-body bg-success">
									<h3><i class="fas fa-receipt nav-icon"></i> Transaksi Harian</h3>
									<div>Total Transaksi Hari ini</div><hr/>
									
									<h2 align="center"><?= $totalTransaksiToday ?></h2>
								</div>
							</div>
						</div>
					</div>


					<div class="card">
						<div class="card-body">
							<div class="table-responsive">
								<div class="card mb-4">
								<div class="card-header relative py-3">
										<form class="form-inline" style="text-align: left;">
											<div class="row">
												<div class="col-md-6">
													<label>Mulai :</label>
													<input type="date" class="form-control" placeholder="Start" id="date1" value="<?=$date1?>" />
												</div>
												<div class="col-md-6">
													<label>Sampai :</label>
													<input type="date" class="form-control" placeholder="End" id="date2" value="<?=$date2?>"/>
												</div>
											</div>
											
											<div class="row">
												<div class="col-md-12 text-left">
													<div class="ml-2">
														<label>Pencarian :</label>
														<input id="searchbar" name="key" type="text" class="form-control" placeholder="Cari ...">
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>

								
								<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>No</th>
										<th>No Transaksi</th>
										<th>Cashier</th>
										<th>Tanggal Transaksi</th>
										<th>Total Biaya</th>
										<th>Diskon</th>
										<th>Metode Pembayaran</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody id="list-transaksi">
								</tbody>
							</table>

							</div>
						</div>
					</div>


				<?php } ?>
					
	    </section>
	</div>
</div>

<script>
	var Search = document.getElementById("searchbar");
	var Start = document.getElementById("date1");
	var End = document.getElementById("date2");

	document.addEventListener('DOMContentLoaded', function() {
		search();
	});

	Search.addEventListener('keyup', function (event) {
		search();
    });

	Start.addEventListener('change', function (event) {
		search();
	});

	End.addEventListener('change', function (event) {
		search();
	});

	function search(){
		
		$.ajax({
                url: "<?php echo base_url('Karyawan/searchTransaksi/'); ?>",
                type: "POST",
                dataType: 'json',
                data: {
					key: Search.value,
                    start: Start.value,
					end: End.value
				},
                success: function(response) {
                    $("#list-transaksi").empty();
                    $.each(response.data, function(index, item) {
                        // Tambahkan baris HTML untuk setiap elemen
                        $("#list-transaksi").append(
                            `
							<tr style="${item.color}">
								<td>${item.no}</td>
								<td>${item.no_transaksi}</td>
								<td>${item.cashier}</td>
								<td>${item.tanggal_pesanan}</td>
								<td>Rp.${item.total_biaya}</td>
								<td>Rp.${item.diskon}</td>
								<td>${item.metode_pembayaran}</td>
								<td>${item.status}</td>
								<td><a href="${item.url}" class='btn btn-primary btn-sm'>Detail</a></td>
							</tr>   
                            `
                        );
                    });
                    
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
            });
	}

</script>