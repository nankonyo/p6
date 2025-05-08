<?php
namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailerHelper
{
    public static function send(string $to, string $subject, string $body, string $altBody = '')
    {
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

            // Set From & To
            $mail->setFrom($_ENV['MAIL_FROM_ADDRESS'], $_ENV['MAIL_FROM_NAME']);
            $mail->addAddress($to);  // Kirim ke alamat email tujuan

            // Konten
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            if (!empty($altBody)) {
                $mail->AltBody = $altBody;  // Jika ada body alternatif (plain text)
            }

            // Kirim email
            return $mail->send();
        } catch (Exception $e) {
            return false;  // Jika terjadi error
        }
    }
}
