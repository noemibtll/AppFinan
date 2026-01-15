<?php
    include_once('../../php/web.config.php');
    include_once(ROOT . "php/conexion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Inicio - App Financiera</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tu hoja de estilos local -->
    <link rel="stylesheet" href="../../css/bootstrap.css">

    <!-- Scripts opcionales (si los necesitas luego) -->
    <script src="<?php echo JS_DIR; ?>/jquery-3.3.1.min.js"></script>
    <script>
        const JS_DIR_URL = "<?php echo JS_DIR; ?>";
        const PHP_DIR_URL = "<?php echo PHP_DIR; ?>";
        const BASE_URL = "<?php echo BASE_URL; ?>";
    </script>
</head>
<body class="bg-light">

    <div class="container text-center mt-5">
        <h1 class="mb-4">Bienvenido a Tu App Financiera</h1>
        <p class="mb-5">Gestiona tus ingresos, egresos y objetivos personales</p>

        <div class="d-grid gap-3 col-6 mx-auto">
            <a href="<?php echo BASE_URL; ?>pages/login/login.php" class="btn btn-primary btn-lg">Iniciar Sesión</a>
            <a href="<?php echo BASE_URL; ?>pages/usuario/agregar_usuario.php" class="btn btn-outline-primary btn-lg">Registrarse</a>
        </div>
    </div>

</body>
</html>
