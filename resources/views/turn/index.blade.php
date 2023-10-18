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
            </div>
        </div>
        <div class="card-body">
            @if (session('notification'))
                <div class="alert alert-success" role="alert">
                    <strong><i class="fa fa-user-md"></i></strong>{{ session('notification') }}
                </div>
            @endif
        </div>
        <div class="table-responsive">
            <!-- Projects table -->
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Medico</th>
                        <th scope="col">Paciente</th>
                        <th scope="col">Modulo</th>
                        <th scope="col">Especialidad</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    @foreach ($turnos as $turno)
                        <tr>
                            <th scope="row">Dr. {{ $turno->appointment->doctor->name }}</th>
                            <td>{{ $turno->appointment->patient->name }}</td>
                            <td>{{ $turno->appointment->modulo }}</td>
                            <td>{{ $turno->appointment->specialty->nombre }}</td>
                            <td>{{ $turno->statusT }}</td>
                            <td>
                                <button class="llamarTurno btn btn-sm btn-success"
                                    data-turno-id="{{ $turno->id }}">Llamar Turno</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="cord-body">
            {{ $turnos->links() }}
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.llamarTurno').click(function() {
                var boton = $(this); // Referencia al botón clickeado
                boton.prop('disabled', true); // Desactiva el botón temporalmente
        
                var turnoId = boton.data('turno-id');
                $.ajax({
                    url: '/llamar-turno/' + turnoId,
                    type: 'POST',
                    data: { '_token': '{{ csrf_token() }}' },
                    success: function(response) {
                        alert('Turno llamado exitosamente');
        
                        // Habilita el botón nuevamente para llamar otro turno
                        boton.prop('disabled', false);
        
                        // Aquí puedes actualizar la interfaz de usuario si es necesario.
                    },
                    error: function() {
                        alert('Error al llamar el turno');
        
                        // Habilita el botón nuevamente en caso de error
                        boton.prop('disabled', false);
                    }
                });
            });
        });
        </script>
@endsection
