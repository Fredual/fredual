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
          <div class="row">
            <div class="col-sm">
              <span>
                <h5 class="mb-0">Selecionar Médico</h5>
                <select class="form-control" id="miSelect" name="miSelect">
                  <option value="" selected>Seleccione un médico...</option>
                    @foreach ($doctors as $doctor)
                      <option value="{{$doctor->id}}">{{$doctor->name}}</option>
                    @endforeach
                </select>
              </span>
            </div>
            <div class="col-sm">
              <span>
                <h5 class="mb-0">Selecionar Fecha Inicio</h5>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                      </div>
                      <input class="form-control datepicker" id="fechaInicio" name="fechaHora" placeholder="Selecionar Fecha" type="text">
                    </div>
                  </div>
              </span>
              <span>
                <h5 class="mb-0">Selecionar Fecha Fin</h5>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                      </div>
                      <input class="form-control datepicker" id="fechaFin" name="fechaHora" placeholder="Selecionar Fecha" type="text">
                    </div>
                  </div>
              </span>
            </div>
            <div class="col-sm">
              <button type="button" id="botonEnviar" style="margin-top: 20px" class="btn btn-info">Consultar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    {{-- <div class="card-body">
      @if (session('notification'))
        <div class="alert alert-success" role="alert">
          <strong><i class="fa fa-user-md"></i></strong>{{session('notification')}}
        </div>
      @endif
    </div> --}}
    <div class="table-responsive">
      <!-- Projects table -->
      <div id="vistaLaravel"></div>
    </div>
  </div>   
</form>
 <script>
    $(document).ready(function() {
    // Cuando se cambia el valor en el select
    $("#botonEnviar").click(function() {
        // Obtener el valor seleccionado del select
        var valorSeleccionado = $('#miSelect').val();
        var fechaInicio = $('#fechaInicio').val();
        var fechaFin = $('#fechaFin').val();

        console.log(valorSeleccionado);
        console.log(fechaInicio);
        console.log(fechaFin);
        // Limpiar el contenido existente en el div
        $('#vistaLaravel').empty();

        // Realizar la solicitud AJAX con el valor seleccionado
        $.ajax({
            url: "{{ route('horario.view') }}", // Reemplaza con la ruta correcta
            type: "GET",
            data: { id: valorSeleccionado,
                    inicio: fechaInicio,
                    fin: fechaFin
                    }, // Enviar el id al controlador
            dataType: "html",
            success: function(response) {
                $("#vistaLaravel").html(response); // Carga la vista en el div
            },
            error: function(xhr) {
                // Manejar errores si es necesario
            }
        });
    });
});
/* $.ajax({
          type: 'POST',
          url: '{{ url("/horario") }}',
          data: {
            id: valorSeleccionado,
            _token: $('input[name="_token"]').val()
          }
        }).done(function(res) {
          // Resto de tu código AJAX aquí
          var arreglo = JSON.parse(res);
        console.log('El valor es:'+arreglo.length);
        if (arreglo.length == 0) {
                var todo = '<tr><td COLSPAN="5">No se encontro registro</td></tr>';
                $('tbody').append(todo);
        } else {
        for (let x = 0; x < arreglo.length; x++) {
                var todo = '<tr><td>'+arreglo[x].day+'</td>';
                todo+='<td>'+arreglo[x].active+'</td>';
                todo+='<td>'+arreglo[x].morning_start+'</td>';
                todo+='<td>'+arreglo[x].morning_end+'</td>';
                todo+='<td>'+arreglo[x].afternoon_start+'</td>';
                todo+='<td>'+arreglo[x].afternoon_end+'</td>';
                todo+='<td></td></tr>';
                $('tbody').append(todo);
            }
        }
        }); */
</script>

@endsection

