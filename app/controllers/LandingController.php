<?php

namespace App\Controllers;

use Core\Session;
use Core\Controller;
use Core\View;
use App\Helpers\DeviceInfoHelper;
use App\Helpers\UrlHelpers;
use App\Models\User;
use App\Models\DeviceInfo;

class LandingController extends Controller
{
    public function index()
    {
        $fullUrl = UrlHelpers::getFullUrl();
        $pathOnly = UrlHelpers::getPathOnly();
        View::render('landing/index', [
            'layout' => '_layouts/landing',
            'title' => 'LEMBAGA PENGEMBANGAN APARATUR PEMERINTAH - LPAP',
            'description' => 'description home',
            'keywords' => 'keywords home',
            'author' => 'author home',
            'type' => 'website',
            'image' => 'image',
            'robots' => 'index, follow',
            'full_url' => $fullUrl,
            'path_only' => $pathOnly,
            'ogType' => 'website'
        ]);
    }
}
