<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

$route[ 'default_controller' ]   = 'C_Home';
$route[ 'Home' ]                 = 'C_Home';
$route[ '404_override' ]         = '';
$route[ 'translate_uri_dashes' ] = FALSE;

$route[ 'Key-Creator' ] = 'Key_creator';

// Artikel
$route[ 'artikel/semua' ]                         = 'C_Home/semua_artikel';
$route[ 'artikel/semua/(:num)' ]                  = 'C_Home/semua_artikel/$1';
$route[ 'artikel/kategori/(:any)' ]               = 'C_Home/semua_artikel/$1';
$route[ 'artikel/kategori/(:any)/(:any)' ]        = 'C_Home/semua_artikel/$1/$2';
$route[ 'artikel/kategori/(:any)/(:any)/(:num)' ] = 'C_Home/semua_artikel/$1/$2/$3';
$route[ 'artikel/(:any)' ]                        = 'C_Home/artikel/$1';

$route[ 'Struktur-Organisasi' ] = 'C_Home/struktur_organisasi';
$route[ 'Wilayah-Kerja' ]       = 'C_Home/wilayah_kerja';
$route[ 'Tentang-Kami' ]        = 'C_Home/tentang_kami';

// Auth
$route[ 'Auth-Register' ] = 'C_Auth/register';
$route[ 'Auth-Login' ]    = 'C_Auth/index';
$route[ 'Auth-Logout' ]   = 'C_Auth/logout';
$route[ 'Auth-Validate' ] = 'C_Auth/validate_field';

// Admin
$route[ 'Dashboard-Admin' ] = 'C_Admin';

// Admin - Users Management
$route[ 'Manage-Users' ]        = 'C_Users';
$route[ 'Get-Users' ]           = 'C_Users/get_users';
$route[ 'Add-Users' ]           = 'C_Users/add_user';
$route[ 'Edit-Users/(:num)' ]   = 'C_Users/edit_user/$1';
$route[ 'Delete-Users/(:num)' ] = 'C_Users/delete_user/$1';

// Admin - Management Area
$route[ 'Manage-Area' ]             = 'C_Area';
$route[ 'Add-RW' ]                  = 'C_Area/rw_add';
$route[ 'Edit-RW/(:num)' ]          = 'C_Area/rw_edit/$1';
$route[ 'Delete-RW/(:num)' ]        = 'C_Area/rw_delete/$1';
$route[ 'Add-RT' ]                  = 'C_Area/rt_add';
$route[ 'Edit-RT/(:num)' ]          = 'C_Area/rt_edit/$1';
$route[ 'Delete-RT/(:num)' ]        = 'C_Area/rt_delete/$1';
$route[ 'Ketua-PKK/(:num)' ]        = 'C_Area/ketua_pkk/$1';
$route[ 'Set-Ketua-PKK/(:num)' ]    = 'C_Area/set_ketua_pkk/$1';
$route[ 'Remove-Ketua-PKK/(:num)' ] = 'C_Area/remove_ketua_pkk/$1';

// Admin - Management Log
$route[ 'Manage-Log' ] = 'C_Log';

// Petugas
$route[ 'Dashboard-Petugas' ] = 'C_Petugas';
$route[ 'Manage-Nasabah' ]    = 'C_Petugas/nasabah';

// Petugas - Management Jenis Sampah
$route[ 'Manage-Jenis-Sampah' ]        = 'C_JenisSampah';
$route[ 'Get-Jenis-Sampah' ]           = 'C_JenisSampah/get_jenis_sampah';
$route[ 'Add-Jenis-Sampah' ]           = 'C_JenisSampah/add_jenis_sampah';
$route[ 'Edit-Jenis-Sampah/(:num)' ]   = 'C_JenisSampah/edit_jenis_sampah/$1';
$route[ 'Delete-Jenis-Sampah/(:num)' ] = 'C_JenisSampah/delete_jenis_sampah/$1';

// Petugas - Management Sampah
$route[ 'Manage-Sampah' ]        = 'C_Sampah';
$route[ 'Add-Sampah' ]           = 'C_Sampah/add_sampah';
$route[ 'Edit-Sampah/(:num)' ]   = 'C_Sampah/edit_sampah/$1';
$route[ 'Delete-Sampah/(:num)' ] = 'C_Sampah/delete_sampah/$1';

// Petugas - Management Harga Sampah
$route[ 'Get-Last-Harga-Sampah/(:num)' ] = 'C_Sampah/get_last_harga/$1';
$route[ 'Edit-Harga-Sampah/(:num)' ]     = 'C_Sampah/update_harga/$1';
$route[ 'Rollback-Harga-Sampah/(:num)' ] = 'C_Sampah/delete_harga/$1';

// Petugas - Management Transaksi Sampah
$route[ 'Manage-Transaksi' ]           = 'C_Transaksi';
$route[ 'Search-Sampah' ]              = 'C_Sampah/search_pilih_sampah';
$route[ 'Search-Harga-Sampah/(:any)' ] = 'C_Sampah/search_harga_sampah/$1';
$route[ 'Search-Nasabah' ]             = 'C_Transaksi/search_pilih_nasabah';
$route[ 'Add-Transaksi' ]              = 'C_Transaksi/add_transaksi';
$route[ 'Checkout-Transaksi/(:any)' ]  = 'C_Transaksi/checkout/$1';
$route[ 'Checkout-Print/(:any)' ]      = 'C_Transaksi/print_checkout/$1';
$route[ 'Checkout-Print-PDF/(:any)' ]  = 'C_Transaksi/print_pdf_invoice/$1';
$route[ 'Checkout-Process' ]           = 'C_Transaksi/checkout_process';

// Petugas - Management Hasil Karya Sampah
$route[ 'Hasil-Karya' ]                 = 'C_Hasil_Karya';
$route[ 'Hasil-Karya/add' ]             = 'C_Hasil_Karya/add';
$route[ 'Hasil-Karya/save' ]            = 'C_Hasil_Karya/save';
$route[ 'Hasil-Karya/edit/(:num)' ]     = 'C_Hasil_Karya/edit/$1';
$route[ 'Hasil-Karya/update/(:num)' ]   = 'C_Hasil_Karya/update/$1';
$route[ 'Hasil-Karya/delete/(:num)' ]   = 'C_Hasil_Karya/delete/$1';
$route[ 'Hasil-Karya/get_subkategori' ] = 'C_Hasil_Karya/get_subkategori';

// Front routes
$route[ 'karya' ]               = 'C_hasil_karya/semua_karya';
$route[ 'karya/detail/(:num)' ] = 'C_hasil_karya/detail/$1';

// Petugas - Management Peta Sampah
$route[ 'Peta-Wilayah' ]       = 'C_Peta';
$route[ 'Add-Peta' ]           = 'C_Peta/add_peta';
$route[ 'Edit-Peta/(:num)' ]   = 'C_Peta/update_peta/$1';
$route[ 'Delete-Peta/(:num)' ] = 'C_Peta/delete_peta/$1';

// Petugas - Management Laporan Sampah
$route[ 'Laporan-Transaksi' ] = 'C_Transaksi/laporan';

// Nasabah
$route[ 'Dashboard-Nasabah' ]         = 'C_Nasabah';
$route[ 'Profile-Nasabah' ]           = 'C_Nasabah/profile';
$route[ 'Update-Profile/(:num)' ]     = 'C_Nasabah/update_profile/$1';
$route[ 'Riwayat-Transaksi-Nasabah' ] = 'C_Nasabah/riwayat_transaksi';
$route[ 'Tarik-Tabungan-Nasabah' ]    = 'C_Nasabah/tarik_tabungan';
$route[ 'Proses-Tarik-Tabungan' ]     = 'C_Nasabah/proses_tarik_tabungan';

// Notifikasi
$route[ 'Notifikasi' ]             = 'C_Notifikasi/semua';
$route[ 'Get-Notifikasi' ]         = 'C_Notifikasi/get_notifikasi';
$route[ 'Read-Notifikasi/(:num)' ] = 'C_Notifikasi/mark_as_read/$1';
$route[ 'Read-All-Notifikasi' ]    = 'C_Notifikasi/mark_all_as_read';