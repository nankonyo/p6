<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Core\App;

date_default_timezone_set($_ENV['APP_TIMEZONE'] ?? 'UTC');

// Inisialisasi dan jalankan aplikasi
$app = new App();
$app->run();
