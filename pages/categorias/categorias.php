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
    <title>Categorías</title>

    <!-- Bootstrap desde CDN -->
            <link rel="stylesheet" href="<?php echo CSS_DIR?>/bootstrap.css" />

</head>
<body class="bg-light">

    <div class="container mt-5">
        <h1 class="mb-4">Listado de Categorías</h1>

        <div class="row row-cols-1 row-cols-md-2 g-4">
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Alimentacion</h5>
                        <p class="card-text mb-1"><strong>Tipo de Operación:</strong> Gasto</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Transporte</h5>
                        <p class="card-text mb-1"><strong>Tipo de Operación:</strong> Gasto</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Nomina</h5>
                        <p class="card-text mb-1"><strong>Tipo de Operación:</strong> Ingreso</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Ahorro</h5>
                        <p class="card-text mb-1"><strong>Tipo de Operación:</strong> Ingreso</p>
                    </div>
                </div>
            </div>
                        <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Hogar</h5>
                        <p class="card-text mb-1"><strong>Tipo de Operación:</strong> Gasto</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Salud</h5>
                        <p class="card-text mb-1"><strong>Tipo de Operación:</strong> Gasto</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Entretenimiento</h5>
                        <p class="card-text mb-1"><strong>Tipo de Operación:</strong> Gasto</p>
                    </div>
                </div>
            </div>
            <?php
                $conexion = conectar();
                $sql = "SELECT * FROM categoria WhERE id_usuario = '$id'";
                $res = $conexion->query($sql);

                while ($row = $res->fetch_assoc()) {
                    $id_categoria = $row['Id_categoria'];
                    $nombre_categoria = $row['nombre_categoria'];
                    $tipo_operacion = $row['tipo_operacion'] == 1 ? 'Ingreso' : 'Gasto';
            ?>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($nombre_categoria); ?></h5>
                        <p class="card-text mb-1"><strong>Tipo de Operación:</strong> <?php echo $tipo_operacion; ?></p>

                        <a href="editar/index.php?id=<?php echo $id_categoria; ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                    </div>
                </div>
            </div>
            <?php } ?>
                    <div class="mt-4">
            <a href="agregar/index.php" class="btn btn-success me-2">Agregar Categoría</a>
            <a href="<?php echo PAGES_DIR; ?>" class="btn btn-secondary">Regresar</a>
        </div>
        </div>
    <div class="container mt-5">
        <h1 class="mb-4">Listado de Objetivos</h1>
        <div class="row row-cols-1 row-cols-md-2 g-4">

            <?php
                $conexion = conectar();
                $sql = "SELECT * FROM objetivos WhERE id_usuario = '$id'";
                $res = $conexion->query($sql);

                while ($row = $res->fetch_assoc()) {
                    $id_objetivo = $row['Id_objetivo'];
                    $nombre_objetivo = $row['nombre_objetivo'];
                    $monto_objetivo = $row['monto_objetivo'];
            ?>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($nombre_objetivo); ?></h5>
                        <p class="card-text mb-1"><strong>Objetivo:</strong> $<?php echo $monto_objetivo; ?></p>

                        <a href="<?php echo PAGES_DIR;?>/objetivos/informacion/index.php?id=<?php echo $id_objetivo; ?>" class="btn btn-sm btn-outline-primary">Ver</a>
                    </div>
                </div>
            </div>
            <?php } ?>
    </div>
                        <br>
    </div>
            



    </div>

</body>
</html>
