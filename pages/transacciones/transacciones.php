<?php 

// Conexión
$conexion = conectar();
if (!$conexion) die("Error al conectar a la base de datos: " . mysqli_connect_error());

// Paginación
$transacciones_por_pagina = 5;
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina_actual < 1) $pagina_actual = 1;
$offset = ($pagina_actual - 1) * $transacciones_por_pagina;

// Total transacciones
$sql_total = "SELECT COUNT(*) as total FROM transacciones WHERE Id_usuario = $id";
$res_total = $conexion->query($sql_total);
$total_transacciones = $res_total->fetch_assoc()['total'];
$total_paginas = ceil($total_transacciones / $transacciones_por_pagina);
if ($pagina_actual > $total_paginas && $total_paginas > 0) $pagina_actual = $total_paginas;

// Resumen financiero
$sql_ingresos = "SELECT SUM(monto) as total FROM transacciones WHERE Id_usuario = $id AND tipo = 1";
$total_ingresos = $conexion->query($sql_ingresos)->fetch_assoc()['total'] ?? 0;

$sql_gastos = "SELECT SUM(monto) as total FROM transacciones WHERE Id_usuario = $id AND tipo = 2";
$total_gastos = $conexion->query($sql_gastos)->fetch_assoc()['total'] ?? 0;

$balance = $total_ingresos - $total_gastos;

// Transacciones recientes
$sql_recientes = "
    SELECT t.Id_transacciones, t.tipo, t.monto, t.fecha, t.descripcion, c.nombre_categoria
    FROM transacciones t
    INNER JOIN categoria c ON t.Id_categoria = c.Id_categoria
    WHERE t.Id_usuario = $id
    ORDER BY t.fecha DESC 
    LIMIT 10";
$res_recientes = $conexion->query($sql_recientes);

// Distribución de gastos por categoría
$sql_distribucion = "
    SELECT c.nombre_categoria, SUM(t.monto) as total
    FROM transacciones t
    INNER JOIN categoria c ON t.Id_categoria = c.Id_categoria
    WHERE t.Id_usuario = $id AND t.tipo = 2
    GROUP BY c.Id_categoria";
$res_distribucion = $conexion->query($sql_distribucion);
$categorias_gastos = [];
$montos_gastos = [];
while ($row = $res_distribucion->fetch_assoc()) {
    $categorias_gastos[] = $row['nombre_categoria'];
    $montos_gastos[] = $row['total'];
}

// Transacciones paginadas
$sql = "
    SELECT t.Id_transacciones, t.Id_usuario, t.Id_categoria, c.nombre_categoria, t.tipo, t.monto, t.fecha, t.frecuencia, t.descripcion
    FROM transacciones t
    INNER JOIN categoria c ON t.Id_categoria = c.Id_categoria
    WHERE t.Id_usuario = $id
    ORDER BY t.fecha DESC
    LIMIT $transacciones_por_pagina OFFSET $offset";
$res = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Transacciones</title>
    <link rel="stylesheet" href="../../css/bootstrap.css" />
    <link rel="stylesheet" href="../../css/transacciones_css/transacciones.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h1 class="mb-4">Transacciones de <?php echo htmlspecialchars($usuario); ?></h1>
    
    <!-- Resumen Financiero -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Ingresos</h5>
                    <h2 class="card-text">$<?php echo number_format($total_ingresos, 2); ?></h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h5 class="card-title">Gastos</h5>
                    <h2 class="card-text">$<?php echo number_format($total_gastos, 2); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Balance</h5>
                    <h2 class="card-text">$<?php echo number_format($balance, 2); ?></h2>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Gráfico de Distribución de Gastos -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Distribución de Gastos</h5>
                </div>
                <div class="card-body">
                    <canvas id="gastosChart" height="250"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Transacciones Recientes -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Transacciones Recientes</h5>
                </div>
                <div class="card-body">
                    <?php if ($res_recientes && $res_recientes->num_rows > 0): ?>
                        <div class="list-group">
                            <?php while ($row_reciente = $res_recientes->fetch_assoc()): ?>
                                <div class="list-group-item d-flex justify-content-between align-items-center <?php echo $row_reciente['tipo'] == 1 ? 'transaction-income' : 'transaction-expense'; ?>">
                                    <div>
                                        <h6 class="mb-1"><?php echo htmlspecialchars($row_reciente['nombre_categoria']); ?></h6>
                                        <small class="text-muted"><?php echo $row_reciente['fecha']; ?> - <?php echo htmlspecialchars($row_reciente['descripcion']); ?></small>
                                    </div>
                                    <span class="<?php echo $row_reciente['tipo'] == 1 ? 'text-success' : 'text-danger'; ?> fw-bold">
                                        <?php echo $row_reciente['tipo'] == 1 ? '+' : '-'; ?>$<?php echo number_format($row_reciente['monto'], 2); ?>
                                    </span>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">No hay transacciones recientes.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Transacciones -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Todas las Transacciones</h5>
            <span class="badge bg-secondary">Página <?php echo $pagina_actual; ?> de <?php echo $total_paginas; ?></span>
        </div>
        <div class="card-body p-0">
            <?php if ($res && $res->num_rows > 0): ?>
            <ul class="list-group list-group-flush">
                <?php while ($row = $res->fetch_assoc()):
                    $tipo = ($row['tipo'] == 1) ? "Ingreso" : "Gasto";
                    $badgeClass = $row['tipo'] == 1 ? "list-group-item-success" : "list-group-item-danger";
                    $montoSign = $row['tipo'] == 1 ? "+" : "-";
                    switch ($row['frecuencia']) {
                        case 0: $frecuencia_texto = "Sin frecuencia"; break;
                        case 1: $frecuencia_texto = "Diaria"; break;
                        case 2: $frecuencia_texto = "Semanal"; break;
                        case 3: $frecuencia_texto = "Mensual"; break;
                        default: $frecuencia_texto = "Desconocida";
                    }
                ?>
                <li class="list-group-item <?php echo $badgeClass; ?> d-flex justify-content-between align-items-center">
                    <div>
                        <strong><?php echo htmlspecialchars($row['nombre_categoria']); ?></strong><br>
                        <small class="text-muted"><?php echo $row['fecha']; ?> - <?php echo htmlspecialchars($row['descripcion']); ?></small><br>
                        <small class="text-dark"><?php echo $frecuencia_texto; ?></small>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-primary rounded-pill"><?php echo $montoSign; ?>$<?php echo number_format($row['monto'], 2); ?></span>
                        <a href="editar/index.php?id=<?php echo $row['Id_transacciones']; ?>"class="btn btn-outline-dark">
                            <i class="bi bi-pencil"></i>
                        </a>
                    </div>
                </li>
                <?php endwhile; ?>
            </ul>
            <?php else: ?>
                <p class="text-center py-4">No hay transacciones registradas.</p>
            <?php endif; ?>

            <!-- Paginación -->
            <?php if ($total_paginas > 1): ?>
            <div class="card-footer">
                <nav aria-label="Navegación de transacciones">
                    <ul class="pagination justify-content-center mb-0">
                        <li class="page-item <?php echo $pagina_actual <= 1 ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?pagina=<?php echo $pagina_actual - 1; ?>">&laquo; Anterior</a>
                        </li>
                        <?php
                        $inicio = max(1, $pagina_actual - 2);
                        $fin = min($total_paginas, $inicio + 4);
                        if ($fin - $inicio < 4) $inicio = max(1, $fin - 4);
                        for ($i = $inicio; $i <= $fin; $i++): ?>
                            <li class="page-item <?php echo $i == $pagina_actual ? 'active' : ''; ?>">
                                <a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?php echo $pagina_actual >= $total_paginas ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?pagina=<?php echo $pagina_actual + 1; ?>">Siguiente &raquo;</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Botones de acción -->
    <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-4">
        <a href="agregar/" class="btn btn-success me-md-2">
            <i class="bi bi-plus-circle"></i> Agregar Transacción
        </a>
        <a href="<?php echo PAGES_DIR; ?>" class="btn btn-secondary">
            <i class="bi bi-house"></i> Regresar al Inicio
        </a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('gastosChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($categorias_gastos); ?>,
            datasets: [{
                data: <?php echo json_encode($montos_gastos); ?>,
                backgroundColor: ['#FF6384','#36A2EB','#FFCE56','#4BC0C0','#9966FF','#FF9F40','#FF6384','#C9CBCF','#4BC0C0','#FFCD56']
            }]
        },
        options: { responsive:true, plugins:{ legend:{ position:'right' } } }
    });
});
</script>

</body>
</html>
