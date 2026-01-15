<?php 
    include_once('php/web.config.php');
    include_once(ROOT . "php/conexion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Inicio - App Financiera</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Tu hoja de estilos personalizada -->
    <link rel="stylesheet" href="css/inicio_css/inicio.css">

    <!-- Scripts opcionales -->
    <script src="<?php echo JS_DIR; ?>/jquery-3.3.1.min.js"></script>
    <script>
        const JS_DIR_URL = "<?php echo JS_DIR; ?>";
        const PHP_DIR_URL = "<?php echo PHP_DIR; ?>";
        const BASE_URL = "<?php echo BASE_URL; ?>";
    </script>
</head>
<body>

    <div class="container text-center mt-5 hero">
        <!-- Card de bienvenida -->
        <div class="welcome-card animate-card">
            <h2 class="titulo-bienvenida mb-3">Bienvenido a Tu App Financiera</h2>     
            <img src="css/inicio_css/logo.png" alt="Logo App Financiera" class="logo-app mb-2">
            <h4 class="eslogan mb-2">Organiza tu dinero, alcanza tus metas</h4>

            <!-- Botones inmediatamente después del eslogan -->
            <div class="d-grid gap-2 col-6 mx-auto">
                <a href="<?php echo BASE_URL; ?>pages/login/login.php" class="btn btn-primary btn-lg">Iniciar Sesión</a>
                <a href="<?php echo BASE_URL; ?>pages/registro/" class="btn btn-secondary btn-lg">Registrarse</a>
            </div>
        </div>

        <!-- Beneficios -->
        <div class="row mb-3 beneficios">
            <div class="col-md-4 col-12 mb-3 animate-benefit">
                <i class="bi bi-wallet2 feature-icon"></i>
                <p>Control de ingresos y gastos</p>
            </div>
            <div class="col-md-4 col-12 mb-3 animate-benefit">
                <i class="bi bi-bar-chart-line feature-icon"></i>
                <p>Gráficas fáciles de entender</p>
            </div>
            <div class="col-md-4 col-12 mb-3 animate-benefit">
                <i class="bi bi-bullseye feature-icon"></i>
                <p>Alcanza tus objetivos</p>
            </div>
        </div>

        <!-- Pie de página -->
        <footer class="footer text-center mt-5">
            <p>&copy; <?php echo date('Y'); ?> App Financiera. Todos los derechos reservados.</p>
        </footer>

    </div>

    <!-- Animaciones con jQuery -->
    <script>
        $(document).ready(function(){
            // Fade-in general de la card de bienvenida
            $('.animate-card').css({opacity:0, top:20}).animate({opacity:1, top:0}, 1000);

            // Animación de los beneficios uno por uno
            $('.animate-benefit').css({opacity:0, top:20}).each(function(i){
                $(this).delay(i*300).animate({opacity:1, top:0}, 800);
            });
        });
    </script>

</body>
</html>
