<?php
include_once("../../php/web.config.php");
include_once(ROOT . "php/conexion.php");

$codigo = $_POST['codigo'];
$correo = $_POST['correo'];
$conexion = conectar();

// Usar prepared statement para seguridad
$stmt = $conexion->prepare("SELECT * FROM usuario WHERE correo = ? AND codigo = ? AND activo = 0");
$stmt->bind_param("ss", $correo, $codigo);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows == 1) {
    echo 0; // ✅ código correcto
} else {
    echo 1; // ❌ código incorrecto
}

$stmt->close();
$conexion->close();
?>
