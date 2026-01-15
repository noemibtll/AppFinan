<?php

$conexion = conectar();

// Obtener resumen financiero real desde la BD
$sql_ingresos = "SELECT SUM(monto) as total FROM transacciones WHERE Id_usuario = $id AND tipo = 1";
$res_ingresos = $conexion->query($sql_ingresos);
$ingresos_mes = $res_ingresos->fetch_assoc()['total'] ?? 0;

$sql_gastos = "SELECT SUM(monto) as total FROM transacciones WHERE Id_usuario = $id AND tipo = 2";
$res_gastos = $conexion->query($sql_gastos);
$gastos_mes = $res_gastos->fetch_assoc()['total'] ?? 0;

$saldo_total = $ingresos_mes - $gastos_mes;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="../../css/usuario_css/home.css">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">

<!-- Contenido principal -->
<div class="container mt-5">
    <h2 class="mb-4 text-center">Bienvenido 👋</h2>

    <!-- Resumen rápido -->
    <div class="row text-center g-4 mb-5">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-3">
                <i class="bi bi-wallet2 fs-1 text-primary"></i>
                <h5 class="mt-2">Saldo Total</h5>
                <p class="fs-4 fw-bold text-success">$<?php echo number_format($saldo_total, 2); ?></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-3">
                <i class="bi bi-graph-up-arrow fs-1 text-success"></i>
                <h5 class="mt-2">Ingresos del mes</h5>
                <p class="fs-4 fw-bold text-success">$<?php echo number_format($ingresos_mes, 2); ?></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-3">
                <i class="bi bi-graph-down-arrow fs-1 text-danger"></i>
                <h5 class="mt-2">Gastos del mes</h5>
                <p class="fs-4 fw-bold text-danger">$<?php echo number_format($gastos_mes, 2); ?></p>
            </div>
        </div>
    </div>

    <!-- Menú principal -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <a href="../usuario/" class="text-decoration-none">
                <div class="card text-center shadow-sm border-0">
                    <div class="card-body">
                        <i class="bi bi-person-circle fs-1 text-primary"></i>
                        <h5 class="mt-3">Usuario</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="../categorias/" class="text-decoration-none">
                <div class="card text-center shadow-sm border-0">
                    <div class="card-body">
                        <i class="bi bi-tags fs-1 text-success"></i>
                        <h5 class="mt-3">Categorías</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="../objetivos/" class="text-decoration-none">
                <div class="card text-center shadow-sm border-0">
                    <div class="card-body">
                        <i class="bi bi-bullseye fs-1 text-warning"></i>
                        <h5 class="mt-3">Objetivos</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="../transacciones/" class="text-decoration-none">
                <div class="card text-center shadow-sm border-0">
                    <div class="card-body">
                        <i class="bi bi-cash-coin fs-1 text-danger"></i>
                        <h5 class="mt-3">Transacciones</h5>
                    </div>
                </div>
            </a>
        </div>
    </div>
    

    <!-- Footer -->
    <footer class="footer bg-primary text-white text-center mt-1">
        <small>&copy; App Financiera</small>
    </footer>
</div>

</body>
</html>
