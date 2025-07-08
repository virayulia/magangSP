<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');
$routes->get('/tentang_kami', 'Home::tentang_kami');
$routes->get('/lowongan', 'Home::lowongan');

$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');
$routes->get('register', 'Auth::register');
$routes->post('register/process', 'Auth::attemptRegister');
$routes->get('/api/kota', 'Auth::getCities');

// ==========================
// Group untuk User
// ==========================
$routes->group('', ['filter' => 'user'], function($routes) {
    $routes->get('/profile', 'User::profil');
    $routes->get('/data-pribadi', 'User::dataPribadi');
    $routes->post('/data-pribadi/save', 'User::saveDataPribadi');
    $routes->post('/data-akademik/save', 'User::saveDataAkademik');

    $routes->get('/status-lamaran', 'User::statusLamaran');
    $routes->get('/pelaksanaan', 'User::pelaksanaan');
    $routes->post('/pendaftaran/save', 'User::savedaftar');

    $routes->post('magang/daftar', 'Magang::daftar');
    $routes->post('magang/konfirmasi', 'Magang::konfirmasi');
    $routes->post('magang/validasi-berkas', 'Magang::validasiBerkas');
    $routes->get('cetak-tanda-pengenal/(:num)', 'Magang::cetakTandaPengenal/$1');

    // Upload routes
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
});

// ==========================
// Group untuk Admin
// ==========================
$routes->group('', ['filter' => 'admin'], function($routes) {
    $routes->get('/admin', 'Admin::index');

    // Kelola Lowongan
    $routes->get('/kelola-lowongan', 'Lowongan::index');
    $routes->post('/periode/save', 'Lowongan::periodesave');
    $routes->post('/periode/update/(:num)', 'Lowongan::update/$1');

    // Kelola Pendaftaran
    $routes->get('/manage-pendaftaran', 'Admin::index');

    // Kelola Unit
    $routes->get('/kelola-unit', 'Admin::indexUnit');
    $routes->post('/kelola-unit/update/(:num)', 'Admin::updateUnit/$1');

    // Kelola Kuota Unit
    $routes->get('/kelola-kuota-unit', 'Admin::indexKuotaUnit');
    $routes->post('/kelola-kuota-unit/update/(:num)', 'Admin::updateKelolaUnit/$1');

    // Kelola Kuota
    $routes->get('/kelola-kuota', 'Admin::indexKuota');

    // Kelola Seleksi
    $routes->get('/manage-seleksi', 'Admin::indexSeleksi');
    $routes->get('/manage-seleksi/pendaftar', 'Admin::pendaftar');
    $routes->post('/manage-seleksi/terima/(:num)', 'Admin::terimaPendaftar/$1');
    $routes->post('/manage-seleksi/tolak/(:num)', 'Admin::tolakPendaftar/$1');
    $routes->post('/manage-seleksi/terima-banyak', 'Admin::terimaBanyak');
    $routes->post('/manage-seleksi/tolak-banyak', 'Admin::tolakBanyak');

    // Kelola Kelengkapan Berkas
    $routes->get('/manage-kelengkapan-berkas', 'Admin::indexBerkas');
    $routes->post('/manage-kelengkapan-berkas/valid/(:num)', 'Admin::validasiBerkas/$1');

    // Kelola Magang
    $routes->get('/manage-magang', 'Admin::indexMagang');

    $routes->get('detail-pendaftaran/(:num)', 'Admin::detail/$1');
    $routes->post('manage-pendaftaran/approve/(:num)', 'Admin::approve/$1');
    $routes->post('manage-pendaftaran/reject/(:num)', 'Admin::reject/$1');
    $routes->post('manage-pendaftaran/konfirmasi/(:num)', 'User::konfirmasi/$1');
    $routes->get('generateSuratPenerimaan/(:num)', 'GeneratePDF::suratPenerimaan/$1');
    $routes->get('generateSuratPenerimaan2/(:num)', 'GeneratePDF::generateAndSavePDF/$1');
});
