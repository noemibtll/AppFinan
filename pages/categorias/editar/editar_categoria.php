<?php

    $conexion = conectar();
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $sql = "SELECT * FROM categoria WHERE Id_categoria = '$id'";
    $res = $conexion->query($sql);

    $nombre_categoria = "";
    $tipo_operacion = 1;
    $tipo_gasto = 1;

    if ($res && $row = $res->fetch_assoc()) {
        $nombre_categoria = $row['nombre_categoria'];
        $tipo_operacion = $row['tipo_operacion'];
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoría</title>

    <!-- Bootstrap desde CDN -->
     <link rel="stylesheet" href="<?php echo CSS_DIR?>/bootstrap.css" />
    <script src="<?php echo JS_DIR; ?>/jquery-3.3.1.min.js"></script>
    <script>
        const JS_DIR_URL = "<?php echo JS_DIR; ?>";
        const PHP_DIR_URL = "<?php echo PHP_DIR; ?>";
    </script>
    <script src="<?php echo JS_DIR; ?>/categoria_js/validacion.js"></script>
</head>
<body class="bg-light">

    <div class="container mt-5">
        <h1 class="mb-4">Editar Categoría</h1>

        <form id="categoria" name="categoria" method="post" action="<?php echo PHP_DIR; ?>/categoria/guardar.php" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <div class="mb-3">
                <label for="nombre_categoria" class="form-label">Nombre de la categoría:</label>
                <input type="text" class="form-control" id="nombre_categoria" name="nombre_categoria" value="<?php echo htmlspecialchars($nombre_categoria); ?>" required>
            </div>

            <div class="mb-3">
                <label for="tipo_operacion" class="form-label">Tipo de operación:</label>
                <select class="form-select" id="tipo_operacion" name="tipo_operacion">
                    <option value="1" <?php if ($tipo_operacion == 1) echo 'selected'; ?>>Ingreso</option>
                    <option value="2" <?php if ($tipo_operacion == 2) echo 'selected'; ?>>Gasto</option>
                </select>
            </div>


            <div class="mb-3">
                <input type="submit" class="btn btn-primary" value="Guardar Categoría">
                <a href="<?php echo PAGES_DIR; ?>/categorias/" class="btn btn-secondary ms-2">Regresar</a>
            </div>

            <div id="campos_vacios" class="text-danger"></div>
        </form>
    </div>

</body>
</html>
