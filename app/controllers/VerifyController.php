<?php
namespace App\Controllers;

use Core\Session;
use Core\Controller;
use Core\View;
use App\Helpers\DeviceInfoHelper;
use App\Helpers\UrlHelpers;
use App\Helpers\MailerHelper;
use App\Models\User;
use App\Models\DeviceInfo;

class VerifyController extends Controller
{
    public function device()
    {
        $fullUrl = UrlHelpers::getFullUrl();
        $pathOnly = UrlHelpers::getPathOnly();

        // Ambil user id dari session
        $id_user = Session::get('user')['id'] ?? null;

        // Inisialisasi
        $deviceData = null;

        $deviceInfo = DeviceInfoHelper::getDeviceInfo($_SERVER['HTTP_USER_AGENT']);
        $identifier = DeviceInfoHelper::generateIdentifier($deviceInfo);

        // Cek apakah perangkat sudah terverifikasi dengan status 'true'
        $deviceModel = new DeviceInfo();

        if ($deviceModel->isDeviceKnown($id_user, $identifier)) {
            header('Location: /dashboard');
            exit;
        }

        // Email verifikasi status
        $emailVerStat = false;

        if ($id_user) {
            $userModel = new User();
            $emailVerStat = $userModel->isEmailVerified($id_user);
        }

        // Ambil data perangkat
        $deviceData = $deviceModel->getInfoDevice($id_user, $identifier);

        // Ambil alamat email
        $email = null;

        if ($id_user) {
            $userModel = new User();
            $email = $userModel->getEmailById($id_user);
        }

        // Kirim email jika email belum diverifikasi
        if ($id_user && !$emailVerStat) {
            $sent = MailerHelper::send(
                $email,                                 // To Email
                'Verifikasi Email Anda',                // Subject
                'Klik <a href="' . $fullUrl . '/verify-email">di sini</a> untuk memverifikasi email Anda.'  // Body
            );

            // Pemberitahuan jika email berhasil dikirim atau gagal
            if ($sent) {
                // Bisa ganti dengan view untuk pemberitahuan sukses
                echo 'Email verifikasi berhasil dikirim!';
            } else {
                echo 'Gagal mengirim email verifikasi.';
            }
        }

        $redirSource=UrlHelpers::getRedirSource();

        // Render view
        View::render('verify/device', [
            'layout' => '_layouts/dashboard',
            'title' => 'LEMBAGA PENGEMBANGAN APARATUR PEMERINTAH - LPAP',
            'description' => 'description home',
            'keywords' => 'keywords home',
            'author' => 'author home',
            'type' => 'website',
            'image' => 'image',
            'robots' => 'index, follow',
            'full_url' => $fullUrl,
            'path_only' => $pathOnly,
            'ogType' => 'website',
            'redir_source' => $redirSource,
            'device' => $deviceData,
            'emailVerStat' => $emailVerStat,
            'email' => $email
        ]);
    }
}
