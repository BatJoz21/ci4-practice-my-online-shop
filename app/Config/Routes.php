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
$routes->get('products/(:num)', '\App\Controllers\Customers\Products::show/$1');

// Customer routes
$routes->group('', ['namespace' => '\App\Controllers\Customers', 'filter' => 'customer'], function($routes) {
    $routes->post('products/addToCart', 'Carts::addItem');

    $routes->get('cart', 'Carts::show');
    $routes->get('cart/checkout', 'Carts::showCheckOut');
    $routes->patch('cart/(:num)', 'Carts::update/$1');
    $routes->delete('cart/(:num)', 'Carts::delete/$1');

    $routes->get('orders', 'Orders::index');
    $routes->get('orders/(:num)', 'Orders::show/$1');
    $routes->patch('orders/(:num)/cancel', 'Orders::cancelOrder/$1');
    $routes->patch('orders/(:num)/complete', 'Orders::completeStatus/$1');
    $routes->post('orders', 'Orders::create');

    $routes->post('orders/(:num)/payment', 'Payments::pay/$1');
    $routes->get('orders/(:num)/payment/result', 'Payments::paymentResult/$1');

    $routes->get('products/(:num)/reviews', 'Reviews::new/$1');
    $routes->post('products/(:num)/reviews', 'Reviews::create/$1');
});

// Merchant routes
$routes->group('merchant/', ['namespace' => '\App\Controllers\Merchants', 'filter' => 'merchant'], function($routes) {
    $routes->get('products/new', 'Products::new');
    $routes->post('products', 'Products::create');
    $routes->get('products', 'Products::index');
    $routes->get('products/(:num)', 'Products::show/$1');
    $routes->get('products/(:num)/edit', 'Products::edit/$1');
    $routes->patch('products/(:num)', 'Products::update/$1');
    $routes->delete('products/(:num)', 'Products::delete/$1');
    $routes->post('products/(:num)/variants', 'ProductVariants::create/$1');
    $routes->get('products/(:num)/variants/(:num)/edit', 'ProductVariants::edit/$1/$2');
    $routes->patch('products/(:num)/variants/(:num)', 'ProductVariants::update/$1/$2');
    $routes->delete('products/(:num)/variants/(:num)', 'ProductVariants::delete/$1/$2');

    $routes->get('orders', 'Orders::index');
    $routes->get('orders/(:num)', 'Orders::show/$1');
    $routes->patch('orders/(:num)', 'Orders::update/$1');
});
