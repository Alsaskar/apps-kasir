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
 
                <form method="post" enctype="multipart/form-data" action="<?= base_url('barang/edit-barang'); ?>">
                    <!-- <input type="text" class="d-none" value="barang/daftar-barang" name="url"> -->
                    <input type="text" class="d-none" value="<?= $barang->id ?>" name="id">

                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row no-gutters px-2 py-2">
                                        <div class="col-md-6">
                                            <div class="container">
                                                <input type="text" value="<?=$barang->gambar?>" name="old-img" class="d-none">
                                                <img id="preview-image" src="#" alt="Preview Gambar" class="card-img" style="display:none;max-height: 400px;">
                                                <img src="<?=base_url("assets/images/barang/".$barang->gambar)?>" class="card-img" id="temporary-img" alt="Product Image">
                                                <div class="custom-file btn-choose-image">
                                                    <input type="file" name="customFile" class="custom-file-input" id="customFile" onchange="previewImage()">
                                                    <label class="custom-file-label" for="customFile">Pilih Gambar</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card-body">
                                                    <div class="text-right">
                                                        <input type="submit" name="Add" class="btn btn-primary" value="Simpan">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="barCode">Kode Produk:</label>
                                                        <input type="text" readonly class="form-control" name="barCode" id="barCode" value=" <?= $barang->id ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="namaBarang">Nama Produk:</label>
                                                        <input type="text" class="form-control" id="namaBarang" name="namaBarang" value="<?=$barang->nama_barang?>" placeholder="Nama Produk Anda">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="harga">Harga:</label>
                                                        <input type="number" class="form-control" id="harga" name="harga" value="<?=$barang->harga?>" placeholder="10000">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="stok">Stok:</label>
                                                        <input type="number" class="form-control" id="stok" name="stok" value="<?=$barang->stok?>" placeholder="50">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" style="width:100%;">
                                                <label for="deskripsi">Deskripsi:</label>
                                                <textarea name="deskripsi" placeholder="Deskripsi Produk" class="form-control" id="deskripsi" placeholder="" cols="30" rows="4"><?=str_replace(['<br />','<br>','/r' ,'/n'], '', $barang->deskripsi)?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
 
            </div>
        </section>
    </div>
</div>
 
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
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