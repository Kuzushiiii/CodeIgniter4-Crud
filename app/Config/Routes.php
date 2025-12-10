<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->setAutoRoute(false);

$routes->get('/', 'Home::index');
$routes->get('/dbtest', 'DbTest::index');

// User Routes
$routes->get('/users', 'UserController::index');
$routes->get('/users/fetch', 'UserController::fetch');

// Routes untuk operasi CRUD pada user
$routes->get('/users/create', 'UserController::create');
$routes->post('/users/store', 'UserController::store');
$routes->get('/users/edit/(:num)', 'UserController::edit/$1');
$routes->post('/users/update/(:num)', 'UserController::update/$1');
$routes->delete('/users/delete/(:num)', 'UserController::delete/$1');