$(function() {
    $("#login").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 5
            }
        },
        messages: {
            password: {
                required: "Por favor proporcione una contraseña",
                minlength: "Su contraseña debe tener al menos 5 caracteres."
            },
            email: "Por favor, introduce una dirección de correo electrónico válida"
        },
        submitHandler: function(form) {
            var data = sends("includes/config/functions.php?f=login", 'POST', ($("#login").serialize()));
            if (data.indexOf(".php") > -1) {
                $(location).attr('href', data);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data,
                })
            }
        }
    });
    $("#election").validate({
        rules: {
            year: {
                required: true,
                number: true,
                min: 2000,
                max: 2016
            },
            votes: {
                required: true,
                number: true,
            }
        },
        messages: {
            year: "Por favor, introduce un año valido ente 2000 y 2016",
            votes: {
                required: "Por favor proporcione un numero de votos",
            },
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});

function sends(url, type, form_data) {
    var result = "";
    $.ajax({
        async: false,
        type: type,
        url: url,
        data: form_data,
        dataType: 'json',
        success: function(json) {
            result = json;
        },
        complete: function(xhr, status) {
            console.log('Petición realizada');
        },
        error: function(xhr, status) {
            result = 'Disculpe, existió un problema';
            console.log(xhr, status);
        }
    });
    return result;
}