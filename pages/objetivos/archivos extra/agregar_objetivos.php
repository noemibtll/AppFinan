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
    <title>Agregar Objetivos</title>

    <!-- Bootstrap desde CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    
    <!-- jQuery y JS personalizados -->
    <script src="<?php echo JS_DIR; ?>/jquery-3.3.1.min.js"></script>
    <script>
        const JS_DIR_URL = "<?php echo JS_DIR; ?>";
        const PHP_DIR_URL = "<?php echo PHP_DIR; ?>";
    </script>
    <script src="<?php echo JS_DIR; ?>/objetivos_js/agregar_objetivos.js"></script>
</head>
<body class="bg-light">

    <div class="container mt-5">
        <h1 class="mb-4">Agregar Objetivo</h1>

        <form id="objetivos" name="objetivos" method="post" action="<?php echo PHP_DIR; ?>/objetivos/agregar.php" enctype="multipart/form-data" class="border p-4 bg-white rounded shadow-sm">

            <div class="mb-3">
                <label for="nombre_objetivo" class="form-label">Título:</label>
                <input type="text" class="form-control" id="nombre_objetivo" name="nombre_objetivo" placeholder="Ingresar Nombre Objetivo" required>
            </div>

            <div class="mb-3">
                <label for="objetivo" class="form-label">Tipo de objetivo:</label>
                <select id="objetivo" name="objetivo" class="form-select" required>
                    <option value="0" selected disabled>Seleccionar</option>
                    <option value="1">Mensual</option>
                    <option value="2">Único</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="monto_objetivo" class="form-label">Monto objetivo:</label>
                <input type="number" min="1" class="form-control" id="monto_objetivo" name="monto_objetivo" required>
            </div>

            <div class="mb-3">
                <label for="fecha_objetivo" class="form-label">Fecha:</label>
                <input type="date" class="form-control" id="fecha_objetivo" name="fecha_objetivo" required>
            </div>

            <div class="mb-3">
                <input type="submit" class="btn btn-primary" value="Agregar Nuevo Objetivo">
                <a href="<?php echo PAGES_DIR; ?>/objetivos/" class="btn btn-secondary ms-2">Regresar</a>
            </div>

            <div id="campos_vacios" class="text-danger"></div>
        </form>
    </div>

</body>
</html>
