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
                            <h5>Service Handphone, Computer, Laptop & TV</h5>
                            <h5><?= $getOwner->no_hp ?></h5>
                            <h6><?= $getOwner->alamat_toko ?></h6>
                        </div>
                    </div>
                </div>

                <!-- Apabila status nota telah selesai atau batal -->
                <?php if($getNota->status == 'selesai' || $getNota->status == 'batal'){ ?>
                <div id="ket" class="cetakNota">
                    <hr/><div class="alert alert-warning">
                        Service ini telah <?= $getNota->status == 'selesai' ? 'selesai' : 'dibatalkan' ?>
                    </div>
                </div>
                <?php } ?>

                <div class="row mt-4">
                    <div class="col-md-6">

                        <!-- Data Konsumen -->
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr align="center">
                                    <th colspan="3">Data Konsumen</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Nama</td>
                                    <td align="center">:</td>
                                    <td><?= $getNota->namaCustomer ?></td>
                                </tr>
                                <tr>
                                    <td>No WA</td>
                                    <td align="center">:</td>
                                    <td><?= $getNota->noHp ?></td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td align="center">:</td>
                                    <td><?= $getNota->alamat ?></td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Data Barang -->
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr align="center">
                                    <th colspan="3">Data Barang</th>
                                    <th colspan="2">Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Type Item</td>
                                    <td align="center">:</td>
                                    <td><?= $getNota->tipeHp ?></td>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td>Imei/SN</td>
                                    <td align="center">:</td>
                                    <td><?= $getNota->imei ?></td>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td>Kerusakan</td>
                                    <td align="center">:</td>
                                    <td><?= $getNota->kerusakan ?></td>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td>Perbaikan</td>
                                    <td align="center">:</td>
                                    <td><?= $getNota->perbaikan ?></td>
                                    <td><b>Total</b></td>
                                    <td><?= rupiah($getNota->hargaService) ?></td>
                                </tr>
                                <tr>
                                    <th colspan="4"><b><center>DP</center></b></th>
                                    <th><?= rupiah($getNota->uangPanjar) ?></th>
                                </tr>
                                <tr>
                                    <th colspan="4"><b><center>Sisa</center></b></th>
                                    <th>
                                        <?php 
                                        
                                        $sisa = $getNota->hargaService - $getNota->uangPanjar;

                                        echo rupiah($sisa);
                                            
                                        ?>
                                    </th>
                                </tr>
                            </tbody>
                        </table>

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

                        <?php if($getNota->status == 'proses'){ ?>

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