<?php
    include_once("../../php/web.config.php");
    include_once(ROOT . "php/conexion.php");

    $correo = $_POST['correo'];
    $codigo = $_POST["codigo"];

    $conexion = conectar();

    if ($conexion) {

            $sql = "UPDATE usuario SET codigo= 0 , activo=1 WHERE correo='$correo'";

        if (mysqli_query($conexion, $sql)) {
            // Redirige sin mostrar nada antes
            header("Location: " . PAGES_DIR . "/registro/verificacion/confirmacion.php");

            exit;
        } else {
            echo "Error en la consulta: " . mysqli_error($conexion);
        }
    } else {
        echo "Error al conectar a la base de datos";
    }
?>
