<style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        .product-details {
            margin-top: 20px;
        }
    </style>

<body class="hold-transition sidebar-mini layout-fixed">
 
<?php 
 
$message = $this->session->flashdata('msg_sweetalert');
 
if (isset($message)) {
  echo $message;
  $this->session->unset_userdata('msg_sweetalert');
}
 
?>

 <div class="wrapper">
    <?= $sidebar ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper pb-3">
          <section class="content">
                <div class="container-fluid"> 
                        <!-- Form Cek Barcode -->
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title text-center">Cek Barcode</h5> <br>
                                           <form action="" method="post">
                                                <div class="form-group">
                                                    <label for="barcodeInput">Barcode ID:</label>
                                                    <input type="text" class="form-control" id="barcodeInput" name="barcodeInput" placeholder="Masukkan Barcode ID">
                                                </div>
                                                <button type="submit" name="checkProduct" class="btn btn-primary btn-block">Cek Produk</button>
                                           </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?=$display?>

                </div>
          </div>
      </section>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        focusElement();
    });

    function focusElement() {
        var inputElement = document.getElementById('barcodeInput');
        if (inputElement) {
            inputElement.focus();
        }
    }
</script>