<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dashboard elevation-4">
  <!-- Brand Logo -->
  <a href="<?= base_url('/dashboard') ?>" class="brand-link text-center">
    <img src="<?= base_url('assets/images/shop.png') ?>" alt="" class="brand-image img-circle elevation-3">
    <span class="brand-text font-weight-light">Aplikasi BaDag</span><hr style="background-color: #ffffff;" />
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel d-flex">
      <div class="image">

        <img src="<?= base_url('assets/images/user.png') ?>" class="img-circle elevation-2">
        
      </div>
      <div class="info">
        <a href="#" class="d-block"><?= $getUser->firstname ?></a>
      </div>
    </div><hr style="background-color: #ffffff;" />

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">

        <li class="nav-item">
          <a href="<?= base_url('/dashboard') ?>" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>


        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fas fa-cube nav-icon"></i>

            <p>Manage Toko<i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('barang/create') ?>" class="nav-link">
              <i class="fas fa-solid fa-qrcode nav-icon"></i>
                <p>Buat Produk</p>
              </a>
              <a href="<?= base_url('barang/add') ?>" class="nav-link">
              <i class="fas fa-solid fa-qrcode nav-icon"></i>
                <p>Tambah Stok Produk</p>
              </a>
              <a href="<?= base_url('barang/daftar-barang') ?>" class="nav-link">
              <i class="fas fa-cube nav-icon"></i>

                <p>Daftar Produk</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fas fa-user nav-icon"></i>
            <p>Manage User<i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('karyawan/add-karyawan') ?>" class="nav-link">
                <i class="fas fa-plus-square nav-icon"></i>
                <p>Tambah Karyawan</p>
              </a>
              <a href="<?= base_url('karyawan/list') ?>" class="nav-link">
              <i class="fas fa-user nav-icon"></i>
                <p>Daftar Karyawan</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-header">MORE</li>

        <li class="nav-item">
          <a href="<?= base_url('owner/profil') ?>" class="nav-link">
            <i class="fas fa-user nav-icon"></i>
            <p>Profil</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?= base_url('change-pass') ?>" class="nav-link">
            <i class="fas fa-cog nav-icon"></i>
            <p>Ganti Password</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="#logout" data-toggle="modal" class="nav-link">
            <i class="fas fa-sign-out-alt nav-icon"></i>
            <p>Keluar</p>
          </a>
        </li><br/><br/><br/>

      </ul>
    </nav> <!-- /.sidebar-menu -->
  </div> <!-- /.sidebar -->
</aside>

<!-- Modal Keluar -->
<div class="modal fade" id="logout" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Anda ingin keluar dari sistem ?
      </div>
      <div class="modal-footer">
        <a href="<?= base_url('logout') ?>" class="btn btn-primary">Ya</a>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
      </div>
    </div>
  </div>
</div>