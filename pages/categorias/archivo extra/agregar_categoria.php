<?php
include_once('../../php/web.config.php');
include_once(ROOT . "php/conexion.php");
include_once("../../php/auth.php");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Agregar Categoría</title>

    <!-- Bootstrap desde CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- jQuery -->
    <script src="<?php echo JS_DIR; ?>/jquery-3.3.1.min.js"></script>

    <!-- Variables JS desde PHP -->
    <script>
        const JS_DIR_URL = "<?php echo JS_DIR; ?>";
        const PHP_DIR_URL = "<?php echo PHP_DIR; ?>";
    </script>

    <!-- Validación personalizada -->
    <script src="<?php echo JS_DIR; ?>/categoria_js/validacion.js"></script>
</head>
<body class="bg-light">

    <div class="container mt-5">
        <h1 class="mb-4">Agregar Categoría</h1>

        <form id="categoria" name="categoria" method="post" action="<?php echo PHP_DIR; ?>/categoria/agregar.php" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="nombre_categoria" class="form-label">Categoría:</label>
                <input type="text" class="form-control" id="nombre_categoria" name="nombre_categoria" placeholder="Categoría" required />
            </div>

            <div class="mb-3">
                <label for="tipo_operacion" class="form-label">Tipo de Operación:</label>
                <select class="form-select" id="tipo_operacion" name="tipo_operacion" required>
                    <option value="1" selected>Ingreso</option>
                    <option value="2">Gasto</option>
                </select>
            </div>


            <div id="campos_vacios" class="text-danger mb-3"></div>

            <button type="submit" class="btn btn-primary">Agregar Categoría</button>
        </form>

        <div class="mt-4">
            <a href="<?php echo PAGES_DIR; ?>/categorias/" class="btn btn-secondary">Regresar</a>
        </div>
    </div>

</body>
</html>
