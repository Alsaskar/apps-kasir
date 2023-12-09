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
 
                        <h2>Tambah Karyawan</h2><hr/>
 
                        <form method="post" action="">
                            <div class="form-group">
                                <label for="firstName">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter first name" value="<?= set_value('firstName') ?>">
                                <?php echo form_error('firstName', '<small class="text-muted"><font color="red">', '</font></small>'); ?>
                            </div>
 
                            <div class="form-group">
                                <label for="lastName">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter last name" value="<?= set_value('lastName') ?>">
                                <?php echo form_error('lastName', '<small class="text-muted"><font color="red">', '</font></small>'); ?>
                            </div>
 
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="<?= set_value('email') ?>">
                                <?php echo form_error('email', '<small class="text-muted"><font color="red">', '</font></small>'); ?>
                            </div>
 
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                                <?php echo form_error('password', '<small class="text-muted"><font color="red">', '</font></small>'); ?>
                            </div>
 
                            <div class="form-group">
                                <label>Status Karyawan</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="statusKaryawan" id="aktif" value="yes" checked>
                                    <label class="form-check-label" for="aktif">Aktif</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="statusKaryawan" id="tidakAktif" value="no">
                                    <label class="form-check-label" for="tidakAktif">Tidak Aktif</label>
                                </div>
                            </div>
 
                            <div class="form-group">
                                <label for="phoneNumber">Nomor Handphone</label>
                                <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Enter phone number">
                                <?php echo form_error('phoneNumber', '<small class="text-muted"><font color="red">', '</font></small>'); ?>
                            </div>
 
                            <div class="form-group">
                                <label>Jabatan</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jabatan" id="kasir" value="cashier" checked>
                                    <label class="form-check-label" for="kasir">Kasir</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jabatan" id="customer service" value="customer service">
                                    <label class="form-check-label" for="customer service">Customer Service</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jabatan" id="teknisi" value="teknisi">
                                    <label class="form-check-label" for="teknisi">Teknisi</label>
                                </div>
                            </div>
 
                            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                        </form>
 
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
            "url": "<?php echo site_url('Owner/listApi') ?>",
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