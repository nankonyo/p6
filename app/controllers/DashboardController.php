<?php

namespace App\Controllers;

use Core\Session;
use App\Models\User;
use Core\Controller;
use Core\View;

class DashboardController extends Controller
{
    
    public function index()
    {
        // Render tampilan dashboard
        View::render('dashboard/index', [
            'layout' => '_layouts/register',  // Menentukan layout yang akan digunakan
            'title' => 'LEMBAGA PENGEMBANGAN APARATUR PEMERINTAH - LPAP',
            'description' => 'description home',
            'keywords' => 'keywords home',
            'author' => 'author home',
            'type' => 'website',
            'image' => 'image',
            'robots' => 'index, follow'
        ]);
    }
}
