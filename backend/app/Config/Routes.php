<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->resource('api/users', ['controller' => 'Api\Users']);
$routes->resource('api/auth', ['controller' => 'Api\Auth']);
$routes->options('api/(:segment)', 'Api\Users::options');
$routes->options('api/(:any)', function () {
    return service('response')
        ->setHeader('Access-Control-Allow-Origin', '*')
        ->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
        ->setStatusCode(200);
});
$routes->group('auth', function($routes) {
    $routes->post('login', 'Auth::login');
    $routes->options('login', 'Auth::login'); // สำหรับ preflight CORS request
    $routes->get('protected', 'Auth::protected_route');
    $routes->options('protected', 'Auth::protected_route'); // สำหรับ preflight CORS request
});
