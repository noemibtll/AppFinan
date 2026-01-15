<?php
    include_once("../../php/web.config.php");
    include_once("../../php/auth.php"); // Asegúrate que haya autenticación
    include_once(ROOT . "php/conexion.php");
    
    // include("../conexion.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';
    
        $objetivo_tipo  = $_POST['objetivo_tipo'];
        $nombre_objetivo    = $_POST['nombre_objetivo'];
        $fecha_objetivo     = $_POST['fecha_objetivo'];
        $monto_objetivo     = $_POST['monto_objetivo'];



        // Conectar a la base de datos
        $conexion = conectar();
    
        // Verificar la conexión
        if ($conexion) {
            $sql = "INSERT INTO objetivos ( fecha_objetivo, nombre_objetivo, monto_objetivo, objetivo_tipo, id_usuario) VALUES ('$fecha_objetivo', '$nombre_objetivo', '$monto_objetivo', '$objetivo_tipo', '$id')";
            if (mysqli_query($conexion, $sql)) {
                header("Location: ".PAGES_DIR."/home");

    
                echo "Usuario registrado con éxito";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
            }
        } else {
            echo "Error al conectar a la base de datos";
        }
    }
    ?>    