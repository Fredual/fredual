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
        <strong><i class="fa fa-user-md"></i></strong>{{session('notification')}}
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
            <th scope="col">Tipo</th>
            <th scope="col">Opciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($citas as $cita)
          <tr>
            <th scope="row">Dr. {{$cita->doctor->name}}</th>
            <td>{{$cita->patient->name}}</td>
            <td>{{$cita->modulo}}</td>
            <td>{{$cita->specialty->nombre}}</td>
            <td>{{$cita->type}}</td>
            <td>
            <form action="{{ url('/turnos/'.$cita->id) }}" method="POST">
                @csrf     
                <input type="hidden" name="cita_id" value="{{ $cita->id }}">
                <button type="submit" class="btn btn-sm btn-success">Llamar</button>
            </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="cord-body">
      {{$citas->links()}}
    </div>
  </div>
@endsection

@section('scripts')
{{-- <script src="{{asset('js/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>

<script src="{{asset('/js/appointment/create.js')}}"></script> --}}
@endsection