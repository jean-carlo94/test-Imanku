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
            },
            party: {
                required: true,
            },
            contry: {
                required: true,
            }
        },
        messages: {
            year: "Por favor, introduce un año valido ente 2000 y 2016",
            votes: {
                required: "Por favor proporcione un numero de votos",
            },
            party: {
                required: "Por favor proporcione un Partido",
            },
            contry: {
                required: "Por favor proporcione un county",
            },
        },
        submitHandler: function(form) {
            var data = sends("includes/config/functions.php?f=addvotes", 'POST', ($("#election").serialize()));
            Swal.fire(data);
        }
    });
});

$("#excel_accion").click(function() {
    var excel = $("#excel");
    if(excel.val() != ""){
        var formData = new FormData();
        var files = $('#excel')[0].files[0];
        formData.append('file',files);
        var data = upload(formData);
        Swal.fire(data);
    }else{
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "Deve Seleccionar un archivo Excel",
        })
    }
});
$("#json_accion").click(function() {
    var josn = $("#json");
    if(josn.val() != ""){
        var formData = new FormData();
        var files = $('#json')[0].files[0];
        formData.append('file',files);
        var data = upload(formData);
        Swal.fire(data);
    }else{
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "Deve Seleccionar un archivo josn",
        })
    }
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

function upload(formData) {
    var result = "";
    $.ajax({
        async: false,
        url: 'upload.php',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            result = response;
            console.log(result);
        }
    });
    return result;
}