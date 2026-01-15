<?php
include_once('../../php/web.config.php');
include_once(ROOT . "php/conexion.php");
include_once("../../php/auth.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Editar Usuario</title>

    <!-- Bootstrap (usa esta línea si prefieres el CDN) -->
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
        <?php
        $conexion = conectar();
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $sql = "SELECT * FROM usuario WHERE Id_usuario = '".$id."'";
        $res = $conexion->query($sql);
        while ($row = $res->fetch_assoc()) {
            $nombre = $row['nombre'];
            $apellidos = $row['apellidos'];
            $correo = $row['correo'];
            $password = $row['password'];
        }
        ?>

        <h1 class="mb-4">Editar Usuario</h1>

        <form id="editar_usuario" name="editar_usuario" method="post" action="<?php echo PHP_DIR; ?>/usuario/editar.php" enctype="multipart/form-data">
            <input type="hidden" value="<?php echo $id ?>" id="id" name="id" />

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre ?>" required />
            </div>

            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos:</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo $apellidos ?>" required />
            </div>

            <div class="mb-3">
                <label for="correo" class="form-label">Correo:</label>
                <input type="email" class="form-control" id="correo" name="correo" value="<?php echo $correo ?>" onchange="comprobacion()" required />
                <div id="correo_error" class="text-danger mt-1"></div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese nueva contraseña" />
            </div>

            <div class="mb-3 text-danger" id="campos_vacios"></div>

            <button type="submit" class="btn btn-primary">Editar Usuario</button>
        </form>

        <div class="mt-4">
            <a href="<?php echo PAGES_DIR; ?>/usuario/" class="btn btn-secondary">Regresar</a>
        </div>
    </div>

</body>
</html>
