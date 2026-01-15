<?php
include_once('../../php/web.config.php');
include_once(ROOT . "php/conexion.php");
include_once("../../php/auth.php");

$id_usuario = isset($_SESSION['id']) ? intval($_SESSION['id']) : null;
if (!$id_usuario) {
    die("Usuario no autenticado.");
}

$id_transacciones = isset($_GET['id']) ? intval($_GET['id']) : null;
if (!$id_transacciones) {
    die("Transacción no válida.");
}

$conexion = conectar();
if (!$conexion) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

$stmt = $conexion->prepare("SELECT * FROM transacciones WHERE Id_transacciones = ? AND Id_usuario = ?");
if (!$stmt) {
    die("Error al preparar la consulta: " . $conexion->error);
}

$stmt->bind_param("ii", $id_transacciones, $id_usuario);
$stmt->execute();

$res = $stmt->get_result();
if ($res->num_rows === 0) {
    die("Transacción no encontrada o no pertenece al usuario.");
}

$row = $res->fetch_assoc();

$monto = $row['monto'];
$tipo_operacion = $row['tipo'];
$id_categoria = $row['Id_categoria'];
$fecha = $row['fecha'];
$descripcion = $row['descripcion'];
$frecuencia = $row['frecuencia'];  // <--- Aquí traemos frecuencia
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Editar Transacción</title>

    <link rel="stylesheet" href="../../css/bootstrap.css" />
    <script src="<?php echo JS_DIR; ?>/jquery-3.3.1.min.js"></script>
    <script src="<?php echo JS_DIR; ?>/transaccion_js/validacion.js"></script>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="mb-4">Editar Transacción</h2>

        <form
            id="transaccion"
            name="transaccion"
            method="post"
            action="<?php echo PHP_DIR; ?>/transaccion/editar.php"
            class="card p-4 shadow-sm bg-white"
        >
            <input type="hidden" name="id_transaccion" value="<?php echo $id_transacciones; ?>" />
            <input type="hidden" name="id_usuario" value="<?php echo $id_usuario; ?>" />

            <div class="mb-3">
                <label for="monto" class="form-label">Monto</label>
                <input
                    type="number"
                    min="1"
                    id="monto"
                    name="monto"
                    class="form-control"
                    value="<?php echo htmlspecialchars($monto); ?>"
                    required
                />
            </div>

            <div class="mb-3">
                <label for="tipo_operacion" class="form-label">Tipo de operación</label>
                <select id="tipo_operacion" name="tipo_operacion" class="form-select" required>
                    <option value="1" <?php if ($tipo_operacion == 1) echo "selected"; ?>>Ingreso</option>
                    <option value="2" <?php if ($tipo_operacion == 2) echo "selected"; ?>>Gasto</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="categoria" class="form-label">Categoría</label>
                <select name="categoria" id="categoria" class="form-select" required>
                    <option value="0" selected>Seleccionar</option>
                    <option value="1" >Alimentacion</option>
                    <option value="2" >Transporte</option>
                    <option value="3" >Nomina</option>  
                    <option value="4" >Ahorro</option>
                    <option value="5" >Hogar</option>
                    <option value="6" >Salud</option>
                    <option value="7" >Entretenimiento</option>                    

                    <?php
                    $sql_cat = "SELECT nombre_categoria, Id_categoria FROM categoria WHERE Id_usuario = ?";
                    $stmt_cat = $conexion->prepare($sql_cat);
                    if ($stmt_cat) {
                        $stmt_cat->bind_param("i", $id_usuario);
                        $stmt_cat->execute();
                        $result_cat = $stmt_cat->get_result();
                        while ($cat = $result_cat->fetch_assoc()) {
                            $selected = ($cat['Id_categoria'] == $id_categoria) ? 'selected' : '';
                            echo "<option value=\"" . htmlspecialchars($cat['Id_categoria']) . "\" $selected>" . htmlspecialchars($cat['nombre_categoria']) . "</option>";
                        }
                    } else {
                        echo "<option value=\"0\">Error cargando categorías</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input
                    type="date"
                    id="fecha"
                    name="fecha"
                    class="form-control"
                    value="<?php echo htmlspecialchars($fecha); ?>"
                    required
                />
            </div>

            <div class="mb-3">
                <label for="frecuencia" class="form-label">Frecuencia</label>
                <select name="frecuencia" id="frecuencia" class="form-select" required>
                    <option value="0" <?php if ($frecuencia == 0) echo "selected"; ?>>Sin frecuencia</option>
                    <option value="1" <?php if ($frecuencia == 1) echo "selected"; ?>>Diaria</option>
                    <option value="2" <?php if ($frecuencia == 2) echo "selected"; ?>>Semanal</option>
                    <option value="3" <?php if ($frecuencia == 3) echo "selected"; ?>>Mensual</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <input
                    type="text"
                    id="descripcion"
                    name="descripcion"
                    class="form-control"
                    value="<?php echo htmlspecialchars($descripcion); ?>"
                    required
                />
            </div>

            <button type="submit" class="btn btn-primary w-100">Guardar Cambios</button>
        </form>

        <div class="mt-3">
            <a href="<?php echo PAGES_DIR; ?>/transacciones/" class="btn btn-secondary">Regresar</a>
        </div>
    </div>
</body>
</html>
