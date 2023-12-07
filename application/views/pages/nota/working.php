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
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper pb-3">
    <section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- Form Scan Nota -->
            <div class="col-md-4 cetakNota">
                <div class="card px-2 py-2">
                    <div class="row" id="button">
                        <div class="col-md-6 mt-3">
                            <button onclick="window.print();" class="btn btn-primary btn-block cetakNota"><i class="fas fa-print"></i> Cetak Nota</button>
                        </div>
                        <div class="col-md-6 mt-3 <?php if($getNota->status_nota == 'Selesai' || $getNota->status_nota == 'dibatalkan'){echo "d-none";}?>">
                            <button onclick="update();" class="btn btn-secondary btn-block cetakNota">
                            Update</button>
                        </div>
                    </div>
                    <div class="<?php if($getNota->status_nota == 'Selesai' || $getNota->status_nota == 'dibatalkan'){echo "d-none";}?>">
                        <div class="form-group">
                            <label for="kondisi">Kondisi Barang:</label>
                            <select class="form-control" id="kondisi" name="kondisi">
                                <option value="<?=$getNota->status_nota?>"><?=$getNota->status_nota?></option>
                                <option disabled>-----------------</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Ada Kerusakan Lain">Ada Kerusakan Lain</option>
                                <option value="Tidak Selesai">Tidak Selesai</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan:</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="4"><?php echo str_replace(['<br />','<br>','/r' ,'/n'], '', $lastHistory->keterangan)?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Area Tampilan Data Nota -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header cetakNota">
                        Data Nota yang Sedang diKerjakan

                    </div>
                    <div id="nota" class="card-body">
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
</div>
</div>

<input type="text" value="<?=$invoice?>" class="d-none" id="invoice">

<script>
    scan = document.getElementById("invoice");
    document.addEventListener('DOMContentLoaded', function() {
    var scannedData = scan.value;
            $.ajax({
                    url: "<?php echo base_url('Nota/scanNota'); ?>",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        kode: scannedData,
                    },
                    success: function(response) {
                        if(response.nota == true){
                            $("#button").show();
                            $("#nota").html(`
                                <div id="header">
                                        <div class="row">
                                            <div class="col-md-6 col-6">
                                                <img src="${response.image}" style="height: 200px;width: 100%">
                                            </div>
                                            <div class="col-md-6 col-6">
                                                <h5>${response.tipe_toko}</h5>
                                                <h5>${response.no_hp}</h5>
                                                <h6>${response.alamat_toko}</h6>
                                                <img src="${response.invoice}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">

                                    <table class="table table-bordered table-sm">
                                        <thead>
                                            <tr align="center">
                                                <th colspan="3">Data Nota</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Nama Customer</td>
                                                <td align="center">:</td>
                                                <td>${response.nama_customer}</td>
                                            </tr>
                                            <tr>
                                                <td>No WA</td>
                                                <td align="center">:</td>
                                                <td>${response.no_hp}</td>
                                            </tr>
                                            <tr>
                                                <td>Alamat</td>
                                                <td align="center">:</td>
                                                <td>${response.alamat}</td>
                                            </tr>
                                            <tr>
                                                <td>Pembayaran</td>
                                                <td align="center">:</td>
                                                <td>${response.status_pembayaran}</td>
                                            </tr>
                                            <tr>
                                                <td>Status</td>
                                                <td align="center">:</td>
                                                <td>${response.status_nota}</td>
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
                                                <td>${response.nama_barang}</td>
                                                <td colspan="2"></td>
                                            </tr>
                                            <tr>
                                                <td>Imei/SN</td>
                                                <td align="center">:</td>
                                                <td>${response.serial_number}</td>
                                                <td colspan="2"></td>
                                            </tr>
                                            <tr>
                                                <td>Kerusakan</td>
                                                <td align="center">:</td>
                                                <td>${response.kerusakan}</td>
                                                <td colspan="2"></td>
                                            </tr>
                                            <tr>
                                                <td>Perbaikan</td>
                                                <td align="center">:</td>
                                                <td>${response.perbaikan}</td>
                                                <td><b>Total</b></td>
                                                <td>${response.harga_service}</td>
                                            </tr>
                                            <tr>
                                                <th colspan="4"><b><center>DP</center></b></th>
                                                <th>${response.uang_muka}</th>
                                            </tr>
                                            <tr>
                                                <th colspan="4"><b><center>Sisa</center></b></th>
                                                <th>
                                                ${response.sisa}
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div>
                                        <label for="last-activity">
                                        <a style="cursor: pointer;text-decoration: underline;" class="text-dark" href="${response.url}">
                                        Aktivitas Terakhir
                                        </a>
                                        </label>
                                        <p>${response.lastStatus}</p>
                                        <label for="Keterangan">Keterangan</label>
                                        <p>${response.lastKeterangan}</p>
                                    </div>
                                    <div id="note">
                                        <h6><u>Note</u></h6>
                                        <div>- Semua perlengkapan & Acc dibawa pulang</div>
                                        <div>- Pengambilan Barang harus disertai dengan <span style="color: red;">nota</span></div>
                                        <div>- Barang yang sudah dikonfirmasi selesai oleh tim ${response.namaToko} Service harap segera di ambil</div>
                                        <div>- Barang yang sudah lewat 3 bulan setelah diperbaiki & tidak diambil, tim Sutan Service berhak untuk melelang sebagai penggantian biaya service</div>
                                    </div>

                                    <div id="payment" class="mt-3">
                                        <h6><u>Payment Detail</u></h6>
                                        
                                        <table style="width:auto;">
                                            <tbody>
                                                <tr>
                                                    <td>Bank Name</td>
                                                    <td>:</td>
                                                    <td>${response.bankName}</td>
                                                </tr>
                                                <tr>
                                                    <td>Bank Branch</td>
                                                    <td>:</td>
                                                    <td>${response.bankBranch}</td>
                                                </tr>
                                                <tr>
                                                    <td>Bank Account Number</td>
                                                    <td>:</td>
                                                    <td>${response.bankAccountNumber}</td>
                                                </tr>
                                                <tr>
                                                    <td>Bank Account Name</td>
                                                    <td>:</td>
                                                    <td>${response.bankAccountName}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                </div>
                            </div>
                                `);
                        }else{
                            $("#nota").html(`
                            <div><h2>Nota Tidak Ditemukan </h2></div>
                            `);
                        }
                    }
                });

    });

    function update(){
        var status = document.getElementById("kondisi");
        var keterangan = document.getElementById("keterangan");

        Swal.fire({
            title: 'Konfirmasi!',
            text: 'Apakah Anda yakin ingin Update Nota ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Lanjutkan!',
            cancelButtonText: 'Batal'
            }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "<?php echo base_url('Nota/updateNota'); ?>",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        kode: scan.value,
                        status: status.value,
                        keterangan: keterangan.value
                    },
                    success: function(response) {
                        Swal.fire({
                        title: "Berhasil",
                        text: "Nota Telah di Update",
                        icon: "success",})
                        location.reload();
                    }
                    });
            } else {
                Swal.fire({
                title: "Operasi diBatalkan",
                text: "Nota ini akan Menunggu Update Berikutnya",
                icon: "error",})
            }
        });

    }

    
</script>