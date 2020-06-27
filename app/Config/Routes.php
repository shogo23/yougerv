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
$routes->set404Override('App\Controllers\Home::notfound');
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
$routes->get('/accountsettings', 'Users::accountsettings');
$routes->post('/accountsettings/fullname/save', 'Users::fullnamesave');
$routes->post('/accountsettings/nickname/save', 'Users::nicknamesave');
$routes->post('/accountsettings/password/check', 'Users::passwordcheck');
$routes->post('/accountsettings/password/save', 'Users::passwordsave');
$routes->get('/upload', 'Channels::upload');
$routes->post('/upload', 'Channels::doupload');
$routes->post('/upload/convert', 'Channels::doconvert');
$routes->post('/upload/details', 'Channels::savevideodetails');
$routes->add('/watch/(:segment)', 'Channels::watch');
$routes->post('/comments', 'Channels::comments');
$routes->post('/comments/postcomment', 'Channels::postcomment');
$routes->post('/comments/delete', 'Channels::deletecomment');
$routes->post('/like', 'Channels::like');
$routes->get('/mychannel', 'Channels::mychannel');
$routes->post('/mychannel/mywall', 'Channels::mywall');
$routes->post('/mychannel/mywall/creatwallepost', 'Channels::createwallpost');
$routes->post('/mychannel/mywall/getposts', 'Channels::getwallposts');
$routes->post('/mychannel/mywall/loadmore', 'Channels::loadmorewallposts');
$routes->post('/mychannel/mywall/approvepost', 'Channels::approvewallpost');
$routes->post('/mychannel/mywall/updatepost', 'Channels::updatewallpost');
$routes->post('/mychannel/mywall/deletepost', 'Channels::deletewallpost');
$routes->post('/mychannel/myvideos', 'Channels::myvideos');
$routes->post('/mychannel/myvideos/loadmorevideos', 'Channels::loadmorevideos');
$routes->post('/mychannel/myvideos/editdetails', 'Channels::editdetails');
$routes->post('/mychannel/myvideos/editdetails/save', 'Channels::savedetails');
$routes->post('/mychannel/myvideos/delete', 'Channels::deletevideo');
$routes->post('/mychannel/mysubscribers', 'Channels::mysubscribers');
$routes->post('/mychannel/mysubscribers/remove', 'Channels::removemysubscriber');
$routes->post('/mychannel/mysubscription', 'Channels::mysubscription');
$routes->post('/mychannel/mysubscription/remove', 'Channels::removemysubscription');
$routes->get('/channel/(:segment)/(:segment)', 'Channels::userchannel');
$routes->post('/channel/(:segment)/(:segment)/createwallpost', 'Channels::createuserwallpost');
$routes->post('/channel/(:segment)/(:segment)/userwall', 'Channels::userwall');
$routes->post('/channel/(:segment)/(:segment)/loaduserposts', 'Channels::userwallposts');
$routes->post('/channel/(:segment)/(:segment)/loadmoreuserposts', 'Channels::moreuserwallposts');
$routes->post('/channel/(:segment)/(:segment)/update', 'Channels::updateuserpost');
$routes->post('/channel/(:segment)/(:segment)/delete', 'Channels::userdeletepost');
$routes->post('/channel/(:segment)/(:segment)/uservideos', 'Channels::uservideos');
$routes->post('/channel/(:segment)/(:segment)/loadmoreuservideos', 'Channels::uservideosmore');
$routes->post('/channel/(:segment)/(:segment)/subscribe', 'Channels::usersubscribe');
$routes->post('/notifications/create', 'Notifications::create');
$routes->post('/notifications/check', 'Notifications::check');
$routes->post('/notifications/update', 'Notifications::update');
$routes->post('/notifications/get', 'Notifications::get');
$routes->post('/notifications/clear', 'Notifications::clear');
$routes->get('/search', 'Search::search');
$routes->get('/videostream/(:segment)', 'Channels::videostream');
$routes->get('/out', 'Home::out');

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
