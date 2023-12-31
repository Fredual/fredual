<?php
use Illuminate\Support\Str;
?>
@extends('layouts.panel')

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="mb-0">Llamar Pacientes</h3>
                </div>
                <div class="col text-right">
                    <a href="{{-- {{url('')}} --}}" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#form">Nuevo
                        Turno</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if (session('notification'))
                <div class="alert alert-success" role="alert">
                    <strong><i class="fa fa-user-md"></i></strong>{{ session('notification') }}
                </div>
            @endif
        </div>
        <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header border-bottom-0">
                        <h5 class="modal-title" id="exampleModalLabel">Crear Nuevo Turno</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('formulario.turno') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nombre_paciente">Nombre de Paciente</label>
                                <input type="text" class="form-control" id="nombre_paciente" name="nombre_paciente" placeholder="Nombre Paciente">
                            </div>
                            <div class="form-group">
                                <label for="modulo">Modulo</label>
                                <select class="form-control" id="modulo" name="modulo">
                                    <option>Seleccione...</option>
                                    <option value="101">Modulo 1</option>
                                    <option value="102">Modulo 2</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer border-top-0 d-flex justify-content-center">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <!-- Projects table -->
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Paciente</th>
                        <th scope="col">Modulo</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    @foreach ($turnos as $turno)
                        <tr>
                            <td>{{ $turno->nombre_paciente }}</td>
                            <td>{{ $turno->modulo_turno }}</td>
                            <td>{{ $turno->statusT }}</td>
                            <td>
                                <button class="llamarTurno btn btn-sm btn-success" data-turno-id="{{ $turno->id }}"
                                    data-nombre-paciente="{{ $turno->nombre_paciente }}">Llamar Turno</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="modal fade bd-example-modal-sm" id="modalTurno" tabindex="-1" role="dialog"
            aria-labelledby="modalTurnoLabel" data-turno-id="" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="modalTurnoLabel">Paciente Llamado</h3>
                    </div>
                    <div class="modal-body">
                        <!-- Aquí puedes agregar contenido para rellamar o cerrar el turno -->
                        <h4>Nombre: <span id="nombrePaciente"></span></h4>
                    </div>
                    <div class="modal-footer">
                        <button id="rellamarBtn" class="btn btn-primary">Rellamar Turno</button>
                        <button id="cerrarBtn" class="btn btn-secondary" data-dismiss="modal">Cerrar Turno</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="cord-body">
            {{ $turnos->links() }}
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var csrf_token = '{{ csrf_token() }}';
    </script>
    <script src="{{ asset('js/turnos/llamarTurno.js') }}"></script>

    {{-- <script>
        $(document).ready(function() {

            $('.llamarTurno').click(function() {
                var boton = $(this); // Referencia al botón clickeado
                boton.prop('disabled', true); // Desactiva el botón temporalmente

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
                console.log("Botón clickeado"); // Agrega esta línea

                var turnoI = $('#modalTurno').data('turno-id');
                cerrarTurno(turnoI);
            });


            //funcion cerrar 
            function cerrarTurno(turnoI) {
                    $.ajax({
                        url: '/cerrar-turno/' + turnoI,
                        type: 'POST',
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log('Turno cerrado exitosamente');
                            // Aquí puedes realizar acciones adicionales si es necesario
                            window.location.reload();
                        },
                        error: function() {
                            console.log('Error al cerrar el turno');
                        }
                    });
                }

            //funcion ajax
            function llamarTurno(turnoId) {
                $.ajax({
                    url: '/llamar-turno/' + turnoId,
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log('Turno llamado exitosamente');
                        // Aquí puedes realizar acciones adicionales si es necesario
                    },
                    error: function() {
                        console.log('Error al llamar el turno');
                    }
                });
            }

        });
    </script> --}}
@endsection
