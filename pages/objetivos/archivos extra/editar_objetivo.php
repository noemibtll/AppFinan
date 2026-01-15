<?php
include_once('../../php/web.config.php');
include_once(ROOT . "php/conexion.php");
include_once("../../php/auth.php"); // Asegúrate que haya autenticación

$conexion = conectar();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de objetivo no válido.");
}
$id_objetivo = intval($_GET['id']);


$sql = "SELECT * FROM objetivos WHERE Id_objetivo = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    die("Objetivo no encontrado.");
}

$row = $res->fetch_assoc();

$nombre_objetivo = $row['nombre_objetivo'];
$fecha_objetivo = $row['fecha_objetivo'];
$objetivo_tipo = $row['objetivo_tipo'];
$monto_objetivo = $row['monto_objetivo'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Editar Objetivo</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <script src="<?php echo JS_DIR; ?>/jquery-3.3.1.min.js"></script>
    <script src="<?php echo JS_DIR; ?>/objetivos_js/validacion.js"></script>
</head>
<body class="bg-light">
<div class="container mt-5">
    <h1 class="mb-4">Editar Objetivo</h1>

    <form id="objetivos" name="objetivos" method="post" action="<?php echo PHP_DIR; ?>/objetivos/editar.php" enctype="multipart/form-data" class="border p-4 bg-white rounded shadow-sm">
        <input type="hidden" name="id" value="<?php echo $id ?>" />

        <div class="mb-3">
            <label for="nombre_objetivo" class="form-label">Nombre:</label>
            <input
                type="text"
                id="nombre_objetivo"
                name="nombre_objetivo"
                class="form-control"
                value="<?php echo htmlspecialchars(trim($nombre_objetivo)); ?>"
                required
            />
        </div>

        <div class="mb-3">
            <label for="objetivo" class="form-label">Tipo de objetivo:</label>
            <select id="objetivo" name="objetivo" class="form-select" required>
                <option value="1" <?php if ($objetivo_tipo == 1) echo 'selected'; ?>>Mensual</option>
                <option value="2" <?php if ($objetivo_tipo == 2) echo 'selected'; ?>>Único</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="monto_objetivo" class="form-label">Monto objetivo:</label>
            <input
                type="number"
                min="1"
                id="monto_objetivo"
                name="monto_objetivo"
                class="form-control"
                value="<?php echo htmlspecialchars($monto_objetivo); ?>"
                required
            />
        </div>

        <div class="mb-3">
            <label for="fecha_objetivo" class="form-label">Fecha:</label>
            <input
                type="date"
                id="fecha_objetivo"
                name="fecha_objetivo"
                class="form-control"
                value="<?php echo htmlspecialchars($fecha_objetivo); ?>"
                required
            />
        </div>

        <div class="mb-3">
            <input type="submit" class="btn btn-primary" value="Guardar" />
            <a href="<?php echo PAGES_DIR; ?>/objetivos/" class="btn btn-secondary ms-2">Regresar</a>
        </div>

        <div id="campos_vacios" class="text-danger"></div>
    </form>
</div>
</body>
</html>
