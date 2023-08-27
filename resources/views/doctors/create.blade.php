@extends('layouts.panel')

@section('content')
<div class="card shadow">
  <div class="card-header border-0">
    <div class="row align-items-center">
      <div class="col">
        <h3 class="mb-0">Nuevo Médico</h3>
      </div>
      <div class="col text-right">
        <a href="{{url('/medicos')}}" class="btn btn-sm btn-success">
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
    <form action="{{url('/medicos')}}" method="post">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre del Médico</label>
            <input type="text" name="nombre" class="form-control" value="{{old('nombre')}}" required>
        </div>
        <div class="form-group">
            <label for="email">Correo Electronico</label>
            <input type="text" name="email" class="form-control" value="{{old('email')}}">
        </div>
        <div class="form-group">
            <label for="cedula">Cedula</label>
            <input type="text" name="cedula" class="form-control" value="{{old('cedula')}}">
        </div>
        <div class="form-group">
            <label for="addres">Dirección</label>
            <input type="text" name="addres" class="form-control" value="{{old('addres')}}">
        </div>
        <div class="form-group">
            <label for="phone">Teléfono / Móvil</label>
            <input type="text" name="phone" class="form-control" value="{{old('phone')}}">
        </div>
        <button type="submit" class="btn btn-sm btn-primary">Crear Médico</button>
    </form>
  </div>
</div>
@endsection