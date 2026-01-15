<?php
session_start(); 
include_once("../../php/web.config.php");
include_once(ROOT . "php/conexion.php");

// include_once("../conexion.php");

$correo         = $_POST['correo'];
$password       = $_POST['password'];
$pass_encript   = md5($password);


$conexion = conectar();


$sql = "SELECT * FROM usuario WHERE correo = '$correo' AND password ='$pass_encript' AND activo = 1 ";
$res = $conexion->query($sql);
$num = $res->num_rows;

if ($num == 1) {
    $row = $res->fetch_array();
    $id = $row['Id_usuario'];
    $usuario = $row['nombre'] . ' ' . $row['apellidos'];
    
    $_SESSION['id'] = $id;
    $_SESSION['usuario'] = $usuario;
    echo 1;

    } else {
        echo $correo .' '.$password;
    }

$conexion->close();
?>