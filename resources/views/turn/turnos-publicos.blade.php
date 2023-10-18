<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        GersonCruz
    </title>
    <!-- Favicon -->
    <link href="{{ asset('img/brand/favicon1.png') }}" rel="icon" type="image/png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->
    <link href="{{ asset('js/plugins/nucleo/css/nucleo.css') }}" rel="stylesheet" />
    <link href="{{ asset('js/plugins/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
    <!-- CSS Files -->
    <link href="{{ asset('css/argon-dashboard.css?v=1.1.2') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nombre+de+la+Fuente">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body class="bg-white">
    <div class="main-content">
        <!-- Header -->

        <div class="header bg-gradient-dark py-7 py-lg-8">
            <div class="separator separator-bottom separator-skew zindex-100">
                <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1"
                    xmlns="http://www.w3.org/2000/svg">
                    <polygon class="fill-white" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-8"><span>col-8</span></div>
                    <div class="col-4 bg-white">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Modulo</th>
                                </tr>
                            </thead>
                            <tbody id="tabla-numeros-llamados">
                                <!-- Aquí se mostrarán los números llamados -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- ------------------------------------------------------------------------------------- Contenido ----------------------------------- --}}


        <!-- Footer -->
        <footer class="py-5">
            <div class="container">
                <div class="row align-items-center justify-content-xl-between">
                </div>
            </div>
        </footer>
    </div>
    <!--   Core   -->
    <script src="{{ asset('js/plugins/jquery/dist/jquery.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!--   Argon JS   -->
    <script src="{{ asset('js/argon-dashboard.min.js?v=1.1.2') }}"></script>
    <script>
        function actualizarPantallaSalaEspera() {
            $.ajax({
                url: '/turno-llamado',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    //console.log(response);
                    if (response.turnoLlamado) {
                        // Agregar el número llamado a la tabla
                        var $tabla = $('#tabla-numeros-llamados');
                        var $fila = $('<tr><td>' + response.turnoLlamado.id + '</td><td>' + response
                            .turnoLlamado.nombrePaciente + '</td><td>' + response.turnoLlamado
                            .nombreModulo + '</td></tr>');
                        $tabla.prepend($fila);

                        // Limitar la tabla a mostrar solo los últimos 8 números
                        if ($tabla.find('tr').length > 8) {
                            $tabla.find('tr:last').remove();
                        }


                        setTimeout(function() {
                            $.ajax({
                                url: '/atender-turno/' + response.turnoLlamado.id,
                                type: 'POST',
                                data: {
                                    '_token': '{{ csrf_token() }}'
                                },
                                success: function() {
                                    $('#estadoTurno').text('Atendido');
                                },
                                error: function() {
                                    console.log('Error al atender el turno');
                                }
                            });
                        }, 5000);
                    }
                },
                error: function() {
                    // Maneja errores si es necesario.
                    console.log('error')
                }
            });
        }

        setInterval(actualizarPantallaSalaEspera, 10000); // Actualiza cada 5 segundos (ajusta según tus necesidades).
    </script>
</body>

</html>
