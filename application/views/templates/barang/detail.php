<form method="post" enctype="multipart/form-data" action="<?=base_url('barang/edit-barang');?>">
<input type="text" class="d-none" value="barang/create/<?=$barang->id?>" name="url">
<input type="text" class="d-none" value="<?=$barang->id?>" name="id">

<div class="row justify-content-center product-details">
    <div class="col-md-6">
        <div class="card">
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
</form>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function previewImage() {
        var input = document.getElementById('customFile');
        var preview = document.getElementById('preview-image');
        var file = input.files[0];
        var reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            document.getElementById("temporary-img").style.display="none";
        };

        reader.readAsDataURL(file);
    }
</script>