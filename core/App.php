<?php

namespace Core;

use Dotenv\Dotenv;
use Core\Session;

class App
{
    public function __construct()
    {
        // Load .env
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();

        // Set timezone
        date_default_timezone_set($_ENV['APP_TIMEZONE'] ?? 'UTC');

        // Mulai session dan ambil user
        Session::start();
        $user = Session::get('user');

        // Memuat routes
        require_once __DIR__ . '/../app/routes/web.php';  // Memuat file routes
    }

    public function run()
    {
        // Jalankan routing
        Route::start();  // Memulai pengecekan URL
    }
}

