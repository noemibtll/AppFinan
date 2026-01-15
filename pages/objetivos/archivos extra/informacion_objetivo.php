<?php
include_once('../../php/web.config.php');
include_once(ROOT . "php/conexion.php");
include_once("../../php/auth.php"); // Asegúrate que haya autenticación

$conexion = conectar();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de objetivo no válido.");
}
$id_objetivo = intval($_GET['id']);

$sql = "SELECT * FROM objetivos WHERE Id_objetivo = ? ";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_objetivo);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
    die("Transacción no encontrada o no pertenece al usuario.");
}


$row = $res->fetch_assoc(); 
$id_objetivo = $row['Id_objetivo'];
$nombre_objetivo = $row['nombre_objetivo'];
$fecha_objetivo = $row['fecha_objetivo'];
$objetivo_tipo = ($row['objetivo_tipo'] == 1) ? "Mensual" : "Unico";
$monto_objetivo = $row['monto_objetivo'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Objetivo</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <script src="<?php echo JS_DIR; ?>/jquery-3.3.1.min.js"></script>
    <script src="<?php echo JS_DIR; ?>/objetivos_js/validacion.js"></script>
</head>
<body class="bg-light">
<div class="container mt-5">
    <h1 class="mb-4">Editar Objetivo</h1>


        <div class="mb-3">
            <label for="nombre_objetivo" class="form-label">Nombre:</label>
            <label
                id="nombre_objetivo"
                name="nombre_objetivo"
                class="form-control"><?php echo htmlspecialchars(trim($nombre_objetivo)); ?></label>
        </div>

        <div class="mb-3">
            <label for="objetivo" class="form-label">Tipo de objetivo: <?php echo htmlspecialchars(trim($objetivo_tipo)); ?></label>
        </div>

        <div class="mb-3">
            <label for="monto_objetivo" class="form-label">Monto objetivo:</label>
            <label
                id="monto_objetivo"
                name="monto_objetivo"
                class="form-control">$<?php echo htmlspecialchars($monto_objetivo); ?></label>
        </div>

        <div class="mb-3">
            <label for="fecha_objetivo" class="form-label">Fecha:</label>
            <label
                id="fecha_objetivo"
                name="fecha_objetivo"
                class="form-control"><?php echo htmlspecialchars($fecha_objetivo); ?></label>
        </div>


        <div class="mb-3">
            <a href="./editar_objetivo.php?id=<?php echo $id_objetivo;?>" class="tn btn-secondary ms-2">Editar Objetivo</a>

            <a href="<?php echo PAGES_DIR; ?>/objetivos/" class="btn btn-secondary ms-2">Regresar</a>
        </div>

        <div id="campos_vacios" class="text-danger"></div>
    </form>
</div>
</body>
</html>
