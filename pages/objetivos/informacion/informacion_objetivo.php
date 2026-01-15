<?php
$conexion = conectar();
if (!$conexion) die("Error al conectar a la base de datos.");

// Validar ID de objetivo
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de objetivo no válido.");
}
$id_objetivo = intval($_GET['id']);

// Obtener datos del objetivo
$sql = "SELECT * FROM objetivos WHERE Id_objetivo = ? AND Id_usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ii", $id_objetivo, $id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    die("Objetivo no encontrado o no pertenece al usuario.");
}

$row = $res->fetch_assoc(); 
$nombre_objetivo = $row['nombre_objetivo'];
$fecha_objetivo = $row['fecha_objetivo'];
$monto_objetivo = $row['monto_objetivo'];

switch ($row['objetivo_tipo']) {
    case 1: $objetivo_tipo = "Único"; break;
    case 3: $objetivo_tipo = "Mensual"; break;
    default: $objetivo_tipo = "Quincenal";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Objetivo</title>
    <link rel="stylesheet" href="<?php echo CSS_DIR ?>/bootstrap.css" />
    <script src="<?php echo JS_DIR ?>/jquery-3.3.1.min.js"></script>
    <script src="<?php echo JS_DIR ?>/objetivos_js/validacion.js"></script>
</head>
<body class="bg-light">
<div class="container mt-5">
    <h1 class="mb-4">Objetivo</h1>

    <div class="mb-3">
        <label for="nombre_objetivo" class="form-label">Nombre:</label>
        <label id="nombre_objetivo" class="form-control"><?php echo htmlspecialchars(trim($nombre_objetivo)); ?></label>
    </div>

    <div class="mb-3">
        <label class="form-label">Tipo de objetivo: <?php echo htmlspecialchars(trim($objetivo_tipo)); ?></label>
    </div>

    <div class="mb-3">
        <label class="form-label">Monto objetivo:</label>
        <label class="form-control">$<?php echo htmlspecialchars($monto_objetivo); ?></label>
    </div>

    <div class="mb-3">
        <label class="form-label">Fecha:</label>
        <label class="form-control"><?php echo htmlspecialchars($fecha_objetivo); ?></label>
    </div>

    <div class="mb-3">
        <a href="../editar/index.php?id=<?php echo $id_objetivo;?>" class="btn btn-primary ms">Editar Objetivo</a>
        <a href="<?php echo PAGES_DIR; ?>/objetivos/" class="btn btn-secondary ms-2">Regresar</a>
    </div>
</div>

<div class="container mt-5">
    <h1 class="mb-4">Últimos movimientos</h1>
        <br>
    <div class="mb-3">
        <a href="../obj_tran/index.php?id=<?php echo $id_objetivo;?>" class="btn btn-primary ms">Agregar Transferencia</a>
    </div>
    <div class="row row-cols-1 row-cols-md-2 g-4">
        <?php 
        // Obtener transacciones vinculadas a este objetivo
        $sql_trans = "
            SELECT Id_transacciones, tipo, monto, fecha, descripcion
            FROM transacciones
            WHERE Id_objetivo = ? AND Id_usuario = ?
            ORDER BY fecha DESC
        ";
        $stmt_trans = $conexion->prepare($sql_trans);
        $stmt_trans->bind_param("ii", $id_objetivo, $id);
        $stmt_trans->execute();
        $res_trans = $stmt_trans->get_result();

        if ($res_trans && $res_trans->num_rows > 0) {
            while ($row = $res_trans->fetch_assoc()) {
                $tipo = ($row['tipo'] == 1) ? "Ingreso" : "Gasto";
                $fecha = $row['fecha'];
                $descripcion = $row['descripcion'] ;

                $monto = number_format($row['monto'], 2);
        ?>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($descripcion); ?></h5>
                        <p class="card-text mb-1"><strong>Fecha:</strong> $<?php echo $fecha; ?></p>
                        <p class="card-text mb-1"><strong>Monto:</strong> $<?php echo $monto; ?></p>
                        <p class="card-text mb-1"><strong>Tipo:</strong> <?php echo $tipo; ?></p>
                        <a href="<?php echo PAGES_DIR;?>/transacciones/" class="btn btn-sm btn-outline-primary">Ver</a>
     
                    </div>
                </div>
            </div>
        <?php 
            }
        } else {
            echo '<p>No hay transacciones vinculadas a este objetivo.</p>';
        }
        ?>
    </div>


</div>

</body>
</html>
