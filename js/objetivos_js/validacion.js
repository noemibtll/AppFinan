let bandera = true;

function valida_campos() {
    var nombre_objetivo = $('#nombre_objetivo').val();
    var objetivo = $('#objetivo').val();
    var monto_objetivo = $('#monto_objetivo').val();
    var fecha_objetivo = $('#fecha_objetivo').val();

    console.log(nombre_objetivo, objetivo, monto_objetivo, fecha_objetivo);

    if (
        nombre_objetivo.trim() !== "" &&
        objetivo !== "0" &&
        monto_objetivo !== "" && 
        parseFloat(monto_objetivo) > 0 &&
        fecha_objetivo !== "" &&
        bandera === true
    ) {
        return true;
    } else {
        $('#campos_vacios').show().html('Faltan Campos Por Llenar o son inválidos');
        setTimeout(function () {
            $('#campos_vacios').html('').hide();
        }, 5000);
        return false;
    }
}

$(document).ready(function () {
    $('#objetivos').submit(function (event) {
        if (!valida_campos()) {
            event.preventDefault();
        }
    });
});
