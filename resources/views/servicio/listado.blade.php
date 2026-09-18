@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .tamanio_boton {
            font-size: 6px;
        }
    </style>
@endsection
@section('metadatos')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('content')

    <!--begin::Modal - Add task-->
    <div class="modal fade" id="modalServicio" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header" id="kt_modal_add_user_header">
                    <h3 class="fw-bold">FORMULARIO DE SERVICIO <span class="text-info" id="nombre_busqueda"></span></h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body scroll-y">
                    <form id="formularioServicio">
                        <input type="hidden" name="id" id="id">
                        <div class="row">
                            <div class="col-md">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Nombre</label>
                                    <input type="text" class="form-control form-control-sm" id="nombre"
                                        name="nombre">
                                    <div class="text-danger error-message" id="error-nombre"></div>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Costo</label>
                                    <input type="number" class="form-control form-control-sm" id="precio_venta"
                                        name="precio_venta">
                                    <div class="text-danger error-message" id="error-precio_venta"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-sm w-100 btn-success" onclick="guardarServicio()">Guardar</button>
                        </div>
                    </div>
                </div>
                <!--end::Modal body-->
            </div>
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Add task-->

    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxlg">
                <!--begin::Card-->
                <div class="card">
                    <div class="card-header flex-wrap bg-light-info py-4">
                        <h3 class="card-title page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                            LISTADO DE SERVICIOS</h3>
                        <div class="card-toolbar">
                            <a class="btn btn-sm fw-bold btn-primary my-2" onclick="modalNuevoServicio()"><i class="fa fa-plus"></i>Nuevo</a>
                        </div>
                    </div>
                    <div class="card-body py-4">
                        <div id="table_listado">

                        </div>
                    </div>
                </div>
                <!--end::Card-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->

@stop()

@section('js')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script>
        $.ajaxSetup({
            // definimos cabecera donde estarra el token y poder hacer nuestras operaciones de put,post...
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $(document).ready(function() {
            ajaxListado();
        });

        function ajaxListado() {

            let datos = {};
            $.ajax({
                url: "{{ route('servicio.ajaxListado') }}",
                method: "POST",
                data: datos,
                success: function(resultado) {

                    if (resultado.estado) {
                        $('#table_listado').html(resultado.data.listado)
                    } else {

                    }
                    // Ocultar SweetAlert2 cuando la solicitud sea exitosa
                    // Swal.close();
                }
            })
        }

        function limpiarErorres() {
            $('.error-message').html('');
            $('.is-invalid').removeClass('is-invalid');
        }

        function modalNuevoServicio() {
            limpiarErorres();
            $('#nombre').prop('readonly', false);

            $('#id').val(0);
            $('#nombre').val('');
            $('#precio_venta').val('');
            $('#modalServicio').modal('show')
        }

        function guardarServicio() {
            let datos = $('#formularioServicio').serializeArray();
            $.ajax({
                url: "{{ route('servicio.guardarServicio') }}",
                method: "POST",
                data: datos,
                success: function(resultado) {
                    if (resultado.estado) {
                        Swal.fire({
                            title: "EL REGISTRO FUE EXITOSO.",
                            icon: "success",
                            timer: 3000, // Se cierra en 3 segundos
                            showConfirmButton: false
                        });
                        ajaxListado();
                        $('#modalServicio').modal('hide')
                    } else {

                    }
                },
                error: function(xhr) {
                    limpiarErorres();

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, messages) {
                            let input = $('[name="' + key + '"]');
                            let errorDiv = $('#error-' + key);

                            if (input.length > 0) {
                                input.addClass('is-invalid'); // Agregar clase de error
                                errorDiv.html('<span>' + messages[0] + '</span>'); // Mostrar mensaje
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error inesperado.',
                        });
                    }
                }
            });
        }

        function editarServicio(servicio) {
            limpiarErorres();

            if(servicio.id == 1){
                $('#nombre').prop('readonly', true);
            }else{
                $('#nombre').prop('readonly', false);
            }

            Object.keys(servicio).forEach(key => {
                let input = $(`#${key}`);

                // Saltar los inputs de tipo file
                if (input.attr('type') === 'file') {
                    return; // ignorar este campo
                }

                if (input.is(':checkbox')) {
                    // Marcar si el valor es 1, true o "on"
                    input.prop('checked', servicio[key] == 1 || servicio[key] === true || servicio[key] === "on");
                } else if (input.is('select')) {
                    // Para selects con librerías como Select2
                    input.val(servicio[key]).trigger('change');
                } else if (input.length) {
                    // Para inputs normales (text, number, email, etc.)
                    input.val(servicio[key]);
                }
            });
            $('#modalServicio').modal('show');
        }

        function eliminarServicio(servicio) {
            Swal.fire({
                title: "Quieres eliminar " + servicio.nombre,
                text: "Ya no podras recuperarlo!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, borrar!",
                cancelButtonText: "No, cancelar!",
                reverseButtons: true
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('servicio.eliminarServicio') }}",
                        method: "POST",
                        data: servicio,
                        success: function(resultado) {
                            if (resultado.estado) {
                                ajaxListado();
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Ocurrió un error inesperado.',

                            });
                        }
                    });
                } else if (result.dismiss === "cancel") {
                    Swal.fire(
                        "Cancelado",
                        "La operacion fue cancelada",
                        "error"
                    )
                }
            });

        }

    </script>
@endsection
