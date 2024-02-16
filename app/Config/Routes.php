<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('menu/getData', 'MenuController::getData');
$routes->post('menu/addData', 'MenuController::addData');
$routes->delete('menu/deleteData/(:num)', 'MenuController::deleteData/$1');
$routes->put('menu/updateData/(:num)', 'MenuController::updateData/$1');

$routes->post('register', 'RegisterController::register');
$routes->post('login', 'LoginController::login');

$routes->post('session/new', 'SessionController::newSession');
$routes->get('session/getSessions', 'SessionController::getSessions');
$routes->post('session/end/(:num)', 'SessionController::endSession/$1'); // Add this line



$routes->post('menu/uploadImage', 'MenuController::uploadImage');
$routes->get('fetchAllImages', 'MenuController::fetchAllImages');
// $routes->post('menu/uploadImage', 'MenuController::uploadImage');

$routes->get('stocks/getData', 'StockController::getData');
$routes->get('orders/getData', 'OrderController::getData');
$routes->post('orders/addData', 'OrderController::addData');
$routes->get('orders/getLatestOrderId', 'OrderController::getLatestOrderId');
$routes->put('orders/updateTotalOrderPrice/(:num)', 'OrderController::updateTotalOrderPrice/$1');
    