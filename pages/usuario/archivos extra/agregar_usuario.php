<?php
include_once('../../php/web.config.php');
include_once(ROOT . "php/conexion.php");
include_once("../../php/auth.php");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Usuario</title>

    <!-- Bootstrap desde CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="<?php echo JS_DIR; ?>/jquery-3.3.1.min.js"></script>

    <script>
        const JS_DIR_URL = "<?php echo JS_DIR; ?>";
        const PHP_DIR_URL = "<?php echo PHP_DIR; ?>";
    </script>
</head>
<body class="bg-light">

    <div class="container mt-5">
        <h1 class="mb-4">Agregar Usuario</h1>

        <form id="agregar_usuario" name="agregar_usuario" method="post" action="<?php echo PHP_DIR; ?>/usuario/agregar.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresar nombre" required>
            </div>

            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos:</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Ingresar apellidos" required>
            </div>

            <div class="mb-3">
                <label for="correo" class="form-label">Correo:</label>
                <input type="email" class="form-control" id="correo" name="correo" value="@" placeholder="Correo electrónico" onchange="comprobacion()" required>
                <div id="correo_error" class="text-danger mt-1"></div>
            </div>

            <div class="mb-3">
                <label for="pass" class="form-label">Contraseña:</label>
                <input type="password" class="form-control" id="pass" name="pass" placeholder="Contraseña" required>
            </div>

            <div class="mb-3 text-danger" id="campos_vacios"></div>

            <button type="submit" class="btn btn-success">Agregar Nuevo Usuario</button>
        </form>

        <div class="mt-4">
            <a href="<?php echo PAGES_DIR; ?>/categorias/" class="btn btn-secondary">Regresar</a>
        </div>
    </div>

</body>
</html>
