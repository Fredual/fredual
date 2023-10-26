function actualizarPantallaSalaEspera() {
    var modulo;

    $.ajax({
        url: "/turno-llamado",
        type: "GET",
        dataType: "json",
        success: function (response) {
            //console.log(response);
            if (response.turnoLlamado) {
                if ((response.turnoLlamado.nombreModulo = 101)) {
                    modulo = 1;
                } else {
                    modulo = 2;
                }
                // Agregar el número llamado a la tabla
                var $tabla = $("#tabla-numeros-llamados");
                var $fila = $(
                    "<tr><td>" +
                        modulo +
                        "</td><td>" +
                        response.turnoLlamado.nombrePaciente +
                        "</td></tr>"
                );
                $tabla.prepend($fila);

                // Limitar la tabla a mostrar solo los últimos 8 números
                if ($tabla.find("tr").length > 8) {
                    $tabla.find("tr:last").remove();
                }

                var successSound = document.getElementById("successSound");
                successSound.play();

                setTimeout(function () {
                    $.ajax({
                        url: "/atender-turno/" + response.turnoLlamado.id,
                        type: "POST",
                        data: {
                            _token: csrf_token
                        },
                        success: function () {
                            $("#estadoTurno").text("Atendido");
                        },
                        error: function () {
                            console.log("Error al atender el turno");
                        },
                    });
                }, 5000);
            }
        },
        error: function () {
            // Maneja errores si es necesario.
            console.log("error");
        },
    });
}

setInterval(actualizarPantallaSalaEspera, 10000); // Actualiza cada 5 segundos (ajusta según tus necesidades).
