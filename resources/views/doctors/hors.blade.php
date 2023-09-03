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
        @if ($horarios->count() > 0)
        @foreach ($horarios as $key => $day)
          <tr>
              <th>{{$day->day}}</th>
              <td>
                  <label class="custom-toggle">
                      <input type="checkbox" name="active[]" value="{{$key}}" @if ($day->active == 1)  checked @endif>
                      <span class="custom-toggle-slider rounded-circle"></span>
                  </label>
              </td>
              <td>
                  <div class="row">
                      <div class="col">
                          <select class="form-control" name="morning_start[]">
                            <option value="{{$day->morning_start}}" selected>{{$day->morning_start}}</option>
                              @for ($i = 8; $i <= 11; $i++)
                                  <option value="{{$i}}:00">{{$i}}:00 AM</option>
                                  <option value="{{$i}}:30">{{$i}}:30 AM</option>
                              @endfor
                          </select>
                      </div>
                      <div class="col">
                          <select class="form-control" name="morning_end[]">
                              <option value="{{$day->morning_end}}" selected>{{$day->morning_end}}</option>
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
                              <option value="{{$day->afternoon_start}}" selected>{{$day->afternoon_start}}</option>
                              @for ($i = 2; $i <= 11; $i++)
                                  <option value="{{$i+12}}:00">{{$i}}:00 PM</option>
                                  <option value="{{$i+12}}:30">{{$i}}:30 PM</option>
                              @endfor
                          </select>
                      </div>
                      <div class="col">
                          <select class="form-control" name="afternoon_end[]">
                            <option value="{{$day->afternoon_end}}" selected>{{$day->afternoon_end}}</option>
                              @for ($i = 2; $i <= 11; $i++)
                                  <option value="{{$i+12}}:00">{{$i}}:00 PM</option>
                                  <option value="{{$i+12}}:30">{{$i}}:30 PM</option>
                              @endfor
                          </select>
                      </div>
                  </div>
              </td>
          </tr>
        @endforeach
        <div class="col">
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
        @else
        @foreach ($days as $key => $day)
        <tr>
            <th>{{$day}}</th>
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
        @endforeach
        <div class="col">
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
        @endif
    </tbody>
  </table>