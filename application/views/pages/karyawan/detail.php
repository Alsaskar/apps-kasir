ss<body class="hold-transition sidebar-mini layout-fixed">

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
	    		
            <form method="post" enctype="multipart/form-data">

                <div class="row"> 
                    <div class="col-lg-4">
                        <div class="card">
                            <input type="file" name="profilePictureInput" id="profilePictureInput" class="d-none">
                            <input type="text" value="<?=$karyawan->photo_karyawan?>" name="profilePictureInput_lama" class="d-none">

                            <label for="profilePictureInput">
                                <img src="<?= base_url('assets/images/profile/'. $karyawan->photo_karyawan)?>" alt="Profil Karyawan" class="card-img-top img-thumbnail cursor-pointer">
                                <div class="btn ml-2 mt-2 btn-primary btn-upload-profile">
                                    <i class="fas fa-camera"></i> Ganti Profil
                                </div>
                            </label>
                            <div class="card-body text-center">
                                <h5 class="card-title"><?=$user->firstname?> <?=$user->lastname?></h5> <br><hr>
                                <input type="text" value="<?=$karyawan->status_karyawan?>" class="d-none" name="jabatan">
                                <p class="card-text"><?=$karyawan->status_karyawan?></p>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-body">
                                <h5 class="card-title">Status Pegawai </h5> <br>
                                <div class="form-group">
                                    <label for="status">Status:</label>
                                    <select name="status_aktif" class="form-control" id="status">
                                        <?php
                                        if($user->verified_email == 'yes'){
                                        echo "
                                        <option value='yes'>Aktif</option>
                                        ";
                                        }elseif($user->verified_email == 'no'){
                                        echo "
                                        <option value='no'>Nonaktif</option>
                                        ";
                                        }
                                        ?>
                                        <option disabled>---------------</option>
                                        <option value='yes'>Aktif</option>
                                        <option value='no'>Nonaktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-bold">Informasi Pribadi</h5><br/><hr />
                                <div class="form-group">
                                    <label for="firstName">Nama Depan:</label>
                                    <input type="text" required class="form-control" id="firstName" name="firstName" value="<?=$user->firstname?>">
                                </div>
                                <div class="form-group">
                                    <label for="lastName">Nama Belakang:</label>
                                    <input type="text" required class="form-control" id="lastName" name="lastName" value="<?=$user->lastname?>">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" required class="form-control" id="email" name="email" value="<?=$user->email?>">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Nomor HP:</label>
                                    <input type="tel" required class="form-control" id="phone" name="phone" value="<?=$karyawan->no_hp?>">
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-body">
                                <h5 class="card-title">Ganti Password</h5> <br>
                                <div class="form-group">
                                    <label for="password">Password:</label>
                                    <input onkeyup="checkPassword()" type="text" class="form-control" id="password" placeholder="Masukkan password baru">
                                    <input value="<?=$user->password?>" type="text" name="password_lama" class="d-none">
                                    <label for="password">Konfirmasi Password:</label>
                                    <input onkeyup="checkPassword()" type="text" class="form-control" name="password" id="confirmPassword" placeholder="Konfirmasi Password">
                                    <p id="message" style="color: red;"></p>
                                    <p class="text-red text-md mt-2">*silahkan kosongkan kolom password bila tidak ingin mengganti password</p>
                                </div>
                                <div class="text-center mt-3">
                                    <input type="submit" class="btn btn-primary" name="simpan" id="submitButton" value="Simpan Perubahan">
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
<script>

        function checkPassword() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirmPassword").value;
            var message = document.getElementById("message");
            var submitButton = document.getElementById("submitButton");

            if (password !== confirmPassword) {
                message.innerHTML = "Password tidak cocok!";
                message.style.color = "red";
                submitButton.disabled = true;
            } else {
                message.innerHTML = "";
                submitButton.disabled = false;
            }
        }
</script>