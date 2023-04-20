@extends('layouts.app')

@section('scripts')
<script
  src="https://code.jquery.com/jquery-3.6.4.js"
  integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
  crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
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
</script>

<!-- <script src="{{asset('js/main.js')}}" defer></script> -->
<script>
    document.addEventListener('DOMContentLoaded',function(){
    var calendarEl=document.getElementById('calendar');
    var calendar=new FullCalendar.Calendar(calendarEl,{
      
        plugins:['dayGrid','interaction','timeGrid','list'],
        
        //defaultView:'timeGridDay-'   Alternador de modelos calendario

        header:{
            left:'prev,next today Miboton',
            center:'title',
            right:'dayGridMonth,timeGridWeek,timeGridDay'
        },
        buttonText: {
            today: 'hoy',
            day: 'Dia',
            week:'Semana',
             month:'Mes'
        },
        customButtons:{
            Miboton:{
                text:"Agregar Evento",
                click:function(){
                    $('#exampleModal').modal('show')
                }
            }
        },
        dateClick:function(info){
            limpiarFormulario();
            $('#txtFecha').val(info.dateStr);      
            $("#btnAgregar").prop("disabled",false);
            $("#btnModificar").prop("disabled",true);
            $("#btnEliminar").prop("disabled",true);
            $('#exampleModal').modal('show')
        },
        eventClick:function(info){
            $("#btnAgregar").prop("disabled",true);
            $("#btnModificar").prop("disabled",false);
            $("#btnEliminar").prop("disabled",false);
            $('#txtID').val(info.event.id),
            $('#txtTitle').val(info.event.title),
            $('#txtCliente').val(info.event.extendedProps.cliente),
            $('#txtHabitacion').val(info.event.extendedProps.habitacion),

            mes =(info.event.start.getMonth()+1);
            dia=(info.event.start.getDate());
            anio=(info.event.start.getFullYear());
            
            mes=(mes<10)?"0"+mes:mes;
            dia=(dia<10)?"0"+dia:dia;

            minutos=info.event.start.getMinutes();
            hora=info.event.start.getHours();

            minutos=(minutos<10)?"0"+minutos:minutos;
            hora=(hora<10)?"0"+hora:hora;

            horario=(hora+":"+minutos);

            $('#txtFecha').val(anio+"-"+mes+"-"+dia),
            $('#txtHora').val(horario),
            $('#txtColor').val(info.event.backgroundColor),

            $('#txtServicio').val(info.event.extendedProps.servicio),

            $('#exampleModal').modal('show')
        }, 
        events:url_show,
        
        
        //"{{url('/eventos/show')}}"

    });
    calendar.setOption('locale','Es')
    calendar.render();
    

    $('#btnAgregar').click(function(){
        ObjEvento=recolectarDatosGUI("POST");
        EnviarInformacion('', ObjEvento)
    .then(function(objEventoReporte) {
        console.log("Generated IDSgeunda: " + JSON.stringify(objEventoReporte));
    // Do something with the generated ID
    EnviarReporteInformacion(objEventoReporte, 'C')
  .then(function(response) {
    console.log("Generated ID: ", response.id);
    // Do something with the generated ID
  })
  .catch(function(error) {
    console.log("Error occurred: ", error);
  });
  })
  .catch(function() {
    console.log("Error occurred");
  });
      
       
    });

    $('#btnEliminar').click(function(){
        ObjEvento=recolectarDatosGUI("DELETE");
        EnviarInformacion('/'+$('#txtID').val(),ObjEvento);
        estado="E";
        EnviarReporteInformacion(ObjEvento,estado)
    });

    $('#btnModificar').click(function(){
        ObjEvento=recolectarDatosGUI("PATCH");
        EnviarInformacion('/'+$('#txtID').val(),ObjEvento);
        estado="M";
        EnviarReporteInformacion(ObjEvento,estado)
    });

    function recolectarDatosGUI(method){
        nuevoEvento={
            id:$('#txtID').val(),
            title:$('#txtTitle').val(),
            cliente:$('#txtCliente').val(),
            habitacion:$('#txtHabitacion').val(),
            servicio:$('#txtServicio').val(),
            color:$('#txtColor').val(),
            estado:'C',
            textColor:'#FFFFFF',
            start:$('#txtFecha').val()+" "+$('#txtHora').val(),
            end:$('#txtFecha').val()+" "+$('#txtHora').val(),
            '_token':$("meta[name='csrf-token']").attr("content"),
            '_method':method
        }
        return(nuevoEvento)
        
    }

    function EnviarInformacion(accion,objEvento){
  return new Promise(function(resolve, reject) {
    $.ajax({
      type:"POST",
      url:url_eventos+accion,
      data:objEvento,
      success:function(msg){
        console.log(msg);
        $('#exampleModal').modal('toggle'); 
        calendar.refetchEvents( );
        console.log("EVENTO OBJEC:" + objEvento._method );
        var responseObj = Object.assign({}, objEvento, {id:msg.id});
        resolve(responseObj); // resolve the generated ID
      },
      error:function(){reject();}
    });
  });
}
function EnviarReporteInformacion(objEvento, estado) {
  return new Promise(function(resolve, reject) {
    $.ajax({
      type: "POST",
      url: "{{ route('reporte.enviar') }}",
      data: {
        '_token': '{{ csrf_token() }}',
        'objEvento': objEvento,
        'estado': estado
      },
      success: function(msg) {
        console.log("Success reporte: ", msg);
        resolve(msg); // resolve with the server response
      },
      error: function(xhr, status, error) {
        console.error("Error reporte: ", error);
        reject(error); // reject with the error message
      }
    });
  });
}

    function limpiarFormulario(){
            $('#txtID').val(""),
            $('#txtTitle').val(""),
            $('#txtCliente').val(""),
            $('#txtHabitacion').val(""),
            $('#txtFecha').val(""),
            $('#txtHora').val("07:00"),
            $('#txtColor').val(""),
            $('#txtServicio').val("");
    }
    console.log("{{url('/eventos')}}")
})</script>
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
            <div class="form-group col-md-8">
            <label for="exampleDataList" class="form-label">Encargada</label>
            <input class="form-control" list="datalistOptions" id="txtTitle" name="txtTitle" placeholder="Seleccione persona a cargo...">
                <datalist id="datalistOptions">
                @foreach($personas as $personas)
                 
                <option value="{{$personas->nombreCompleto}}" data-color="{{$personas->color}}">
        
                @endforeach
                </datalist>
            </div>
            
            <div class="form-group col-md-4">
                <label>
                    Hora:
                </label>
                <input type="time" min="07:00" max="23:00" steps="600" class="form-control" name="txtHora" id="txtHora">
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
          
            <div class="form-group col-md-12">
                <label>
                    Color:
                </label>
                
                <input type="color" class="form-control" name="txtColor" id="txtColor">
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
        @if(Auth::user()->role=='admin')
        <button id="btnEliminar" class="btn btn-danger">Borrar</button>
        @endif
        
        <button id="btnCancelar" data-bs-dismiss="modal" class="btn btn-default">Cancelar</button>
      
        </div>
      </div>
    </div>
  </div>
@endsection