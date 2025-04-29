<?php

namespace App\Controllers;

use Core\Controller;
use Core\Database;
use Core\View;

class HomeController extends Controller
{
    public function index()
    {
        // Membuat koneksi ke database
        $db = new Database();
        $connection = $db->getConnection();

        // Menjalankan query untuk melihat apakah koneksi berhasil
        try {
            $result = $connection->query('SELECT NOW()')->fetch(\PDO::FETCH_ASSOC);
            $message = "Database connected!";
        } catch (\PDOException $e) {
            $message = "Database connection failed: " . $e->getMessage();
        }

        // Menggunakan View untuk merender tampilan dan mengirim data ke view
        $view = new View();
        View::render('landing/index', [
            'layout' => '_layouts/landing',
            'title' => 'Home - Raja Sakti Telematika',
            'description' => 'description home',
            'keywords' => 'keywords home',
            'author' => 'author home',
            'type' => 'website',
            'image' => 'image',
            'robots' => 'index, follow',
            'cekdb' =>  $message
        ]);
    }
}
