<?php
    include_once('../../php/web.config.php');
    include_once(ROOT . "php/conexion.php");
    include_once("../../php/auth.php");

    $id = $_SESSION['id'];
    $usuario = $_SESSION['usuario'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Transacción</title>

    <!-- Bootstrap local -->
    <link rel="stylesheet" href="../../css/bootstrap.css">

    <script src="<?php echo JS_DIR; ?>/jquery-3.3.1.min.js"></script>
    <script>
        const JS_DIR_URL = "<?php echo JS_DIR; ?>";
        const PHP_DIR_URL = "<?php echo PHP_DIR; ?>";
    </script>
    <script src="<?php echo JS_DIR; ?>/transaccion_js/validacion.js"></script>
</head>
<body class="bg-light">

    <div class="container mt-5">
        <h2 class="mb-4">Agregar Transacción</h2>
        <form id="transaccion" name="transaccion" method="post" action="<?php echo PHP_DIR; ?>/transaccion/agregar.php" enctype="multipart/form-data" class="card p-4 shadow-sm bg-white">

            <input type="hidden" value="<?php echo $id; ?>" id="id_usuario" name="id_usuario">

            <div class="mb-3">
                <label for="monto" class="form-label">Monto</label>
                <input type="number" min="1" id="monto" name="monto" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="tipo_operacion" class="form-label">Tipo de operación</label>
                <select id="tipo_operacion" name="tipo_operacion" class="form-select" required>
                    <option value="0" selected>Seleccionar</option>
                    <option value="1">Ingreso</option>
                    <option value="2">Gasto</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="categoria" class="form-label">Categoría</label>
                <select name="categoria" id="categoria" class="form-select" required>
                    <option value="0" selected>Seleccionar</option>
                    <option value="1" >Alimentacion</option>
                    <option value="2" >Transporte</option>
                    <option value="3" >Nomina</option>  
                    <option value="4" >Ahorro</option>
                    <option value="5" >Hogar</option>
                    <option value="6" >Salud</option>
                    <option value="7" >Entretenimiento</option>                    


                    <?php 
                        $conexion = conectar();
                        $sql = "SELECT nombre_categoria, Id_categoria FROM categoria WHERE Id_usuario = {$id}";
                        $res = $conexion->query($sql);
                        while ($row = $res->fetch_assoc()) {
                            $id_categoria = $row['Id_categoria'];
                            $nombre_categoria = $row['nombre_categoria'];
                            echo "<option value=\"$id_categoria\">$nombre_categoria</option>";
                        }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" id="fecha" name="fecha" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="frecuencia" class="form-label">Frecuencia</label>
                <select name="frecuencia" id="frecuencia" class="form-select" required>
                    <option value="0" >Sin frecuencia</option>
                    <option value="1" >Diaria</option>
                    <option value="2" >Semanal</option>
                    <option value="3" >Mensual</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <input type="text" id="descripcion" name="descripcion" class="form-control" placeholder="Ingresar descripción" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Agregar Transacción</button>
        </form>

        <div class="mt-3">
            <a href="<?php echo PAGES_DIR; ?>/transacciones/" class="btn btn-secondary">Regresar</a>
        </div>

    </div>
</body>
</html>
