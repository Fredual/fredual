<div class="table-responsive">
    <!-- Projects table -->
    <table class="table align-items-center table-flush">
      <thead class="thead-light text-center">
        <tr>
          <th scope="col">Fecha</th>
          <th scope="col">Especialidad</th>
          @if ($role == 'paciente' || 'admin')
            <th scope="col">Médico</th>
          @endif
          @if($role == 'doctor' || 'admin')
            <th scope="col">Paciente</th>
          @endif
          <th scope="col">Hora</th>
          <th scope="col">Tipo</th>
          <th scope="col">Opciones</th>
        </tr>
      </thead>
      <tbody class="text-center">
        @foreach ($pendingAppointments as $cita)
        <tr>
          <th scope="row">{{$cita->scheduled_date}}</th>
          <td>{{$cita->specialty->nombre}}</td>
          @if ($role == 'paciente' || 'admin')
            <td>{{$cita->doctor->name}}</td>
          @endif  
          @if($role == 'doctor' || 'admin')
            <td>{{$cita->patient->name}}</td>
          @endif
          <td>{{$cita->Scheduled_Time_12}}</td>
          <td>{{$cita->type}}</td>
          <td>
            @if ($role == 'doctor' || 'admin')
              <form action="{{ url('/miscitas/'.$cita->id.'/confirm') }}" method="POST" class="d-inline-block">
                @csrf
                <button type="submit" class="btn btn-sm btn-success" title="Confirmar Cita"><i class="ni ni-check-bold"></i></button>
              </form>   
            @endif
            <form action="{{ url('/miscitas/'.$cita->id.'/cancel') }}" method="POST" class="d-inline-block">
              @csrf
              <button type="submit" class="btn btn-sm btn-danger" title="Cancelar Cita" ><i class="ni ni-fat-delete"></i></button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>