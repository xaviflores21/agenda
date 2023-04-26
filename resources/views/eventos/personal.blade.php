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
            <th>color</th>
            <th>Inicio del horario</th>
            <th>Final del horario</th>
            <th>Dias de la semana</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($personas as $personas)
    @if($personas->estado=="C"||$personas->estado=="M")
    <tr>
        
        <td>{{ $personas->nombreCompleto }}</td>
        <td>{{ $personas->color }}</td>
        <td>{{ date('H:i', strtotime($personas->horarioInicio)) }}</td>
        <td>{{ date('H:i', strtotime($personas->horarioFinal)) }}</td>
        <td>{{$personas->dias}}</td>
        <td>
        <button class="btn btn-primary" id="submitButton" data-bs-toggle="modal" data-bs-target="#editModal{{$personas->id}}" data-id="{{ $personas->id }}" data-nombre="{{ $personas->nombreCompleto }}" data-color="{{ $personas->color }}" data-horarioinicio="{{ $personas->horarioInicio }}" data-horariofinal="{{ $personas->horarioFinal }}">Modificar</button>
            <form action="{{ route('personas.destroy', $personas->id) }}" method="POST" style="display: inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Borrar</button>
            </form>
        </td>
    </tr>
    

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal{{$personas->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modificar</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
    <div class="modal-body">
    <form id="editForm{{$personas->id}}" action="{{ route('personas.update', $personas->id) }}" method="POST">
    @csrf
    @method('PATCH')
    <div class="form-group">
        <label for="nombre{{$personas->id}}">Nombre Encargada</label>
        <input type="text" class="form-control" id="nombre{{$personas->id}}" name="nombreCompleto" value="{{ $personas->nombreCompleto }}">
    </div>
    <div class="form row">
    <div class="form-group col-md-4">
        <label for="color{{$personas->id}}">Color</label>
        <input type="color" class="form-control" id="color{{$personas->id}}" name="color" value="{{ $personas->color }}">
    </div>
    <div class="form-group col-md-4">
        <label for="horarioInicio{{$personas->id}}">Inicio del horario</label>
        <input type="time" class="form-control" id="horarioInicio{{$personas->id}}" name="horarioInicio" value="{{ $personas->horarioInicio }}">
    </div>
    <div class="form-group col-md-4">
        <label for="horarioFinal{{$personas->id}}">Final del horario</label>
        <input type="time" class="form-control" id="horarioFinal{{$personas->id}}" name="horarioFinal" value="{{ $personas->horarioFinal }}">
    </div>
    </div>
    <div class="form-group">
        <label for="dias{{$personas->id}}">Dias de la semana</label>
        <br>
        <input type="checkbox" id="lu{{$personas->id}}" name="dias[]" value="LU" @if(in_array('LU', explode(',', $personas->dias))) checked @endif>
        <label for="lu{{$personas->id}}">Lunes</label>
        <br>
        <input type="checkbox" id="ma{{$personas->id}}" name="dias[]" value="MA" @if(in_array('MA', explode(',', $personas->dias))) checked @endif>
        <label for="ma{{$personas->id}}">Martes</label>
        <br>
        <input type="checkbox" id="mi{{$personas->id}}" name="dias[]" value="MI" @if(in_array('MI', explode(',', $personas->dias))) checked @endif>
        <label for="mi{{$personas->id}}">Miércoles</label>
        <br>
        <input type="checkbox" id="ju{{$personas->id}}" name="dias[]" value="JU" @if(in_array('JU', explode(',', $personas->dias))) checked @endif>
        <label for="ju{{$personas->id}}">Jueves</label>
        <br>
        <input type="checkbox" id="vi{{$personas->id}}" name="dias[]" value="VI" @if(in_array('VI', explode(',', $personas->dias))) checked @endif>
        <label for="vi{{$personas->id}}">Viernes</label>
        <br>
        <input type="checkbox" id="sa{{$personas->id}}" name="dias[]" value="SA" @if(in_array('SA', explode(',', $personas->dias))) checked @endif>
        <label for="sa{{$personas->id}}">Sabado</label>
        <br>
        <input type="checkbox" id="sa{{$personas->id}}" name="dias[]" value="SA" @if(in_array('DO', explode(',', $personas->dias))) checked @endif>
        <label for="sa{{$personas->id}}">Domingo</label>
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
    
    @endif
    @endforeach
    
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

    </tbody>
</table>

<button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#agregarModal">Añadir</button>

<!-- Add Modal -->
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
          <div class="form-group">
            <label for="nombre">Nombre Encargada</label>
            <input type="text" class="form-control" id="nombre" name="nombreCompleto">
          </div>
          <div class="form-group">
            <label for="color">Color</label>
            <input type="color" class="form-control" id="color" name="color">
          </div>
          <div class="form-group">
            <label for="horarioInicio">Inicio del horario</label>
            <input type="time" class="form-control" id="horarioInicio" name="horarioInicio">
          </div>
          <div class="form-group">
            <label for="horarioFinal">Final del horario</label>
            <input type="time" class="form-control" id="horarioFinal" name="horarioFinal">
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
