<?php
$id_objetivo = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id_objetivo === 0) die("ID de objetivo no válido.");

$conexion = conectar();
if (!$conexion) die("Error al conectar a la base de datos.");

$transacciones_por_pagina = 10;

// Página actual para vinculadas
$page_v = isset($_GET['page_v']) ? intval($_GET['page_v']) : 1;
$offset_v = ($page_v - 1) * $transacciones_por_pagina;

// Página actual para no vinculadas
$page_nv = isset($_GET['page_nv']) ? intval($_GET['page_nv']) : 1;
$offset_nv = ($page_nv - 1) * $transacciones_por_pagina;

// 1️⃣ Transacciones YA vinculadas
$sql_vinculadas = "
    SELECT t.Id_transacciones, t.Id_categoria, c.nombre_categoria, t.tipo, t.monto, t.fecha, t.frecuencia, t.descripcion
    FROM transacciones t
    INNER JOIN categoria c ON t.Id_categoria = c.Id_categoria
    WHERE t.Id_usuario = ?
      AND t.Id_objetivo = ?
    ORDER BY t.fecha DESC
    LIMIT ? OFFSET ?
";
$stmt_v = $conexion->prepare($sql_vinculadas);
$stmt_v->bind_param("iiii", $id, $id_objetivo, $transacciones_por_pagina, $offset_v);
$stmt_v->execute();
$res_v = $stmt_v->get_result();

// Contar total vinculadas
$total_v = $conexion->query("
    SELECT COUNT(*) AS total FROM transacciones 
    WHERE Id_usuario = $id AND Id_objetivo = $id_objetivo
")->fetch_assoc()['total'];
$total_paginas_v = ceil($total_v / $transacciones_por_pagina);

// 2️⃣ Transacciones NO vinculadas
$sql_no_vinculadas = "
    SELECT t.Id_transacciones, t.Id_categoria, c.nombre_categoria, t.tipo, t.monto, t.fecha, t.frecuencia, t.descripcion
    FROM transacciones t
    INNER JOIN categoria c ON t.Id_categoria = c.Id_categoria
    WHERE t.Id_usuario = ?
      AND (t.Id_objetivo IS NULL OR t.Id_objetivo != ?)
    ORDER BY t.fecha DESC
    LIMIT ? OFFSET ?
";
$stmt_nv = $conexion->prepare($sql_no_vinculadas);
$stmt_nv->bind_param("iiii", $id, $id_objetivo, $transacciones_por_pagina, $offset_nv);
$stmt_nv->execute();
$res_nv = $stmt_nv->get_result();

// Contar total no vinculadas
$total_nv = $conexion->query("
    SELECT COUNT(*) AS total FROM transacciones 
    WHERE Id_usuario = $id AND (Id_objetivo IS NULL OR Id_objetivo != $id_objetivo)
")->fetch_assoc()['total'];
$total_paginas_nv = ceil($total_nv / $transacciones_por_pagina);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Transacciones Objetivo</title>
<link rel="stylesheet" href="<?php echo CSS_DIR ?>/bootstrap.css">
</head>
<body class="bg-light">
<div class="container mt-5">
<h1 class="mb-4">Transacciones vinculadas al objetivo <?php echo $id_objetivo; ?></h1>

<form action="<?php echo PHP_DIR ?>/objetivos/actualizar_objetivo.php" method="post">
    <input type="hidden" name="id_usuario" value="<?php echo $id; ?>">
    <input type="hidden" name="id_objetivo" value="<?php echo $id_objetivo; ?>">

    <h3>Ya seleccionadas</h3>
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Selección</th><th>Categoría</th><th>Tipo</th><th>Monto</th><th>Fecha</th><th>Frecuencia</th><th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $res_v->fetch_assoc()): 
                $tipo = ($row['tipo'] == 1) ? "Ingreso" : "Gasto";
                $monto = number_format($row['monto'], 2);
                switch ($row['frecuencia']) {
                    case 0: $frecuencia_texto="Sin frecuencia"; break;
                    case 1: $frecuencia_texto="Diaria"; break;
                    case 2: $frecuencia_texto="Semanal"; break;
                    case 3: $frecuencia_texto="Mensual"; break;
                    default: $frecuencia_texto="Desconocida";
                }
            ?>
            <tr>
                <td><input type="checkbox" name="transacciones[]" value="<?php echo $row['Id_transacciones']; ?>" checked></td>
                <td><?php echo htmlspecialchars($row['nombre_categoria']); ?></td>
                <td><?php echo $tipo; ?></td>
                <td>$<?php echo $monto; ?></td>
                <td><?php echo $row['fecha']; ?></td>
                <td><?php echo $frecuencia_texto; ?></td>
                <td><?php echo htmlspecialchars($row['descripcion']); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- 🔸 PAGINACIÓN vinculadas -->
    <nav>
      <ul class="pagination">
        <?php for ($i=1; $i<=$total_paginas_v; $i++): ?>
          <li class="page-item <?php echo ($i==$page_v)?'active':''; ?>">
            <a class="page-link" href="?id=<?php echo $id_objetivo; ?>&page_v=<?php echo $i; ?>"><?php echo $i; ?></a>
          </li>
        <?php endfor; ?>
      </ul>
    </nav>

    <h3>No seleccionadas</h3>
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Selección</th><th>Categoría</th><th>Tipo</th><th>Monto</th><th>Fecha</th><th>Frecuencia</th><th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $res_nv->fetch_assoc()): 
                $tipo = ($row['tipo'] == 1) ? "Ingreso" : "Gasto";
                $monto = number_format($row['monto'], 2);
                switch ($row['frecuencia']) {
                    case 0: $frecuencia_texto="Sin frecuencia"; break;
                    case 1: $frecuencia_texto="Diaria"; break;
                    case 2: $frecuencia_texto="Semanal"; break;
                    case 3: $frecuencia_texto="Mensual"; break;
                    default: $frecuencia_texto="Desconocida";
                }
            ?>
            <tr>
                <td><input type="checkbox" name="transacciones[]" value="<?php echo $row['Id_transacciones']; ?>"></td>
                <td><?php echo htmlspecialchars($row['nombre_categoria']); ?></td>
                <td><?php echo $tipo; ?></td>
                <td>$<?php echo $monto; ?></td>
                <td><?php echo $row['fecha']; ?></td>
                <td><?php echo $frecuencia_texto; ?></td>
                <td><?php echo htmlspecialchars($row['descripcion']); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- 🔸 PAGINACIÓN no vinculadas -->
    <nav>
      <ul class="pagination">
        <?php for ($i=1; $i<=$total_paginas_nv; $i++): ?>
          <li class="page-item <?php echo ($i==$page_nv)?'active':''; ?>">
            <a class="page-link" href="?id=<?php echo $id_objetivo; ?>&page_nv=<?php echo $i; ?>"><?php echo $i; ?></a>
          </li>
        <?php endfor; ?>
      </ul>
    </nav>

    <div class="mt-3">
        <button type="submit" class="btn btn-primary">Actualizar Objetivos</button>
        <a href="<?php echo PAGES_DIR; ?>/objetivos/informacion/index.php?id=<?php echo $id_objetivo;?>" class="btn btn-secondary">Regresar</a>
    </div>
</form>
</div>
</body>
</html>
