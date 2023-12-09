<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<body class="hold-transition sidebar-mini layout-fixed">

<?php 

$message = $this->session->flashdata('msg_sweetalert');

if (isset($message)) {
  echo $message;
  $this->session->unset_userdata('msg_sweetalert');
}

?>

<style>
    body {
      background-color: #f8f9fa; /* Warna latar belakang abu-abu muda */
    }
    .container {
      margin-top: 50px;
    }
    .custom-select-label {
      color: #3498db; /* Warna biru cerah untuk label */
    }
    .custom-select {
      border-color: #3498db; /* Warna biru cerah untuk border */
    }
    .custom-select:hover {
      border-color: #2980b9; /* Warna biru yang lebih tua saat hover */
    }
    .custom-select:focus {
      border-color: #2980b9; /* Warna biru yang lebih tua saat focus */
      box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25); /* Efek shadow saat focus */
    }
  </style>
<div class="wrapper">
  <!-- Sidebar -->
  <?= $sidebar ?>

  	<!-- Content Wrapper. Contains page content -->
  	<div class="content-wrapper pb-3">
	    <section class="content">
	    	<div class="container-fluid">
	    		
			<div class="row">
				<!-- Card: Total Products -->
				<div class="col-md-3 mb-3">
				<div class="card">
					<div class="card-body">
					<h5 class="card-title">Total Barang</h5>
					<p class="card-text text-xl"> <i class="fas fa-cube nav-icon"></i> <?=$totalBarang?></p>
					</div>
				</div>
				</div>

				<!-- Card: Total Employees -->
				<div class="col-md-3 mb-3">
				<div class="card">
					<div class="card-body">
					<h5 class="card-title">Total Karyawan</h5>
					<p class="card-text text-xl"> <i class="fas fa-user nav-icon"></i> <?=$totalKaryawan?></p>
					</div>
				</div>
				</div>

				<!-- Card: Total Transactions -->
				<div class="col-md-3 mb-3">
					
				<div class="card">
					<div class="card-body">
					<h5 class="card-title">Total Transaksi</h5>
					<p class="card-text text-xl"> <i class="fas fa-cash-register nav-icon"></i> <?=$totalTransaksi?></p>
					</div>
				</div>
				</div>

				<!-- Card: Total Invoices -->
				<div class="col-md-3 mb-3">
				<div class="card">
					<div class="card-body">
					<h5 class="card-title">Total Nota</h5>
					<p class="card-text text-xl"><i class="fas fa-receipt nav-icon"></i>  <?=$totalNota?></p>
					</div>
				</div>
				</div>
			</div>
				<!-- Chart: Daily Transactions -->
				<div class="col-md-12">
					<?php 
					if($transaksiMingguan == false){
						echo "$transaksiNone";
					}else{
						$index=0; foreach ($transaksiMingguan->result() as $item):
						$index++; ?>
						<input type="text" id="Day-<?=$index?>" value="<?=$item->tanggal_pesanan?>" class="d-none">
						<?php endforeach;
						if($index < 7){
							echo "Grafik Transaksi Akan Keluar Setelah 7 Hari Kerja";
						}
						
						echo "<canvas id='dailyTransactionsChart'></canvas>";
					}
					?>
				</div>
			</div>	

	    	</div>
	    </section>
	</div>
</div>



<script>

		var ctx = document.getElementById('dailyTransactionsChart').getContext('2d');
		var day1 = document.getElementById("Day-1").value;
		var day2 = document.getElementById("Day-2").value;
		var day3 = document.getElementById("Day-3").value;
		var day4 = document.getElementById("Day-4").value;
		var day5 = document.getElementById("Day-5").value;
		var day6 = document.getElementById("Day-6").value;
		var day7 = document.getElementById("Day-7").value;
		var dailyTransactionsChart = new Chart(ctx, {
			type: 'line',
			data: {		
			labels: [day7,day6,day5,day4,day3,day2,day1],
			datasets: [{
				label: 'Transaksi Minggu ini',
				data: [<?=$day7?>, <?=$day6?>, <?=$day5?>, <?=$day4?>, <?=$day3?>, <?=$day2?>, <?=$day1?>],
				borderColor: 'rgba(75, 192, 192, 1)',
				borderWidth: 2,
				fill: false
			}]
			},
			options: {
			scales: {
				y: {
				beginAtZero: true
				}
			}
			}
		});
	
</script>