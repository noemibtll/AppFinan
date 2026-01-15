
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Objetivos</title>

    <!-- Bootstrap desde archivo local -->
    <link rel="stylesheet" href="../../css/bootstrap.css">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <h1 class="mb-4">Lista de Objetivos</h1>

        <div class="list-group">
        <?php
            $conexion = conectar();
            $sql = "SELECT * FROM objetivos where Id_usuario = $id";
            $res = $conexion->query($sql);

            while ($row = $res->fetch_assoc()) {
                $id_objetivo = $row['Id_objetivo'];
                $monto_objetivo = $row['monto_objetivo'];
                $nombre_objetivo = $row['nombre_objetivo'];
                $fecha_objetivo = $row['fecha_objetivo'];
                if ($row['objetivo_tipo'] == 1) {
                    $objetivo_tipo = "Unico";
                } elseif ($row['objetivo_tipo'] == 2) {
                    $objetivo_tipo = "Quincenal";
                } else {
                    $objetivo_tipo = "Mensual"; // tercera opción
                }
        ?>
             <a href="informacion/index.php?id=<?php echo $id_objetivo;?>" class="list-group-item list-group-item-action">
                <strong>Nombre:</strong> <?php echo $nombre_objetivo; ?> |
                <strong>Monto:</strong> $<?php echo $monto_objetivo; ?> |
                <strong>Tipo:</strong> <?php echo $objetivo_tipo; ?> |
                <strong>Fecha:</strong> <?php echo $fecha_objetivo; ?>
            </a>
        <?php
            }
        ?>
        </div>

        <div class="mt-4">
            <a href="agregar/index.php" class="btn btn-success me-2">Agregar Objetivos</a>
            <a href="<?php echo PAGES_DIR; ?>" class="btn btn-secondary">Regresar</a>
        </div>
    </div>

</body>
</html>
