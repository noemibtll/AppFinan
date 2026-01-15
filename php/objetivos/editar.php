<?php
include_once("../../php/web.config.php");
include_once(ROOT . "php/conexion.php");
include_once("../../php/auth.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_objetivo     = isset($_POST['id_objetivo']) ? intval($_POST['id_objetivo']) : 0;
    $nombre_objetivo = isset($_POST['nombre_objetivo']) ? trim($_POST['nombre_objetivo']) : '';
    $objetivo_tipo   = isset($_POST['objetivo']) ? intval($_POST['objetivo']) : 0;
    $monto_objetivo  = isset($_POST['monto_objetivo']) ? floatval($_POST['monto_objetivo']) : 0;
    $fecha_objetivo  = isset($_POST['fecha_objetivo']) ? $_POST['fecha_objetivo'] : '';

    // Validaciones
    if ($id_objetivo <= 0 || empty($nombre_objetivo) || !in_array($objetivo_tipo, [1, 2]) || $monto_objetivo <= 0 || empty($fecha_objetivo)) {
        die("Datos inválidos o incompletos.");
    }

    $conexion = conectar();
    if (!$conexion) {
        die("Error al conectar a la base de datos: " . mysqli_connect_error());
    }

    $sql = "UPDATE objetivos 
            SET nombre_objetivo = ?, objetivo_tipo = ?, monto_objetivo = ?, fecha_objetivo = ? 
            WHERE Id_objetivo = ? AND Id_usuario = ?";
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }

    // Tipos: s = string, i = int, d = double
    $stmt->bind_param("sidssi", $nombre_objetivo, $objetivo_tipo, $monto_objetivo, $fecha_objetivo, $id_objetivo, $id);

    if ($stmt->execute()) {
        header("Location: " . PAGES_DIR . "/objetivos/");
        exit();
    } else {
        echo "Error al actualizar el objetivo: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
} else {
    die("Acceso no permitido.");
}
?>
