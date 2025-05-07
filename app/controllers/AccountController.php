<?php

namespace App\Controllers;

use Core\Session;
use App\Models\User;
use Core\Controller;
use Core\View;
use App\Helpers\UrlHelpers;

class AccountController extends Controller
{
    
    public function index()
    {
        $fullUrl = UrlHelpers::getFullUrl();
        $pathOnly =UrlHelpers::getPathOnly();
        $redirSource=UrlHelpers::getRedirSource();
        View::render('account/index', [
            'layout' => '_layouts/dashboard',  // Menentukan layout yang akan digunakan
            'title' => 'LEMBAGA PENGEMBANGAN APARATUR PEMERINTAH - LPAP',
            'description' => 'description home',
            'keywords' => 'keywords home',
            'author' => 'author home',
            'type' => 'website',
            'image' => 'image',
            'robots' => 'index, follow',
            'full_url' => $fullUrl,
            'path_only' => $pathOnly,
            'redir_source' => $redirSource,
            'ogType' => 'website'
        ]);
    }
}
