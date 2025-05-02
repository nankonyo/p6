<?php
// Memuat dependensi dan autoloader
require_once __DIR__ . '/../core/Helper.php';
require_once __DIR__ . '/../vendor/autoload.php';

// Menggunakan kelas App untuk memulai aplikasi
use Core\App;

// Inisialisasi dan jalankan aplikasi
$app = new App();  // Membuat instance App
$app->run();       // Menjalankan routing
