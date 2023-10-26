$(document).ready(function() {
    $('.llamarTurno').click(function() {
        var boton = $(this);
        boton.prop('disabled', true);

        var nombrePaciente = boton.data('nombre-paciente');
        var turnoId = boton.data('turno-id');

        $('#nombrePaciente').text(nombrePaciente);
        $('#modalTurno').data('turno-id', turnoId);

        $('#modalTurno').modal('show');
        llamarTurno(turnoId);
    });

    $("#rellamarBtn").click(function() {
        var turnoI = $('#modalTurno').data('turno-id');
        llamarTurno(turnoI);
    });

    $("#cerrarBtn").click(function() {
        console.log("Botón clickeado");

        var turnoI = $('#modalTurno').data('turno-id');
        cerrarTurno(turnoI);
    });

    // Otras funciones como cerrarTurno y llamarTurno

    function cerrarTurno(turnoI) {
        $.ajax({
            url: '/cerrar-turno/' + turnoI,
            type: 'POST',
            data: {
                '_token': csrf_token
            },
            success: function(response) {
                console.log('Turno cerrado exitosamente');
                window.location.reload();
            },
            error: function() {
                console.log('Error al cerrar el turno');
            }
        });
    }
    
    function llamarTurno(turnoId) {
        $.ajax({
            url: '/llamar-turno/' + turnoId,
            type: 'POST',
            data: {
                '_token': csrf_token
            },
            success: function(response) {
                console.log('Turno llamado exitosamente');
            },
            error: function() {
                console.log('Error al llamar el turno');
            }
        });
    }
});


