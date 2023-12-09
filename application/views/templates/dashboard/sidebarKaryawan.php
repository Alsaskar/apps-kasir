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

        <!-- Menu Kasir -->
        <?php if($getKaryawan->status_karyawan == 'cashier'){ ?>

        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fas fa-user nav-icon"></i>
            <p>Menu kasir<i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('kasir/add') ?>" class="nav-link">
              <i class="fas fa-cash-register nav-icon"></i>
                <p>Tambah Transaksi</p>
              </a>
              <a href="<?= base_url('kasir/list') ?>" class="nav-link">
              <i class="fas fa-receipt nav-icon"></i> 
                <p>Data Transaksi</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Menu Teknisi -->
        <?php }else if($getKaryawan->status_karyawan == 'teknisi'){ ?>
          
          <li class="nav-item">
          <a href="#" class="nav-link">
          <i class="fas fa-sticky-note nav-icon"></i>
            <p>Managament Nota <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('nota/add') ?>" class="nav-link">
              <i class="fas fa-plus-square nav-icon"></i>
                <p>Tambah Nota</p>
              </a>
              <a href="<?= base_url('nota/list') ?>" class="nav-link">
              <i class="fas fa-receipt nav-icon"></i> 
                <p>Data Nota</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item">
          <a href="<?= base_url('teknisi/profil') ?>" class="nav-link">
            <i class="fas fa-user nav-icon"></i>
            <p>Profil</p>
          </a>
        </li>

        <?php } ?>

        <li class="nav-header">MORE</li>

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
