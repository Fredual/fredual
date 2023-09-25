@extends('layouts.panel')

@section('content')
<div class="card shadow">
  <div class="card-header border-0">
    <div class="row align-items-center">
      <div class="col">
        <h3 class="mb-0">Mis Citas</h3>
      </div>
    </div>
  </div>
  <div class="card-body">
    @if (session('notification'))
        <div class="alert alert-success" role="alert">
            <strong><i class="fas fa-tooth"></i></strong>{{session('notification')}}
        </div>
    @endif
    <div class="nav-wrapper position-relative end-0">
        <ul class="nav nav-pills nav-fill p-1" role="tablist">
            <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0 active" data-toggle="tab" href="#ModuloUno" role="tab" aria-selected="true">
                    <i class="ni ni-calendar-grid-58 mr-2"></i>Modulo Uno</a>
            </li>
            <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0" data-toggle="tab" href="#ModuloDos" role="tab" aria-selected="false">
                    <i class="ni ni-bell-55 mr-2"></i>Modulo Dos</a>
            </li>
        </ul>
    </div>
  </div>
  <div class="card shadow">
    <div class="card">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="ModuloUno" role="tabpanel">
                @include('appointment.modulouno')
            </div>
            <div class="tab-pane fade" id="ModuloDos" role="tabpanel">
                @include('appointment.modulodos')
            </div>
        </div>
    </div>
  </div>
</div>
<!-- Agrega un elemento para almacenar los datos de las citas -->
<div id="citasData" data-citas='@json($citas)'></div>
@endsection
@section('scripts')

<script src="{{asset('/js/appointment/cita.js')}}"></script>
<script>
  // Pasa los datos como atributos de datos HTML
  var consultas = @json($citas);
</script>
@endsection
