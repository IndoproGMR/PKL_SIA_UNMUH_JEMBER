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

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// !home all user
$routes->get('/', 'Home::index');
$routes->get('/error_perm', 'Home::error_perm');
$routes->get('/Error_Exception', 'Home::CustomError');
$routes->get('/qr-validasi', 'SuratKeluarController::kameraQR');


// !surat Mahasiswa
$routes->get('/status-surat', 'SuratKeluarController::indexStatusSurat');
$routes->get('/riwayat-surat', 'SuratKeluarController::indexRiwayatSurat');
$routes->get('/minta-surat', 'SuratKeluarController::indexMintaSurat');

$routes->get('/minta-surat/(:num)', 'SuratKeluarController::indexMintaSurat/$1');
$routes->post('/minta-surat/(:num)', 'SuratKeluarController::addmintaSuratProses/$1');



// !PenandaTangan
$routes->get('/status-TTD', 'SuratKeluarController::indexStatusTTD');
$routes->post('/status-TTD', 'SuratKeluarController::TTDProses');

$routes->get('/riwayat-TTD', 'SuratKeluarController::indexRiwayatTTD');

// !untuk pengajaran
$routes->get('/semua-surat', 'SuratKeluarController::indexJenisSurat');

$routes->post('/toggleshow-surat', 'SuratKeluarController::updateJenisSuratToggleProses');

$routes->get('/detail-surat/(:num)', 'SuratKeluarController::detailJenisSurat/$1');
$routes->post('/detail-surat', 'SuratKeluarController::updateJenisSuratProses');

$routes->get('/bikin-surat', 'SuratKeluarController::addJenisSurat');
$routes->post('/bikin-surat', 'SuratKeluarController::addJenisSuratProses');



// !WIP
// $routes->get('/suratmasuk/pdf', 'TestSuratmasuk::pdf');
$routes->get('/staff/TestMPDF', 'Pdfrender::TestMPDF');


// !done
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




// !PDF
// Preview
$routes->post('/staff/Preview-Surat', 'Pdfrender::PreviewSurat');
// $routes->get('/staff/Preview-Surat', 'Pdfrender::PreviewSurat');

// untuk Mahasiswa dan Pengajaran
$routes->get('/Preview/(:num)', 'Pdfrender::PreviewJenisSurat/$1');

// mahasiswa
$routes->post('/Download/Surat', 'Pdfrender::DownloadSurat');





// !quary
$routes->get('/quary', 'TestQuary::index');
$routes->post('/quary', 'TestQuary::caridata');


// !AUTH
$routes->get('/login', 'Login::index');
$routes->get('/logout', 'Login::logout');
$routes->post('/login', 'Login::debuglogin');
// $routes->post('/login', 'Login::loginProses');


// !API
$routes->get('/api/v1/validasi/qr', 'apiv1::validasiqr');
$routes->get('/api/v1/validasi/qr/detail', 'apiv1::validasiqrdetail');

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
