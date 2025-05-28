<?php

namespace App\Controllers;

use Core\Session;
use App\Models\User;
use Core\Controller;
use Core\View;
use App\Helpers\UrlHelpers;

class DashboardController extends Controller
{
    
    public function index()
    {
        $userSession = Session::get('user');
        $userId = isset($userSession['id']) ? (int) $userSession['id'] : null;
        $userModel = new User();
        $user = $userModel->findById($userId);

        if (!$user) {
            UrlHelpers::redirect('/login');
        }

        $idRole = (int) $user['id_role'];
        $viewPath = 'dashboard/pengguna'; // default view

        switch ($idRole) {
            case 2:
                $viewPath = 'dashboard/staff';
                break;
            case 3:
                $viewPath = 'dashboard/admin';
                break;
        }

        View::render($viewPath, [
            'layout' => '_layouts/dashboard',
            'title' => 'Dashboard',
            'description' => 'description home',
            'keywords' => 'keywords home',
            'author' => 'author home',
            'type' => 'website',
            'image' => 'image',
            'robots' => 'index, follow',
            'full_url' => UrlHelpers::getFullUrl(),
            'path_only' => UrlHelpers::getPathOnly(),
            'redir_source' => UrlHelpers::getRedirSource(),
            'ogType' => 'website',
            'user' => $user,
        ]);
    }

}
