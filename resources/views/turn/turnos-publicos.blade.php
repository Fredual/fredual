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
    <!-- CSS Files -->
    <link href="{{ asset('css/argon-dashboard.css?v=1.1.2') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @php
        $backgroundImage = asset('img/brand/fondo.jpg');
    @endphp
    <link rel="stylesheet" href="{{ asset('css/publico.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="video-container">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item"
                            src="https://www.youtube.com/embed/6QSUTjsHU6s?si=felQN3HiN8q4QO-b"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen></iframe>
                            
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <table class="table custom-table">
                    <thead class="bg-dark text-light">
                        <tr>
                            <th class="text-center">Modulo</th>
                            <th class="text-center">Nombre</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-numeros-llamados">
                        <tr>
                            <td>-</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>-</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>-</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>-</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>-</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>-</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>-</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>-</td>
                            <td></td>
                        </tr>
                        <!-- Aquí se mostrarán los números llamados -->
                    </tbody>
                </table>
            </div>
        </div>
        <audio id="successSound" src="{{ asset('sound/iphone.mp3') }}" preload="auto"></audio>
    </div>

    <!--   Core   -->
    <script src="{{ asset('js/plugins/jquery/dist/jquery.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!--   Argon JS   -->
    <script src="{{ asset('js/argon-dashboard.min.js?v=1.1.2') }}"></script>
    <script src="{{ asset('js/turnos/mostrarTurno.js') }}"></script>
    <script>
        var csrf_token = '{{ csrf_token() }}';
    </script>
</body>

</html>
