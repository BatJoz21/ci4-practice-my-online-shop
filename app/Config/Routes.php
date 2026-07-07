<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('register', 'Auth::registerPage');
$routes->post('register', 'Auth::register');
$routes->get('login', 'Auth::loginPage');
$routes->post('login', 'Auth::login');
$routes->post('logout', 'Auth::logout');
$routes->get('session-test', function () {
    dd(session()->get());
});

$routes->get('products', 'Products::index');
$routes->get('products/(:num)/image', 'Products::getProductImage/$1');

// Customer routes
$routes->group('', ['namespace' => '\App\Controllers\Customers', 'filter' => 'jwtauth'], function($routes) {
    $routes->get('products/(:num)', 'Products::show/$1');
});

// Merchant routes
$routes->group('', ['namespace' => '\App\Controllers\Merchants', 'filter' => 'merchant'], function($routes) {
    $routes->get('my-products', 'Products::index');
    $routes->get('products/new', 'Products::new');
});
