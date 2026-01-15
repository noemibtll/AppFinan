<?php
include_once("../../php/web.config.php");
include_once(ROOT . "php/conexion.php");

$correo = $_POST['correo'];

$conexion = conectar();

$sql = "SELECT * FROM usuario WHERE correo = '$correo'";
$res = $conexion->query($sql);
$num = $res->num_rows;

if ($num == 1) {
    $row = $res->fetch_array();
    echo 1;
} 
else {
        echo 2;
}


$conexion->close();
?>