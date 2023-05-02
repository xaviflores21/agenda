@extends('layouts.app')

@section('scripts')
<script
  src="https://code.jquery.com/jquery-3.6.4.js"
  integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
  crossorigin="anonymous"></script>

<!-- Libreria moment -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<!--<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>-->

<link rel="stylesheet" href="{{asset('fullcalendar/core/main.css')}}">
<link rel="stylesheet" href="{{asset('fullcalendar/daygrid/main.css')}}">
<link rel="stylesheet" href="{{asset('fullcalendar/list/main.css')}}">
<link rel="stylesheet" href="{{asset('fullcalendar/timegrid/main.css')}}">

<script src="{{asset('fullcalendar/core/main.js')}}" defer></script>
<script src="{{asset('fullcalendar/interaction/main.js')}}" defer></script>
<script src="{{asset('fullcalendar/daygrid/main.js')}}" defer></script>
<script src="{{asset('fullcalendar/list/main.js')}}" defer></script>
<script src="{{asset('fullcalendar/timegrid/main.js')}}" defer></script>

<script>
    let url_eventos="{{url('/eventos')}}";
    let url_reporte="{{url('/reporte')}}";
    let url_show="{{url('/eventos/show')}}";
    let url_reporte_enviar="{{ route('reporte.enviar') }}"
    var routes = {
        'horarios': '{{ route("horarios") }}',
        'reporteEnviar':'{{ route("reporte.enviar") }}',
        // add other route URLs here
    };
    let tokenEnviar="{{ csrf_token() }}";
</script>

<!-- LLamando al SCRIPT CALENDAR -->

<script src="{{asset('js/main.js')}}" defer></script>

@endsection
@section('content')
<div class="row">
<div class="col"></div>
<div class="col-11"><div id="calendar"></div></div>
<div class="col"></div>
</div>
 <!-- Modal -->
 <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Registrar Eventos</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="d-none">
            ID:
          <input type="text" name="txtID" id="txtID">
          <br>
          FECHA:
          <input type="text" name="txtFecha" id="txtFecha">
          <br>
          </div>
            
          <div class="form-row">
            <div class="form-group col-md-6">
            <label for="exampleDataList" class="form-label">Encargada</label>
            <input class="form-control" list="datalistOptions" id="txtTitle" name="txtTitle" placeholder="Seleccione persona a cargo...">
                <datalist id="datalistOptions">
                
                @foreach($personas as $personas)
                @if($personas->estado == 'C' || $personas->estado == 'M')
                    <option value="{{ $personas->nombreCompleto }}" data-color="{{ $personas->color }}">
                @endif
                @endforeach

                </datalist>
            </div>
            
            <div class="form-group col-md-3">
                <label>
                    Hora:
                </label>
                <input type="time" min="07:00" max="23:00" steps="600" class="form-control" name="txtHora" id="txtHora">
            </div>
            <div class="form-group col-md-3">
                <label>
                    Terminado:
                </label>
                <input type="time" min="07:00" max="23:00" steps="600" class="form-control" name="txtHoraEventoTerminado" id="txtHoraEventoTerminado">
            </div>
            <div class="form-group col-md-9">
                <label>
                    Cliente:
                </label>
                <input type="text" class="form-control" name="txtCliente" id="txtCliente">
            </div>
            <div class="form-group col-md-3">
                <label>
                    Habitacion:
                </label>
                <input type="text" class="form-control" name="txtHabitacion" id="txtHabitacion">
            </div>
            <div class="form-group col-md-12">
                <label>
                    Servicio:
                </label>
                <textarea name="txtServicio" class="form-control" id="txtServicio" cols="30" rows="3"></textarea>
            </div>
          
            <div class="form-group col-md-3">
                <label>
                    Color:
                </label>
                
                <input type="color" class="form-control" name="txtColor" id="txtColor">
            </div>
            <div class="form-group col-md-9">
                <label>
                    Telefono:
                </label>
                <input type="text" class="form-control" name="txtTelefono" id="txtTelefono">
            </div>
            <script>// Get the txtTitle and txtColor inputs
                var txtTitle = document.getElementById('txtTitle');
                var txtColor = document.getElementById('txtColor');

                // Add an event listener to the txtTitle input
                txtTitle.addEventListener('change', function() {
                // Get the selected option from the datalist
                var selectedOption = document.querySelector('#datalistOptions option[value="' + this.value + '"]');

                // Set the color value of the selected option to the txtColor input
                if (selectedOption) {
                    txtColor.value = selectedOption.dataset.color;
                }
                });
            </script>
       
          
          </div>
          
        </div>
        <div class="modal-footer">
        <button id="btnAgregar" class="btn btn-success">Agregar</button>
        <button id="btnModificar" class="btn btn-warning">Modificar</button>
        @if(in_array(Auth::user()->role, ['admin', 'Jefe de area']))
        <button id="btnEliminar" class="btn btn-danger">Borrar</button>
        @endif
        
        <button id="btnCancelar" data-bs-dismiss="modal" class="btn btn-default">Cancelar</button>
      
        </div>
      </div>
    </div>
  </div>
@endsection