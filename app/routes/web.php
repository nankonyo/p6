<?php

use App\Controllers\HomeController;
use Core\Route;  // Pastikan kita mengimpor class Route untuk mengakses method routing

$router = new Route();  // Menginisialisasi objek Route

// Rute untuk halaman utama
$router->get('/', [HomeController::class, 'index']);
