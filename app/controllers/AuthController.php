<?php

namespace App\Controllers;

use Core\Session;
use Core\Controller;
use Core\View;
use App\Helpers\DeviceInfoHelper;
use App\Helpers\UrlHelpers;
use App\Models\User;
use App\Models\DeviceInfo;

class AuthController extends Controller
{
    public function index()
    {
        $fullUrl = UrlHelpers::getFullUrl();
        $pathOnly =UrlHelpers::getPathOnly();
        View::render('auth/index', [
            'layout' => '_layouts/simple',
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
        $redir        = $_POST['redir'] ?? ''; // Fetch the 'redir' parameter from POST
    
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
    
        $redir = urldecode($redir) ?: '/dashboard'; // Decode the redir and fallback to default if empty
    
        // Validate if $redir is a valid URL
        if (!filter_var($redir, FILTER_VALIDATE_URL)) {
            $redir = '/dashboard';
        }
    
        $_SESSION['user_logged_in'] = true;
        $_SESSION['user'] = [
            'id' => $user['id']
        ];

        $deviceInfo = DeviceInfoHelper::getDeviceInfo($_SERVER['HTTP_USER_AGENT']);

        $rawIdentifier = implode('|', [
            $deviceInfo['browser'],
            $deviceInfo['os'],
            $deviceInfo['device'],
            $deviceInfo['ip_address'],
            $deviceInfo['host_name'],
            $deviceInfo['location']['city'],
            $deviceInfo['location']['region'],
            $deviceInfo['location']['country']
        ]);

        $identifier = hash('sha256', $rawIdentifier);

        $dataToInsert = [
            'id_user'           => $user['id'],
            'identifier'        => $identifier,
            'browser'           => $deviceInfo['browser'],
            'os'                => $deviceInfo['os'],
            'device'            => $deviceInfo['device'],
            'ip_address'        => $deviceInfo['ip_address'],
            'host_name'         => $deviceInfo['host_name'],
            'location_city'     => $deviceInfo['location']['city'],
            'location_region'   => $deviceInfo['location']['region'],
            'location_country'  => $deviceInfo['location']['country'],
            'user_agent'        => substr($deviceInfo['user_agent'], 0, 256)
        ];

        $deviceModel = new DeviceInfo();
        $deviceModel->saveOrUpdate($dataToInsert);
    
        echo json_encode([
            'status' => 'success',
            'message' => 'Login berhasil',
            'redirect' => $redir
        ]);
    }


    public function logout()
    {
        // Hapus sesi login
        Session::remove('user_logged_in'); 
        Session::remove('user');
        $redir = $_GET['redir'] ?? '';
        if (!empty($redir)) {
            $redir = urlencode($redir);
            header("Location: /auth?redir=$redir");
        } else {
            // Default redirect to /auth if no redir parameter is provided
            header("Location: /auth");
        }

        exit;
    }

}
