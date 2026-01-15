let bandera = true;

function valida_campos(){
    var nombre_categoria = $('#nombre_categoria').val();
    var tipo_operacion = $('#tipo_operacion').val();

    console.log(nombre_categoria, tipo_operacion, );

    if(nombre_categoria !== "" && tipo_operacion !== "" && bandera === true){
        return true;
    } else {
        $('#campos_vacios').show().html('Faltan Campos Por Llenar');
        setTimeout(function() {
            $('#campos_vacios').html('').hide();
        }, 5000);
        return false;
    }
}

$(document).ready(function() {
    console.log("JS cargado y esperando submit");

    $('#categoria').submit(function(event) {
        if (!valida_campos()) {
            event.preventDefault();
        }
    });
});