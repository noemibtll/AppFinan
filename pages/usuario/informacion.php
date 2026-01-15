<?php
include_once('../../php/web.config.php');
include_once(ROOT . "php/conexion.php");
include_once("../../php/auth.php");

// Verificar sesión
if (!isset($id)) {
    header("Location: " . BASE_URL . "pages/login/login.php");
    exit();
}

// Conectar
$conexion = conectar();

// Datos del usuario
$stmt = $conexion->prepare("SELECT nombre, apellidos, correo FROM usuario WHERE id_usuario = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$usuario = $res->fetch_assoc();
$stmt->close();

// Función auxiliar para obtener listas
function fetchCol($conexion, $sql, $id) {
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $data = [];
    while ($row = $res->fetch_assoc()) $data[] = $row;
    $stmt->close();
    return $data;
}

// Datos adicionales
$categoria = fetchCol($conexion, "SELECT nombre_categoria, tipo_operacion FROM categoria WHERE id_usuario = ? LIMIT 3", $id);
$objetivos = fetchCol($conexion, "SELECT nombre_objetivo, fecha_objetivo, monto_objetivo FROM objetivos WHERE id_usuario = ? LIMIT 3", $id);
$transacciones = fetchCol($conexion, "SELECT monto, fecha FROM transacciones WHERE id_usuario = ? LIMIT 3", $id);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Resumen de Usuario</title>
    <link rel="stylesheet" href="<?php echo CSS_DIR ?>/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo CSS_DIR ?>/usuario_css/style_agregar.css" />
    <style>
        .perfil-container { display: flex; align-items: center; gap: 20px; margin-bottom: 30px; }
        .perfil-icon { width: 80px; height: 80px; border-radius: 50%; }
        .perfil-info h3 { margin-bottom: 5px; }
        .perfil-info p { margin-bottom: 0; color: #555; }
        .table th { width: 180px; }
    </style>
</head>
<body class="container py-4">

    <div class="perfil-container">
        <img src="<?php echo CSS_DIR; ?>/usuario_css/perfil.png" alt="Icono de perfil" class="perfil-icon">
        <div class="perfil-info">
            <h3><?php echo htmlspecialchars($usuario['nombre'] . " " . $usuario['apellidos']); ?></h3>
            <p><?php echo htmlspecialchars($usuario['correo']); ?></p>
        </div>
    </div>

    <h4>Categorías</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Tipo</th>
            </tr>
        </thead>
        <tbody>
            <?php if(count($categoria) > 0): ?>
                <?php foreach($categoria as $c): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($c['nombre_categoria']); ?></td>
                        <td><?php echo ($c['tipo_operacion']==1)?'Ingreso':'Gasto'; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="2"><em>No hay categorías registradas</em></td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <h4>Objetivos</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Fecha</th>
                <th>Monto</th>
            </tr>
        </thead>
        <tbody>
            <?php if(count($objetivos) > 0): ?>
                <?php foreach($objetivos as $o): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($o['nombre_objetivo']); ?></td>
                        <td><?php echo htmlspecialchars($o['fecha_objetivo']); ?></td>
                        <td>$<?php echo number_format($o['monto_objetivo'],2); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="3"><em>No hay objetivos registrados</em></td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <h4>Últimas transacciones</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Monto</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php if(count($transacciones) > 0): ?>
                <?php foreach($transacciones as $t): ?>
                    <tr>
                        <td>$<?php echo number_format($t['monto'],2); ?></td>
                        <td><?php echo htmlspecialchars($t['fecha']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="2"><em>No hay transacciones registradas</em></td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="mt-3">
        <a href="<?php echo PAGES_DIR; ?>/home/" class="btn btn-secondary">Regresar</a>
        <a href="editar/index.php?id=<?php echo $id;?>" class="btn btn-primary ms-2">Editar Perfil</a>
    </div>

</body>
</html>
