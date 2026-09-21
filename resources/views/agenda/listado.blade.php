@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <div>
                <h4 class="mb-0">
                    <i class="fas fa-calendar-alt"></i>
                    Agenda
                </h4>

                <small class="text-muted">
                    Administración de citas y actividades
                </small>
            </div>

            <button type="button" class="btn btn-primary" id="btnNuevaAgenda">
                <i class="fas fa-plus"></i>
                Nueva cita
            </button>

        </div>

        <div class="card-body">

            <div id="calendar"></div>

        </div>

    </div>

</div>

@include('agenda.components.modal')

@endsection
@section('js')

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

    const calendarEl = document.getElementById('calendar');

    const calendar = new FullCalendar.Calendar(calendarEl, {

        initialView: 'dayGridMonth',
        locale: 'es',
        firstDay: 1,
        height: 'auto',
        selectable: true,
        editable: true,
        nowIndicator: true,
        dayMaxEvents: true,

        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },

        buttonText: {
            today: 'Hoy',
            month: 'Mes',
            week: 'Semana',
            day: 'Día',
            list: 'Lista'
        },
        // ========================================================
        // CARGAR EVENTOS DESDE LARAVEL
        // ========================================================

        events: {
            url: "{{ route('agenda.eventos') }}",
            method: "GET",

            failure: function() {

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudieron cargar las citas.'
                });

            }
        },


        // ========================================================
        // CLICK EN UNA FECHA
        // ========================================================

        dateClick: function(info) {

            limpiarFormularioAgenda();

            $('#tituloModal').text('Nueva cita');

            let fecha = info.dateStr.substring(0, 10);

            $('#fecha_inicio').val(fecha + 'T08:00');

            $('#fecha_fin').val(fecha + 'T09:00');

            $('#modalAgenda').modal('show');
        },


        // ========================================================
        // CLICK EN UN EVENTO
        // ========================================================

        eventClick: function(info) {

            const evento = info.event;

            const datos = evento.extendedProps;

            $('#agenda_id').val(evento.id);

            $('#titulo').val(evento.title);

            $('#estado').val(
                datos.estado ?? 'PENDIENTE'
            );

            $('#cliente_id').val(
                datos.cliente_id ?? ''
            );

            $('#usuario_asignado_id').val(
                datos.usuario_asignado_id ?? ''
            );

            $('#sucursal_id').val(
                datos.sucursal_id ?? ''
            );

            $('#descripcion').val(
                datos.descripcion ?? ''
            );

            $('#observacion').val(
                datos.observacion ?? ''
            );

            $('#color').val(
                datos.color ?? '#3788d8'
            );


            // FECHA INICIO
            if (evento.start) {

                $('#fecha_inicio').val(
                    fechaInput(evento.start)
                );

            } else {

                $('#fecha_inicio').val('');

            }


            // FECHA FIN
            if (evento.end) {

                $('#fecha_fin').val(
                    fechaInput(evento.end)
                );

            } else {

                $('#fecha_fin').val('');

            }


            $('#tituloModal').text(
                'Editar cita'
            );

            $('#btnEliminar').removeClass('d-none');

            $('#modalAgenda').modal('show');
        },

        // ========================================================
        // ARRASTRAR EVENTO
        // ========================================================

        eventDrop: function(info) {
            moverEvento(info);
        },


        // ========================================================
        // CAMBIAR DURACIÓN
        // ========================================================

        eventResize: function(info) {
            moverEvento(info);
        }


    });

    calendar.render();

    // ==========================================
    // BOTÓN NUEVA CITA
    // ==========================================
    $('#btnNuevaAgenda').on('click', function () {
        limpiarFormularioAgenda();
        $('#tituloModal').text('Nueva cita');
        $('#btnEliminar').addClass('d-none');
        $('#modalAgenda').modal('show');
    });


    // ============================================================
    // GUARDAR / MODIFICAR
    // ============================================================

    $('#btnGuardar').on('click', function () {

        let titulo = $('#titulo').val();

        let fechaInicio = $('#fecha_inicio').val();


        // VALIDACIÓN
        if (!titulo) {

            Swal.fire({
                icon: 'warning',
                title: 'Atención',
                text: 'Debe ingresar el título de la cita.'
            });

            $('#titulo').focus();

            return;
        }


        if (!fechaInicio) {

            Swal.fire({
                icon: 'warning',
                title: 'Atención',
                text: 'Debe seleccionar la fecha y hora de inicio.'
            });

            return;
        }


        // DESHABILITAR BOTÓN
        $('#btnGuardar')
            .prop('disabled', true)
            .html(
                '<i class="fas fa-spinner fa-spin"></i> Guardando...'
            );


        let datos = {

            _token: "{{ csrf_token() }}",

            agenda_id: $('#agenda_id').val(),

            titulo: $('#titulo').val(),

            estado: $('#estado').val(),

            fecha_inicio: $('#fecha_inicio').val(),

            fecha_fin: $('#fecha_fin').val(),

            cliente_id: $('#cliente_id').val(),

            usuario_asignado_id:
                $('#usuario_asignado_id').val(),

            sucursal_id:
                $('#sucursal_id').val(),

            color: $('#color').val(),

            descripcion:
                $('#descripcion').val(),

            observacion:
                $('#observacion').val()
        };


        $.ajax({

            url: "{{ route('agenda.guardar') }}",

            type: "POST",

            data: datos,

            success: function(response) {

                $('#modalAgenda').modal('hide');

                calendar.refetchEvents();


                Swal.fire({

                    icon: 'success',

                    title: 'Correcto',

                    text: response.mensaje,

                    timer: 1500,

                    showConfirmButton: false

                });

            },

            error: function(xhr) {

                console.log(xhr.responseText);


                let mensaje =
                    'Ocurrió un error al guardar la cita.';


                // ERRORES DE VALIDACIÓN LARAVEL
                if (xhr.status === 422) {

                    let errores =
                        xhr.responseJSON.errors;

                    let mensajes = [];


                    $.each(
                        errores,
                        function(campo, error) {

                            mensajes.push(
                                error[0]
                            );

                        }
                    );


                    mensaje =
                        mensajes.join('<br>');

                } else if (
                    xhr.responseJSON &&
                    xhr.responseJSON.message
                ) {

                    mensaje =
                        xhr.responseJSON.message;

                }


                Swal.fire({

                    icon: 'error',

                    title: 'Error',

                    html: mensaje

                });

            },

            complete: function() {

                $('#btnGuardar')
                    .prop('disabled', false)
                    .html(
                        '<i class="fas fa-save"></i> Guardar'
                    );

            }

        });

    });



    // ============================================================
    // ELIMINAR
    // ============================================================

    $('#btnEliminar').on('click', function () {

        let agendaId =
            $('#agenda_id').val();


        if (!agendaId) {

            return;

        }


        Swal.fire({

            title: '¿Eliminar cita?',

            text: 'Esta acción eliminará la cita seleccionada.',

            icon: 'warning',

            showCancelButton: true,

            confirmButtonText: 'Sí, eliminar',

            cancelButtonText: 'Cancelar'

        }).then((result) => {

            if (!result.isConfirmed) {

                return;

            }


            $.ajax({

                url: "{{ route('agenda.eliminar') }}",

                type: "POST",

                data: {

                    _token:
                        "{{ csrf_token() }}",

                    agenda_id:
                        agendaId

                },

                success: function(response) {

                    $('#modalAgenda')
                        .modal('hide');


                    calendar
                        .refetchEvents();


                    Swal.fire({

                        icon: 'success',

                        title: 'Eliminado',

                        text:
                            response.mensaje,

                        timer: 1500,

                        showConfirmButton:
                            false

                    });

                },

                error: function(xhr) {

                    console.log(
                        xhr.responseText
                    );


                    Swal.fire({

                        icon: 'error',

                        title: 'Error',

                        text:
                            'No se pudo eliminar la cita.'

                    });

                }

            });

        });

    });



    // ============================================================
    // MOVER EVENTO
    // ============================================================

    function moverEvento(info) {

        let evento = info.event;


        $.ajax({

            url: "{{ route('agenda.mover') }}",

            type: "POST",

            data: {

                _token:
                    "{{ csrf_token() }}",

                agenda_id:
                    evento.id,

                fecha_inicio:
                    fechaServidor(evento.start),

                fecha_fin:
                    evento.end
                        ? fechaServidor(evento.end)
                        : null

            },

            success: function(response) {

                Swal.fire({

                    icon: 'success',

                    title: 'Cita reprogramada',

                    text:
                        response.mensaje,

                    timer: 1200,

                    showConfirmButton:
                        false

                });

            },

            error: function(xhr) {

                console.log(
                    xhr.responseText
                );


                // REGRESAR EVENTO A SU POSICIÓN
                info.revert();


                Swal.fire({

                    icon: 'error',

                    title: 'Error',

                    text:
                        'No se pudo cambiar la fecha de la cita.'

                });

            }

        });

    }



    // ============================================================
    // LIMPIAR FORMULARIO
    // ============================================================

    function limpiarFormularioAgenda() {

        $('#formAgenda')[0].reset();

        $('#agenda_id').val('');

        $('#estado').val(
            'PENDIENTE'
        );

        $('#color').val(
            '#3788d8'
        );

        $('#tituloModal').text(
            'Nueva cita'
        );

        $('#btnEliminar')
            .addClass('d-none');

    }



    // ============================================================
    // CONVERTIR FECHA PARA datetime-local
    // ============================================================

    function fechaInput(fecha) {

        let year =
            fecha.getFullYear();

        let month =
            String(
                fecha.getMonth() + 1
            ).padStart(2, '0');

        let day =
            String(
                fecha.getDate()
            ).padStart(2, '0');

        let hour =
            String(
                fecha.getHours()
            ).padStart(2, '0');

        let minute =
            String(
                fecha.getMinutes()
            ).padStart(2, '0');


        return year +
            '-' +
            month +
            '-' +
            day +
            'T' +
            hour +
            ':' +
            minute;

    }



    // ============================================================
    // FECHA PARA LARAVEL
    // ============================================================

    function fechaServidor(fecha) {

        let year =
            fecha.getFullYear();

        let month =
            String(
                fecha.getMonth() + 1
            ).padStart(2, '0');

        let day =
            String(
                fecha.getDate()
            ).padStart(2, '0');

        let hour =
            String(
                fecha.getHours()
            ).padStart(2, '0');

        let minute =
            String(
                fecha.getMinutes()
            ).padStart(2, '0');

        let second =
            String(
                fecha.getSeconds()
            ).padStart(2, '0');


        return year +
            '-' +
            month +
            '-' +
            day +
            ' ' +
            hour +
            ':' +
            minute +
            ':' +
            second;

    }

});
</script>

@endsection
