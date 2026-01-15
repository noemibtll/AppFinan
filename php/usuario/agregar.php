<?php
    include_once("../../php/web.config.php");

    include_once(ROOT . "php/conexion.php");
    // include("../conexion.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';
    
    
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $password = $_POST['pass'];
        $pass_encript = md5($password);
        $correo = $_POST['correo'];
        
    
        // Asegúrate de que los valores están siendo recibidos
    
        // Conectar a la base de datos
        $conexion = conectar();
    
        // Verificar la conexión
        if ($conexion) {
            $sql = "INSERT INTO usuario ( nombre, apellidos, correo, password) VALUES ('$nombre', '$apellidos', '$correo', '$pass_encript')";
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