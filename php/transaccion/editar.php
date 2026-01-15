<?php
include_once("../../php/web.config.php");
include_once(ROOT . "php/conexion.php");
include_once("../../php/auth.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_transacciones = isset($_POST['id_transaccion']) ? intval($_POST['id_transaccion']) : 0;
    $id_usuario = isset($_POST['id_usuario']) ? intval($_POST['id_usuario']) : 0;
    $monto = isset($_POST['monto']) ? floatval($_POST['monto']) : 0;
    $categoria = isset($_POST['categoria']) ? intval($_POST['categoria']) : 0;
    $tipo_operacion = isset($_POST['tipo_operacion']) ? intval($_POST['tipo_operacion']) : 0;
    $fecha = isset($_POST['fecha']) ? $_POST['fecha'] : '';
    $frecuencia = isset($_POST['frecuencia']) ? intval($_POST['frecuencia']) : 0;
    $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';

    // Validar datos básicos
    if ($id_transacciones <= 0 || $id_usuario <= 0 || $monto <= 0 || $categoria <= 0 || !in_array($tipo_operacion, [1, 2]) || empty($fecha) || empty($descripcion)) {
        die("Datos inválidos o incompletos.");
    }

    $conexion = conectar();
    if (!$conexion) {
        die("Error al conectar a la base de datos: " . mysqli_connect_error());
    }

    $sql = "UPDATE transacciones SET monto = ?, Id_categoria = ?, tipo = ?, fecha = ?, descripcion = ?, frecuencia = ? WHERE Id_transacciones = ? AND Id_usuario = ?";
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }

    $stmt->bind_param("diissiii", $monto, $categoria, $tipo_operacion, $fecha, $descripcion, $frecuencia, $id_transacciones, $id_usuario);

    if ($stmt->execute()) {
        header("Location: " . PAGES_DIR . "/transacciones/");
        exit();
    } else {
        echo "Error al actualizar la transacción: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
} else {
    die("Acceso no permitido.");
}
?>
