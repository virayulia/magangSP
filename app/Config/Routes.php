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
$routes->post('logout', 'Auth::logout');

$routes->get('register', 'Auth::register');
$routes->post('register/process', 'Auth::attemptRegister');
$routes->get('/api/kota', 'Auth::getCities');
$routes->get('/get-instansi', 'Auth::getInstansi');

$routes->get('active-account', 'Auth::activateAccount');
$routes->get('resend-activate-account', 'Auth::resendActivateAccount');

$routes->get('forgot', 'Auth::forgotPassword');
$routes->post('forgot', 'Auth::attemptForgot');
$routes->get('reset-password', 'Auth::resetPassword');
$routes->post('reset-password', 'Auth::attemptReset');



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
    $routes->get('magang/surat-pernyataan', 'Magang::suratPernyataan');
    $routes->post('magang/setujui-surat-pernyataan', 'Magang::setujuiPernyataan');

    $routes->post('penelitian/daftar', 'Penelitian::daftar');


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
    
    // Kelola Instansi
    $routes->get('/kelola-instansi', 'Instansi::index');
    $routes->post('/instansi/save', 'Instansi::save');
    $routes->post('/instansi/update/(:num)', 'Instansi::update/$1');
    $routes->post('/instansi/delete/(:num)', 'Instansi::delete/$1');
    // Kelola Jurusan
    $routes->get('/kelola-jurusan', 'Jurusan::index');
    $routes->post('/jurusan/save', 'Jurusan::save');
    $routes->post('/jurusan/update/(:num)', 'Jurusan::update/$1');
    $routes->post('/jurusan/delete/(:num)', 'Jurusan::delete/$1');

    // Kelola Pendaftaran Magang
    $routes->get('/manage-pendaftaran', 'Admin::index');

    //Kelola Penelitian
    $routes->get('/manage-penelitian', 'Penelitian::index');

    // Kelola Unit
    $routes->get('/kelola-unit', 'Admin::indexUnit');
    $routes->post('/kelola-unit/update/(:num)', 'Admin::updateUnit/$1');
    $routes->post('/unit/save', 'Unitkerja::save');

    // Kelola Kuota Unit
    $routes->get('/kuota-unit', 'KuotaUnit::index');
    $routes->post('/kuota-unit/save', 'KuotaUnit::save');
    $routes->get('/kelola-kuota-unit', 'Admin::indexKuotaUnit');
    $routes->post('/kelola-kuota-unit/update/(:num)', 'Admin::updateKelolaUnit/$1');

    //Kelola Jurusan Unit
    $routes->get('jurusan-unit', 'JurusanUnit::index');
    $routes->post('jurusan-unit/save', 'JurusanUnit::save');
    $routes->post('jurusan-unit/addJurusan', 'JurusanUnit::addJurusan');
    $routes->post('jurusan-unit/deleteJurusan/(:num)', 'JurusanUnit::deleteJurusan/$1');
    // $routes->post('jurusan-unit/delete/(:num)', 'JurusanUnit::delete/$1');

    // Kelola Kuota
    // $routes->get('/kelola-kuota', 'Admin::indexKuota');

    // Kelola Seleksi
    $routes->get('/manage-seleksi', 'Admin::indexSeleksi');
    $routes->get('/manage-seleksi/pendaftar', 'Admin::pendaftar');
    $routes->post('/manage-seleksi/terima/(:num)', 'Admin::terimaPendaftar/$1');
    $routes->post('/manage-seleksi/tolak/(:num)', 'Admin::tolakPendaftar/$1');
    $routes->post('/manage-seleksi/terima-banyak', 'Admin::terimaBanyak');
    $routes->post('/manage-seleksi/tolak-banyak', 'Admin::tolakBanyak');

    // Kelola Kelengkapan Berkas
    $routes->get('/manage-kelengkapan-berkas', 'Admin::indexBerkas');
    $routes->post('/manage-kelengkapan-berkas/valid/(:num)', 'Admin::valid/$1');
    $routes->post('/manage-kelengkapan-berkas/tidakValid/(:num)', 'Admin::tidakValid/$1');

    // Kelola Magang
    $routes->get('/manage-magang', 'Admin::indexMagang');

    $routes->get('detail-pendaftaran/(:num)', 'Admin::detail/$1');
    $routes->post('manage-pendaftaran/approve/(:num)', 'Admin::approve/$1');
    $routes->post('manage-pendaftaran/reject/(:num)', 'Admin::reject/$1');
    $routes->post('manage-pendaftaran/konfirmasi/(:num)', 'User::konfirmasi/$1');
    $routes->get('generateSuratPenerimaan/(:num)', 'GeneratePDF::suratPenerimaan/$1');
    $routes->get('generateSuratPenerimaan2/(:num)', 'GeneratePDF::generateAndSavePDF/$1');
});
