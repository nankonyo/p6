<?php

use Core\Route;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\RegisterController;
use App\Controllers\DashboardController;
use App\Middlewares\AuthMiddleware;

// Inisialisasi router
$router = new Route();

// ===================
// Definisi Rute Publik
// ===================

$router->get('/', 'HomeController@index');

$router->get('/auth', 'AuthController@index');
$router->post('/auth', 'AuthController@signin');
$router->get('/logout', 'AuthController@logout');

$router->get('/register', 'RegisterController@index');
$router->post('/register', 'RegisterController@store');

// ===================
// Rute yang Membutuhkan Middleware
// ===================

// Menambahkan middleware AuthMiddleware pada /dashboard
$router->get('/dashboard', 'DashboardController@index', [AuthMiddleware::class]);

return $router;
