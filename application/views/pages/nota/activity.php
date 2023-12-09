<body class="hold-transition sidebar-mini layout-fixed">

<?php 

$message = $this->session->flashdata('msg_sweetalert');

if (isset($message)) {
  echo $message;
  $this->session->unset_userdata('msg_sweetalert');
}

?>

<style>
    @media print {
        .cetakNota{
            display: none;
        }

        @page { size: auto;  margin: 5mm; }
    }

</style>

<div class="wrapper">
  <!-- Sidebar -->
  <?= $sidebar ?>

  	<!-- Content Wrapper. Contains page content -->
  	<div class="content-wrapper pb-3">
	    <section class="content">
	    	<div class="container-fluid">

                <div id="header">
                    <div class="row">
                        <div class="col-md-6 col-6">
                            <?php if($getOwner->photo_toko == ""){ ?>

                            <img src="<?= base_url('assets/images/no-image.png') ?>" style="height: 200px;width: 100%">

                            <?php }else{ ?>

                                <img src="<?= base_url('assets/images/logo-toko/'.$getOwner->photo_toko) ?>" style="height: 200px;width: 100%">

                            <?php } ?>
                            
                        </div>
                        <div class="col-md-6 col-6">
                            <h5><?= $getOwner->tipe_toko ?></h5>
                            <h5><?= $getOwner->no_hp ?></h5>
                            <h6><?= $getOwner->alamat_toko ?></h6>
                            <img src="<?= base_url('nota/qrcode/'.$invoice);?>">

                        </div>
                    </div>
                </div>

                <!-- Apabila status nota telah selesai atau batal -->
                <?php if($getNota->status_nota == 'diambil cus' || $getNota->status_nota == 'dibatalkan'){ ?>
                <div id="ket" class="cetakNota">
                    <hr/><div class="alert alert-warning">
                        Service ini telah <?= $getNota->status_nota == 'selesai' ? 'selesai' : 'dibatalkan' ?>
                    </div>
                </div>
                <?php } ?>

                <div class="row mt-4">
                    <div class="col-md-6">

                        <!-- Data Konsumen -->
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr align="center">
                                    <th colspan="3">Data Nota</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>No Invoice</td>
                                    <td align="center">:</td>
                                    <td><?= $getNota->no_invoice ?></td>
                                </tr>
                                <tr>
                                    <td>Nama Customer</td>
                                    <td align="center">:</td>
                                    <td><?= $getNota->nama_customer ?></td>
                                </tr>
                                <tr>
                                    <td>No WA</td>
                                    <td align="center">:</td>
                                    <td><?= $getNota->no_hp ?></td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td align="center">:</td>
                                    <td><?= $getNota->alamat ?></td>
                                </tr>
                                <tr>
                                    <td>Pembayaran</td>
                                    <td align="center">:</td>
                                    <td><?= $getNota->status_pembayaran ?></td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td align="center">:</td>
                                    <td><?= $getNota->status_nota ?></td>
                                </tr>
                            </tbody>
                        </table>

                        <table id="table" class="table text-sm text-center table-bordered">
                            <thead>
                            <tr>   
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                            </thead>
                            <tbody class="text-xs">
                                <?php $index = 0;?>
                                <?php foreach ($getHistory as $item): ?>
                                <?php $index++;?>
                                    <tr>
                                        <td><?=$index?></td>
                                        <td><?=$item->tanggal?></td>
                                        <td><?=$item->status?></td>
                                        <td>
                                        <button class="btn btn-primary" onclick="cekAktivitas(<?=$item->id?>)">Cek</button>
                                        </td>
                                    </tr>   
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div id="Keterangan">
                        <label for="Keterangan">Keterangan</label>
                        <p><?=$lastHistory->keterangan?></p>
                        </div>
                        <div id="note">
                            <h6><u>Note</u></h6>
                            <div>- Semua perlengkapan & Acc dibawa pulang</div>
                            <div>- Pengambilan Barang harus disertai dengan <span style="color: red;">nota</span></div>
                            <div>- Barang yang sudah dikonfirmasi selesai oleh tim <?= $getOwner->nama_toko ?> Service harap segera di ambil</div>
                            <div>- Barang yang sudah lewat 3 bulan setelah diperbaiki & tidak diambil, tim Sutan Service berhak untuk melelang sebagai penggantian biaya service</div>
                        </div>

                        <div id="payment" class="mt-3">
                            <h6><u>Payment Detail</u></h6>
                            
                            <table style="width: 70%;">
                                <tbody>
                                    <tr>
                                        <td>Bank Name</td>
                                        <td>:</td>
                                        <td><?= $getOwner->bankName ?></td>
                                    </tr>
                                    <tr>
                                        <td>Bank Branch</td>
                                        <td>:</td>
                                        <td><?= $getOwner->bankBranch ?></td>
                                    </tr>
                                    <tr>
                                        <td>Bank Account Number</td>
                                        <td>:</td>
                                        <td><?= $getOwner->bankAccountNumber ?></td>
                                    </tr>
                                    <tr>
                                        <td>Bank Account Name</td>
                                        <td>:</td>
                                        <td><?= $getOwner->bankAccountName ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4">
                                <button onclick="window.print();" class="btn btn-primary btn-block cetakNota"><i class="fas fa-print"></i> Cetak Nota</button>
                            </div>
                        </div>

                        <?php if($getNota->status_nota == 'proses'){ ?>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <a href="#modalDone" data-toggle="modal" class="btn btn-success btn-block cetakNota"><i class="fas fa-check"></i> Selesai</a>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <a href="#modalReject" data-toggle="modal" class="btn btn-danger btn-block cetakNota"><i class="fas fa-times"></i> Batal</a>
                            </div>
                        </div>

                        <?php } ?>
                        
                    </div>
                </div>
				
	    	</div>
	    </section>
	</div>
</div>

<!-- Modal for Done (Service) -->
<div class="modal fade" id="modalDone" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div align="center">Apakah Anda telah menyelesaikan service ini ?</div>
      </div>
      <div class="modal-footer">
        <a href="?status=selesai" class="btn btn-primary btn-sm">Ya</a>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Belum</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal for Reject (Service) -->
<div class="modal fade" id="modalReject" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div align="center">Apakah Anda ingin membatalkan service ini ?</div>
      </div>
      <div class="modal-footer">
        <a href="?status=batal" class="btn btn-primary btn-sm">Ya</a>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Tidak</button>
      </div>
    </div>
  </div>
</div>


<script>
    function cekAktivitas(index) {
            $.ajax({
                url: "<?php echo base_url('Nota/getHistory/'); ?>"+index,
                type: "GET",
                data: {},
                dataType: 'json',
                success: function(response) {
                    $("#Keterangan").html(`
                    <label for="Keterangan">Status:</label>
                    <p>${response.status}</p>
                    <label for="Keterangan">Keterangan:</label>
                    <p>${response.keterangan}</p>
                    `);
                }
            });
    }


</script>