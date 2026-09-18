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
    <div class="modal fade" id="modalAperturaCaja" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            @include('caja.components.formularioAperturaCaja')
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Add task-->

    <!--begin::Modal - Add task-->
    <div class="modal fade" id="modalCerrarCaja" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            @include('caja.components.formularioCerrarCaja', ['cajaAbierta' => $cajaAbierta])
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Add task-->

    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxlg">
                <!--begin::Card-->
                <div class="card">
                    <div class="card-header flex-wrap bg-light-info py-4">
                        <h3
                            class="card-title page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                            LISTADO DE CAJAS</h3>
                        <div class="card-toolbar">
                            @if ($cajaAbierta)
                                <a class="btn btn-sm fw-bold btn-danger" onclick="modalCerrarCaja()"><i
                                        class="fa fa-plus"></i>Cerrar Caja</a>
                            @else
                                <a class="btn btn-sm fw-bold btn-success" onclick="modalAperturaCaja()"><i
                                        class="fa fa-plus"></i>Abrir Caja</a>
                            @endif
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

            $('#monto_apertura').on('focus', function() {
                if ($(this).val() == '0' || $(this).val() === 0) {
                    $(this).val("");
                }
            });
        });

        function ajaxListado() {

            let datos = {};
            $.ajax({
                url: "{{ url('caja/ajaxListado') }}",
                method: "POST",
                data: datos,
                success: function(resultado) {

                    if (resultado.estado) {
                        $('#table_listado').html(resultado.data.listado)
                    } else {

                    }
                }
            })
        }

        function modalAperturaCaja() {
            $('#monto_apertura').val(0);
            $('#descripcion').val('')
            $('#modalAperturaCaja').modal('show')
        }

        function guardarAperturaCaja() {
            if($('#formularioAperturaCaja')[0].checkValidity()){
                $('#boton_abrir_caja').attr('disabled', true);
                let datos = $('#formularioAperturaCaja').serializeArray();
                $.ajax({
                    url: "{{ url('caja/guardarAperturaCaja') }}",
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

                            location.reload();
                        } else {

                        }
                    },
                    error: function(xhr) {
                        // limpiarErorres();

                        // if (xhr.status === 422) {
                        //     let errores = xhr.responseJSON.errors;

                        //     for (let campo in errores) {
                        //         let mensaje = errores[campo][0];

                        //         let input = $(`[name="${campo}"]`);
                        //         input.addClass("is-invalid");
                        //         input.after(`<div class="invalid-feedback">${mensaje}</div>`);
                        //     }
                        // } else {
                        //     Swal.fire({
                        //         icon: 'error',
                        //         title: 'Error',
                        //         text: 'Ocurrió un error inesperado.',
                        //     });
                        // }
                    }
                });
            }else{
                $('#formularioAperturaCaja')[0].reportValidity()
            }
        }

        function modalCerrarCaja() {
            $('#modalCerrarCaja').modal('show')
        }

        function guardarCerrarCaja() {
            if($('#formularioCerrarCaja')[0].checkValidity()){
                $('#boton_cerrar_caja').attr('disabled', true);
                let datos = $('#formularioCerrarCaja').serializeArray();
                $.ajax({
                    url: "{{ url('caja/guardarCerrarCaja') }}",
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

                            location.reload();
                        } else {

                        }
                    },
                    error: function(xhr) {

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error inesperado.' + xhr,
                        });
                    }
                });
            }else{
                $('#formularioCerrarCaja')[0].reportValidity()
            }
        }

        // function limpiarErorres(){
        //     $(".invalid-feedback").remove();
        //     $(".is-invalid").removeClass("is-invalid");
        // }

        // function modalNuevoRol(){
        //     limpiarErorres();

        //     $('#id').val(0)
        //     $('#nombre').val('')
        //     $('#modalRol').modal('show')
        // }

        // function guardarRol(){
        //     let datos = $('#formularioRol').serializeArray();
        //     $.ajax({
        //         url: "{{ route('rol.guardarRol') }}",
        //         method: "POST",
        //         data: datos,
        //         success: function (resultado) {
        //             if(resultado.estado){
        //                 Swal.fire({
        //                     title: "EL REGISTRO FUE EXITOSO.",
        //                     icon: "success",
        //                     timer: 3000, // Se cierra en 3 segundos
        //                     showConfirmButton: false
        //                 });
        //                 ajaxListado();
        //                 $('#modalRol').modal('hide')
        //             }else{

        //             }
        //         },
        //         error: function (xhr) {
        //             limpiarErorres();

        //             if (xhr.status === 422) {
        //                 let errores = xhr.responseJSON.errors;

        //                 for (let campo in errores) {
        //                     let mensaje = errores[campo][0];

        //                     let input = $(`[name="${campo}"]`);
        //                     input.addClass("is-invalid");
        //                     input.after(`<div class="invalid-feedback">${mensaje}</div>`);
        //                 }
        //             } else {
        //                 Swal.fire({
        //                     icon: 'error',
        //                     title: 'Error',
        //                     text: 'Ocurrió un error inesperado.',
        //                 });
        //             }
        //         }
        //     });
        // }

        // function editarRol(rol){
        //     limpiarErorres();

        //     Object.keys(rol).forEach(key => {
        //         let input = $(`#${key}`);
        //         if (input.length) {
        //             input.val(rol[key]);
        //         }
        //     });
        //     $('#modalRol').modal('show')
        // }

        function habilitarCaja(caja){
            Swal.fire({
                title: "Quieres habilitar la caja de fecha de apertura " + caja.fecha_apertura + "?",
                text: "Esto permitirá realizar operaciones en la caja!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, habilitar!",
                cancelButtonText: "No, cancelar!",
                reverseButtons: true
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('caja.habilitarCaja') }}",
                        method: "POST",
                        data: caja,
                        success: function (resultado) {
                            if(resultado.estado){
                                Swal.fire({
                                    title: "SE HABILITO LA CAJA.",
                                    icon: "success",
                                    timer: 3000, //Se cierra en 3 segundos
                                    showConfirmButton: false
                                });

                                window.location.reload();
                            }
                        },
                        error: function (xhr) {
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
