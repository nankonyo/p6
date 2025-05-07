<?php

namespace App\Middlewares;

use Core\Session;
use App\Helpers\UrlHelpers;
use App\Models\User;


class AuthMiddleware
{
    public function dashboardHandle()
    {
        {
            $fullUrl = UrlHelpers::getFullUrl();

            if (empty($_SESSION['user_logged_in']) || empty($_SESSION['user']['id'])) {
                header('Location: /auth?redir=' . urlencode($fullUrl));
                exit;
            }
    
            $userModel = new User();
            $user = $userModel->findById($_SESSION['user']['id']);
    
            if (!$user) {
                session_destroy();
                header('Location: /auth?redir=' . urlencode($fullUrl));
                exit;
            }
    
            if ($user['email_ver_stat'] == false) {
                header('Location: /verify-email?redir=' . urlencode($fullUrl));
                exit;
            }
        }
    }

    public function authHandle()
    {
        if (Session::get('user_logged_in')) {
            $redir = urldecode($_GET['redir']) ?: '/dashboard';
            header('Location: '.$redir.'');
            exit;
        }
    }
    
}
