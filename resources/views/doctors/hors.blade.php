<table class="table align-items-center table-flush text-center">
    <thead class="thead-light">
      <tr>
        <th scope="col">Día</th>
        <th scope="col">Activo</th>
        <th scope="col">Turno Mañana</th>
        <th scope="col">Turno Tarde</th>
      </tr>
    </thead>
    <tbody>
@foreach ($horarios as $key => $horario)
    @if ($horarios)
    <tr>
        <th>
            {{$horario->fecha_doctors}}
            <input type="hidden" name="fecha_doctors" value="{{$horario->fecha_doctors}}">
            <input type="hidden" name="user_id" value="{{$horario->user_id}}">
        </th>
        <td>
            <label class="custom-toggle">
                <input type="hidden" name="active[{{$key}}]" value="0"> <!-- Valor predeterminado en caso de que el checkbox no esté marcado -->
                <input type="checkbox" name="active[{{$key}}]" value="1" @if ($horario->active == 1) checked @endif>
                <span class="custom-toggle-slider rounded-circle"></span>
            </label>
        </td>
        <td>
            <div class="row">
                <div class="col">
                    <select class="form-control" name="morning_start[]">
                      <option value="{{$horario->morning_start}}" selected>{{$horario->morning_start}}</option>
                        @for ($i = 8; $i <= 11; $i++)
                            <option value="{{$i}}:00">{{$i}}:00 AM</option>
                            <option value="{{$i}}:30">{{$i}}:30 AM</option>
                        @endfor
                    </select>
                </div>
                <div class="col">
                    <select class="form-control" name="morning_end[]">
                        <option value="{{$horario->morning_end}}" selected>{{$horario->morning_end}}</option>
                        @for ($i = 8; $i <= 11; $i++)
                            <option value="{{$i}}:00">{{$i}}:00 AM</option>
                            <option value="{{$i}}:30">{{$i}}:30 AM</option>
                        @endfor
                    </select>
                </div>
            </div>
        </td>
        <td>
            <div class="row">
                <div class="col">
                    <select class="form-control" name="afternoon_start[]">
                        <option value="{{$horario->afternoon_start}}" selected>{{$horario->afternoon_start}}</option>
                        @for ($i = 2; $i <= 11; $i++)
                            <option value="{{$i+12}}:00">{{$i}}:00 PM</option>
                            <option value="{{$i+12}}:30">{{$i}}:30 PM</option>
                        @endfor
                    </select>
                </div>
                <div class="col">
                    <select class="form-control" name="afternoon_end[]">
                      <option value="{{$horario->afternoon_end}}" selected>{{$horario->afternoon_end}}</option>
                        @for ($i = 2; $i <= 11; $i++)
                            <option value="{{$i+12}}:00">{{$i}}:00 PM</option>
                            <option value="{{$i+12}}:30">{{$i}}:30 PM</option>
                        @endfor
                    </select>
                </div>
            </div>
        </td>
    </tr>
    @else
    <tr>
        <th></th>
        <td>
            <label class="custom-toggle">
                <input type="checkbox" name="active[]" value="{{$key}}" checked>
                <span class="custom-toggle-slider rounded-circle"></span>
            </label>
        </td>
        <td>
            <div class="row">
                <div class="col">
                    <select class="form-control" name="morning_start[]">
                        @for ($i = 8; $i <= 11; $i++)
                            <option value="{{$i}}:00">{{$i}}:00 AM</option>
                            <option value="{{$i}}:30">{{$i}}:30 AM</option>
                        @endfor
                    </select>
                </div>
                <div class="col">
                    <select class="form-control" name="morning_end[]">
                        @for ($i = 8; $i <= 11; $i++)
                            <option value="{{$i}}:00">{{$i}}:00 AM</option>
                            <option value="{{$i}}:30">{{$i}}:30 AM</option>
                        @endfor
                    </select>
                </div>
            </div>
        </td>
        <td>
            <div class="row">
                <div class="col">
                    <select class="form-control" name="afternoon_start[]">
                        @for ($i = 2; $i <= 11; $i++)
                            <option value="{{$i+12}}:00">{{$i}}:00 PM</option>
                            <option value="{{$i+12}}:30">{{$i}}:30 PM</option>
                        @endfor
                    </select>
                </div>
                <div class="col">
                    <select class="form-control" name="afternoon_end[]">
                        @for ($i = 2; $i <= 11; $i++)
                            <option value="{{$i+12}}:00">{{$i}}:00 PM</option>
                            <option value="{{$i+12}}:30">{{$i}}:30 PM</option>
                        @endfor
                    </select>
                </div>
            </div>
        </td>
    </tr>
    @endif
@endforeach
<div class="col">
    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
</div>
</tbody>
</table>