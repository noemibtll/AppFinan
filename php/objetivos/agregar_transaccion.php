<?php
    include_once("../../php/web.config.php");

    include_once(ROOT . "php/conexion.php");
    // include("../conexion.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';
    
        $id_transaccion  = $_POST['id_transaccion'];



        // Conectar a la base de datos
        $conexion = conectar();
    
        // Verificar la conexión
        if ($conexion) {
            $sql = "UPDATE objetivos SET id_transaccion = $id_transaccion WHERE Id_objetivo = $id_objetivo";;
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