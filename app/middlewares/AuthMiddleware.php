<?php

namespace App\Middlewares;

use Core\Session;

class AuthMiddleware
{
    public function handle()
    {
        if (!Session::get('user_logged_in')) {
            header('Location: /auth');
            exit;
        }
    }
}

