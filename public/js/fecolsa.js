
var isNumeric = function (e) {
    var key = window.Event ? e.which : e.keyCode;
    return (key >= 48 && key <= 57);
};

var validateEmail = function (email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
};

var checkSubmit = function (e, obj) {
    if (e && e.keyCode === 13) {
        if (obj.id === 'formRegistro') {
            submitRegistro();
        } else if (obj.id === 'formLogin') {
            submitLogin();
        } else if (obj.id === 'formAgregar') {
            submitAgregar();
        } else if (obj.id === 'formAsignar') {
            submitAsignar();
        }
    }
};

var setHora = function () {
    $('#v_usuarhorar').val($('#v_usuarhorar_h').val() + ':' + $('#v_usuarhorar_m').val());
};

var submitRegistro = function () {
    if (!$('#v_usuarnombr').val()) {
        alert('Los nombres del líder son requeridos.');
        $('#v_usuarnombr').focus();
        return false;
    }
    if (!$('#v_usuarapell').val()) {
        alert('Los apellidos del líder son requeridos.');
        $('#v_usuarapell').focus();
        return false;
    }
    if (!$('#v_usuarcedul').val()) {
        alert('La cédula del líder es requerida.');
        $('#v_usuarcedul').focus();
        return false;
    }
    if (!$('#v_usuarcargo').val()) {
        alert('El cargo del líder es requerido.');
        $('#v_usuarcargo').focus();
        return false;
    }
    if (!$('#v_usuaremail').val()) {
        alert('El e-mail del líder es requerido.');
        $('#v_usuaremail').focus();
        return false;
    }
    
    if (!validateEmail($('#v_usuaremail').val())) {
        alert('El campo e-mail debe contener un formato válido.');
        $('#v_usuaremail').focus();
        return false;
    }
    
    if (!$('#v_usuardirec').val()) {
        alert('La dirección del líder es requerida.');
        $('#v_usuardirec').focus();
        return false;
    }
    if (!$('#v_usuarcelul').val()) {
        alert('El celular del líder es requerido.');
        $('#v_usuarcelul').focus();
        return false;
    }
    if (confirm('¿Estás seguro de registrarte con los datos ingresados?')) {

        var clave = '';
        for (var i = 0; i < 8; i++) {
            clave += String(Math.floor((Math.random() * 9) + 1));
        }
        $('#v_usuarclave').val(clave);

        var data = sendMailRegistro();
        sendEmailSMTP(data);
    }
};

var goToHome = function () {
    document.location.href = 'index.php';
};

var sendMailRegistro = function () {
    var emailData = {
        from: {
            email: 'contacto@techambits.com',
            name: 'TechAmbits Fecolsa'
        },
        to: $('#v_usuaremail').val(),
        //replyto: 'chris.gekko@hotmail.com',
        cco: {
            e1: {
                email: 'alejandro.ortegon@techambits.com',
                name: 'Alejandro Ortegón'
            },
            e2: {
                email: 'nathalie.checa@techambits.com',
                name: 'Nathalie Checa'
            }
        },
        subject: 'Registro de Líder de Grupo FECOLSA.',
        message: 'Apreciado <b>' + $('#v_usuarnombr').val() + '</b>, has efectuado tu registro como líder de manera exitosa. Tu contraseña de acceso será <b>' + $('#v_usuarclave').val() + '</b>.'
    };
    return emailData;
};

var sendEmailSMTP = function (data) {
    $.ajax({
        type: 'POST',
        url: 'http://www.techambits.net/giweb-smtp/',
        dataType: 'json',
        contentType: 'application/json; charset=UTF-8',
        crossDomain: true,
        data: JSON.stringify(data),
        beforeSend: function () {

        },
        success: function (response) {
            $('script').val('registro');
            document.getElementById('formRegistro').submit();
        },
        error: function (error) {
            console.log('sendEmailSMTP: ' + error);
        }
    });
};


var submitLogin = function () {
    if (!$('#email').val()) {
        alert('Ingresa tu correo electrónico.');
        $('#email').focus();
        return false;
    }
    if (!$('#password').val()) {
        alert('Ingresa la clave.');
        $('#password').focus();
        return false;
    }
    
    document.getElementById('formLogin').submit();
};


var submitAgregar = function () {
    if (!$('#v_usuarnombr').val()) {
        alert('Los nombres son requeridos.');
        $('#v_usuarnombr').focus();
        return false;
    }
    if (!$('#v_usuarapell').val()) {
        alert('Los apellidos son requeridos.');
        $('#v_usuarapell').focus();
        return false;
    }
    if (!$('#v_usuarcedul').val()) {
        alert('La cédula es requerida.');
        $('#v_usuarcedul').focus();
        return false;
    }
    if (!$('#v_usuarcargo').val()) {
        alert('El cargo es requerido.');
        $('#v_usuarcargo').focus();
        return false;
    }
    if (!$('#v_usuaremail').val()) {
        alert('El e-mail es requerido.');
        $('#v_usuaremail').focus();
        return false;
    }
    
    if (!validateEmail($('#v_usuaremail').val())) {
        alert('El campo e-mail debe contener un formato válido.');
        $('#v_usuaremail').focus();
        return false;
    }
    
    if (!$('#v_usuardirec').val()) {
        alert('La dirección es requerida.');
        $('#v_usuardirec').focus();
        return false;
    }
    if (!$('#v_usuarcelul').val()) {
        alert('El celular es requerido.');
        $('#v_usuarcelul').focus();
        return false;
    }
    if (confirm('¿Estás seguro de agregar tu amigo con los datos ingresados?')) {

        document.getElementById('formAgregar').submit();
    }
};

var submitReservar = function () {
    if (!$('#v_direcrecog').val()) {
        alert('La dirección de recogida es requerida.');
        $('#v_direcrecog').focus();
        return false;
    }
    if (!$('#v_fecharecog_f').val()) {
        alert('La fecha de recogida es requerida.');
        $('#v_fecharecog_f').focus();
        return false;
    }
    if (!$('#v_destifinal').val()) {
        alert('El destino final es requerido.');
        $('#v_destifinal').focus();
        return false;
    }
    if (confirm('¿Estás seguro de efectuar la Reserva de este evento para el grupo conformado?')) {
        
        $('#v_fecharecog').val($('#v_fecharecog_f').val() + ' ' + $('#v_fecharecog_h').val() + ':' + $('#v_fecharecog_m').val() + ':00');
        
        document.getElementById('formReservar').submit();
    }
};


var seleccionarReserva = function (reserva) {
    $('#reserva').val(reserva);
    document.getElementById('formReservas').submit();
};


var submitAsignar = function () {
    if (!$('#v_conductorx').val()) {
        alert('El Conductor es requerido.');
        $('#v_conductorx').focus();
        return false;
    }
    if (!$('#v_placaxxxxx').val()) {
        alert('La Placa del Vehículo es requerida.');
        $('#v_placaxxxxx').focus();
        return false;
    }
    if (!$('#v_telefconta').val()) {
        alert('El Teléfono de Contacto es requerido.');
        $('#v_telefconta').focus();
        return false;
    }
    if (confirm('¿Estás seguro de Asignar Vehículo a la Reserva No. ' + $('#reserva').val() + '?')) {
        document.getElementById('formAsignar').submit();
    }
};