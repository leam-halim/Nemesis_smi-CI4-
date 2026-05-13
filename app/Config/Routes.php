<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Auth Routes
$routes->get('login', 'AuthController::login');
$routes->post('loginProcess', 'AuthController::loginProcess');
$routes->get('logout', 'AuthController::logout');

// Protected Routes
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'DashboardController::index');
    $routes->get('dashboard', 'DashboardController::index');
    
    // Super Admin Only
    $routes->group('admin', ['filter' => 'role:superadmin'], function($routes) {
        $routes->get('users', 'AdminController::users');
    });
});
