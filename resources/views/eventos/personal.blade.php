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
        <tr>      
          <td>{{ $persona->nombreCompleto }}</td>
          @if($horario->estado=="C"||$horario->estado=="M")
            <td>{{ $horario->horarioInicio }}</td>
            <td>{{ $horario->horarioFinal }}</td>
            <td>{{ $horario->lunes ? 'lun' : '-' }}</td>
            <td>{{ $horario->martes ? 'mar' : '-' }}</td>
            <td>{{ $horario->miercoles ? 'mie' : '-' }}</td>
            <td>{{ $horario->jueves ? 'jue' : '-' }}</td>
            <td>{{ $horario->viernes ? 'vie' : '-' }}</td>
            <td>{{ $horario->sabado ? 'sab' : '-' }}</td>
            <td>{{ $horario->domingo ? 'dom' : '-' }}</td>
          @else
            <td colspan="9">No hay horario asignado</td>
          @endif
          <td>
            <button class="btn btn-primary" id="submitButton" data-bs-toggle="modal" data-bs-target="#editModal{{$persona->id}}" data-id="{{ $persona->id }}" data-nombre="{{ $persona->nombreCompleto }}" data-color="{{ $persona->color }}" data-horarioinicio="{{ $persona->horarioInicio }}" data-horariofinal="{{ $persona->horarioFinal }}">Modificar</button>
            <form action="{{ route('personas.destroy', $persona->id) }}" method="POST" style="display: inline-block;">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger">Borrar</button>
            </form>
          </td>
        </tr>
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
                      <input type="hidden" name="horario_id" value="{{ $horario->id }}">
                      <label for="nombre{{$persona->id}}">Nombre Encargada</label>
                      <input type="text" class="form-control" id="nombre{{$persona->id}}" name="nombreCompleto" value="{{ $persona->nombreCompleto }}">
                    </div>
                      
                    <div class="form-group ">
                      <label for="telefono{{$persona->id}}">Telefono</label>
                      <input type="text" class="form-control" id="telefono{{$persona->id}}" name="telefono" value="{{$persona->telefono}}">
                    </div>

                    <div class="form row">
                      <div class="form-group col-md-4">
                        <label for="color{{$persona->id}}">Color</label>
                        <input type="color" class="form-control" id="color{{$persona->id}}" name="color" value="{{ $persona->color }}">
                      </div>
                    </div>
                         <div class="form-group col-md-12">
                            <label for="horarioInicio">Horarios :</label>
                            <select name="horario_ids" class="form-control selectpicker" >
                              @foreach($horarios as $horario)
                              @if($horario->estado == "C" || $horario->estado == "M")
                              <option value="{{ $horario->id }}">{{ $horario->horarioInicio }} - {{ $horario->horarioFinal }} 
                                @php $first = true; @endphp
                                @if ($horario->lunes)
                                @if ($first)
                                &nbsp;&nbsp;&nbsp;LU
                                @php $first = false; @endphp
                                @else
                                - LU
                                @endif
                                @endif
                                @if ($horario->martes)
                                @if ($first)
                                &nbsp;&nbsp;&nbsp;MA
                                @php $first = false; @endphp
                                @else
                                - MA
                                @endif
                                @endif                                
                                @if ($horario->miercoles)
                                @if ($first)
                                &nbsp;&nbsp;&nbsp;MI
                                @php $first = false; @endphp
                                @else
                                - MI
                                @endif
                                @endif
                                @if ($horario->jueves)
                                @if ($first)
                                &nbsp;&nbsp;&nbsp;JU
                                @php $first = false; @endphp
                                @else
                                - JU
                                @endif
                                @endif
                                @if ($horario->viernes)
                                @if ($first)
                                &nbsp;&nbsp;&nbsp;VI
                                @php $first = false; @endphp
                                @else
                                - VI
                                @endif
                                @endif
                                @if ($horario->sabado)
                                @if ($first)
                                &nbsp;&nbsp;&nbsp;SA
                                @php $first = false; @endphp
                                @else
                                - SA
                                @endif
                                @endif
                                @if ($horario->domingo)
                                @if ($first)
                                &nbsp;&nbsp;&nbsp;DO
                                @php $first = false; @endphp
                                @else
                                - DO
                                @endif
                                @endif
                              </option>
                              @endif
                              @endforeach
                            </select>
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


          <!-- Botones Inferiores -->
          <div class="d-flex justify-content-between">
            <div class="d-flex justify-content-start">
              <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#agregarModal">Añadir</button>
              <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#agregarHorarios">Agregar Horario</button>
              <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#updateHorarioModal">Modificar horario</button>
              <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#eliminarHorario">Eliminar horario</button>
            </div>
            <a href="{{url('/')}}" class="btn btn-success">Menu principal</a>
          </div>

      

    
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
          
          <script>
            $(document).ready(function() {
              $('#agregarModal').on('show.bs.modal', function() {
                var randomColor = '#'+(Math.random()*0xFFFFFF<<0).toString(16);
                $('#color').val(randomColor);
              });
            });
            </script>
           
           <!-- ANADIR -->
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
                              @if($horario->estado == "C" || $horario->estado == "M")
                              <option value="{{ $horario->id }}">{{ $horario->horarioInicio }} - {{ $horario->horarioFinal }} 
                                @php $first = true; @endphp
                                @if ($horario->lunes)
                                @if ($first)
                                &nbsp;&nbsp;&nbsp;LU
                                @php $first = false; @endphp
                                @else
                                - LU
                                @endif
                                @endif
                                @if ($horario->martes)
                                @if ($first)
                                &nbsp;&nbsp;&nbsp;MA
                                @php $first = false; @endphp
                                @else
                                - MA
                                @endif
                                @endif                                
                                @if ($horario->miercoles)
                                @if ($first)
                                &nbsp;&nbsp;&nbsp;MI
                                @php $first = false; @endphp
                                @else
                                - MI
                                @endif
                                @endif
                                @if ($horario->jueves)
                                @if ($first)
                                &nbsp;&nbsp;&nbsp;JU
                                @php $first = false; @endphp
                                @else
                                - JU
                                @endif
                                @endif
                                @if ($horario->viernes)
                                @if ($first)
                                &nbsp;&nbsp;&nbsp;VI
                                @php $first = false; @endphp
                                @else
                                - VI
                                @endif
                                @endif
                                @if ($horario->sabado)
                                @if ($first)
                                &nbsp;&nbsp;&nbsp;SA
                                @php $first = false; @endphp
                                @else
                                - SA
                                @endif
                                @endif
                                @if ($horario->domingo)
                                @if ($first)
                                &nbsp;&nbsp;&nbsp;DO
                                @php $first = false; @endphp
                                @else
                                - DO
                                @endif
                                @endif
                              </option>
                              @endif
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
<div class="modal fade" id="agregarHorarios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Añadir horarios</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('horarios.add') }}">
          @csrf
          <div class="form row">            
            <div class="form-group col-md-4">
              <label for="horarioInicio">Inicio del horario</label>
              <input type="time" class="form-control" id="horarioInicio" name="horarioInicio" value="{{ '07:00' }}" required>
            </div>
            <div class="form-group col-md-4">
              <label for="horarioFinal">Final del horario</label>
              <input type="time" class="form-control" id="horarioFinal" name="horarioFinal" value="{{ '17:00' }}" required>                      
            </div>
          </div>
          <div class="form-group">
    <label>Dias de la semana</label>
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
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
    <button type="submit" class="btn btn-primary">Guardar</button>
  </div>
</form>
</div>
</div>
</div>
</div>
    <!-- MODAL ELIMINAR HORARIOS -->
    <div class="modal fade" id="eliminarHorario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Añadir horarios</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="{{ route('horarios.destroyHorario', $horario->id) }}" method="POST">
          @csrf
          @method('DELETE')
          <div class="form row">            
          <div class="form-group col-md-12">
                            <label for="horarioInicio">Horarios :</label>
                            <select name="horario_id" class="form-control selectpicker" >
                              @foreach($horarios as $horario)
                              @if($horario->estado == "C" || $horario->estado == "M")
                              <option value="{{ $horario->id }}">{{ $horario->horarioInicio }} - {{ $horario->horarioFinal }} 
                                @php $first = true; @endphp
                                @if ($horario->lunes)
                                @if ($first)
                                &nbsp;&nbsp;&nbsp;LU
                                @php $first = false; @endphp
                                @else
                                - LU
                                @endif
                                @endif
                                @if ($horario->martes)
                                @if ($first)
                                &nbsp;&nbsp;&nbsp;MA
                                @php $first = false; @endphp
                                @else
                                - MA
                                @endif
                                @endif                                
                                @if ($horario->miercoles)
                                @if ($first)
                                &nbsp;&nbsp;&nbsp;MI
                                @php $first = false; @endphp
                                @else
                                - MI
                                @endif
                                @endif
                                @if ($horario->jueves)
                                @if ($first)
                                &nbsp;&nbsp;&nbsp;JU
                                @php $first = false; @endphp
                                @else
                                - JU
                                @endif
                                @endif
                                @if ($horario->viernes)
                                @if ($first)
                                &nbsp;&nbsp;&nbsp;VI
                                @php $first = false; @endphp
                                @else
                                - VI
                                @endif
                                @endif
                                @if ($horario->sabado)
                                @if ($first)
                                &nbsp;&nbsp;&nbsp;SA
                                @php $first = false; @endphp
                                @else
                                - SA
                                @endif
                                @endif
                                @if ($horario->domingo)
                                @if ($first)
                                &nbsp;&nbsp;&nbsp;DO
                                @php $first = false; @endphp
                                @else
                                - DO
                                @endif
                                @endif
                              </option>
                              @endif
                              @endforeach
                            </select>
                          </div>
          </div>
          
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
    <button type="submit" class="btn btn-primary">Eliminar</button>
  </div>
</form>
</div>
</div>
</div>
</div>
@endsection

<!-- Modificar Horarios -->


<!-- Modal with dropdown -->
<div class="modal fade" id="updateHorarioModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Select Horario ID</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <select class="form-control" id="horarioSelect" name="horario_id" onchange="updateCheckbox();updateHorario();">
          <option value="">Select Horario ID</option>
            @foreach($horarioModificacion as $horario)
            <option value="{{ $horario->id }}" data-lunes="{{ $horario->lunes }}" data-martes="{{ $horario->martes }} " data-miercoles="{{ $horario->miercoles }} " data-jueves="{{ $horario->jueves }} " data-viernes="{{ $horario->viernes }} " data-sabado="{{ $horario->sabado }}" data-domingo="{{ $horario->domingo }}" data-horarioinicio="{{ $horario->horarioInicio }}" data-horariofinal="{{ $horario->horarioFinal }}">{{ $horario->id }}</option>
            @endforeach
          </select>
          <br>
          <label for="">Dias de la semana</label>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="lunesCheckbox" name="lunes" value="1" data-checked="{{ $horario->lunes }}">
            <label class="form-check-label" for="lunesCheckbox">Lunes</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="martesCheckbox" name="martes" value="1" data-checked="{{ $horario->martes }}">
            <label class="form-check-label" for="martesCheckbox">Martes</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="miercolesCheckbox" name="miercoles" value="1" data-checked="{{ $horario->miercoles }}">
            <label class="form-check-label" for="miercolesCheckbox">Miercoles</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="juevesCheckbox" name="jueves" value="1" data-checked="{{ $horario->jueves }}">
            <label class="form-check-label" for="juevesCheckbox">Jueves</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="viernesCheckbox" name="viernes" value="1" data-checked="{{ $horario->viernes }}">
            <label class="form-check-label" for="viernesCheckbox">Viernes</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="sabadoCheckbox" name="sabado" value="1" data-checked="{{ $horario->sabado }}">
            <label class="form-check-label" for="sabadoCheckbox">Sabado</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="domingoCheckbox" name="domingo" value="1" data-checked="{{ $horario->domingo }}">
            <label class="form-check-label" for="domingoCheckbox">Domingo</label>
          </div>
          <div class="form-group col-md-4">
            <label for="horarioInicio">Inicio del horario</label>
            <input type="time" class="form-control" id="horarioInicio" name="horarioInicio" required>
          </div>
          <div class="form-group col-md-4">
            <label for="horarioFinal">Final del horario</label>
            <input type="time" class="form-control" id="horarioFinal" name="horarioFinal" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary"  data-bs-dismiss="modal">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script>
function updateCheckbox() {
  var selectedOption = document.getElementById("horarioSelect").selectedOptions[0];
  var lunesValue = selectedOption.getAttribute("data-lunes");
  document.getElementById("lunesCheckbox").checked = (lunesValue == 1);
  var martesValue = selectedOption.getAttribute("data-martes");
  document.getElementById("martesCheckbox").checked = (martesValue == 1);
  var miercolesValue = selectedOption.getAttribute("data-miercoles");
  document.getElementById("miercolesCheckbox").checked = (miercolesValue == 1);
  var juevesValue = selectedOption.getAttribute("data-jueves");
  document.getElementById("juevesCheckbox").checked = (juevesValue == 1);
  var viernesValue = selectedOption.getAttribute("data-viernes");
  document.getElementById("viernesCheckbox").checked = (viernesValue == 1);
  var sabadoValue = selectedOption.getAttribute("data-sabado");
  document.getElementById("sabadoCheckbox").checked = (sabadoValue == 1);
  var domingoValue = selectedOption.getAttribute("data-domingo");
  document.getElementById("domingoCheckbox").checked = (domingoValue == 1);
 

}
function updateHorario() {
  var selectedOption = document.getElementById("horarioSelect").options[document.getElementById("horarioSelect").selectedIndex];
  var horarioInicio = selectedOption.getAttribute("data-horarioinicio");
  var horarioFinal = selectedOption.getAttribute("data-horariofinal");
  document.getElementById("horarioInicio").value = horarioInicio;
  document.getElementById("horarioFinal").value = horarioFinal;
}
</script>



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