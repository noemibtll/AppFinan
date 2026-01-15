<?php
include_once("../../php/web.config.php");
include_once("../../php/auth.php"); // $id = usuario logueado
include_once(ROOT . "php/conexion.php");

$conexion = conectar();
if (!$conexion) {
    die("Error al conectar a la base de datos.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id_objetivo   = intval($_POST['id_objetivo']);
    $id_usuario    = $id; // de la sesión
    $seleccionadas = $_POST['transacciones'] ?? [];
    $seleccionadas = array_map('intval', $seleccionadas); // sanitizar

    // 🔎 Depuración opcional
    // echo "<pre>"; print_r($_POST); echo "</pre>"; exit;

    // 1️⃣ Liberar todas las transacciones de este objetivo
    $sql_reset = "
        UPDATE transacciones
        SET Id_objetivo = NULL
        WHERE Id_usuario = ? AND Id_objetivo = ?
    ";
    $stmt = $conexion->prepare($sql_reset);
    $stmt->bind_param("ii", $id_usuario, $id_objetivo);
    if (!$stmt->execute()) {
        die("Error al liberar transacciones: " . $stmt->error);
    }

    // 2️⃣ Asignar las seleccionadas
    if (!empty($seleccionadas)) {
        // Crear lista de IDs segura
        $ids_str = implode(',', $seleccionadas);

        $sql_update = "
            UPDATE transacciones
            SET Id_objetivo = $id_objetivo
            WHERE Id_usuario = $id_usuario
              AND Id_transacciones IN ($ids_str)
        ";

        if (!$conexion->query($sql_update)) {
            die("Error al actualizar transacciones: " . $conexion->error);
        }
    }

    // 3️⃣ Redirigir
    header("Location: " . PAGES_DIR . "/objetivos/informacion/index.php?id=" . $id_objetivo);
    exit;
} else {
    die("Método no permitido.");
}
?>
