<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Predicción de Gastos - AppFinanciera</title>

    <link rel="stylesheet" href="<?php echo CSS_DIR; ?>/bootstrap.css" />
    <script src="<?php echo JS_DIR; ?>/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Estilos para los contenedores de los gráficos */
        .chart-container { 
            position: relative; 
            margin: auto; 
            height: 300px; /* Altura para el gráfico de barras */
            width: 100%; 
        }
        .line-chart-container { 
            position: relative; 
            height: 400px; /* Altura para el gráfico de línea */
            width: 100%; 
            overflow-x: auto; /* Scroll si el contenido es más ancho */
        }
        /* --- NUEVO ESTILO: Para la lista de detalles del modelo --- */
        .model-details-list { list-style: none; padding-left: 0; }
        .model-details-list li { 
            display: flex; 
            justify-content: space-between; 
            padding: 0.5rem 0.2rem; /* Más espacio */
            border-bottom: 1px solid #eee; 
            font-size: 0.9rem; /* Ligeramente más pequeño */
        }
        .model-details-list li span { font-weight: bold; color: #333; }
        /* --- FIN NUEVO ESTILO --- */
    </style>
</head>
<body class="bg-light">

<div class="container mt-5">
    <h1 class="mb-4 text-center">Predicción de Gastos Futuros</h1>

    <div class="row justify-content-center mb-3">
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text">$</span>
                <input type="number" id="ingreso_manual" class="form-control" placeholder="Ingresa tu ingreso mensual esperado (opcional)">
                <button class="btn btn-outline-secondary" type="button" id="guardar_ingreso">Usar</button>
            </div>
            <small class="form-text text-muted">
                Si no ingresas un valor, se usará un promedio de tus últimos 3 meses.
            </small>
        </div>
    </div>

    <div class="row justify-content-center mb-4">
        <div class="col-md-4 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Ahorro Proyectado</h5>
                    <h2 class="card-text">$<span id="ahorro_proyectado">0.00</span></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h5 class="card-title">Gasto Predicho</h5>
                    <h2 class="card-text">$<span id="gasto_predicho_total">0.00</span></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card bg-info text-dark">
                <div class="card-body">
                    <h5 class="card-title">Categoría Predominante (Tuya)</h5>
                    <h2 class="card-text"><span id="categoria_predominante_usuario">N/A</span></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Gráfico de Predicciones y Datos Históricos</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-center">
                        <div class="line-chart-container">
                            <canvas id="predictionChart"></canvas>
                        </div>
                    </div>
                    <div id="loading" class="text-center mt-3" style="display:none;"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div><p class="mt-2">Analizando tus datos...</p></div>
                    <div id="no-data" class="alert alert-warning text-center mt-3" style="display:none;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-lg-6 mb-4">
             <div class="card shadow-sm mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Visión General del Dataset</h5>
                </div>
                <div class="card-body">
                    <p>Categoría con el mayor gasto promedio (general):
                        <strong id="mayor_gasto_promedio_general_display">Calculando...</strong>
                    </p>
                     <small class="form-text text-muted">
                        Basado en el promedio de gastos por categoría en el dataset de entrenamiento.
                    </small>
                </div>
            </div>
             <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Distribución Promedio de Gasto (General)</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                         <canvas id="distribucionGastoChart"></canvas>
                    </div>
                     <div id="distribucion-loading" class="text-center mt-3" style="display:block;">
                        <p class="text-muted">Cargando distribución...</p>
                    </div>
                     <div id="distribucion-error" class="alert alert-warning text-center mt-3" style="display:none;">
                        No se pudo cargar la distribución.
                    </div>
                    <small class="form-text text-muted mt-2">
                        Porcentaje del gasto total por categoría en el dataset general.
                    </small>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Factores que Influyen en las Predicciones</h5>
                </div>
                <div class="card-body d-flex flex-column">
                    <ul id="factores-lista" class="list-group list-group-flush flex-grow-1">
                        <li class="list-group-item">Cargando factores...</li>
                    </ul>
                    <small class="form-text text-muted mt-auto pt-2">
                        Porcentaje de influencia relativa de cada factor en el modelo.
                    </small>
                </div>
            </div>
        </div>
    </div>


    <div class="row justify-content-center mt-4">
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    <h5 class="mb-0">Recomendaciones de IA</h5>
                </div>
                <div id="recomendaciones-ia" class="card-body">
                    <p class="text-muted">Calculando recomendaciones...</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    <h5 class="mb-0">Detalles del Modelo Predictivo</h5>
                </div>
                <div id="detalles-modelo-body" class="card-body">
                    <ul class="model-details-list">
                        <li>Tipo de Modelo: <span id="detalle_tipo_modelo">Cargando...</span></li>
                        <li>Datos de Entrenamiento: <span id="detalle_datos_entrenamiento">Cargando...</span></li>
                        <li>Período Cubierto: <span id="detalle_periodo_cubierto">Cargando...</span></li>
                        <li>Características Utilizadas: <span id="detalle_caracteristicas">Cargando...</span></li>
                        <li>
                            Precisión del Modelo (R²): 
                            <span class="badge fs-6" id="detalle_precision">Cargando...</span>
                        </li>
                        <li>Próxima Actualización: <span id="detalle_actualizacion">Cargando...</span></li>
                    </ul>
                     <small class="form-text text-muted mt-2">
                        El modelo se reentrena con cada carga usando el dataset general.
                    </small>
                </div>
                <div id="detalles-modelo-error" class="card-body text-danger" style="display:none;">
                    No se pudieron cargar los detalles del modelo.
                </div>
            </div>
        </div>
        </div>
    <div class="mt-4 mb-5 text-center">
        <a href="<?php echo PAGES_DIR; ?>/" class="btn btn-secondary">Regresar al Inicio</a>
    </div>
</div>

<script>
$(document).ready(function() {
    // Referencias DOM
    const loadingDiv = $('#loading');
    const noDataDiv = $('#no-data');
    const canvas = $('#predictionChart');
    const ctx = canvas.length ? canvas[0].getContext('2d') : null;
    const gastoPredichoSpan = $('#gasto_predicho_total');
    const ahorroProyectadoSpan = $('#ahorro_proyectado');
    const categoriaPredominanteUsuarioSpan = $('#categoria_predominante_usuario');
    const mayorGastoPromedioGeneralDisplay = $('#mayor_gasto_promedio_general_display');
    const factoresListaUl = $('#factores-lista');
    const recomendacionesDiv = $('#recomendaciones-ia');
    const ingresoManualInput = $('#ingreso_manual');
    const distribucionCanvas = $('#distribucionGastoChart');
    const distribucionCtx = distribucionCanvas.length ? distribucionCanvas[0].getContext('2d') : null;
    const distribucionLoading = $('#distribucion-loading');
    const distribucionError = $('#distribucion-error');
    let myPredictionChart = null;
    let myDistribucionChart = null;
    
    // --- NUEVAS CONSTANTES: Detalles del Modelo ---
    const detallesModeloBody = $('#detalles-modelo-body');
    const detallesModeloError = $('#detalles-modelo-error');
    const detalleTipoModeloSpan = $('#detalle_tipo_modelo');
    const detalleDatosEntrenamientoSpan = $('#detalle_datos_entrenamiento');
    const detallePeriodoCubiertoSpan = $('#detalle_periodo_cubierto');
    const detalleCaracteristicasSpan = $('#detalle_caracteristicas');
    const detallePrecisionSpan = $('#detalle_precision');
    const detalleActualizacionSpan = $('#detalle_actualizacion');
    // --- FIN NUEVAS CONSTANTES ---

    // --- FUNCIÓN PARA CARGAR PREDICCIONES ---
    function cargarPredicciones(ingresoManual = null) {
        loadingDiv.show();
        noDataDiv.hide();
        // Resetear elementos
        factoresListaUl.html('<li class="list-group-item">Cargando...</li>');
        recomendacionesDiv.html('<p class="text-muted">Calculando...</p>');
        mayorGastoPromedioGeneralDisplay.text('Calculando...');
        categoriaPredominanteUsuarioSpan.text('N/A');
        gastoPredichoSpan.text('0.00');
        ahorroProyectadoSpan.text('0.00');
        distribucionLoading.show();
        distribucionError.hide();
        // --- Resetear Detalles Modelo ---
        detallesModeloBody.show();
        detallesModeloError.hide();
        detalleTipoModeloSpan.text('Cargando...');
        detalleDatosEntrenamientoSpan.text('Cargando...');
        detallePeriodoCubiertoSpan.text('Cargando...');
        detalleCaracteristicasSpan.text('Cargando...');
        detallePrecisionSpan.text('Cargando...').removeClass('bg-success bg-danger bg-warning bg-secondary');
        detalleActualizacionSpan.text('Cargando...');
        // --- Fin Resetear ---
        if(myPredictionChart) { myPredictionChart.destroy(); myPredictionChart = null;}
        if(myDistribucionChart) { myDistribucionChart.destroy(); myDistribucionChart = null;}

        let ajaxData = {};
        if (ingresoManual !== null) {
            ajaxData.ingreso_manual = ingresoManual;
        }

        $.ajax({
            url: '<?php echo PHP_DIR; ?>/ia/obtener_prediccion.php',
            method: 'GET', dataType: 'json', data: ajaxData,
            success: function(response) {
                loadingDiv.hide();
                distribucionLoading.hide();
                console.log("Respuesta servidor:", response);

                noDataDiv.hide(); 

                if (response.error) {
                    noDataDiv.text(response.error).show();
                    console.error("Error servidor:", response.error);
                    // Resetear en caso de error
                    factoresListaUl.html('<li class="list-group-item text-danger">Error</li>');
                    recomendacionesDiv.html('<p class="text-danger">Error</p>');
                    mayorGastoPromedioGeneralDisplay.text('Error');
                    distribucionError.text('Error al cargar.').show();
                    detallesModeloBody.hide(); // Ocultar body
                    detallesModeloError.show(); // Mostrar error
                    return;
                }

                // --- CAMBIO: Verificar nueva clave 'detalles_modelo' ---
                if (response.fechas_prediccion && Array.isArray(response.fechas_prediccion) &&
                    response.gasto_por_dia && Array.isArray(response.gasto_por_dia) &&
                    response.historical_dates && Array.isArray(response.historical_dates) &&
                    response.historical_amounts && Array.isArray(response.historical_amounts) &&
                    response.categoria_predominante &&
                    response.factores_influencia_pct && Array.isArray(response.factores_influencia_pct) &&
                    response.categoria_mayor_gasto_promedio &&
                    response.distribucion_gasto_general &&
                    response.detalles_modelo // <-- Verificar nueva clave
                   )
                {
                    // Actualizar tarjetas
                    gastoPredichoSpan.text(response.gasto_predicho_total.toFixed(2));
                    ahorroProyectadoSpan.text(response.ahorro_proyectado.toFixed(2));
                    categoriaPredominanteUsuarioSpan.text(response.categoria_predominante);
                    mayorGastoPromedioGeneralDisplay.text(response.categoria_mayor_gasto_promedio);

                    // --- NUEVO: Rellenar Detalles del Modelo ---
                    if (response.detalles_modelo && !response.detalles_modelo.error) {
                        const detalles = response.detalles_modelo;
                        detalleTipoModeloSpan.text(detalles.tipo_modelo || 'N/A');
                        detalleDatosEntrenamientoSpan.text(detalles.datos_entrenamiento || 'N/A');
                        detallePeriodoCubiertoSpan.text(detalles.periodo_cubierto || 'N/A');
                        detalleCaracteristicasSpan.text(detalles.caracteristicas_utilizadas || 'N/A');
                        detalleActualizacionSpan.text(detalles.proxima_actualizacion || 'N/A');
                        
                        // Lógica para color de Precisión
                        const precision = parseFloat(detalles.precision_modelo_pct);
                        if (!isNaN(precision)) {
                            let precisionColor = 'bg-danger'; // Malo por defecto
                            if (precision >= 70) precisionColor = 'bg-success'; // Bueno
                            else if (precision >= 40) precisionColor = 'bg-warning'; // Regular
                            detallePrecisionSpan.text(precision.toFixed(0) + '%').addClass(precisionColor);
                        } else {
                            detallePrecisionSpan.text('N/A').addClass('bg-secondary');
                        }
                    } else {
                        // Error al cargar solo los detalles
                        detallesModeloBody.hide();
                        detallesModeloError.show();
                    }
                    // --- FIN NUEVO ---


                    // Mostrar Factores
                    factoresListaUl.empty();
                    const topFactores = response.factores_influencia_pct.slice(0, 5);
                    if(topFactores.length > 0){ topFactores.forEach(f => { let bC='bg-primary'; if(f.factor.includes('Dia')) bC='bg-success'; const pT=(!isNaN(parseFloat(f.importancia_pct)))?parseFloat(f.importancia_pct).toFixed(1)+'%':'N/A'; factoresListaUl.append(`<li class="list-group-item d-flex justify-content-between align-items-center">${f.factor||'?'}<span class="badge ${bC} rounded-pill">${pT}</span></li>`); }); } else { factoresListaUl.html('<li class="list-group-item">No hay factores significativos.</li>'); }

                    // Mostrar Recomendación
                    recomendacionesDiv.empty();
                    if (response.recomendacion_ia && response.recomendacion_ia.mensaje_corto) {
                        let aC='alert-info'; let i='💡'; if(response.recomendacion_ia.tipo==='alerta'){aC='alert-danger';i='⚠️';} else if(response.recomendacion_ia.tipo==='exito'){aC='alert-success';i='✅';} recomendacionesDiv.append(`<div class="alert ${aC}" role="alert"><h5 class="alert-heading">${i} ${response.recomendacion_ia.mensaje_corto}</h5><p class="mb-0">${response.recomendacion_ia.mensaje_detalle||''}</p></div>`);
                    } else { recomendacionesDiv.html('<p class="text-muted">Sin recomendaciones específicas.</p>'); }

                    // Gráfico de Distribución (Barras)
                    if (distribucionCtx) {
                        try {
                            const distData=response.distribucion_gasto_general; const distArr=Object.entries(distData).sort(([,a],[,b])=>b-a); const distLabels=distArr.map(([k])=>k); const distVals=distArr.map(([,v])=>v); if(myDistribucionChart){myDistribucionChart.destroy();} myDistribucionChart=new Chart(distribucionCtx,{type:'bar',data:{labels:distLabels,datasets:[{label:'% Gasto',data:distVals,backgroundColor:['rgba(255, 99, 132, 0.6)','rgba(54, 162, 235, 0.6)','rgba(255, 206, 86, 0.6)','rgba(75, 192, 192, 0.6)','rgba(153, 102, 255, 0.6)','rgba(255, 159, 64, 0.6)','rgba(99, 255, 132, 0.6)'],borderWidth:1}]},options:{indexAxis:'y',responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false},tooltip:{callbacks:{label:(c)=>`${c.label}: ${c.raw.toFixed(1)}%`}}},scales:{x:{title:{display:true,text:'%'},beginAtZero:true,max:Math.max(...distVals)>50?100:Math.ceil(Math.max(...distVals)/10)*10+5},y:{ticks:{autoSkip:false}}}}});
                        } catch (e) { console.error("Error gráfico distribución:", e); distribucionError.text('Error al mostrar distribución.').show(); }
                    } else { distribucionError.text('Error: Canvas no encontrado.').show(); }

                    // Lógica Gráfico de Línea
                    if (ctx) {
                        const histD=response.historical_dates; const histA=(response.historical_amounts||[]).map(Number); const labs=[...histD,...response.fechas_prediccion]; const dS=[{label:'Históricos',data:histA,borderColor:'rgb(75, 192, 192)',backgroundColor:'rgba(75, 192, 192, 0.5)',tension:0.1,fill:false,pointRadius:3},{label:'Predicho',data:Array(histD.length).fill(null).concat(response.gasto_por_dia),borderColor:'rgb(255, 99, 132)',backgroundColor:'rgba(255, 99, 132, 0.5)',borderDash:[5, 5],tension:0.1,fill:false,pointRadius:3}]; if(myPredictionChart){myPredictionChart.destroy();} myPredictionChart=new Chart(ctx,{type:'line',data:{labels:labs,datasets:dS},options:{responsive:true,maintainAspectRatio:false,interaction:{mode:'index',intersect:false},plugins:{tooltip:{callbacks:{label:function(c){return(c.dataset.label||'')+': '+new Intl.NumberFormat('es-MX',{style:'currency',currency:'MXN'}).format(c.parsed.y||0);}}}},scales:{x:{title:{display:true,text:'Fecha'}},y:{title:{display:true,text:'Monto ($)'},beginAtZero:true}}}});
                        if (histA.length === 0 && !response.error) {
                             noDataDiv.text('Predicción OK, pero sin gastos históricos recientes.').show();
                        }
                    } else {
                        noDataDiv.text('Error: Canvas del gráfico de línea no encontrado.').show();
                    }

                } else {
                    noDataDiv.text('Respuesta incompleta del servidor.').show();
                    console.error("Respuesta incompleta:", response);
                    distribucionError.text('Datos incompletos.').show();
                    detallesModeloBody.hide(); // Ocultar body
                    detallesModeloError.show(); // Mostrar error
                }
            },
            error: function(xhr, status, error) {
                loadingDiv.hide(); distribucionLoading.hide();
                noDataDiv.text('Error AJAX al obtener datos.').show();
                console.error("Error en la solicitud AJAX:", status, error, xhr.responseText);
                 // Resetear todo
                gastoPredichoSpan.text('0.00');
                ahorroProyectadoSpan.text('0.00');
                categoriaPredominanteUsuarioSpan.text('N/A');
                mayorGastoPromedioGeneralDisplay.text('Error');
                factoresListaUl.html('<li class="list-group-item text-danger">Error.</li>');
                recomendacionesDiv.html('<p class="text-danger">Error.</p>');
                distribucionError.text('Error al cargar.').show();
                detallesModeloBody.hide(); // Ocultar body
                detallesModeloError.show(); // Mostrar error
                if(myPredictionChart) { myPredictionChart.destroy(); myPredictionChart = null;}
            }
        });
    }
    // --- FIN FUNCIÓN CARGAR PREDICCIONES ---

    // Carga inicial
    cargarPredicciones();

    // Lógica botón ingreso manual
    $('#guardar_ingreso').on('click', function() {
        const ingresoManualValor = ingresoManualInput.val();
        if (ingresoManualValor && !isNaN(ingresoManualValor) && parseFloat(ingresoManualValor) >= 0) {
            cargarPredicciones(parseFloat(ingresoManualValor));
             $(this).text('Actualizando...').prop('disabled', true);
             setTimeout(() => { $(this).text('Usar').prop('disabled', false); }, 1500);
        } else {
            alert('Por favor, ingresa un monto de ingreso válido.');
            ingresoManualInput.val('');
        }
    });

});
</script>

</body>
</html>