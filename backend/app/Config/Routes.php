<?php
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

// RESTful User API
$routes->resource('api/users', ['controller' => 'Api\Users']);

// Auth API
$routes->post('api/auth', 'Api\Auth::login');
$routes->get('api/protected', 'Api\Auth::protected_route');

// OPTIONS handler for CORS
$routes->options('api/(:segment)', 'Api\Users::options');
$routes->options('api/(:any)', function () {
    return service('response')
        ->setHeader('Access-Control-Allow-Origin', '*')
        ->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
        ->setStatusCode(200);
});
