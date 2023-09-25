<div class="table-responsive">
    <!-- Projects table -->
    <table class="table align-items-center table-flush">
      <thead class="thead-light text-center">
        <tr>
          <th scope="col">Fecha</th>
          <th scope="col">Especialidad</th>
          @if ($role == 'paciente')
            <th scope="col">Médico</th>
          @elseif($role == 'doctor')
            <th scope="col">Paciente</th>
          @endif
          <th scope="col">Hora</th>
          <th scope="col">Tipo</th>
          <th scope="col">Estado</th>
        </tr>
      </thead>
      <tbody class="text-center">
        @foreach ($oldAppointments as $cita)
        <tr>
          <th scope="row">{{$cita->scheduled_date}}</th>
          <td>{{$cita->specialty->nombre}}</td>
          @if ($role == 'paciente')
            <td>{{$cita->doctor->name}}</td>
          @elseif($role == 'doctor')
            <td>{{$cita->patient->name}}</td>
          @endif
          <td>{{$cita->Scheduled_Time_12}}</td>
          <td>{{$cita->type}}</td>
          <td>{{$cita->status}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>