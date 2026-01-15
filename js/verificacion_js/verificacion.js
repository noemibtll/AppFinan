var bandera = false;

function comprobacion() {
    var codigo = $('#codigo').val();
    var correo = $('#correo').val();
    console.log("Código:", codigo, "Correo:", correo);

    $.ajax({
        url: PHP_DIR_URL + '/funciones/validar_codigo.php',
        type: 'post',
        dataType: 'text',
        data: { 
            codigo: codigo,
            correo: correo   
        },
        success: function(res) {
            console.log("Respuesta:", res);
            if (res == 0) {
                bandera = true;
                $('#codigo_error').hide();
                console.log("Validación correcta");
            } else {
                bandera = false;
                $('#codigo_error').show().html('Código no válido');
                setTimeout(function() {
                    $('#codigo_error').html('').hide();
                }, 5000);
            }
        },
        error: function() {
            alert('Error al conectar con el servidor');
        }
    });
}

function valida_campos(){
    var codigo = $('#codigo').val();
    console.log(codigo);
    if (codigo !== "" && bandera === true) {
        return true;
    } else if (codigo === "") {
        $('#campos_vacios').show().html('Ingresa el código de verificación');
        setTimeout(function() {
            $('#campos_vacios').html('').hide();
        }, 5000);
        return false;
    } else {
        $('#codigo_error').show().html('Código incorrecto');
        setTimeout(function() {
            $('#codigo_error').html('').hide();
        }, 5000);
        return false;
    }
}

$(document).ready(function() {
    $('#verificar').submit(function(event) {
        if (!valida_campos()) {
            event.preventDefault();
        }
    });
});
