function validar() {
    var correo = $('#correo').val();
    var password = $('#password').val();

    console.log("Valores recibidos:", correo, password);

    if (correo !== "" && password !== "") {
        return true;
    } else {
        $('#campos_vacios').show().html('Faltan Campos Por Llenar');
        setTimeout(function() {
            $('#campos_vacios').html('').hide();
        }, 5000);
        return false;
    }
}

function ajax(correo, password) {
    $.ajax({
        url: PHP_DIR_URL + '/funciones/login.php',
        type: 'post',
        dataType: 'text',
        data: {
            correo: correo,
            password: password
        },
        success: function(res) {
            console.log("Respuesta del servidor:", res);
            if (res == "1") {
                window.location.href = BASE_URL;
            } 
            else {
                alert('Usuario no válido');
            }
        },
        error: function() {
            alert('Error al conectar');
        }
    });
}

$(document).ready(function() {
    console.log("JS cargado y esperando submit");

    $('#login').submit(function(event) {
        event.preventDefault();
        if (validar()) {
            var correo = $('#correo').val();
            var password = $('#password').val();
            ajax(correo, password);
        }
    });
});
