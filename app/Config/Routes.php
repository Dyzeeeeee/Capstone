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
$routes->post('orders/addItemToOrder', 'OrderController::addItemToOrder');
$routes->put('orders/updateOrderItem/(:num)', 'OrderController::updateOrderItem/$1'); // Add this line
$routes->get('orders/getOrderItems/(:num)', 'OrderController::getOrderItems/$1');
$routes->put('orders/updateOrderItem/(:num)', 'OrderController::updateOrderItem/$1');
$routes->delete('orders/deleteOrderItem/(:num)', 'OrderController::deleteOrderItem/$1');
$routes->delete('orders/deleteOrder/(:num)', 'OrderController::deleteOrder/$1');
$routes->get('orders/getOrderData/(:num)', 'OrderController::getOrderData/$1');
$routes->get('orders/getOrderCount/(:segment)', 'OrderController::getOrderCount/$1');
$routes->get('orders/getDataBySession/(:segment)', 'OrderController::getDataBySession/$1');
