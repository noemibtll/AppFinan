<?php
    include_once("../../php/web.config.php");

    include_once(ROOT . "php/conexion.php");
    // include("../conexion.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';
    
        $id_usuario  = $_POST['id_usuario'];
        $monto  = $_POST['monto'];
        $categoria  = $_POST['categoria'];
        $tipo_operacion    = $_POST['tipo_operacion'];
        $fecha     = $_POST['fecha'];
        $descripcion     = $_POST['descripcion'];
        $frecuencia = $_POST['frecuencia'];  



        // Conectar a la base de datos
        $conexion = conectar();
    
        // Verificar la conexión
        if ($conexion) {
            $sql = "INSERT INTO transacciones ( Id_usuario, monto, Id_categoria, tipo, fecha, descripcion,frecuencia) VALUES ('$id_usuario', '$monto', '$categoria', '$tipo_operacion', '$fecha', '$descripcion','$frecuencia')";
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