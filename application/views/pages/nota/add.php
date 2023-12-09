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

				<div class="row justify-content-center">
					<div class="col-md-8">
						<div class="card">
							<div class="card-body">
								
								<h3>Buat Nota</h3>
								<div>Silahkan buat Nota untuk customer</div><hr/>

								<form action="" method="post">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="namaCustomer">Nama Customer</label>
												<input type="text" class="form-control" name="namaCustomer" id="namaCustomer" value="<?= set_value('namaCustomer') ?>" placeholder="Masukkan Nama Customer">
												<?php echo form_error('namaCustomer', '<small class="text-muted"><font color="red">', '</font></small>'); ?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="statusPembayaran">Status</label>
												<select class="form-control" name="statusPembayaran" id="statusPembayaran">
													<option value="belum bayar">belum bayar</option>
													<option value="uang muka">uang muka</option>
													<option value="lunas">lunas</option>
													<?php echo form_error('statusPembayaran', '<small class="text-muted"><font color="red">', '</font></small>'); ?>
												</select>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="noHp">Nomor HP</label>
												<input type="text" class="form-control" name="noHp" id="noHp" value="<?= set_value('noHp') ?>" placeholder="Masukkan Nomor HP atau WA">
												<?php echo form_error('noHp', '<small class="text-muted"><font color="red">', '</font></small>'); ?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="alamat">Alamat</label>
												<input type="text" class="form-control" name="alamat" id="alamat" value="<?= set_value('alamat') ?>" placeholder="Masukkan Alamat">
												<?php echo form_error('alamat', '<small class="text-muted"><font color="red">', '</font></small>'); ?>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="namaBarang">Nama Barang</label>
												<input type="text" class="form-control" name="namaBarang" id="namaBarang" value="<?= set_value('namaBarang') ?>" placeholder="Masukkan Tipe HP">
												<?php echo form_error('namaBarang', '<small class="text-muted"><font color="red">', '</font></small>'); ?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="imei">Imei/SN</label>
												<input type="number" class="form-control" name="imei" id="imei" value="<?= set_value('imei') ?>" placeholder="Masukkan Imei/SN">
												<?php echo form_error('imei', '<small class="text-muted"><font color="red">', '</font></small>'); ?>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="kerusakan">kerusakan</label>
												<input type="text" class="form-control" id="kerusakan" name="kerusakan"  value="<?= set_value('kerusakan') ?>" placeholder="Masukkan kerusakan">
												<?php echo form_error('kerusakan', '<small class="text-muted"><font color="red">', '</font></small>'); ?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="hargaService">Harga Service</label>
												<input type="number" class="form-control" name="hargaService" id="hargaService" value="<?= set_value('hargaService') ?>" placeholder="Masukkan Harga Service">
												<?php echo form_error('hargaService', '<small class="text-muted"><font color="red">', '</font></small>'); ?>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="uangPanjar">DP/Panjar</label>
												<input type="number" class="form-control" name="uangPanjar" id="uangPanjar" value="<?= set_value('uangPanjar') ?>" placeholder="Masukkan DP/Panjar">
												<?php echo form_error('uangPanjar', '<small class="text-muted"><font color="red">', '</font></small>'); ?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="perbaikan">Perbaikan</label>
												<input type="text" class="form-control" name="perbaikan" id="perbaikan" value="<?= set_value('perbaikan') ?>" placeholder="Perbaikan">
												<?php echo form_error('perbaikan', '<small class="text-muted"><font color="red">', '</font></small>'); ?>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="keterangan">Keterangan</label>
										<textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Masukkan keterangan Nota Service"><?= set_value('keterangan') ?></textarea>
										<?php echo form_error('keterangan', '<small class="text-muted"><font color="red">', '</font></small>'); ?>
									</div><hr/>
									<div class="row">
										<div class="col-md-3">
											<button type="submit" class="btn btn-primary btn-block">Simpan</button>
										</div>
									</div>
								</form>

							</div>
						</div>
					</div>
				</div>
				
	    	</div>
	    </section>
	</div>
</div>