<?php
require '../../vendor/autoload.php'; // Ruta del archivo

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendEmail($to, $subject, $body) {
    $mail = new PHPMailer(true);
    try {
        // Configuración del servidor
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Especifica el servidor SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'FontechPriv@gmail.com'; // Correo de origen
        $mail->Password = 'hgkw xknt pdao lrhi'; // Contraseña del correo de origen
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587; // Puerto SMTP

        // Destinatarios
        $mail->setFrom('FontechPriv@gmail.com', 'Fontech');
        $mail->addAddress($to);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}