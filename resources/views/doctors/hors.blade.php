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
@foreach ($fechasConInformacion as $fecha => $info)
    @if ($info['tieneInformacion'])
        <tr>
            <th>
                {{$fecha}}
                <input type="hidden" name="fechas_doctors[{{$fecha}}]" value="{{$fecha}}">
                <input type="hidden" name="user_id[{{$fecha}}]" value="{{$info['horarios'][0]->user_id}}">
            </th>
            <td>
                <label class="custom-toggle">
                    <input type="hidden" name="active[{{$fecha}}]" value="0">
                    <input type="checkbox" name="active[{{$fecha}}]" value="1" @if ($info['horarios'][0]->active == 1) checked @endif>
                    <span class="custom-toggle-slider rounded-circle"></span>
                </label>
            </td>
            <td>
                <div class="row">
                    <div class="col">
                        <select class="form-control" name="morning_start[{{$fecha}}]">
                          <option value="{{$info['horarios'][0]->morning_start}}" selected>{{$info['horarios'][0]->morning_start}}</option>
                            @for ($i = 8; $i <= 11; $i++)
                                <option value="{{$i}}:00">{{$i}}:00 AM</option>
                                <option value="{{$i}}:30">{{$i}}:30 AM</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col">
                        <select class="form-control" name="morning_end[{{$fecha}}]">
                            <option value="{{$info['horarios'][0]->morning_end}}" selected>{{$info['horarios'][0]->morning_end}}</option>
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
                        <select class="form-control" name="afternoon_start[{{$fecha}}]">
                            <option value="{{$info['horarios'][0]->afternoon_start}}" selected>{{$info['horarios'][0]->afternoon_start}}</option>
                            @for ($i = 2; $i <= 11; $i++)
                                <option value="{{$i+12}}:00">{{$i}}:00 PM</option>
                                <option value="{{$i+12}}:30">{{$i}}:30 PM</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col">
                        <select class="form-control" name="afternoon_end[{{$fecha}}]">
                          <option value="{{$info['horarios'][0]->afternoon_end}}" selected>{{$info['horarios'][0]->afternoon_end}}</option>
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
            <th>
                {{$fecha}}
                <input type="hidden" name="fechas_doctors[{{$fecha}}]" value="{{$fecha}}">
                <input type="hidden" name="user_id[{{$fecha}}]" value="{{$id}}">
            </th>
            <td>
                <label class="custom-toggle">
                    <input type="hidden" name="active[{{ $fecha }}]" value="0">
                    <input type="checkbox" name="active[{{ $fecha }}]" value="1">
                    <span class="custom-toggle-slider rounded-circle"></span>
                </label>
            </td>
            <td>
                <div class="row">
                    <div class="col">
                        <select class="form-control" name="morning_start[{{$fecha}}]">
                            @for ($i = 8; $i <= 11; $i++)
                                <option value="{{$i}}:00">{{$i}}:00 AM</option>
                                <option value="{{$i}}:30">{{$i}}:30 AM</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col">
                        <select class="form-control" name="morning_end[{{$fecha}}]">
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
                        <select class="form-control" name="afternoon_start[{{$fecha}}]">
                            @for ($i = 2; $i <= 11; $i++)
                                <option value="{{$i+12}}:00">{{$i}}:00 PM</option>
                                <option value="{{$i+12}}:30">{{$i}}:30 PM</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col">
                        <select class="form-control" name="afternoon_end[{{$fecha}}]">
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