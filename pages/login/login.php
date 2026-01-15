<?php
    include_once('../../php/web.config.php');
    include_once(ROOT . "php/conexion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/bootstrap.css">

    <!-- Scripts -->
    <script src="<?php echo JS_DIR; ?>/jquery-3.3.1.min.js"></script>
    <script>
        const JS_DIR_URL = "<?php echo JS_DIR; ?>";
        const PHP_DIR_URL = "<?php echo PHP_DIR; ?>";
        const BASE_URL = "<?php echo PAGES_DIR; ?>";
    </script>
    <script src="<?php echo JS_DIR; ?>/login_js/login.js"></script>
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 400px;">
        <div class="card shadow-sm">
            <div class="card-body">
                <h3 class="card-title text-center mb-4">Iniciar Sesión</h3>

                <form id="login" name="login" method="post">
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo electrónico</label>
                        <input type="text" class="form-control" name="correo" id="correo" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Escribe tu password" required>
                    </div>

                    <div id="campos_vacios" class="text-danger mb-3"></div>

                    <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
                    <br><br>
                    <a href="<?php echo BASE_URL; ?>" class="btn btn-primary w-100">Regresar</a>


                </form>
            </div>
        </div>
    </div>
</body>
</html>
