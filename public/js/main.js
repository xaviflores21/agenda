document.addEventListener("DOMContentLoaded", function () {
    var calendarEl = document.getElementById("calendar");
    var calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: ["dayGrid", "interaction", "timeGrid", "list"],
        firstDay: 1,
        //defaultView:'timeGridDay-'   Alternador de modelos calendario

        header: {
            left: "prev,next today Miboton",
            center: "title",
            right: "dayGridMonth,timeGridWeek,timeGridDay",
        },
        buttonText: {
            today: "Dia Actual",
            day: "Dia",
            week: "Semana",
            month: "Mes",
        },
        customButtons: {
            Miboton: {
                text: "Horarios",
                click: function () {
                    console.log("PRUEBAS");
                    window.location.href = routes["horarios"];
                },
            },
        },
        dateClick: function (info) {
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
        events: url_show,
        eventRender: function (info) {
            // Access the event object and retrieve the additional field
            var event = info.event;
            var description = event.extendedProps.habitacion;
            if (description === null) {
                description = 0;
            }

            // Create a new span element to display the additional information in bold
            var descriptionElement = document.createElement("span");
            descriptionElement.innerHTML =
                "<strong> Hab: </strong>" + description;
            // Append the new element to the event element
            info.el.querySelector(".fc-title").appendChild(descriptionElement);
            /* Para append datos en el contenedor inferior de title solo cambiar el .fc-title por container o algo parecido
           info.el.querySelector('.fc-content').appendChild(descriptionElement);
          }
    */

            //TOOLTIPS

            var element = info.el;
            var event = info.event;

            // Add a custom attribute to the event element to store additional information
            $(element).attr(
                "data-info",
                "Cliente: " +
                    event.extendedProps.cliente +
                    ", Telefono: " +
                    event.extendedProps.telefono
            );

            // Add a tooltip to display the additional information when the user hovers over the event
            $(element).tooltip({
                title: $(element).attr("data-info"),
                placement: "top",
                trigger: "hover",
                container: "body",
            });
        },
        //
    });
    calendar.setOption("locale", "Es");
    calendar.render();

    $("#btnAgregar").click(function () {
        ObjEvento = recolectarDatosGUI("POST");
        EnviarInformacion("", ObjEvento)
            .then(function (objEventoReporte) {
                console.log(
                    "Generated IDSgeunda: " + JSON.stringify(objEventoReporte)
                );
                // Do something with the generated ID
                EnviarReporteInformacion(objEventoReporte, "C")
                    .then(function (response) {
                        console.log("Generated ID: ", response.id);
                        // Do something with the generated ID
                    })
                    .catch(function (error) {
                        console.log("Error occurred: ", error);
                    });
            })
            .catch(function () {
                console.log("Error occurred");
            });
    });

    $("#btnEliminar").click(function () {
        ObjEvento = recolectarDatosGUI("DELETE");
        EnviarInformacion("/" + $("#txtID").val(), ObjEvento);
        estado = "E";
        EnviarReporteInformacion(ObjEvento, estado);
    });

    $("#btnModificar").click(function () {
        ObjEvento = recolectarDatosGUI("PATCH");
        EnviarInformacion("/" + $("#txtID").val(), ObjEvento);
        estado = "M";
        EnviarReporteInformacion(ObjEvento, estado);
    });

    $("#btnCancelar").click(function () {
        ObjEvento = recolectarDatosGUI("PATCH");
        ObjEvento.color = "#ff0000";
        EnviarInformacion("/" + $("#txtID").val(), ObjEvento);
        estado = "M";
        EnviarReporteInformacion(ObjEvento, estado);
    });

    function recolectarDatosGUI(method) {
        let endValue = $("#txtHoraEventoTerminado").val();
        if (endValue == null || endValue == "00:00") {
            endValue = $("#txtHora").val();
        }
        nuevoEvento = {
            id: $("#txtID").val(),
            title: $("#txtTitle").val(),
            cliente: $("#txtCliente").val(),
            habitacion: $("#txtHabitacion").val(),
            telefono: $("#txtTelefono").val(),
            servicio: $("#txtServicio").val(),
            color: $("#txtColor").val(),
            estado: "C",
            textColor: "#FFFFFF",
            start: $("#txtFecha").val() + " " + $("#txtHora").val(),
            end: $("#txtFecha").val() + " " + endValue,
            _token: $("meta[name='csrf-token']").attr("content"),
            _method: method,
        };
        return nuevoEvento;
    }

    function EnviarInformacion(accion, objEvento) {
        return new Promise(function (resolve, reject) {
            $.ajax({
                type: "POST",
                url: url_eventos + accion,
                data: objEvento,
                success: function (msg) {
                    console.log(msg);
                    $("#exampleModal").modal("toggle");
                    calendar.refetchEvents();
                    console.log("EVENTO OBJEC:" + objEvento._method);
                    var responseObj = Object.assign({}, objEvento, {
                        id: msg.id,
                    });
                    resolve(responseObj); // resolve the generated ID
                },
                error: function () {
                    reject();
                },
            });
        });
    }
    function EnviarReporteInformacion(objEvento, estado) {
        console.log("Aqui estan las 11");
        return new Promise(function (resolve, reject) {
            $.ajax({
                type: "POST",
                url: url_reporte_enviar,
                data: {
                    _token: tokenEnviar,
                    objEvento: objEvento,
                    estado: estado,
                },
                success: function (msg) {
                    console.log("Success reporte: ", msg);
                    resolve(msg); // resolve with the server response
                },
                error: function (xhr, status, error) {
                    console.error("Error reporte: ", error);
                    reject(error); // reject with the error message
                },
            });
        });
    }

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
});
console.log("Ejecutando desde el main.js");
