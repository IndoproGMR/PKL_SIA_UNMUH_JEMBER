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
// ! =========================================================================<<

// ?

// !Admin Panel ==============================================================>>
// ?index ======================================================================
$routes->get('/Admin-Panel', 'AdminPanelController::index');
// ! =========================================================================<<

// ?

// !Mahasiswa ================================================================>>
// *Surat Keluar ==============================================================>
// ?index ======================================================================
$routes->get('/minta-surat', 'SuratKeluarController::indexMintaSurat');
$routes->get('/status-surat', 'SuratKeluarController::indexStatusSurat');
$routes->get('/riwayat-surat', 'SuratKeluarController::indexRiwayatSurat');

// ?penambahan =================================================================
$routes->get('/minta-surat/(:any)', 'SuratKeluarController::indexMintaSurat/$1');
$routes->post('/minta-surat/(:any)', 'SuratKeluarController::addMintaSuratProses/$1');
// *===========================================================================<
// ! =========================================================================<<

// ?

// !PenandaTangan ============================================================>>
// *Surat Keluar ==============================================================>
// ?index ======================================================================
$routes->get('/riwayat-TTD', 'SuratKeluarController::indexRiwayatTTD');

// ?PenandaTangan ==============================================================
$routes->get('/status-TTD', 'SuratKeluarController::indexStatusTTD');
$routes->post('/status-TTD', 'SuratKeluarController::TTDProses');
// *===========================================================================<
// ! =========================================================================<<

// ?

// !pengajaran ===============================================================>>
// *Surat Keluar ==============================================================>
// ?index ======================================================================
$routes->get('/semua-surat', 'SuratKeluarController::indexJenisSurat');
$routes->get('/semua-surat-tanpa_NoSurat', 'SuratKeluarController::indexTanpaNoSurat');

// ?penambahan =================================================================
$routes->get('/bikin-surat', 'SuratKeluarController::addJenisSurat');
$routes->post('/bikin-surat', 'SuratKeluarController::addJenisSuratProses');

// ?Toggle =====================================================================
$routes->post('/toggleshow-surat', 'SuratKeluarController::updateJenisSuratToggleProses');

// ?detail =====================================================================
$routes->get('/detail-surat/(:any)', 'SuratKeluarController::detailJenisSurat/$1');
$routes->post('/detail-surat', 'SuratKeluarController::updateJenisSuratProses');
// *===========================================================================<

// *Surat Masuk ===============================================================>
// ?index ======================================================================
$routes->get('/semua-arhive-surat', 'SuratMasukController::indexArhiveSurat');

// ?Membuka File PDF ===========================================================
// !$routes->post('/staff/Preview_Arhive', 'ControllerName::index');

// ?Penambahan arhive ==========================================================
$routes->get('/input-arhive-surat', 'SuratMasukController::addArhiveSurat');
$routes->post('/input-arhive-surat', 'SuratMasukController::addArhiveSuratProses');

// ?Penambahan jenis arhive ====================================================
$routes->get('/input-jenis-arhive-surat', 'SuratMasukController::addJenisArhiveSurat');
$routes->post('/input-jenis-arhive-surat', 'SuratMasukController::addJenisArhiveSuratProses');
// *===========================================================================<

// *quary =====================================================================>
// ? test ======================================================================
$routes->get('/quary', 'TestQuary::index');
$routes->post('/quary', 'TestQuary::caridata');
// *===========================================================================<
// ! =========================================================================<<

// ?

// !WIP ======================================================================>>
$routes->get('/staff/TestMPDF', 'Pdfrender::TestMPDF');
// $routes->get('/staff/TestInfo', 'SuratMasukController::TestInfo');
// ! =========================================================================<<

// ?

// !done =====================================================================>>
// $routes->get('/suratmasuk/kameraQR', 'TestSuratmasuk::kameraQR');
// $routes->get('/suratmasuk', 'TestSuratmasuk::index');
// $routes->get('/suratmasuk/mintasurat', 'TestSuratmasuk::mintasuratindex');
// $routes->get('/suratmasuk/mintasurat/(:num)', 'TestSuratmasuk::mintasurat/$1');
// $routes->post('/suratmasuk/mintasurat/(:num)', 'TestSuratmasuk::addmintasurat/$1');
// $routes->post('/suratmasuk/mintasurat', 'TestSuratmasuk::addsuratmasuk');
// $routes->get('/StatusSurat', 'StatuSurat::statusSurat');
// $routes->get('/StatusTTD', 'StatuSurat::statusTTD');
// $routes->post('/StatusTTD/proses', 'StatuSurat::prosesTTD');
// $routes->get('/suratmasuk/validasi/(:any)', 'TestSuratmasuk::validasi/$1/$2');
// $routes->get('/suratmasuk/(:any)', 'TestSuratmasuk::testreture/$1');
// $routes->get('/suratmasuk2/(:any)', 'TestSuratmasuk::testreture2/$1/$2');
// ! =========================================================================<<

// ?

// !PDF ======================================================================>>
// ?Preview ====================================================================
$routes->post('/staff/Preview-Surat', 'Pdfrender::staffPreviewSurat');
$routes->get('/staff/Preview/(:any)', 'Pdfrender::staffPreviewJenisSurat/$1');

// ?untuk Mahasiswa dan Pengajaran =============================================
$routes->get('/Preview/(:any)', 'Pdfrender::PreviewJenisSurat/$1');
$routes->post('/staff/Surat-Archive', 'Pdfrender::staffViewSurat');


// ?mahasiswa ==================================================================
$routes->post('/Download/Surat', 'Pdfrender::DownloadSurat');
// ! =========================================================================<<

// ?

// !AUTH =====================================================================>>
// ?login ======================================================================
$routes->get('/login', 'Login::index');
$routes->get('/logout', 'Login::logout');
$routes->post('/login', 'Login::debuglogin');
// $routes->post('/login', 'Login::loginProses');

// ?Api Auth ===================================================================

// ! =========================================================================<<

// ?

// !API ======================================================================>>
// *Surat Keluar ==============================================================>
// ?tandatangan Qr validasi ====================================================
$routes->get('/api/v1/validasi/qr', 'apiv1::validasiqr');
$routes->get('/api/v1/validasi/qr/detail', 'apiv1::validasiqrdetail');
// *===========================================================================<
// ! =========================================================================<<

// ?

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
