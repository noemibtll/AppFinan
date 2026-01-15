<?php
$dbConfig = [
    'host' => 'localhost',
    'port' => 3307,
    'user' => 'root',
    'password' => '',
    'database' => 'proyecto'
];
function conectar()
{
    global $dbConfig;

    // Crear conexión
    $conexion = mysqli_connect($dbConfig['host'], $dbConfig['user'], $dbConfig['password'], $dbConfig['database'], $dbConfig['port']);

    // Verificar conexión
    if (!$conexion) {
        error_log("Error de conexión a la base de datos: " . mysqli_connect_error());
        return null;
    } 

    return $conexion;
}
?>
