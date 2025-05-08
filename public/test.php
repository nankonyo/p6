<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Load .env ke $_ENV
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// Validasi variabel penting
$requiredEnv = [
    'MAIL_HOST', 'MAIL_USERNAME', 'MAIL_PASSWORD', 'MAIL_ENCRYPTION',
    'MAIL_PORT', 'MAIL_FROM_ADDRESS', 'MAIL_FROM_NAME'
];

foreach ($requiredEnv as $env) {
    if (empty($_ENV[$env])) {
        die("Environment variable $env is not set.");
    }
}

$mail = new PHPMailer(true);

try {
    // Konfigurasi SMTP
    $mail->isSMTP();
    $mail->Host = $_ENV['MAIL_HOST'];
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['MAIL_USERNAME'];
    $mail->Password = $_ENV['MAIL_PASSWORD'];
    $mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'];
    $mail->Port = (int)$_ENV['MAIL_PORT'];

    // From & To
    $mail->setFrom($_ENV['MAIL_FROM_ADDRESS'], $_ENV['MAIL_FROM_NAME']);
    $mail->addAddress('nankonyo@gmail.com', 'gema azano');

    // Konten
    $mail->isHTML(true);
    $mail->Subject = 'Contoh Email dari PHPMailer';
    $mail->Body    = 'Ini adalah <b>email</b> yang dikirim dari <i>PHPMailer</i> dengan SMTP Gmail.';

    $mail->send();
    echo 'Email berhasil dikirim!';
} catch (Exception $e) {
    echo "Gagal kirim email. Error: {$mail->ErrorInfo}";
}
?>
