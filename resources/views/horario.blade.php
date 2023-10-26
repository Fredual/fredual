@extends('layouts.panel')

@section('content')
<form action="{{url('/horario')}}" method="POST">
  @csrf
  <div class="card shadow">
    <div class="card-header border-0">
      <div class="col">
        <span><h2 class="mb-0">Gestion De Horarios</h2></span>
      </div>
      <div class="row align-items-center">
        <div class="container">
          @if (session('success'))
            <div class="alert alert-success">
              {{ session('success') }}
            </div>
          @endif
          <div class="row">
            <div class="col-sm">
              <span>
                <h5 class="mb-0">Selecionar Médico</h5>
                <select class="form-control" id="miSelect" name="miSelect" required> 
                  <option value="" selected>Seleccione un médico...</option>
                    @foreach ($doctors as $doctor)
                      <option value="{{$doctor->id}}">{{$doctor->name}}</option>
                    @endforeach
                </select>
              </span>
            </div>
            <div class="col-sm">
              <span>
                <h5 class="mb-0">Selecionar Fechas</h5>
                  <div class="form-group">
                    <div id="cuadroFechas" class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                      </div>
                      <input class="form-control datepicker" id="fechaInicio" name="fechaHora" placeholder="Selecionar Fecha" type="text" autocomplete="off">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                      </div>
                      <input class="form-control datepicker" id="fechaFin" name="fechaHora" placeholder="Selecionar Fecha" type="text" autocomplete="off">
                    </div>
                  </div>
              </span>
            </div>
            <div class="col-sm">
              <button type="button" id="botonEnviar" style="margin-top: 20px" class="btn btn-default">Consultar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card-body">
      @if (session('errors'))
        <div class="alert alert-danger" role="alert">
          <strong><i class="fa fa-user-md"></i></strong>
          Los cambios se han guardado pero se encontraron las siguientes novedades:
          <ul>
            @foreach(session('errors') as $error)
              <li>{{$error}}</li>
            @endforeach
          </ul>
        </div>
      @endif
    </div> 
    <div class="table-responsive ">
      <!-- Projects table -->
      <div id="vistaLaravel" class="mb-6"></div>
    </div>
  </div>   
</form>
<div class="alert alert-danger alert-dismissible fade show" id="alerta" style="display: none;">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>


@endsection

@section('scripts')
<script>
  var horarioViewUrl = @json(route('horario.view'));
  var csrf_token = '{{ csrf_token() }}';
</script>
<script src="{{ asset('js/appointment/horarios.js') }}"></script>
<script src="{{asset('js/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
@endsection

