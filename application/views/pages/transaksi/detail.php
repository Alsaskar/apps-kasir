<body class="hold-transition sidebar-mini layout-fixed">
 
<?php 
 
$message = $this->session->flashdata('msg_sweetalert');
 
if (isset($message)) {
  echo $message;
  $this->session->unset_userdata('msg_sweetalert');
}
 
?>


<style> 
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
    .myElement {
        background-color: white;
    }

    @media print {
        .cetakNota{
            display: none;
        }

        .card{
            display: none;
        }

        @page { size: auto;  margin: 5mm; }
    }
</style>
<div class="wrapper">
    <?= $sidebar ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper pb-3">
        <section class="content">
          
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <!-- Bagian Struk Pesanan -->
                    <div class="struk-container">
                        <div class="logo">
                            <img src="<?=base_url('assets/images/logo-toko/'.$getOwner->photo_toko);?>" alt="Logo Toko">
                        </div>
                        <div class="toko-name">
                            <?=$getOwner->nama_toko?>
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
                                    <td style="padding-left: 10px;" id='waktu-transaksi'>: <?=$transaksi->tanggal_pesanan?></td>
                                </tr>
                                <tr style="margin-bottom: -5px;">
                                    <th style="padding-right: 10px;">No. Struk</th>
                                    <td style="padding-left: 10px;" id="no-struk">: <?=$transaksi->no_transaksi?></td>
                                </tr>
                                <tr style="margin-bottom: px;">
                                    <th style="padding-right: 10px;">Jenis Pembayaran</th>
                                    <td style="padding-left: 10px;" id="jenis-pembayaran">: <?=$transaksi->metode_pembayaran?></td>
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
                                </tr>
                            </thead>
                            <tbody id="detailbarang">
                                <?php $biaya=0;?>
                                <?php foreach ($detail->result() as $item): ?>
                                <tr>
                                    <td><?=$item->nama_barang?></td>
                                    <td>x<?=$item->jumlah?></td>
                                    <td>Rp.<?=number_format($item->harga_satuan, 0, '.', ',');?></td>
                                    <td>Rp.<?=number_format($item->harga_satuan * $item->jumlah, 0, '.', ',');?></td>
                                    <?php 
                                    $subTotal = $item->harga_satuan * $item->jumlah;
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
                                Bayar/Uang Pelanggan: Rp.<?=number_format($transaksi->uang_pelanggan, 0, '.', ',');?>
                            </div>
                            <div class="detail-item" id="uang-kembalian">
                                Kembalian: Rp. <?=number_format($transaksi->uang_kembalian, 0, '.', ',');?>
                            </div>
                        </div>

                        <div class="divider"></div>

                        <div class="detail">
                            <div class="detail-item">
                            Rekening: <?=$getOwner->bankName?> <?=$getOwner->bankAccountNumber?> <?=$getOwner->bankAccountName?>
                            </div>
                        </div>
                    
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-4">
                            <button onclick="window.print();" class="btn btn-primary btn-block cetakNota"><i class="fas fa-print"></i> Cetak Nota</button>
                        </div>
                    </div>

                </div>
            </div>

        </section>
    <div>
</div>
    
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>