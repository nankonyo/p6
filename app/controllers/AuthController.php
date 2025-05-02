<?php

namespace App\Controllers;

use Core\Session;
use App\Models\User;
use Core\Controller;
use Core\View;

class AuthController extends Controller
{
    public function index()
    {
        View::render('auth/index', [
            'layout' => '_layouts/auth',
            'title' => 'LEMBAGA PENGEMBANGAN APARATUR PEMERINTAH - LPAP',
            'description' => 'description home',
            'keywords' => 'keywords home',
            'author' => 'author home',
            'type' => 'website',
            'image' => 'image',
            'robots' => 'index, follow'
        ]);
    }

    public function signin()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode([
                'status' => 'error',
                'messages' => ['Metode tidak diizinkan']
            ]);
            return;
        }

        header('Content-Type: application/json');

        $errors = [];

        $emailOrPhone = $_POST['email'] ?? '';
        $password     = $_POST['password'] ?? '';

        if (empty($emailOrPhone)) {
            $errors[] = 'Email atau nomor ponsel wajib diisi';
        }

        if (strlen($password) < 6) {
            $errors[] = 'Kata sandi minimal 6 karakter';
        }

        if (!empty($errors)) {
            echo json_encode([
                'status' => 'error',
                'messages' => $errors
            ]);
            return;
        }

        $userModel = new User();

        // Cek user berdasarkan email atau no hp
        $user = $userModel->findByEmailOrPhone($emailOrPhone);

        if (!$user || !password_verify($password, $user['password'])) {
            echo json_encode([
                'status' => 'error',
                'messages' => ['Akun tidak ditemukan.']
            ]);
            return;
        }

        if ((int)$user['is_active'] !== 1) {
            echo json_encode([
                'status' => 'error',
                'messages' => ['Akun belum aktif, Silakan hubungi admin']
            ]);
            return;
        }

        $_SESSION['user_logged_in'] = true;
        $_SESSION['user'] = [
            'id' => $user['id']
        ];

        echo json_encode([
            'status' => 'success',
            'message' => 'Login berhasil',
            'redirect' => '/dashboard'
        ]);
    }


    public function logout()
    {
        // Hapus sesi login
        Session::remove('user_logged_in'); 
        Session::remove('user');  // Menghapus data user dari session
        
        header('Location: /auth');  // Redirect ke halaman login
        exit;
    }
}
