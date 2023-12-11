<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Dashboard
$route['dashboard'] = 'Dashboard';
$route['change-pass'] = 'Dashboard/change_pass';
$route['logout'] = 'Dashboard/logout';
$route['working'] = 'Dashboard/working';
$route['testing'] = 'Dashboard/testing';

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
$route['barang/edit-barang'] = 'Barang/edit';
$route['barang/detail/(:num)'] = 'Barang/detail/$1';
$route['barang/search/(:any)'] = 'Barang/searchItem/$1';
$route['barang/add-proses/(:any)'] = 'Barang/addProses/$1';

//owner
$route['owner/list'] = 'Owner/list';
$route['owner/list-transaksi'] = 'Owner/listTransaksi';
$route['owner/detail-transaksi/(:any)'] = 'Owner/detailTransaksi/$1';
$route['owner/list-nota'] = 'Owner/listNota';
$route['owner/detail-nota/(:any)'] = 'Owner/detailNota/$1';
$route['owner/nota-activity/(:any)'] = 'Owner/notaActivity/$1';

//kasir
$route['kasir/add'] = 'Kasir/tambah';
$route['kasir/delete-cache/(:num)'] = 'Kasir/deleteCache/$1';
$route['kasir/detail-transaksi/(:any)'] = 'Kasir/detailTransaksi/$1';
$route['kasir/list'] = 'Kasir/list';

//customer service
$route['nota/add'] = 'Nota/add';
$route['nota/list'] = 'Nota/list';
$route['nota/scan'] = 'Nota/scan';
$route['nota/detail/(:num)'] = 'Nota/detail/$1';
$route['nota/edit/(:num)'] = 'Nota/edit/$1';
$route['nota/qrcode/(:any)'] = 'Nota/qrcode/$1';
$route['nota/activity/(:any)'] = 'Nota/activity/$1';
$route['nota/getHistory/(:any)'] = 'Nota/getHistory/$1';

// Teknisi
$route['nota/scan-teknisi'] = 'Nota/scanTeknisi';
$route['nota/working/(:any)'] = 'Nota/working/$1';
$route['nota/working-list'] = 'Nota/workingList';

// Profil
$route['teknisi/profil'] = 'Profil/teknisi';
$route['owner/profil'] = 'Profil/owner';