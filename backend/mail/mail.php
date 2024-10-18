<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

function configurarEmail()
{
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'appfeira3f24@gmail.com';
        $mail->Password   = 'sbvp hmza vbzk hdkb';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        return $mail;
    } catch (Exception $e) {
        echo "Erro na configuração SMTP: {$mail->ErrorInfo}";
        return null;
    }
}