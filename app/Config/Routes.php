<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);


// !Admin Panel ==============================================================>>
// ?index ======================================================================
$routes->get('/Admin-Panel', 'AdminPanelController::index');
$routes->post('/Admin-Panel/login', 'AdminPanelController::loginAdminProses');


$routes->get('/Admin-Panel/Masukan-akun', 'AdminPanelController::createNewuser');
$routes->post('/Admin-Panel/Masukan-akun/step2', 'AdminPanelController::createNewuser');


$routes->get('/Admin-Panel/join', 'AdminPanelController::newUser');
$routes->post('/Admin-Panel/join', 'AdminPanelController::newUser');


if (env('CI_ENVIRONMENT') == 'development') {
    $routes->get('/Admin-Panel/CekServer', 'AdminPanelController::testServer');
}
// ! =========================================================================<<

// ?

// !AUTH =====================================================================>>
// ?login ======================================================================
$routes->get('/login', 'Login::index');
$routes->get('/logout', 'Login::index');
$routes->post('/login', 'Login::loginProses');

// ?Api Auth ===================================================================
// $routes->get('/api/v1/login', 'apiv1::validasiqr');

// ! =========================================================================<<

// ?

// ! maintenance =============================================================>>
if (env('MAINTENANCE_ENVIRONMENT', 'false') == 'true') {
    $routes->set404Override('App\Controllers\Home::maintenance');

    if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
        require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
    }

    return;
}
// ! =========================================================================<<

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

/**
 * !Master Gruop (pengguna (Mahasiswa,pengajaran))
 * *SubGruop (Surat Masuk/Keluar)
 * ?fungsi Route
 */


// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// !home all user ============================================================>>
$routes->get('/', 'Home::index');
$routes->get('/error_perm', 'Home::error_perm');
$routes->get('/Error_Exception', 'Home::CustomError');
$routes->get('/qr-validasi', 'SuratKeluarController::kameraQR');

$routes->get('/Staff/help', 'Home::StaffHelp');
$routes->get('/help', 'Home::MahasiswaHelp');

$routes->get('/testinfo', 'Home::TestInfo');
$routes->post('/testinfo/proses', 'Home::TestInfoProses');
$routes->get('/testinfo/data', 'Home::TestInfoput');
// ! =========================================================================<<

// ?

// !Mahasiswa ================================================================>>
// *Surat Keluar ==============================================================>
// ?index ======================================================================
$routes->get('/Surat/Status-TandaTangan', 'SuratKeluarController::indexStatusSurat');
$routes->get('/Surat/Minta-TandaTangan', 'SuratKeluarController::indexMintaSurat');
$routes->get('/Surat/riwayat-Minta-TandaTangan', 'SuratKeluarController::indexRiwayatSurat');

// ?penambahan =================================================================
$routes->get('/Surat/Minta-TandaTangan/(:any)', 'SuratKeluarController::indexMintaSurat/$1');
$routes->post('/Surat/Minta-TandaTangan/(:any)', 'SuratKeluarController::addMintaSuratProses/$1');

// ?PDF ========================================================================
$routes->post('/Download/Surat', 'Pdfrender::DownloadSurat');

$routes->get('/Preview/(:any)', 'Pdfrender::PreviewJenisSurat/$1');

// *===========================================================================<
// ! =========================================================================<<

// ?

// *Surat Keluar ==============================================================>
// ?index ======================================================================
$routes->get('/Staff/Permintaan_TTD-Surat_Tanpa_NoSurat', 'SuratKeluarController::indexTanpaNoSurat');

$routes->get('/Staff/Master-Surat', 'SuratKeluarController::indexJenisSurat');

$routes->post('/Staff/Edit/Permintaan_TTD-Surat_Tanpa_NoSurat', 'SuratKeluarController::updateTanpaNoSurat');
$routes->post('/Staff/Edit-proses/Permintaan_TTD-Surat_Tanpa_NoSurat', 'SuratKeluarController::updateTanpaNoSuratProses');

$routes->post('/delete-proses/surat-tanpa_NoSurat', 'SuratKeluarController::deleteTanpaNoSuratProses');

// ?penambahan =================================================================
$routes->get('/input/master-surat', 'SuratKeluarController::addJenisSurat');
$routes->post('/input-proses/master-surat', 'SuratKeluarController::addJenisSuratProses');

// ?Toggle =====================================================================
$routes->post('/toggleshow-surat', 'SuratKeluarController::updateJenisSuratToggleProses');

// ?detail =====================================================================
$routes->get('/Staff/detail/Master-Surat/(:any)', 'SuratKeluarController::detailJenisSurat/$1');
$routes->post('/Staff/detail/Master-Surat', 'SuratKeluarController::updateJenisSuratProses');

// ?PenandaTangan ==============================================================
$routes->get('/Surat_Perlu_TandaTangan', 'SuratKeluarController::indexStatusTTD');
$routes->post('/TandaTangan-proses/Surat_Perlu_TandaTangan', 'SuratKeluarController::TTDProses');

$routes->get('/Riwayat_TandaTangan', 'SuratKeluarController::indexRiwayatTTD');


// ?PDF ========================================================================
$routes->post('/staff/Preview-Surat', 'Pdfrender::staffPreviewSurat');
$routes->get('/staff/Preview/(:any)', 'Pdfrender::staffPreviewJenisSurat/$1');

$routes->get('/Staff/test/Master-Surat/(:any)', 'Pdfrender::staffTestJenisSurat/$1');
$routes->get('/Staff/test-proses/Master-Surat', 'Pdfrender::staffTestJenisSuratProses');


// *===========================================================================<

// *Surat Masuk ===============================================================>
// ?index ======================================================================
$routes->get('/semua-archive-surat', 'SuratMasukController::indexArchiveSurat');

// ?Membuka File PDF ===========================================================
$routes->post('/staff/Surat-Archive', 'Pdfrender::staffViewSurat');

// ?Penambahan archive =========================================================
$routes->get('/input-archive-surat', 'SuratMasukController::addArchiveSurat');
$routes->post('/staff/input-proses/archive-surat', 'SuratMasukController::addArchiveSuratProses');

// ?edit archive ===============================================================
$routes->post('/detail_edit/archive-surat', 'SuratMasukController::updateArchiveSurat');
$routes->post('/edit-proses/archive-surat', 'SuratMasukController::updateArchiveSuratProses');

// ?delete archive =============================================================
$routes->post('/delete-proses/archive-surat', 'SuratMasukController::deleteArchiveSuratProses');

// ?Penambahan jenis archive ===================================================
$routes->get('/input-jenis-archive-surat', 'SuratMasukController::addJenisArchiveSurat');
$routes->post('/input-jenis-archive-surat', 'SuratMasukController::addJenisArchiveSuratProses');

// ?edit jenis archive =========================================================
$routes->post('/staff/edit/JenisSurat', 'SuratMasukController::updateJenisArchiveSurat');
$routes->post('/staff/edit-proses/JenisSurat', 'SuratMasukController::updateJenisArchiveSuratProses');

// ?delete jenis archive =======================================================
// $routes->post('/staff/delete/JenisSurat', 'SuratMasukController::index');
$routes->post('/staff/delete-proses/JenisSurat', 'SuratMasukController::deleteJenisArchiveSuratProses');

// *===========================================================================<

// *quary =====================================================================>

// *===========================================================================<

// ?

// ! =========================================================================<<

// ?

// !AUTH =====================================================================>>
// ?login ======================================================================
$routes->get('/login', 'Login::index');
$routes->get('/logout', 'Login::index');
$routes->post('/login', 'Login::loginProses');

// ?Api Auth ===================================================================
// $routes->get('/api/v1/login', 'apiv1::validasiqr');

// ! =========================================================================<<

// ?

// !API ======================================================================>>
// *Surat Keluar ==============================================================>
// ?tandatangan Qr validasi ====================================================
$routes->get('/api/v1/validasi/qr/detail', 'Apiv1::ValidasiQRDetail');

$routes->get('/api/v1/validasi/qr', 'Apiv1::validasiqr');

// ?Dengan Perlu AUTH
$routes->get('/api/v1/cekNomerSurat', 'Apiv1::cekNoSurat');

// ?etc
// *===========================================================================<
// ! =========================================================================<<

// ?

// !deprecated ===============================================================>>
$routes->get('/api/v1/validasi/qr', 'Apiv1::validasiqr');
$routes->get('/api/v1/image/(:segment)', 'Apiv1::imagecache/$1');

// $routes->get('/quary', 'TestQuary::index');
// $routes->post('/quary', 'TestQuary::caridata');

// ?WIP ======================================================================>>
$routes->get('/staff/TestMPDF', 'Pdfrender::TestMPDF');
// $routes->get('/staff/TestInfo', 'SuratMasukController::TestInfo');


// *===========================================================================<
// ! =========================================================================<<


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
