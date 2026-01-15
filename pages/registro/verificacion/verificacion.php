<?php
// Verificamos si nos mandaron el correo en el link
if (!isset($_GET['mail']) || empty($_GET['mail'])) {
    // Si no llega, redirigimos al inicio o mostramos error
    header("Location: " . PAGES_DIR); 
    exit();
}

// Sanitizamos el correo recibido
$correo = htmlspecialchars($_GET['mail']);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Cuenta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="<?php echo JS_DIR; ?>/jquery-3.3.1.min.js"></script>

    <script>
        const JS_DIR_URL = "<?php echo JS_DIR; ?>";
        const PHP_DIR_URL = "<?php echo PHP_DIR; ?>";
    </script>
    <script src="<?php echo JS_DIR; ?>/verificacion_js/verificacion.js"></script>

</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-lg p-4 rounded-3">
        <h2 class="mb-4 text-center">Verificar tu cuenta</h2>
        <p class="text-muted text-center">Introduce el código que recibiste en tu correo electrónico.</p>

        <form  id="verificar" name="verificar" action="<?php echo PHP_DIR; ?>/funciones/codigo.php" method="post">
            <input type="hidden" id="correo" name="correo" value="<?php echo $correo; ?>">
            <div class="mb-3">
                <label for="codigo" class="form-label">Código de verificación</label>
                <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Ejemplo: 1234" onchange="comprobacion()" required>
            </div>
            <div id="codigo_error" class="text-danger mb-3"></div>


            <button type="submit" class="btn btn-success w-100">Verificar</button>
        </form>

        <div class="mt-3 text-center">
            <a href="<?php echo PAGES_DIR; ?>" class="btn btn-link">Regresar al inicio</a>
        </div>
    </div>
</div>

</body>
</html>