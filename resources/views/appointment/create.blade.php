<?php 
use Illuminate\Support\Str;
?>
@extends('layouts.panel')

@section('content')
<div class="card shadow">
  <div class="card-header border-0">
    <div class="row align-items-center">
      <div class="col">
        <h3 class="mb-0">Registrar Nueva Cita</h3>
      </div>
      <div class="col text-right">
        <a href="{{url('/pacientes')}}" class="btn btn-sm btn-success">
            <i class="fas fa-chevron-left"></i> Regresar
        </a>
      </div>
    </div>
  </div>
  <div class="card-body">
    @if ($errors->any())
        @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Por favor!</strong>{{$error}}
        </div>
        @endforeach
    @endif
    <form action="{{url('/reservarcitas')}}" method="post">
        @csrf
        <div class="form-group">
            <label for="patient">Paciente</label>
            <select name="patient_id" id="patient" class="form-control">
                <option value="">Seleccionar Paciente</option>
                @foreach ($patients as $paciente)
                    <option value="{{$paciente->id}}" @if (old('patient_id') == $paciente->id) selected @endif>
                        {{$paciente->name}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="specialty">Especialidad</label>
                <select name="specialty_id" id="specialty" class="form-control">
                    <option value="">Seleccionar Especialidad</option>
                    @foreach ($specialties as $especialidad)
                        <option value="{{$especialidad->id}}" 
                            @if (old('specialty_id') == $especialidad->id) selected @endif>
                            {{$especialidad->nombre}}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="doctor">Médico</label>
                <select name="doctor_id" id="doctor" class="form-control" required>
                    @foreach ($doctors as $doctor)
                    <option value="{{$doctor->id}}" 
                        @if (old('doctor_id') == $doctor->id) selected @endif>
                        {{$doctor->name}}
                    </option>
                @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="date">Fecha</label>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                    </div>
                    <input class="form-control datepicker" name="scheduled_date" id="date" placeholder="Seleccionar Fecha" type="text" value="{{old('scheduled_date'), date('Y-m-d')}}" data-date-format="yyyy-mm-dd"
                    data-date-start-date="{{date('Y-m-d')}}" data-date-end-date="+30d">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="hours">Hora de atención</label>
            <div class="">
                <div class="row">
                    <div class="col">
                        <h4 class="m-3 text-center" id="titleMorning"></h4>
                        <div class="text-center" id="hoursMorning">
                            @if ($intervals)
                            <h4 class="m-3">En la mañana</h4>
                            @php
                                $intervalsData = json_decode($intervals->getContent(), true);
                                // Convierte el contenido de JsonResponse en un arreglo asociativo
                            @endphp
                            @foreach ($intervalsData['data']['morning'] as $key => $interval)
                                <div class="custom-control custom-radio custom-control-inline custom-control-sm mb-2">
                                    <input type="checkbox" id="intervalMorning{{$key}}" name="sheduled_time[]" value="{{$interval['start']}}" class="custom-control-input">
                                    <label class="custom-control-label" for="intervalMorning{{$key}}">
                                        {{ $interval['start'] }} - {{ $interval['end'] }}
                                    </label>
                                </div>
                            @endforeach
                            @else
                                <mark>
                                    <small class="text-warning display-5">
                                        Seleccione un medico y una fecha, para ver las horas.
                                    </small>
                                </mark>
                            @endif
                        </div>
                    </div>
                    <div class="col">
                        <h4 class="m-3 text-center" id="titleAfternoon"></h4>
                        <div class="text-center" id="hoursAfternoon">
                            @if ($intervals)
                                <h4 class="m-3">En la tarde</h4>
                                @foreach ($intervalsData['data']['afternoon'] as $key => $interval)
                                    <div class="custom-control custom-radio custom-control-inline custom-control-sm mb-2">
                                        <input type="checkbox" id="intervalAfternoon{{$key}}" name="sheduled_time[]" value="{{$interval['start']}}" class="custom-control-input">
                                        <label class="custom-control-label" for="intervalAfternoon{{$key}}">
                                            {{ $interval['start'] }} - {{ $interval['end'] }}
                                        </label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Tipo de consulta</label><br>
                <div class="form-check form-check-inline mt-3 mb-3">
                    <input class="form-check-input" @if (old('type') == 'Consulta') checked @endif id="type1" type="radio" name="type" id="inlineRadio1" value="Consulta">
                    <label class="form-check-label" for="type1">Consulta</label>
                </div>
                <div class="form-check form-check-inline mb-3">
                    <input class="form-check-input" @if (old('type') == 'Control') checked @endif  id="type2" type="radio" name="type" id="inlineRadio2" value="Control">
                    <label class="form-check-label" for="type2">Control</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" @if (old('type') == 'Cirugía') checked @endif  id="type3" type="radio" name="type" id="inlineRadio3" value="Cirugía">
                    <label class="form-check-label" for="type3">Cirugía</label>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label>Tipo de consulta</label>
                <select name="modulo" id="modulo" class="form-control">
                    <option value="" selected>Seleccione un modulo 1</option>
                    <option value="101">Modulo 1</option>
                    <option value="102">Modulo 2</option>
                </select>
            </div>
        </div>

        
        <div class="form-group">
            <label for="observacion">Observaciones</label>
            <textarea name="observacion" id="observacion" type="text" class="form-control" rows="5" placeholder="Observaciones del paciente"></textarea>
        </div>
        <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script src="{{asset('js/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>

<script src="{{asset('/js/appointment/create.js')}}"></script>
@endsection