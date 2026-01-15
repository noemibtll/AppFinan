let bandera = true;


function valida_campos(){
    var nombre_objetivo = $('#nombre_objetivo').val();
    var objetivo = $('#objetivo').val();
    var monto_objetivo = $('#monto_objetivo').val();
    var fecha_objetivo = $('#fecha_objetivo').val();
    console.log(nombre_objetivo, objetivo, monto_objetivo, fecha_objetivo);
    if(nombre_objetivo !== "" && objetivo !== "1" && bandera === true && fecha_objetivo !== ""){
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
    $('#agregar_objetivos').submit(function(event) {
        if (!valida_campos()) {
            event.preventDefault();
        }
    });
});
