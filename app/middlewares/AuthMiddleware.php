<?php

namespace App\Middlewares;

use Core\Session;
use App\Helpers\UrlHelpers;
use App\Helpers\DeviceInfoHelper;
use App\Models\DeviceInfo;
use App\Models\User;

class AuthMiddleware
{
    public function UserHandle()
    {
        if (!Session::get('user_logged_in')) {
            $fullUrl = UrlHelpers::getFullUrl();
            header('Location: /auth?redir=' . urlencode($fullUrl));
            exit;
        }
        if ($_SERVER['REQUEST_URI'] !== '/verify/device') {
            $this->checkDevice();
        }
    }

    public function authHandle()
    {
        if (Session::get('user_logged_in')) {
            $redir = urldecode($_GET['redir'] ?? '') ?: '/dashboard';
            header('Location: ' . $redir);
            exit;
        }
    }

    private function checkDevice()
    {
        // Ambil ID user dari session
        $userId = $_SESSION['user']['id'] ?? null;
    
        if (!$userId) {
            return;
        }
    
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $deviceInfo = DeviceInfoHelper::getDeviceInfo($userAgent);
        $identifier = DeviceInfoHelper::generateIdentifier($deviceInfo);
    
        $deviceModel = new DeviceInfo();
    
        // Periksa apakah device diketahui dan statusnya 'true'
        if (!$deviceModel->isDeviceKnown($userId, $identifier)) {
            // Jika perangkat belum terdaftar dengan status 'true', arahkan ke halaman verifikasi
            if ($_SERVER['REQUEST_URI'] !== '/verify/device') {
                header('Location: /verify/device');
                exit;
            }
        }
    }
}
