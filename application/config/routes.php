<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Dashboard
$route['dashboard'] = 'Dashboard';
$route['change-pass'] = 'Dashboard/change_pass';
$route['logout'] = 'Dashboard/logout';

$route['default_controller'] = 'Homepage';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//Register
$route['register'] = 'Register';
$route['verification'] = 'Register/verify';

//Karyawan
$route['karyawan/add-karyawan'] = 'Karyawan/addKaryawan';
$route['karyawan/list'] = 'Karyawan/list';
$route['karyawan/edit/(:num)'] = 'Karyawan/edit/$1';
$route['karyawan/delete/(:num)'] = 'Karyawan/delete/$1';
$route['karyawan/deletedata/(:num)'] = 'Karyawan/deleteData/$1';
$route['karyawan/searchTransaksi'] = 'Karyawan/searchTransaksi';

//barang
$route['barang/daftar-barang'] = 'Barang';
$route['barang/add'] = 'Barang/add';
$route['barang/create'] = 'Barang/create';
$route['barang/tambah-barang'] = 'Barang/tambah';
$route['barang/edit-barang'] = 'Barang/edit';
$route['barang/detail/(:num)'] = 'Barang/detail/$1';
$route['barang/search/(:any)'] = 'Barang/searchItem/$1';

//owner
$route['owner/list'] = 'Owner/list';

//kasir
$route['kasir/add'] = 'Kasir/tambah';
$route['kasir/delete-cache/(:num)'] = 'Kasir/deleteCache/$1';
$route['kasir/detail-transaksi/(:any)'] = 'Kasir/detailTransaksi/$1';
$route['kasir/list'] = 'Kasir/list';

// Teknisi
$route['nota/add'] = 'Nota/add';
$route['nota/list'] = 'Nota/list';
$route['nota/detail/(:num)'] = 'Nota/detail/$1';

// Profil
$route['teknisi/profil'] = 'Profil/teknisi';
$route['owner/profil'] = 'Profil/owner';