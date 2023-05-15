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
    let url_show="{{url('/personal/mostrarEventos')}}";
    let url_menuPrincipal="{{url('/')}}";
   
</script>

<!-- LLamando al SCRIPT CALENDAR -->
<script>document.addEventListener("DOMContentLoaded", function () {
    var calendarEl = document.getElementById("calendar");
    var calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: ["dayGrid", "interaction", "timeGrid", "list"],
        firstDay: 1,
        defaultView:'timeGridWeek',   //Alternador de modelos calendario

        header: {
            left: "prev,next today Miboton",
            center: "title",
            right: "timeGridWeek,timeGridDay",
        },
        buttonText: {
            today: "Dia Actual",
            day: "Dia",
            week: "Semana",
            month: "Mes",
        },
        customButtons: {
            Miboton: {
                text: "Menu Principal",
                //Puedo agregar algo nuevo
                click: function () {
                    window.location.href = url_menuPrincipal;
                },
            },
          
        },
        dateClick: function (info) {
            console.log(info.event)
            if (
                info.view.type === "timeGridWeek" ||
                info.view.type === "timeGridDay"
            ) {
                // Parse the date string using moment
                var momentDate = moment(info.date);
                var hour = momentDate.hour(); // Get the hour (0-23)
                var minutes = momentDate.minutes(); // Get the minutes (0-59)
                var timeStr =
                    hour.toString().padStart(2, "0") +
                    ":" +
                    minutes.toString().padStart(2, "0");
                // Outputs "07:00" for April 21st 2023 at 7:00 AM

                var momentDate = moment(info.dateStr);

                // Format the date string as "YYYY-MM-DDTHH:mm:ss"
                var formattedDate = momentDate.format("YYYY-MM-DD");

                // Set the dateStr value to the formatted date string
                info.dateStr = formattedDate;
            }
            limpiarFormulario();
            $("#txtFecha").val(info.dateStr);
            $("#btnAgregar").prop("disabled", false);
            $("#btnModificar").prop("disabled", true);
            $("#btnEliminar").prop("disabled", true);
            $("#exampleModal").modal("show");
            if (typeof timeStr === "undefined") {
                $("#txtHora").val("07:00");
            } else {
                $("#txtHora").val(timeStr);
            }
        },
        eventClick: function (info) {
            console.log(info)
            $("#btnAgregar").prop("disabled", true);
            $("#btnModificar").prop("disabled", false);
            $("#btnEliminar").prop("disabled", false);
            $("#txtID").val(info.event.id),
                $("#txtTitle").val(info.event.title),
                $("#txtCliente").val(info.event.extendedProps.cliente),
                $("#txtHabitacion").val(info.event.extendedProps.habitacion),
                $("#txtTelefono").val(info.event.extendedProps.telefono),
                (mes = info.event.start.getMonth() + 1);
            dia = info.event.start.getDate();
            anio = info.event.start.getFullYear();

            mes = mes < 10 ? "0" + mes : mes;
            dia = dia < 10 ? "0" + dia : dia;

            minutos = info.event.start.getMinutes();
            hora = info.event.start.getHours();

            minutos = minutos < 10 ? "0" + minutos : minutos;
            hora = hora < 10 ? "0" + hora : hora;
            horario = hora + ":" + minutos;

            if (info.event.end) {
                horaEnd =
                    info.event.end.getHours() < 10
                        ? "0" + info.event.end.getHours()
                        : info.event.end.getHours();
                minutosEnd =
                    info.event.end.getMinutes() < 10
                        ? "0" + info.event.end.getMinutes()
                        : info.event.end.getMinutes();
                horarioEnd =
                    info.event.end.getHours() +
                    ":" +
                    info.event.end.getMinutes();
            } else {
                horaEnd = hora;
                minutosEnd = minutos;
                horarioEnd = horario;
            }
            console.log(horarioEnd);
            $("#txtFecha").val(anio + "-" + mes + "-" + dia),
                $("#txtHora").val(horario),
                $("#txtHoraEventoTerminado").val(horaEnd + ":" + minutosEnd),
                $("#txtColor").val(info.event.backgroundColor),
                $("#txtServicio").val(info.event.extendedProps.servicio),
                $("#exampleModal").modal("show");
        },
        events:url_show  ,
        eventRender: function (info) {
  // Access the event object and retrieve the additional field
  // TOOLTIPS
  var event = info.event;

  // Create a new span element to wrap the fc-title contents and apply rotation
  var titleWrapper = document.createElement("span");
  titleWrapper.style.writingMode = "vertical-lr";
  titleWrapper.style.transform = "rotate(180deg)";
  titleWrapper.style.display = "inline-block";
  titleWrapper.style.marginTop = "10px";

  // Clone the fc-title element and append it to the wrapper
  var titleElement = info.el.querySelector(".fc-title").cloneNode(true);
  titleElement.style.fontWeight = "bold";
  titleElement.style.fontSize = "larger";
  titleWrapper.appendChild(titleElement);

  // Clear the existing contents of fc-title
  info.el.querySelector(".fc-title").innerHTML = "";

  // Append the wrapper with the rotated title to the event element
  info.el.querySelector(".fc-title").appendChild(titleWrapper);

  // Remove start and end time from rendering
  var timeElement = info.el.querySelector('.fc-time');
      if (timeElement) {
        timeElement.remove();
      }

  // ... Rest of your code
},


        //
    });
   

    

    function limpiarFormulario() {
        $("#txtID").val(""),
            $("#txtTitle").val(""),
            $("#txtCliente").val(""),
            $("#txtHabitacion").val(""),
            $("#txtHoraEventoTerminado").val("--:--"),
            $("#txtFecha").val(""),
            $("#txtHora").val("07:00"),
            $("#txtColor").val(""),
            $("#txtServicio").val(""),
            $("#txtTelefono").val("");
    }
    console.log("{{url('/eventos')}}");
    calendar.setOption("locale", "Es");
    calendar.render();

});
console.log("Ejecutando desde el main.js");
</script>

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