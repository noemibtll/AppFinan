let bandera = true;

function comprobacion(){
    var correo = $('#correo').val();
    console.log(correo);
    $.ajax({
        url: PHP_DIR_URL + '/funciones/validar_correo.php',
        type: 'post',
        dataType: 'text',
        data: { correo: correo },
        success: function(res) {
            console.log(correo);
            if (res == 1) {
                $('#correo_error').show().html('correo no permitido');
                setTimeout(function() {
                    $('#correo_error').html('').hide();
                }, 5000);
                bandera = false; // Corrige aquí la asignación
            } else {
                bandera = true; // Corrige aquí la asignación
                console.log(res);
            }
        },
        error: function() {
            alert('Error al conectar');
        }
    });
}

function valida_campos(){
    var nombre = $('#nombre').val();
    var apellidos = $('#apellidos').val();
    var correo = $('#correo').val();
    var pass = $('#pass').val();
    console.log(nombre, apellidos, correo, pass);
    if(nombre !== "" && apellidos !== "" && bandera === true && pass !== ""){
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
    $('#agregar_usuario').submit(function(event) {
        if (!valida_campos()) {
            event.preventDefault();
        }
    });
});
