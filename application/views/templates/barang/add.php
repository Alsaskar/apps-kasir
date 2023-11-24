<form method="post" enctype="multipart/form-data" action="<?=base_url('barang/tambah-barang');?>">

<div class="row justify-content-center product-details">
    <div class="col-md-6">
        <div class="card">
            <div class="row no-gutters px-2 py-2">
                <div class="col-md-6">
                    <div class="container">
                        <img id="preview-image" src="#" alt="Preview Gambar" class="card-img" style="display:none;max-height: 400px;">
                        <img src="https://via.placeholder.com/150" class="card-img" id="temporary-img" alt="Product Image">
                        <div class="custom-file btn-choose-image">
                            <input type="file" name="customFile" class="custom-file-input" id="customFile" onchange="previewImage()">
                            <label class="custom-file-label" for="customFile">Pilih Gambar</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card-body">
                            <div class="text-right">
                                <input type="submit" name="Add" class="btn btn-primary" value="Tambah">
                            </div>
                            <div class="form-group">
                                <label for="barCode">Kode Produk:</label>
                                <input type="text" readonly class="form-control" name="barCode" id="barCode" value=" <?= $_SESSION['barcode'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="namaBarang">Nama Produk:</label>
                                <input type="text" class="form-control" id="namaBarang" name="namaBarang" placeholder="Nama Produk Anda">
                            </div>
                            <div class="form-group">
                                <label for="harga">Harga:</label>
                                <input type="text" class="form-control" id="harga" name="harga" placeholder="10000">
                            </div>
                            <div class="form-group">
                                <label for="stok">Stok:</label>
                                <input type="text" class="form-control" id="stok" name="stok" placeholder="50">
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="width:100%;">
                        <label for="deskripsi">Deskripsi:</label>
                        <textarea name="deskripsi" placeholder="Deskripsi Produk" class="form-control" id="deskripsi" placeholder="" cols="30" rows="4"></textarea>
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