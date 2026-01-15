<?php
// Reporte de errores (puedes comentarlo en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('../../php/web.config.php');
include_once(ROOT . "php/auth.php");
include_once(ROOT . "php/conexion.php");

header('Content-Type: application/json');

$datos_finales = [ /* Estructura por defecto */
    'historical_dates' => [], 'historical_amounts' => [], 'fechas_prediccion' => [],
    'gasto_por_dia' => [], 'gasto_predicho_total' => 0.00, 'ahorro_proyectado' => 0.00,
    'categoria_predominante' => 'N/A', 'factores_influencia' => [], 'mensaje' => null,
    'recomendacion_ia' => null, // Nueva clave para recomendación
    'error' => null
];

if (!isset($_SESSION['id'])) {
    $datos_finales['error'] = 'Usuario no autenticado.';
    echo json_encode($datos_finales);
    exit;
}

$id_usuario = $_SESSION['id'];
$fecha_hace_90_dias = date('Y-m-d', strtotime('-90 days'));
$fecha_hace_30_dias = date('Y-m-d', strtotime('-30 days'));

$ingreso_promedio_3meses = 0;
$ingreso_a_usar = 0;
// --- MODIFICADO: Obtener TODOS los gastos históricos (con categoría) ---
$gastos_historicos_completos = []; // Para pasar a Python

// 1. Obtener datos de la base de datos
$conexion = conectar();
if (!$conexion) {
    $datos_finales['error'] = 'Error al conectar a la base de datos desde PHP.';
    echo json_encode($datos_finales);
    exit;
}

try {
    // Gastos Históricos Reales (últimos 30 días para gráfica)
    $query_gastos_grafica = "SELECT fecha, monto FROM transacciones WHERE Id_usuario = ? AND tipo = 2 AND fecha >= ? ORDER BY fecha ASC";
    $stmt_gastos_grafica = $conexion->prepare($query_gastos_grafica);
    if ($stmt_gastos_grafica) {
        $stmt_gastos_grafica->bind_param("is", $id_usuario, $fecha_hace_30_dias);
        $stmt_gastos_grafica->execute();
        $resultado_gastos_grafica = $stmt_gastos_grafica->get_result();
        $gastos_historicos_reales_grafica = $resultado_gastos_grafica->fetch_all(MYSQLI_ASSOC);
        $datos_finales['historical_dates'] = array_column($gastos_historicos_reales_grafica, 'fecha');
        $datos_finales['historical_amounts'] = array_column($gastos_historicos_reales_grafica, 'monto');
        $stmt_gastos_grafica->close();
    }

    // --- NUEVO: Obtener TODOS los gastos históricos (monto, fecha, categoría) para Python ---
    $query_gastos_py = "SELECT t.monto, t.fecha, c.nombre_categoria
                        FROM transacciones t
                        INNER JOIN categoria c ON t.Id_categoria = c.Id_categoria
                        WHERE t.Id_usuario = ? AND t.tipo = 2 ORDER BY t.fecha DESC"; // Orden no importa mucho aquí
    $stmt_gastos_py = $conexion->prepare($query_gastos_py);
    if ($stmt_gastos_py) {
        $stmt_gastos_py->bind_param("i", $id_usuario);
        $stmt_gastos_py->execute();
        $resultado_gastos_py = $stmt_gastos_py->get_result();
        $gastos_historicos_completos = $resultado_gastos_py->fetch_all(MYSQLI_ASSOC); // Guardar para Python
        $stmt_gastos_py->close();
    }
    // --- FIN NUEVO ---


    // Ingreso Promedio (últimos 90 días)
    $query_ingresos_90d = "SELECT SUM(monto) as ingreso_total_90d FROM transacciones WHERE Id_usuario = ? AND tipo = 1 AND fecha >= ?";
    $stmt_ingresos = $conexion->prepare($query_ingresos_90d);
     if ($stmt_ingresos) {
        $stmt_ingresos->bind_param("is", $id_usuario, $fecha_hace_90_dias);
        $stmt_ingresos->execute();
        $resultado_ingresos = $stmt_ingresos->get_result();
        $ingreso_total_90d = $resultado_ingresos->fetch_assoc()['ingreso_total_90d'] ?? 0;
        $stmt_ingresos->close();
        $ingreso_promedio_3meses = $ingreso_total_90d / 3.0;
    }

    // Priorizar Ingreso Manual
    if (isset($_GET['ingreso_manual']) && is_numeric($_GET['ingreso_manual']) && floatval($_GET['ingreso_manual']) >= 0) {
        $ingreso_a_usar = floatval($_GET['ingreso_manual']);
    } else {
        $ingreso_a_usar = $ingreso_promedio_3meses;
    }

} catch (Exception $e) {
     error_log("Error general de base de datos: " . $e->getMessage());
     $datos_finales['error'] = 'Error al obtener datos del servidor.';
} finally {
    if ($conexion) {
        $conexion->close();
    }
}

// 2. Crear archivo temporal con TODOS los gastos históricos del usuario
$temp_file = tempnam(sys_get_temp_dir(), 'ia_userdata_');
// --- MODIFICADO: Pasar $gastos_historicos_completos ---
file_put_contents($temp_file, json_encode($gastos_historicos_completos));

// 3. Ejecutar el script de Python, pasando ingreso
$python_path = "py";
$python_script = ROOT . "ia/modelo_prediccion.py";
$comando = escapeshellcmd("$python_path \"$python_script\" \"$temp_file\" " . floatval($ingreso_a_usar));
$output = shell_exec($comando . ' 2>&1');

// 4. Limpiar archivo temporal
if (isset($temp_file) && file_exists($temp_file)) {
    unlink($temp_file);
}

// 5. Procesar respuesta y combinar
// (La lógica aquí es la misma, procesa $output y lo fusiona con $datos_finales)
if ($output === null || trim($output) === '') {
    if (!$datos_finales['error']) { $datos_finales['error'] = 'El script de Python no devolvió respuesta.'; }
} else {
    $respuesta_json = json_decode($output, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        if (!$datos_finales['error']) { $datos_finales['error'] = 'La respuesta de Python no es JSON válido.'; error_log("Respuesta Python (no JSON): " . $output); }
    } else if (isset($respuesta_json['error'])) {
        if (!$datos_finales['error']) { $datos_finales['error'] = $respuesta_json['error']; error_log("Python devolvió error: " . $respuesta_json['error']); }
    } else {
        // Éxito: fusionar respuesta de Python
        $datos_finales = array_merge($datos_finales, $respuesta_json);
        $datos_finales['error'] = null; // Limpiar error si Python tuvo éxito
    }
}

// 6. Enviar respuesta final
echo json_encode($datos_finales);
exit;
?>