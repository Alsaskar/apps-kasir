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
              <h3>Hai, <?= $getUser->firstname.' '.$getUser->lastname ?></h3>

					<div class="card">
						<div class="card-body">
							<div class="table-responsive">
								<div class="card mb-4">
								<div class="card-header relative py-3">
										<form class="form-inline" style="text-align: left;">
											<div class="row">
												<div class="col-md-6">
													<label>Mulai :</label>
													<input type="datetime-local" class="form-control" placeholder="Start" id="date1" value="<?=$date1?>" />
												</div>
												<div class="col-md-6">
													<label>Sampai :</label>
													<input type="datetime-local" class="form-control" placeholder="End" id="date2" value="<?=$date2?>"/>
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
											
											<div class="row">
												<div class="col-md-12 text-right">
													<div class="ml-2 mt-4">
														<a href="<?=base_url('owner/add-nota');?>" class="btn btn-primary">Tambah</a>
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
										<th>Nama Customer</th>
										<th>Tanggal Masuk</th>
										<th>Status Nota</th>
										<th>Status Pembayaran</th>
									</tr>
								</thead>
								<tbody id="list-nota">
								</tbody>
							</table>
							</div>
						</div>
					</div>
              </div>
          </div>
        </div>
      </section>
	  
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
                url: "<?php echo base_url('Kasir/searchNota/'); ?>",
                type: "POST",
                dataType: 'json',
                data: {
					key: Search.value,
                    start: Start.value,
					end: End.value
				},
                success: function(response) {
                    $("#list-nota").empty();
                    $.each(response.data, function(index, item) {
                        // Tambahkan baris HTML untuk setiap elemen
                        $("#list-nota").append(
                            `
							<tr style="${item.color}">
								<td>${item.no}</td>
								<td>${item.no_invoice}</td>
								<td>${item.nama_customer}</td>
								<td>${item.tanggal_masuk}</td>
								<td>${item.status_nota}</td>
								<td>${item.status_pembayaran}</td>
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