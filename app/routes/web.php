<?php

use Core\Route;
use App\Controllers\LandingController;
use App\Controllers\AuthController;
use App\Controllers\RegisterController;
use App\Controllers\DashboardController;
use App\Middlewares\AuthMiddleware;

// Inisialisasi router
$router = new Route();

// ===================
// Definisi Rute Publik
// ===================

$router->get('/', 'LandingController@index');

$router->post('/auth', 'AuthController@signin');
$router->get('/logout', 'AuthController@logout');

$router->get('/register', 'RegisterController@index');
$router->post('/register', 'RegisterController@store');

$router->post('/verify/send-email', 'VerifyController@sendVerificationEmail');
$router->get('/verify/email-konfirm', 'VerifyController@konVerificationEmail');
$router->get('/verify/device-status', 'VerifyController@checkDeviceStatus');




// ===================
// Rute yang Membutuhkan Middleware
// ===================

// Menambahkan middleware AuthMiddleware pada /dashboard
$router->get('/auth', 'AuthController@index', [[AuthMiddleware::class, 'authHandle']]);
$router->get('/dashboard', 'DashboardController@index', [[AuthMiddleware::class, 'UserHandle']]);
$router->get('/account', 'AccountController@index', [[AuthMiddleware::class, 'UserHandle']]);
$router->get('/verify/device', 'VerifyController@device', [[AuthMiddleware::class, 'UserHandle']]);



return $router;
