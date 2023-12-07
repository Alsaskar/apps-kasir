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
                        <div id="updatebutton" class="col-md-6 mt-3">
                            <button onclick="update();" class="btn btn-secondary btn-block cetakNota">
                            <i class="fas fa-receipt nav-icon"></i> 
                            Update Nota</button>
                        </div>
                    </div>

                    <div id="update">
                        
                    </div>
                </div>
            </div>

            <!-- Area Tampilan Data Nota -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header cetakNota">
                        Data Nota 
                        <input type="text" class="d-none" id="testing2" placeholder="testing2">
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
    var scan = document.getElementById("scanInput");

   document.addEventListener('DOMContentLoaded', function() {
        focusElement();
        $("#button").hide();
        $("#update").hide();
        $("#updatebutton").hide();
    });

    function update(){
        var sisa = $("#sisa").val();
        var pembayaran = $("#testing2").val();
        var statusNota = $("#status-nota").val();
        var statusNotaBaru = $("#status-nota-baru").val();
        var keterangan = $("#keterangan").val();

        if(statusNotaBaru == 'dibatalkan'){
            var isConfirmed = confirm("Apakah Anda yakin ingin Membatalkan Nota ini?");
            if (isConfirmed) {
                $.ajax({
                        url: "<?php echo base_url('Nota/cancelNota'); ?>",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            kode: scan.value,
                            keterangan: keterangan
                        },
                        success: function(response) {
                            location.reload();
                        }
                    });
            } else {
            }
        }else{
            if(pembayaran >= sisa){
            if(statusNota == "Selesai" || statusNota == "Menunggu Customer"){
                Swal.fire({
                    title: 'Konfirmasi!',
                    text: 'Apakah Anda yakin ingin Menyelesaikan Nota ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Lanjutkan!',
                    cancelButtonText: 'Batal'
                    }).then((result) => {
                    if (result.value) {
                        Swal.fire({
                        title: "Success",
                        text: "Nota Telah di Perbarui",
                        icon: "success",})
                        $.ajax({
                            url: "<?php echo base_url('Nota/bayarNota'); ?>",
                            type: "POST",   
                            dataType: 'json',
                            data: {
                                kode: scan.value,
                                keterangan: keterangan,
                                pembayaranNota: pembayaran,
                                statusNota: statusNotaBaru
                            },
                            success: function(response) {
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                        title: "Operasi diBatalkan",
                        text: "Nota ini akan Menunggu Keputusan Berikutnya",
                        icon: "error",})
                    }
                });

            }else{
                Swal.fire({
                title: "Pembayaran Gagal",
                text: "Status Nota Harus Sudah Selesai Sebelum Melakukan Pembayaran",
                icon: "error",})
            }
            }else{
                Swal.fire({
                title: "Pembayaran Gagal",
                text: "Jumlah Pembayaran Tidak Boleh dibawah Jumlah sisa Bayar",
                icon: "error",})
            }
        }
    }
    function focusElement() {
            var inputElement = document.getElementById('scanInput');
            if (inputElement) {
                inputElement.focus();
            }
        }

    function formatCurrency(input) {
        var angka2 = input.value;
        var cleaned = angka2.replace(/[^\d]/g, '');

        // Parse sebagai integer
        var integerValue = parseInt(cleaned, 10);

        $("#testing2").val(integerValue);

        var angka = $("#testing2").val();

        var angkaStr = angka.toString();

        // Pisahkan angka menjadi bagian desimal dan bagian angka
        var parts = angkaStr.split('.');
        var angkaBagian = parts[0];

        // Pisahkan bagian angka menjadi grup tiga digit
        var reversed = angkaBagian.split('').reverse().join('');
        var groups = reversed.match(/\d{1,3}/g);
        var formatted = groups.join('.').split('').reverse().join('');

        // Tambahkan koma untuk bagian desimal jika ada
        var desimalBagian = parts[1] ? ',' + parts[1] : '';

        // Gabungkan bagian angka dan desimal
        var hasilAkhir = formatted + desimalBagian;

        // Tampilkan nilai yang telah diformat
        $("#pembayaran").val(hasilAkhir);

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
                            $("#button").show();
                            $("#update").show();
                            if(response.status_nota != 'dibatalkan' || response.status_nota != 'diambil Customer'){
                                $("#updatebutton").show();
                                $("#update").html(`
                            <div class="form-group">
                                <label for="kondisi">Metode Pembayaran:</label>
                                <select class="form-control" id="metode">
                                    <option value="Tunai">Tunai</option>
                                    <option value="Debit">Debit</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="kondisi">Sisa Pembayaran: ${response.sisa}</label>
                                <input id='sisa' value="${response.sisaSystem}" class="d-none">
                                <input id='status-nota' value="${response.status_nota}" class="d-none">
                                <input id='pembayaran' onkeyup="formatCurrency(this)" class="form-control" placeholder="Contoh: 400000">
                            </div>
                            <div class="form-group">
                                <label for="kondisi">Status Nota: </label>
                                <select class="form-control" id="status-nota-baru">
                                    <option value="${response.status_nota}">${response.status_nota}</option>
                                    <option disabled>-----------------</option>
                                    <option value="diambil Customer">diambil Customer</option>
                                    <option value="Menunggu Customer">Menunggu Customer</option>
                                    <option value="dibatalkan">dibatalkan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="keterangan">Keterangan:</label>
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="4">${response.lastKeterangan}</textarea>
                            </div>
                            `);
                            }else{

                            }
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
                                                <th colspan="4"><b><center>Pembayaran</center></b></th>
                                                <th>
                                                ${response.pembayaran}
                                                </th>
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