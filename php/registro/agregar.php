<?php
include_once("../../php/web.config.php");
include_once(ROOT . "php/conexion.php");

// PHPMailer
require_once ROOT . 'src/Exception.php';
require_once ROOT . 'src/PHPMailer.php';
require_once ROOT . 'src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre     = $_POST['nombre'];
    $apellidos  = $_POST['apellidos'];
    $password   = $_POST['pass'];
    $correo     = $_POST['correo'];
    $pass_encript = md5($password); // 👈 mejor usar password_hash()

    $codigo = rand(1000, 9999); // Código de verificación
    $enviado = false;

    // ===== Enviar correo =====
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'finanzas942@gmail.com';
        $mail->Password   = 'nwbg nnmv pmhj nnao'; // 👈 App Password, no la normal
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('finanzas942@gmail.com', 'AppFinanciera');
        $mail->addAddress($correo, $nombre . ' ' . $apellidos);

        $mail->isHTML(true);
        $mail->Subject = 'Bienvenido a AppFinanciera';
        $mail->Body    = '
            <h1>¡Hola ' . $nombre . ' ' . $apellidos . '!</h1>
            <p>Tu cuenta ha sido creada.</p>
            <p>Tu código de verificación es: <strong>' . $codigo . '</strong></p>
            <p><a href="' . PAGES_DIR . '/registro/verificacion/index.php?mail=' . $correo . '">Verifica aquí tu correo</a></p>
            <p>Gracias por unirte a nosotros.</p>';

        $mail->send();
        $enviado = true;
        } catch (Exception $e) {
        echo "⚠️ Error al enviar correo: {$mail->ErrorInfo}";
    }

    // ===== Insertar en la BD si se envió el correo =====
    if ($enviado) {
        $conexion = conectar();

        if ($conexion) {
            $sql = "INSERT INTO usuario (nombre, apellidos, correo, password, codigo) 
                    VALUES ('$nombre', '$apellidos', '$correo', '$pass_encript', '$codigo')";

            if (mysqli_query($conexion, $sql)) {
                header("Location: ".PAGES_DIR."/registro/verificacion/index.php?mail=$correo");
            } else {
                echo "❌ Error en la BD: " . mysqli_error($conexion);
            }
        } else {
            echo "❌ Error al conectar a la base de datos";
        }
    } else {
        echo "❌ Error al enviar correo, no se registró el usuario.";
    }
}
