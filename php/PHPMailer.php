<?php
require_once 'web.config.php';


// 🚨 Opción 1: Si usas Composer
// require_once ROOT . 'vendor/autoload.php';

// 🚨 Opción 2: Si bajaste PHPMailer manualmente
require_once SRC_DIR . 'Exception.php';
require_once SRC_DIR . 'PHPMailer.php';
require_once SRC_DIR . 'SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'finanzas942@gmail.com';
    $mail->Password   = 'Finanzas12345'; // clave de app de Gmail
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('finanzas942@gmail.com', 'AppFinanciera');
    $mail->addAddress('juan2parada0b@gmail.com');

    $mail->isHTML(true);
    $mail->Subject = 'Bienvenido a AppFinanciera';
    $mail->Body    = '<h1>¡Hola!</h1><p>Tu cuenta ha sido creada.</p>';

    $mail->send();
    echo 'Correo enviado correctamente';
} catch (Exception $e) {
    echo "Error al enviar: {$mail->ErrorInfo}";
}
