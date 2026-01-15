
<?php
    include_once("../../php/web.config.php");
    include_once(ROOT . "php/conexion.php");

    $id = $_POST['id'];
    $nombre_categoria = $_POST["nombre_categoria"];
    $tipo_operacion = $_POST["tipo_operacion"];

    
    
    $conexion = conectar();

    if ($conexion) {
        $sql = "UPDATE categoria SET nombre_categoria ='".$nombre_categoria."', tipo_operacion ='".$tipo_operacion."' WHERE Id_categoria ='".$id."'"; 

        
        if (mysqli_query($conexion, $sql)) {
            echo "Datos de usuario actualizados con éxito";
            header("Location: ".PAGES_DIR."/home");

        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
        }}
    else {
        echo "Error al conectar a la base de datos";
    }
?>
