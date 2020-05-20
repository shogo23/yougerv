<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes(true);

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
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

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/test', 'Home::test');
$routes->get('/logout', 'Users::logout');
$routes->get('/login', 'Users::login');
$routes->post('/login', 'Users::loginP');
$routes->get('/register', 'Users::register');
$routes->post('/register', 'Users::reg');
$routes->get('/setpicture', 'Users::setpicture');
$routes->post('/imageUpload', 'Users::imageupload');
$routes->post('/imageUpload/remove', 'Users::imageremove');
$routes->get('/mychannel', 'Channels::mychannel');
$routes->get('/upload', 'Channels::upload');
$routes->post('/upload', 'Channels::doupload');
$routes->post('/upload/convert', 'Channels::doconvert');
$routes->post('/upload/details', 'Channels::savevideodetails');
$routes->add('/watch/(:segment)', 'Channels::watch');
$routes->post('/comments', 'Channels::comments');
$routes->post('/comments/postcomment', 'Channels::postcomment');
$routes->post('/comments/delete', 'Channels::deletecomment');
$routes->post('/like', 'Channels::like');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
