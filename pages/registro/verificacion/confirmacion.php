<?php
include_once("../../../php/web.config.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verificación Exitosa</title>
    <link rel="stylesheet" href="<?php echo CSS_DIR; ?>/estilos.css"> <!-- opcional -->
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background: #f5f5f5;
            padding: 50px;
        }
        .card {
            background: #fff;
            border-radius: 12px;
            padding: 30px;
            max-width: 400px;
            margin: auto;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        h1 {
            color: #28a745;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            background: #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 6px;
        }
        a:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>✅ ¡Correo verificado con éxito!</h1>
        <p>Gracias por confirmar tu cuenta. Ahora ya puedes iniciar sesión en nuestra plataforma.</p>
        <a href="<?php echo PAGES_DIR; ?>/login">Ir al Login</a>
    </div>
</body>
</html>
