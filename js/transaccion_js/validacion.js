let bandera = true;

function valida_campos() {
    var monto = $('#monto').val().trim();
    var tipo_operacion = $('#tipo_operacion').val();
    var categoria = $('#categoria').val();
    var fecha = $('#fecha').val();
    var descripcion = $('#descripcion').val().trim();
    var frecuencia = $('#frecuencia').val().trim();


    console.log(monto, tipo_operacion, categoria, fecha, descripcion,frecuencia);

    if (
        monto !== "" &&
        !isNaN(parseFloat(monto)) &&
        parseFloat(monto) > 0 &&
        categoria !== "0" &&
        tipo_operacion !== "0" &&
        descripcion !== "" &&
        bandera === true &&
        fecha !== "" &&
        frecuencia !== " "
    ) {
        return true;
    } else {
        $('#campos_vacios').show().html('Faltan campos por llenar o algunos valores son inválidos.');
        setTimeout(function () {
            $('#campos_vacios').html('').hide();
        }, 5000);
        return false;
    }
}

$(document).ready(function () {
    $('#transaccion').submit(function (event) {
        if (!valida_campos()) {
            event.preventDefault();
        }
    });
});
