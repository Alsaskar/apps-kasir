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
                    <label for="scanInput">Scan:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="scanInput">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary" onclick="">Unggah Scan</button>
                        </div>
                    </div>

                    <div class="row" id="button">
                        <div class="col-md-6 mt-3">
                            <button onclick="window.print();" class="btn btn-primary btn-block cetakNota"><i class="fas fa-print"></i> Cetak Nota</button>
                        </div>
                        <div id="working" class="col-md-6 mt-3">
                            <button onclick="working();" class="btn btn-secondary btn-block cetakNota">
                            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512"><path opacity="1" fill="#FFFFFF" d="M78.6 5C69.1-2.4 55.6-1.5 47 7L7 47c-8.5 8.5-9.4 22-2.1 31.6l80 104c4.5 5.9 11.6 9.4 19 9.4h54.1l109 109c-14.7 29-10 65.4 14.3 89.6l112 112c12.5 12.5 32.8 12.5 45.3 0l64-64c12.5-12.5 12.5-32.8 0-45.3l-112-112c-24.2-24.2-60.6-29-89.6-14.3l-109-109V104c0-7.5-3.5-14.5-9.4-19L78.6 5zM19.9 396.1C7.2 408.8 0 426.1 0 444.1C0 481.6 30.4 512 67.9 512c18 0 35.3-7.2 48-19.9L233.7 374.3c-7.8-20.9-9-43.6-3.6-65.1l-61.7-61.7L19.9 396.1zM512 144c0-10.5-1.1-20.7-3.2-30.5c-2.4-11.2-16.1-14.1-24.2-6l-63.9 63.9c-3 3-7.1 4.7-11.3 4.7H352c-8.8 0-16-7.2-16-16V102.6c0-4.2 1.7-8.3 4.7-11.3l63.9-63.9c8.1-8.1 5.2-21.8-6-24.2C388.7 1.1 378.5 0 368 0C288.5 0 224 64.5 224 144l0 .8 85.3 85.3c36-9.1 75.8 .5 104 28.7L429 274.5c49-23 83-72.8 83-130.5zM56 432a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z"/></svg> 
                            Kerjakan Nota</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Area Tampilan Data Nota -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header cetakNota">
                        Data Nota
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


<script>
   document.addEventListener('DOMContentLoaded', function() {
        focusElement();
        $("#button").hide();
    });

    var scan = document.getElementById("scanInput");


    function focusElement() {
            var inputElement = document.getElementById('scanInput');
            if (inputElement) {
                inputElement.focus();
            }
        }
   
    function working() {
        Swal.fire({
            title: 'Konfirmasi!',
            text: 'Apakah Anda yakin ingin Mengerjakan Nota ini',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Lanjutkan!',
            cancelButtonText: 'Batal'
            }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "<?php echo base_url('Nota/takeNota'); ?>",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        kode: scan.value,
                    },
                    success: function(response) {
                        Swal.fire({
                        title: "Success",
                        text: "Anda Sudah Mengambil Nota Ini",
                        icon: "success",})
                        window.location.href = "working/"+scan.value;
                    }
                });
            } else {
                Swal.fire({
                title: "Operasi diBatalkan",
                text: "Nota ini akan Menunggu Teknisi Lain",
                icon: "error",})
            }
        });
    }

    scan.addEventListener('keydown', function (event) {
        if (event.key === 'Enter') {
            // Tombol "Enter" ditekan
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
                            if(response.take == false){
                                $("#working").hide();
                            }else{
                                $("#working").show();
                            }
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


            // Mencegah pengiriman formulir (jika elemen input berada dalam formulir)
            event.preventDefault();
        }
    });
</script>