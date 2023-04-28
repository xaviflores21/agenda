@extends('layouts.app')

@section('content')
<script
  src="https://code.jquery.com/jquery-3.6.4.js"
  integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
  crossorigin="anonymous"></script>
  
<table class="table">
    <thead>
        <tr>
            <th>Nombre Encargada</th>
            <th>Inicio del horario</th>
            <th>Final del horario</th>
            <th>Lunes</th>
            <th>Martes</th>
            <th>Miércoles</th>
            <th>Jueves</th>
            <th>Viernes</th>
            <th>Sábado</th>
            <th>Domingo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($personas as $persona)
        @if($persona->estado=="C"||$persona->estado=="M")
        @foreach($persona->horarios as $horario)
            @if($horario->estado=="C"||$horario->estado=="M")
        <tr>      
            <td>{{ $persona->nombreCompleto }}</td>
            <td>{{ $horario->horarioInicio }}</td>
            <td>{{ $horario->horarioFinal }}</td>
            <td>{{ $horario->lunes ? 'Sí' : 'No' }}</td>
            <td>{{ $horario->martes ? 'Sí' : 'No' }}</td>
            <td>{{ $horario->miercoles ? 'Sí' : 'No' }}</td>
            <td>{{ $horario->jueves ? 'Sí' : 'No' }}</td>
            <td>{{ $horario->viernes ? 'Sí' : 'No' }}</td>
            <td>{{ $horario->sabado ? 'Sí' : 'No' }}</td>
            <td>{{ $horario->domingo ? 'Sí' : 'No' }}</td>
            
           
            <td>
              <button class="btn btn-primary" id="submitButton" data-bs-toggle="modal" data-bs-target="#editModal{{$persona->id}}" data-id="{{ $persona->id }}" data-nombre="{{ $persona->nombreCompleto }}" data-color="{{ $persona->color }}" data-horarioinicio="{{ $persona->horarioInicio }}" data-horariofinal="{{ $persona->horarioFinal }}">Modificar</button>
              <form action="{{ route('personas.destroy', $persona->id) }}" method="POST" style="display: inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Borrar</button>
              </form>
            </td>
          </tr>
          @endif
          @endforeach
          @endif
          @endforeach
          
          </tbody>
        </table>
            <!-- MODALES DE LOS BOTONES ANADIR Y MODIFICAR -->
            <!-- MODIFICAR -->
          <!-- Edit Modal -->
          @foreach($personas as $persona)
          @foreach($persona->horarios as $horario)
          <div class="modal fade" id="editModal{{$persona->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Modificar</h5>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form id="editForm{{$persona->id}}" action="{{ route('personas.update', $persona->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                      <label for="nombre{{$persona->id}}">Nombre Encargada</label>
                      <input type="text" class="form-control" id="nombre{{$persona->id}}" name="nombreCompleto" value="{{ $persona->nombreCompleto }}">
                    </div>
                    <div class="form row">
                      <div class="form-group col-md-4">
                        <label for="color{{$persona->id}}">Color</label>
                        <input type="color" class="form-control" id="color{{$persona->id}}" name="color" value="{{ $persona->color }}">
                      </div>
                      
                      <div class="form-group col-md-4">
                        <label for="horarioInicio{{$persona->id}}">Inicio del horario</label>
                        <input type="time" class="form-control" id="horarioInicio{{$persona->id}}" name="horarioInicio" value="{{ $horario->horarioInicio ?? '--:--' }}">
                      </div>
                      <div class="form-group col-md-4">
                        <label for="horarioFinal{{$persona->id}}">Final del horario</label>
                        <input type="time" class="form-control" id="horarioFinal{{$persona->id}}" name="horarioFinal" value="{{ $horario->horarioFinal ?? '--:--' }}">                      
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Dias de la semana</label>
                      <br>
                      <input type="checkbox" id="lunes{{$persona->id}}" name="lunes" value="1" @if($horario->lunes) checked @endif>
                      <label for="lunes{{$persona->id}}">Lunes</label>
                      <br>
                      <input type="checkbox" id="martes{{$persona->id}}" name="martes" value="1" @if($horario->martes) checked @endif>
                      <label for="martes{{$persona->id}}">Martes</label>
                      <br>
                      <input type="checkbox" id="miercoles{{$persona->id}}" name="miercoles" value="1" @if($horario->miercoles) checked @endif>
                      <label for="miercoles{{$persona->id}}">Miércoles</label>
                      <br>
                      <input type="checkbox" id="jueves{{$persona->id}}" name="jueves" value="1" @if($horario->jueves) checked @endif>
                      <label for="jueves{{$persona->id}}">Jueves</label>
                      <br>
                      <input type="checkbox" id="viernes{{$persona->id}}" name="viernes" value="1" @if($horario->viernes) checked @endif>
                      <label for="viernes{{$persona->id}}">Viernes</label>
                      <br>
                      <input type="checkbox" id="sabado{{$persona->id}}" name="sabado" value="1" @if($horario->sabado) checked @endif>
                      <label for="sabado{{$persona->id}}">Sábado</label>
                      <br>
                      <input type="checkbox" id="domingo{{$persona->id}}" name="domingo" value="1" @if($horario->domingo) checked @endif>
                      <label for="domingo{{$persona->id}}">Domingo</label>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                      <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Guardar cambios</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          @endforeach
@endforeach


            <!-- ANADIR -->
            <script>
              $('form[id^="editForm"]').submit(function(event) {
                event.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var formData = form.serialize();
                $.ajax({
                  type: 'POST',
                  url: url,
                  data: formData,
                  success: function(data) {
                    // Reload the page to update the table with the edited data
                    location.reload();
                  }, 
                  error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                  }
                });
              });
              </script>
<button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#agregarModal">Añadir</button>
<button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalHorarios{{$persona->id}}">Agregar Horario</button>
<script>
  $(document).ready(function() {
    $('#agregarModal').on('show.bs.modal', function() {
      var randomColor = '#'+(Math.random()*0xFFFFFF<<0).toString(16);
      $('#color').val(randomColor);
    });
  });
</script>
<div class="modal fade" id="agregarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Añadir</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addForm" action="{{ route('personas.store') }}" method="POST">
          @csrf
          <div class="form row">
          <div class="form-group col-md-8">
            <label for="nombre">Nombre Encargada</label>
            <input type="text" class="form-control" id="nombre" name="nombreCompleto">
          </div>
          <div class="form-group col-md-4">
            <label for="color">Color</label>
            <input type="color" class="form-control" id="color" name="color">
          </div>
          <div class="form-group col-md-12">
            <label for="nombre">Telefono</label>
            <input type="text" class="form-control" id="telefono" name="telefono">
          </div>
          <div class="form-group col-md-12">
            <label for="horarioInicio">Horarios :</label>
            <select name="horario_id" class="form-control selectpicker" >
              @foreach($horarios as $horario)
              <option value="{{ $horario->id }}">{{ $horario->horarioInicio }} - {{ $horario->horarioFinal }} 
                @if ($horario->lunes)
                &nbsp;&nbsp;&nbsp;LU
                @if ($horario->martes || $horario->miercoles || $horario->jueves || $horario->viernes || $horario->sabado || $horario->domingo)
                -
                @endif
                @endif
                @if ($horario->martes)
                MA
                @if ($horario->miercoles || $horario->jueves || $horario->viernes || $horario->sabado || $horario->domingo)
                -
                @endif
                @endif
                @if ($horario->miercoles)
                MI
                @if ($horario->jueves || $horario->viernes || $horario->sabado || $horario->domingo)
                -
                @endif
                @endif
                @if ($horario->jueves)
                JU
                @if ($horario->viernes || $horario->sabado || $horario->domingo)
                -
                @endif
                @endif
                @if ($horario->viernes)
                VI
                @if ($horario->sabado || $horario->domingo)
                -
                @endif
                @endif
                @if ($horario->sabado)
                SA
                @if ($horario->domingo)
                -
                @endif
                @endif
                @if ($horario->domingo)
                DO
                @endif
              </option>
              @endforeach
            </select>
          </div>

          <div class="form-group col-md-4">
            <br>
          </div>

            
              

          
           

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Guardar cambios</button>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
<!-- Crear un modal para Horarios -->

<div class="modal fade" id="modalHorarios{{$horario->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Modificar</h5>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                <form method="POST" action="{{ route('horarios.store') }}">


    @csrf
                  
                   
                    <div class="form row">
                  
                      
                      <div class="form-group col-md-4">
                        <label for="horarioInicio{{$horario->id}}">Inicio del horario</label>
                        <input type="time" class="form-control" id="horarioInicio{{$horario->id}}" name="horarioInicio" value="{{ $horario->horarioInicio ?? '--:--' }}">
                      </div>
                      <div class="form-group col-md-4">
                        <label for="horarioFinal{{$horario->id}}">Final del horario</label>
                        <input type="time" class="form-control" id="horarioFinal{{$persona->id}}" name="horarioFinal" value="{{ $horario->horarioFinal ?? '--:--' }}">                      
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Dias de la semana</label>
                      <br>
                      <input type="checkbox" id="lunes{{$horario->id}}" name="lunes" value="1" @if($horario->lunes) checked @endif>
                      <label for="lunes{{$horario->id}}">Lunes</label>
                      <br>
                      <input type="checkbox" id="martes{{$horario->id}}" name="martes" value="1" @if($horario->martes) checked @endif>
                      <label for="martes{{$horario->id}}">Martes</label>
                      <br>
                      <input type="checkbox" id="miercoles{{$horario->id}}" name="miercoles" value="1" @if($horario->miercoles) checked @endif>
                      <label for="miercoles{{$horario->id}}">Miércoles</label>
                      <br>
                      <input type="checkbox" id="jueves{{$horario->id}}" name="jueves" value="1" @if($horario->jueves) checked @endif>
                      <label for="jueves{{$horario->id}}">Jueves</label>
                      <br>
                      <input type="checkbox" id="viernes{{$horario->id}}" name="viernes" value="1" @if($horario->viernes) checked @endif>
                      <label for="viernes{{$horario->id}}">Viernes</label>
                      <br>
                      <input type="checkbox" id="sabado{{$horario->id}}" name="sabado" value="1" @if($horario->sabado) checked @endif>
                      <label for="sabado{{$horario->id}}">Sábado</label>
                      <br>
                      <input type="checkbox" id="domingo{{$horario->id}}" name="domingo" value="1" @if($horario->domingo) checked @endif>
                      <label for="domingo{{$horario->id}}">Domingo</label>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                      <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Guardar cambios</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

@endsection
<!-- Esto estaba en modal anadir 
          <div class="form-group">
            <label>Días de la semana</label>
            <br>
            <input type="checkbox" id="lunes" name="lunes" value="1">
            <label for="lunes">Lunes</label>
            <br>
            <input type="checkbox" id="martes" name="martes" value="1">
            <label for="martes">Martes</label>
            <br>
            <input type="checkbox" id="miercoles" name="miercoles" value="1">
            <label for="miercoles">Miércoles</label>
            <br>
            <input type="checkbox" id="jueves" name="jueves" value="1">
            <label for="jueves">Jueves</label>
            <br>
            <input type="checkbox" id="viernes" name="viernes" value="1">
            <label for="viernes">Viernes</label>
            <br>
            <input type="checkbox" id="sabado" name="sabado" value="1">
            <label for="sabado">Sábado</label>
            <br>
            <input type="checkbox" id="domingo" name="domingo" value="1">
            <label for="domingo">Domingo</label>
          </div> -->