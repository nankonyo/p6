<?php

namespace App\Controllers;

use Core\Session;
use Core\Controller;
use Core\View;
use App\Helpers\DeviceInfoHelper;
use App\Helpers\UrlHelpers;
use App\Models\User;
use App\Models\DeviceInfo;

class RegisterController extends Controller
{
    public function index()
    {
        $fullUrl = UrlHelpers::getFullUrl();
        $pathOnly = UrlHelpers::getPathOnly();
        $credit = $_ENV['APP_CREDIT'];
        View::render('register/index', [
            'layout' => '_layouts/blank',
            'title' => 'LEMBAGA PENGEMBANGAN APARATUR PEMERINTAH - LPAP',
            'description' => 'description home',
            'keywords' => 'keywords home',
            'author' => 'author home',
            'type' => 'website',
            'image' => 'image',
            'robots' => 'index, follow',
            'full_url' => $fullUrl,
            'path_only' => $pathOnly,
            'credit' => $credit,
            'ogType' => 'website'
        ]);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode([
                'status' => 'error',
                'messages' => ['Metode tidak diizinkan.']
            ]);
            return;
        }

        header('Content-Type: application/json');

        $errors = [];

        // Validasi role
        if (empty($_POST['id_role']) || !in_array($_POST['id_role'], ['1', '2', '3'])) {
            $errors[] = 'Role tidak valid.';
        }

        // Validasi password

        if (strlen($_POST['password']) < 6) {
            $errors[] = 'Kata sandi minimal 6 karakter.';
        }

        if ($_POST['password'] !== $_POST['password_confirm']) {
            $errors[] = 'Kata sandi tidak cocok.';
        }

        // Validasi email
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Format email tidak valid.';
        }

        $userModel = new User();
        $email = strtolower($_POST['email']);

        // Validasi email sudah terdaftar
        if ($userModel->isEmailExists($email)) {
            $errors[] = 'Email sudah terdaftar.';
        }

        if (empty($_POST['terms']) || $_POST['terms'] != '1') {
            $errors[] = 'Anda harus menyetujui Syarat dan Ketentuan.';
        }

        // Return jika ada error
        if (count($errors) > 0) {
            echo json_encode([
                'status' => 'error',
                'messages' => $errors
            ]);
            return;
        }

        // Proses registrasi
        $baseUsername = explode('@', $email)[0];
        $username = $userModel->generateUniqueUsername($baseUsername);

        $id_role = (int)$_POST['id_role'];
        $is_active = $id_role === 1 ? 1 : 0;

        $data = [
            'username'   => $username,
            'id_role'    => $id_role,
            'email'      => $email,
            'password'   => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'is_active'  => $is_active,
        ];

        try {
            if ($userModel->publicRegister($data)) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Pendaftaran berhasil.',
                    'email' => $data['email']
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    'status' => 'error',
                    'messages' => ['Gagal menyimpan data user.']
                ]);
            }
        } catch (\PDOException $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'messages' => ['Terjadi kesalahan sistem.']
            ]);
        }
    }
}
