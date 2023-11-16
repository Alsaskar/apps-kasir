<body class="hold-transition sidebar-mini layout-fixed">
 
<?php 
 
$message = $this->session->flashdata('msg_sweetalert');
 
if (isset($message)) {
  echo $message;
  $this->session->unset_userdata('msg_sweetalert');
}
 
?>


<style>
        .struk-container {
            width: auto;
            height: auto;
            padding: 10px;
            background: white;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin: 0 auto;
            font-family: Arial, sans-serif;
        }
        .logo {
            text-align: center;
        }
        .logo img {
            width: 190px;
            height: 100px;
        }
        .toko-name {
            text-align: center;
            font-weight: bold;
            margin-top: 10px;
        }
        .follow-text {
            text-align: center;
            margin-top: 10px;
        }
        .divider {
            border-top: 1px solid #ccc;
            margin-top: 10px;
        }
        .detail {
            margin-top: 10px;
        }
        .detail-item {
            margin-bottom: 5px;
        }
        .total-text {
            font-weight: bold;
            margin-top: 10px;
        }
        .transparent-background {
            background-color: rgba(255, 255, 255, 0.5); /* 0.5 adalah tingkat opasitas */
            padding: 20px;
        }
        .payment-input{
            height: 107px; /* Tinggi maksimum 150 piksel */
        }
        
        .card-payment{
            position: absolute;
            width: 500px; /* Tinggi maksimum 150 piksel */
            right:2px;
            border:2px;
        }

    </style>

 <div class="wrapper">
    <?= $sidebar ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper pb-3">
          <section class="content">
          <div class="row">
            <div class="col-lg-8">
                <!-- Bagian Daftar Produk -->
                <div class="card">
                    <div class="card-header">Daftar Produk</div>
                    <div class="payment-input">
                            <div class="card">
                                <div class="card-body card-payment">
                                <form action="" method="post">
                                <input type="text" id="no-transaksi" class="d-none" name="notransaksi">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="jenisPembayaran">Jenis Pembayaran:</label>
                                            <select name="jenisPembayaran" class="form-control" id="jenisPembayaran">
                                                <option value="tunai">Tunai</option>
                                                <option value="debit">Debit</option>
                                                <option value="kredit">Kredit</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="jumlahBayar">Jumlah Bayar:</label>
                                            <input type="number" class="form-control" name="jumlahBayar" placeholder="Contoh: 20000" id="jumlahBayar">
                                        </div>

                                        <div class="col-md-6">
                                        </div>

                                        <div class="col-md-6 mt-2 text-right">

                                            <button onclick="SaveStruct();" type="button" class="btn btn-primary">Simpan</button>

                                            <input name="finish" type="submit" class="btn btn-success" value="Selesai">
                                        </div>
                                    </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Cari...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button">Cari</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                        <div class="row">
                        <?php 
                        $index =0;
                        ?>
                        <?php foreach ($barang->result() as $item): ?>
                                    <?php $index++;?>

                                    <div class="d-none">
                                        <input type="text" value="<?=$item->nama_barang?>" id="namaBarang-<?=$index?>">
                                        <input type="text" value="<?=$item->harga?>" id="harga-<?=$index?>">
                                        <input type="text" value="<?=$item->id?>" id="barangId-<?=$index?>">
                                    </div>

                                    <div class="col-md-4">
                                        <div class="card px-2 py-1">
                                            <div class="product-card">
                                                <img class="product-image" style="height:250px;" src="<?=base_url('assets/images/barang/'.$item->gambar)?>" alt="<?=$item->nama_barang?>">
                                                <h4 class="mt-2"><?=$item->nama_barang?></h4>
                                                <p>Harga: Rp. <?=number_format($item->harga, 0, '.', ',');?></p>
                                                <p>Stok Tersisa: <span id="stok-tersisa-<?=$index?>"><?=$item->stok?></span></p>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <button onclick="decrement(<?=$index?>);" id="decrement-<?=$index?>" class="btn btn-outline-secondary" type="button">-</button>
                                                    </div>
                                                    <input id="quantity-<?=$index?>" type="number" readonly class="form-control text-center" value="1">
                                                    <div class="input-group-append">
                                                        <button onclick="increment(<?=$index?>);" id="increment-<?=$index?>" class="btn btn-outline-secondary" type="button">+</button>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-center">
                                                    <div class="col-md-4 mt-2 mb-2">
                                                        <button onclick="button(<?=$index?>);" id="button-<?=$index?>" class="btn btn-primary btn-block mt-1">Tambah</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                        <?php endforeach; ?>
                        </div>

                        <!-- Isi dengan daftar produk -->
                    </div>
                </div>
            </div>
                <!-- Bagian Struk Pesanan -->
                    <div class="struk-container">
                            <div class="logo">
                                <img src="<?=base_url('assets/images/logo/sutanstore.png');?>" alt="Logo Toko">
                            </div>
                            <div class="toko-name">
                                Nama Toko Anda
                            </div>
                            <div class="follow-text">
                                Follow us on Instagram or Facebook: @sutan.service
                            </div>
                            <div class="divider"></div>
                            <div class="detail">
                            <table class="table-borderless">
                                <tbody>
                                <tr style="margin-bottom: px;">
                                    <th style="padding-right: 10px;">Kasir</th>
                                    <td style="padding-left: 10px;">: <?=$getUser->firstname ." ". $getUser->lastname?></td>
                                </tr>
                                <tr style="margin-bottom: px;">
                                    <th style="padding-right: 10px;">Waktu</th>
                                    <td style="padding-left: 10px;" id='waktu-transaksi'>: </td>
                                </tr>
                                <tr style="margin-bottom: -5px;">
                                    <th style="padding-right: 10px;">No. Struk</th>
                                    <td style="padding-left: 10px;" id="no-struk">: </td>
                                </tr>
                                <tr style="margin-bottom: px;">
                                    <th style="padding-right: 10px;">Jenis Pembayaran</th>
                                    <td style="padding-left: 10px;" id="jenis-pembayaran">: </td>
                                </tr>
                                                        </tbody>
                            </table>

                            </div>
                            <div class="divider"></div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Nama Barang</th>
                                            <th>Jumlah</th>
                                            <th>Harga</th>
                                            <th>Subtotal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="detailbarang">
                                        <?php $biaya=0;?>
                                        <?php foreach ($cache->result() as $item): ?>
                                        <tr>
                                            <td><?=$item->nama_barang?></td>
                                            <td>x<?=$item->jumlah_barang?></td>
                                            <td>Rp.<?=number_format($item->harga_satuan, 0, '.', ',');?></td>
                                            <td>Rp.<?=number_format($item->harga_satuan * $item->jumlah_barang, 0, '.', ',');?></td>
                                            <td><a href="<?php echo base_url('kasir/delete-cache/'.$item->id); ?>" style="color:black"><i class="fas fa-trash"></i></a></td>
                                            <?php 
                                            $subTotal = $item->harga_satuan * $item->jumlah_barang;
                                            $biaya = $biaya + $subTotal;      
                                            ?>
                                        </tr>   
                                    <?php endforeach; ?>
                                        <!-- Tambahkan baris untuk barang-barang lainnya di sini -->
                                    </tbody>
                                </table>
                            <div class="divider"></div>
                            <div id="total-biaya" class="total-text text-right">
                                Total Biaya: Rp.<?=number_format($biaya, 0, '.', ',');?>
                            </div>
                            <div class="divider"></div>
                            <div class="detail">
                                <div class="detail-item" id="uang-pelanggan">
                                    Bayar/Uang Pelanggan: Rp.
                                </div>
                                <div class="detail-item" id="uang-kembalian">
                                    Kembalian: Rp.
                                </div>
                            </div>
                            <div class="divider"></div>
                            <div class="detail">
                                <div class="detail-item">
                                    Rekening: BCA 0262026190 Irtan Sutan Montolalu
                                </div>
                            </div>
                        </div>
                    </div>
            </section>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

        function SaveStruct(){
            var jenisPembayaran = document.getElementById("jenisPembayaran").value;
            var uangPelanggan = document.getElementById("jumlahBayar").value;
            $.ajax({
                url: "<?php echo base_url('Kasir/saveTransaction'); ?>",
                type: "POST",
                data: {
                    jenisPembayaran: jenisPembayaran,
                    uangPelanggan: uangPelanggan
                },
                success: function(response) {
                }
            });

            
            $.ajax({
                url: "<?php echo base_url('Kasir/getDataTransaction'); ?>",
                type: "GET",
                dataType: 'json',
                data: {},
                success: function(response) {
                    $("#waktu-transaksi").html(`: ${response.waktuTransaksi}`);
                    $("#uang-pelanggan").html(`Bayar/Uang Pelanggan: Rp.${response.uangPelanggan}`);
                    $("#uang-kembalian").html(`Kembalian: Rp.${response.uangKembalian}`);
                    $("#no-struk").html(`: ${response.noTransaksi}`);
                    $("#jenis-pembayaran").html(`: ${response.jenisPembayaran}`);
                    document.getElementById("no-transaksi").value=`${response.noTransaksi}`;
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
        }

        function increment(index){
            const decrementButton = document.getElementById("decrement-"+index);
            const incrementButton = document.getElementById("increment-"+index);
            const quantityInput = document.getElementById("quantity-"+index);

            // Menambahkan event listener untuk tombol penambahan
            let currentQuantity = parseInt(quantityInput.value);
            quantityInput.value = currentQuantity + 1;
        }

        function decrement(index){
            const decrementButton = document.getElementById("decrement-"+index);
            const incrementButton = document.getElementById("increment-"+index);
            const quantityInput = document.getElementById("quantity-"+index);

            // Menambahkan event listener untuk tombol penambahan
            let currentQuantity = parseInt(quantityInput.value);
            quantityInput.value = currentQuantity - 1;
        }

        function button(index){
            const namaBarang = document.getElementById("namaBarang-"+index).value;
            const harga = document.getElementById("harga-"+index).value;
            const barangId = document.getElementById("barangId-"+index).value;
            const quantityInput = document.getElementById("quantity-"+index);
            let currentQuantity = parseInt(quantityInput.value);
            var stokTersisa = document.getElementById("stok-tersisa-"+index).innerHTML;

            var stok = parseInt(stokTersisa); 

            if(currentQuantity > stok){
                alert("Jumlah Stok tidak Memadai");
                document.getElementById("quantity-"+index).value=1;
            }else{
                $.ajax({
                    url: "<?php echo base_url('Kasir/execute_action'); ?>",
                    type: "POST",
                    data: {
                        namaBarang: namaBarang,
                        harga: harga,
                        jumlah: currentQuantity,
                        barangId: barangId
                    },
                    success: function(response) {
                        $.ajax({
                        url: "<?php echo base_url('Kasir/cache_transaksi'); ?>",
                        type: "GET",
                        dataType: 'json',
                        data: {},
                        success: function(response) {
                            // Proses data JSON yang diterima dengan looping
                            $("#detailbarang").empty();
                            $("#total-biaya").html(`
                            Total Biaya: Rp.${response.totalBiaya}
                            `);
                            $.each(response.data, function(index, item) {
                                // Tambahkan baris HTML untuk setiap elemen
                                $("#detailbarang").append(
                                    `
                                    <tr>
                                        <td>${item.nama_barang}</td>
                                        <td>x${item.jumlah_barang}</td>
                                        <td>Rp.${item.harga}</td>
                                        <td>Rp.${item.sub_total}</td>
                                        <td><a href="<?php echo base_url('kasir/delete-cache/')?>${item.id}" style="color:black"><i class="fas fa-trash"></i></a></td>
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
                });
            }
        }
    </script>