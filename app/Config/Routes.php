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

$routes->post('menu/uploadImage', 'MenuController::uploadImage');
$routes->get('fetchAllImages', 'MenuController::fetchAllImages');
// $routes->post('menu/uploadImage', 'MenuController::uploadImage');

$routes->get('stocks/getData', 'StockController::getData');
$routes->get('orders/getData', 'OrderController::getData');

