<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Landingpage::index');
$routes->get('/lowongan', 'Landingpage::lowongan');
// $routes->get('/welcome', 'Landingpage::index');

// $routes->get('login', 'AuthController::login');       
// $routes->post('login', 'AuthController::attemptLogin');

// $routes->get('register', 'AuthController::register');
// $routes->post('register', 'AuthController::attemptRegister');

$routes->get('/profile', 'User::profil');
$routes->get('/data-pribadi', 'User::dataPribadi');
$routes->post('/data-pribadi/save', 'User::saveDataPribadi');
$routes->post('/data-akademik/save', 'User::saveDataAkademik');


$routes->get('/api/provinsi', 'User::getState');
$routes->get('/api/kota', 'User::getCities');
$routes->get('/api/kotaDom', 'User::getCitiesDom');

$routes->post('cv/uploads/(:num)', 'Upload::cv/$1');
$routes->get('cv/delete/(:num)', 'Upload::deletecv/$1');
$routes->post('proposal/uploads/(:num)', 'Upload::proposal/$1');
$routes->get('proposal/delete/(:num)', 'Upload::deleteproposal/$1');
$routes->post('surat-permohonan/uploads/(:num)', 'Upload::suratPermohonan/$1');
$routes->get('surat-permohonan/delete/(:num)', 'Upload::deleteSuratPermohonan/$1');
$routes->post('ktp-kk/uploads/(:num)', 'Upload::ktp_kk/$1');
$routes->get('ktp/delete/(:num)', 'Upload::deletektp/$1');

$routes->post('bpjs-kes/uploads/(:num)', 'Upload::bpjsKes/$1');
$routes->get('bpjs-kes/delete/(:num)', 'Upload::deleteBPJSKes/$1');

$routes->post('bpjs-tk/uploads/(:num)', 'Upload::bpjsTK/$1');
$routes->get('bpjs-tk/delete/(:num)', 'Upload::deleteBPJSTK/$1');

$routes->post('buktibpjs-tk/uploads/(:num)', 'Upload::buktibpjsTK/$1');
$routes->get('buktibpjs-tk/delete/(:num)', 'Upload::deletebuktiBPJSTK/$1');

$routes->get('/status-lamaran', 'User::statusLamaran');
$routes->get('/pelaksanaan', 'User::pelaksanaan');

$routes->post('magang/daftar', 'Magang::daftar');
$routes->post('magang/konfirmasi', 'Magang::konfirmasi');
$routes->post('magang/validasi-berkas', 'Magang::validasiBerkas');
$routes->get('cetak-tanda-pengenal/(:num)', 'Magang::cetakTandaPengenal/$1');





$routes->get('/status-lamaran', 'User::statusLamaran');
$routes->get('/pendaftaran', 'User::pendaftaran');
$routes->post('/pendaftaran/save', 'User::savedaftar');



//Bagian Admin
$routes->get('/admin', 'Admin::index');
//Kelola Lowongan
$routes->get('/kelola-lowongan', 'LowonganController::index');
$routes->post('/periode/save', 'LowonganController::periodesave');
$routes->post('/periode/update/(:num)', 'LowonganController::update/$1');

//Kelola Pendaftaran
$routes->get('/manage-pendaftaran', 'Admin::index');

//Kelola Kuota
$routes->get('/kelola-kuota', 'Admin::indexKuota');


//Kelola Seleksi
$routes->get('/manage-seleksi', 'Admin::indexSeleksi');
$routes->get('/manage-seleksi/pendaftar', 'Admin::pendaftar');
$routes->post('/manage-seleksi/terima/(:num)', 'Admin::terimaPendaftar/$1');
$routes->post('/manage-seleksi/tolak/(:num)', 'Admin::tolakPendaftar/$1');

$routes->post('/manage-seleksi/terima-banyak', 'Admin::terimaBanyak');
$routes->post('/manage-seleksi/tolak-banyak', 'Admin::tolakBanyak');

//Kelola Kelengkapan Berkas
$routes->get('/manage-kelengkapan-berkas', 'Admin::indexBerkas');
$routes->post('/manage-kelengkapan-berkas/valid/(:num)', 'Admin::validasiBerkas/$1');

//Kelola Magang
$routes->get('/manage-magang', 'Admin::indexMagang');




$routes->get('detail-pendaftaran/(:num)', 'Admin::detail/$1');
$routes->post('manage-pendaftaran/approve/(:num)', 'Admin::approve/$1');
$routes->post('manage-pendaftaran/reject/(:num)', 'Admin::reject/$1');
$routes->post('manage-pendaftaran/konfirmasi/(:num)', 'User::konfirmasi/$1');
$routes->get('generateSuratPenerimaan/(:num)', 'GeneratePDF::suratPenerimaan/$1');
$routes->get('generateSuratPenerimaan2/(:num)', 'GeneratePDF::generateAndSavePDF/$1');





