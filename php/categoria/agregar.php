<?php
    include_once("../../php/web.config.php");
    include_once("../../php/auth.php");
    include_once(ROOT . "php/conexion.php");
    // include("../conexion.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';
    
        $nombre_categoria = $_POST['nombre_categoria'];
        $tipo_operacion = $_POST['tipo_operacion'];

        
    
        // Asegúrate de que los valores están siendo recibidos
    
        // Conectar a la base de datos
        $conexion = conectar();
    
        // Verificar la conexión
        if ($conexion) {
            $sql = "INSERT INTO categoria ( nombre_categoria, tipo_operacion, id_usuario) VALUES ('$nombre_categoria', '$tipo_operacion','$id')";
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