<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->get('/', 'Home::index');
// routes untuk login
$routes->post('/login', 'Login::index');
$routes->get('/logout', 'Login::logout');
// routes untuk redirect tergantung hak akses
$routes->get('/dashboardsadmin', 'Dashboard::dashboardsadmin', ['filter' => 'sadminauth']);
$routes->get('/dashboardadmin', 'Dashboard::dashboardadmin', ['filter' => 'auth']);

// routes untuk hak akses super admin
$routes->get('/users', 'Users::index', ['filter' => 'sadminauth']);
$routes->post('/users/save', 'Users::save', ['filter' => 'sadminauth']);
$routes->delete('/users/(:num)', 'Users::delete/$1', ['filter' => 'sadminauth']);

// routes untuk hak akses admin biasa
$routes->get('/siswa', 'Siswa::index', ['filter' => 'auth']);
$routes->get('/siswaclientside', 'Siswa::siswaclientside', ['filter' => 'auth']);
$routes->get('/siswa/listsiswa', 'Siswa::listsiswa', ['filter' => 'auth']);
$routes->post('/siswa/save', 'Siswa::save', ['filter' => 'auth']);
$routes->delete('/siswa/(:num)', 'Siswa::delete/$1', ['filter' => 'auth']);

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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
