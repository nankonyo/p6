<?php

// Autoload composer
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Load environment variables (.env)
$envPath = dirname(__DIR__);
if (file_exists($envPath . '/.env')) {
    $dotenv = Dotenv::createImmutable($envPath);
    $dotenv->load();
}

// Load semua file helper di app/helpers/
$helperDir = __DIR__ . '/../app/helpers/';
$helperFiles = glob($helperDir . '*.php');

foreach ($helperFiles as $file) {
    require_once $file;
}


// Fungsi untuk menyisipkan komponen view
if (!function_exists('component')) {
    function component(string $path, array $data = [])
    {
        \Core\View::component($path, $data);
    }
}