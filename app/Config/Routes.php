<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('menu/getData', 'MenuController::getData');
$routes->post('menu/addData', 'MenuController::addData');
$routes->post('menu/uploadImage', 'MenuController::uploadImage');
$routes->get('fetchAllImages', 'MenuController::fetchAllImages');
// $routes->post('menu/uploadImage', 'MenuController::uploadImage');

$routes->get('stocks/getData', 'StockController::getData');
$routes->get('orders/getData', 'OrderController::getData');

