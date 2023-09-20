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
 <script>
 $(document).ready(function() {
    $('.datepicker').datepicker();

    $('.datepicker').on('changeDate', function() {
      $(this).datepicker('hide');
    });


    //Agregar evento click al botón #botonEnviar
    $("#botonEnviar").click(function() {
      var valorSeleccionado = $('#miSelect').val();
      var fechaInicio = $('#fechaInicio').val();
      var fechaFin = $('#fechaFin').val();

      if (valorSeleccionado === "") {
        // Cambia el borde del contenedor a rojo
        $("#miSelect").css("border", "1px solid red");
      } else if (fechaInicio === "" || fechaFin === "") {
        $("#miSelect").css("border", "1px solid green");
        $("#cuadroFechas").css("border", "1px solid red");
      } else {
        // Restaura el borde del contenedor al estilo original
        $("#cuadroFechas").css("border", "1px solid green");
        $("#miSelect").css("border", "1px solid green");

        // Realiza las validaciones de fechas aquí
        var fechaInicioObj = new Date(fechaInicio);
        var fechaFinObj = new Date(fechaFin);
        var diferencia = (fechaFinObj - fechaInicioObj) / (1000 * 60 * 60 * 24);

        if (fechaInicioObj > fechaFinObj) {
          mostrarAlerta("La fecha inicial no puede ser superior a la fecha final.");
          return;
          
        } else if (diferencia > 30) {

          console.log(diferencia);
          mostrarAlerta("El rango de fechas no puede ser superior a 30 días.");
          return;

        } else {

          console.log(valorSeleccionado);
          console.log(fechaInicio);
          console.log(fechaFin);

          $('#vistaLaravel').empty();

          $.ajax({
            url: "{{ route('horario.view') }}",
            type: "POST",
            data: {
                    id: valorSeleccionado,
                    inicio: fechaInicio,
                    fin: fechaFin,
                    _token: "{{ csrf_token() }}"
                  },
            dataType: "html",
                    success: function(response) {
                    $("#vistaLaravel").html(response);
                  },
                    error: function(xhr, status, error) {
                      console.log("Error en la solicitud AJAX:");
                      console.log("Status:", status);
                      console.log("Error:", error);
                  }
        });
        }
      }
    });
    function mostrarAlerta(mensaje) {
      var alerta = $("#alerta");
      alerta.html(mensaje);
      alerta.show();

      setTimeout(function() {
        alerta.hide();
      }, 1000);
    }
  });
</script>

@endsection

@section('scripts')
<script src="{{asset('js/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
@endsection

