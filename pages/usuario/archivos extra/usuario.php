<?php
include_once('../../php/web.config.php');
include_once(ROOT . "php/conexion.php");
include_once(ROOT . "php/auth.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Usuario</title>
    <link rel="stylesheet" href="<?php echo CSS_DIR?>/bootstrap.css" />

</head>
<body class="container py-4">

    <h1 class="mb-4">Lista de Usuarios</h1>

    <?php
    $conexion = conectar();
    $sql = "SELECT * FROM usuario ";
    $res = $conexion->query($sql);
    while ($row = $res->fetch_assoc()) {
        $nombre = $row['nombre'];
        $apellidos = $row['apellidos'];
        $correo = $row['correo'];
    ?>
        <div class="mb-2">
            <a href="./editar_usuario.php?id=<?php echo $id; ?>" class="btn btn-link">
                <?php echo $nombre . ' ' . $apellidos . ' (' . $correo . ')'; ?>
            </a>
        </div>
    <?php
    }
    ?>

    <div class="mt-4">
        <a href="./agregar_usuario.php" class="btn btn-primary">Agregar Usuario</a>
    </div>

    <div class="mt-3">
        <a href="<?php echo BASE_URL; ?>" class="btn btn-secondary">Regresar</a>
    </div>

</body>
</html>
