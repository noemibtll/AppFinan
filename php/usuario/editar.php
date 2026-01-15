<?php
    include_once("../../php/web.config.php");
    include_once(ROOT . "php/conexion.php");

    $id = $_POST['id'];
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $correo = $_POST["correo"];
    $password = $_POST["password"];

    $conexion = conectar();

    if ($conexion) {
        if ($password == "") {
            // SIN CAMBIO DE CONTRASEÑA
            $sql = "UPDATE usuario SET nombre='$nombre', apellidos='$apellidos', correo='$correo' WHERE Id_usuario='$id'";
        } else {
            // CON CAMBIO DE CONTRASEÑA
            $pass_encript = md5($password);
            $sql = "UPDATE usuario SET nombre='$nombre', apellidos='$apellidos', correo='$correo', password='$pass_encript' WHERE Id_usuario='$id'";
        }

        if (mysqli_query($conexion, $sql)) {
            // Redirige sin mostrar nada antes
            header("Location: " . PAGES_DIR . "/usuario");
            exit;
        } else {
            echo "Error en la consulta: " . mysqli_error($conexion);
        }
    } else {
        echo "Error al conectar a la base de datos";
    }
?>
