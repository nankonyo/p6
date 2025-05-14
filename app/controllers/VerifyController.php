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
            header('Location: /account');
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

        $redirSource = UrlHelpers::getRedirSource();

        // Render view
        View::render('verify/device', [
            'layout' => '_layouts/dashboard',
            'title' => 'Verify device',
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

    public function sendVerificationEmail()
    {
        $host = UrlHelpers::getHost();

        header('Content-Type: application/json');

        $id_user = Session::get('user')['id'] ?? null;
        if (!$id_user) {
            http_response_code(401);
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized.']);
            return;
        }

        $userModel = new User();
        $emailVerStat = $userModel->isEmailVerified($id_user);

        if ($emailVerStat) {
            echo json_encode(['status' => 'info', 'message' => 'Email sudah terverifikasi.']);
            return;
        }

        $email = $userModel->getEmailById($id_user);
        $fullUrl = UrlHelpers::getFullUrl();

        // --- Persiapan Token ---
        $deviceInfo = DeviceInfoHelper::getDeviceInfo($_SERVER['HTTP_USER_AGENT']);
        $identifier = DeviceInfoHelper::generateIdentifier($deviceInfo);

        // --- Validasi 2 menit ---
        $deviceModel = new DeviceInfo();
        if (!$deviceModel->canResendToken($id_user, $identifier)) {
            echo json_encode(['status' => 'error', 'message' => 'Kirim lagi nanti.']);
            return;
        }

        // --- Buat token dan simpan ke DB ---
        $token = bin2hex(random_bytes(32));
        $result = $deviceModel->updateVerificationToken($id_user, $identifier, $token);

        if (!$result) {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan token perangkat.']);
            return;
        }

        $verifyLink = $host."/verify/email-konfirm?token=" . urlencode($token);

        $sent = MailerHelper::send(
            $email,
            'Verifikasi Perangkat Baru Anda',
            '
                <div style="font-family:Arial,sans-serif;max-width:600px;margin:auto;padding:20px;border:1px solid #ddd;border-radius:8px;background-color:#f9f9f9;">
                    <h2 style="color:#333;">Verifikasi Perangkat Anda</h2>
                    <p>Halo,</p>
                    <p>Kami mendeteksi login dari perangkat yang belum dikenal. Untuk menjaga keamanan akun Anda, silakan verifikasi perangkat ini.</p>
                    <div style="text-align:center;margin:30px 0;">
                        <a href="' . $verifyLink . '" style="display:inline-block;padding:12px 24px;background-color:#007bff;color:#fff;text-decoration:none;border-radius:5px;font-weight:bold;">
                            Verifikasi Sekarang
                        </a>
                    </div>
                    <p>Jika Anda tidak merasa melakukan ini, abaikan email ini atau segera ubah kata sandi Anda.</p>
                    <p>Hormat kami,<br><strong>Tim Keamanan</strong></p>
                </div>
            '
        );

        if ($sent) {
            echo json_encode(['status' => 'success', 'message' => 'Email verifikasi berhasil dikirim.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal mengirim email verifikasi.']);
        }
    }

    public function konVerificationEmail()
    {
        $token = $_GET['token'] ?? null;

        if (!$token) {
            echo '
            <!DOCTYPE html>
                <html>
                <head>
                    <title>Verifikasi Gagal</title>
                    <script>
                        setTimeout(function() {
                            window.close();
                        }, 5000); // 5 detik delay
                    </script>
                </head>
                <body>
                    <p style="font-family:sans-serif;text-align:center;color:red;">Token tidak ditemukan</p>
                </body>
                </html>
            ';
            return;
        }

        $deviceModel = new DeviceInfo();
        $user_id = $deviceModel->verifyEmailToken($token);

        if (!$user_id) {
            // Token tidak valid atau sudah kedaluwarsa, tampilkan pesan gagal
            echo '
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Verifikasi Gagal</title>
                    <script>
                        // Tunggu sebentar lalu tutup otomatis
                        setTimeout(function() {
                            window.close();
                        }, 5000); // 5 detik delay
                    </script>
                </head>
                <body>
                    <p style="font-family:sans-serif;text-align:center;color:red;">Verifikasi gagal. Token tidak valid atau sudah kadaluarsa.</p>
                </body>
                </html>
            ';
            return;
        }

        // Verifikasi berhasil -> tampilkan pesan sukses dan tutup tab
        echo '
            <!DOCTYPE html>
            <html>
            <head>
                <title>Verifikasi Berhasil</title>
                <script>
                    // Tunggu sebentar lalu tutup otomatis
                    setTimeout(function() {
                        window.close();
                    }, 5000); // 5 detik delay
                </script>
            </head>
            <body>
                <p style="font-family:sans-serif;text-align:center;">Email berhasil diverifikasi.</p>
            </body>
            </html>
        ';
    }

    public function checkDeviceStatus()
    {
        $id_user = Session::get('user')['id'] ?? null;

        if (!$id_user) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'User not found.']);
            return;
        }

        $deviceInfo = DeviceInfoHelper::getDeviceInfo($_SERVER['HTTP_USER_AGENT']);
        $identifier = DeviceInfoHelper::generateIdentifier($deviceInfo);

        $deviceModel = new DeviceInfo();
        // Cek apakah perangkat sudah terverifikasi (status 'true')
        if ($deviceModel->isDeviceKnown($id_user, $identifier)) {
            echo json_encode(['status' => 'success', 'message' => 'Perangkat sudah diverifikasi.']);
        } else {
            echo json_encode(['status' => 'pending', 'message' => 'Perangkat belum diverifikasi.']);
        }
    }
}
