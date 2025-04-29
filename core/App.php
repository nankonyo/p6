<?php

namespace Core;

use Dotenv\Dotenv;

class App
{
    public function __construct()
    {
        // Load .env
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();

        // Memuat routes
        require_once __DIR__ . '/../app/routes/web.php';  // Memuat file routes
    }

    public function run()
    {
        // Jalankan routing
        Route::start();  // Memulai pengecekan URL
    }
}
