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
    <div class="modal fade" id="modalProducto" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header" id="kt_modal_add_user_header">
                    <h3 class="fw-bold">FORMULARIO DE PRODUCTO <span class="text-info" id="nombre_busqueda"></span></h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body scroll-y">
                    <form id="formularioProducto">
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
                                    <label class="required fw-semibold fs-6 mb-2">Codigo</label>
                                    <input type="text" class="form-control form-control-sm" id="codigo"
                                        name="codigo">
                                    <div class="text-danger error-message" id="error-codigo"></div>
                                </div>
                            </div>
                            {{-- <div class="col-md">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Tipo</label>
                                    <select name="tipo" id="tipo" class="form-control form-control-sm"
                                        required>
                                        <option value="">Seleccione</option>
                                        <option value="PRODUCTO">PRODUCTO</option>
                                        <option value="SERVICIO">SERVICIO</option>
                                    </select>
                                    <div class="text-danger error-message" id="error-tipo"></div>
                                </div>
                            </div> --}}
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Precio Compra</label>
                                    <input type="number" class="form-control form-control-sm" id="precio_compra"
                                        name="precio_compra">
                                    <div class="text-danger error-message" id="error-precio_compra"></div>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Precio Venta</label>
                                    <input type="number" class="form-control form-control-sm" id="precio_venta"
                                        name="precio_venta">
                                    <div class="text-danger error-message" id="error-precio_venta"></div>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Minimo Stock</label>
                                    <input type="text" class="form-control form-control-sm" id="minimo_stock"
                                        name="minimo_stock">
                                    <div class="text-danger error-message" id="error-minimo_stock"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <label class="fw-semibold fs-6 mb-2">Imagen del Producto</label>
                                <input type="file" class="form-control form-control-sm" name="imagen_producto" id="imagen_producto"
                                    accept="image/*">
                                <div class="text-danger error-message" id="error-imagen_producto"></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-sm w-100 btn-success" onclick="guardarProducto()">Guardar</button>
                        </div>
                    </div>
                </div>
                <!--end::Modal body-->
            </div>
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Add task-->
    <!--Modal Stock de Sucursal-->
    <div class="modal fade" id="modalStockSucursal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header" id="kt_modal_add_user_header">
                    <h3 class="fw-bold">CANTIDAD STOCK POR SUCUSAL DEL PRODUCTO: <span class="text-info"
                            id="nombre_producto"></span></h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body scroll-y">
                    <div id="tabla_stock">
                    </div>
                </div>
                <div class="modal-footer">
                </div>
                <!--end::Modal body-->
            </div>
        </div>
        <!--end::Modal dialog-->
    </div>
    <div class="modal fade" id="modalStockSucursalProducto" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header" id="kt_modal_add_user_header">
                    <h3 class="fw-bold">INGRESO DE STOCK: <span class="text-info" id="nombre_producto_stock"></span></h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body scroll-y">
                    <form id="formularioStockSucursal">
                        <input type="hidden" name="producto_id" id="producto_id">
                        <input type="hidden" name="sucursal_id" id="sucursal_id">
                        <div class="row">
                            <div class="col-md">
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 required">Sucursal</label>
                                    <input type="text" class="form-control form-control-sm" id="nombre_sucursal"
                                        name="nombre_sucursal" @readonly(true)>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Fecha de Registro</label>
                                    <input type="date" class="form-control form-control-sm" id="fecha"
                                        name="fecha" value="{{ date('Y-m-d') }}" @readonly(true)>
                                    <div class="text-danger error-message" id="error-fecha"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Ingreso la cantidad</label>
                                    <input type="number" min="1" step="any" class="form-control form-control-sm" id="cantidad_ingreso" name="cantidad_ingreso">
                                    <div class="text-danger error-message" id="error-cantidad_ingreso"></div>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Precio Compra</label>
                                    <input type="number" class="form-control form-control-sm" id="f_precio_compra" name="f_precio_compra">
                                    <div class="text-danger error-message" id="error-f_precio_compra"></div>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Precio Venta</label>
                                    <input type="number" class="form-control form-control-sm" id="f_precio_venta" name="f_precio_venta">
                                    <div class="text-danger error-message" id="error-f_precio_venta"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="fw-semibold fs-6 mb-2">Descripcion</label>
                                <textarea class="form-control form-control-sm" name="descripcion" id="descripcion" cols="30" rows="3"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-sm w-100 btn-success" onclick="guardarStockSucursal()">Guardar</button>
                        </div>
                    </div>
                </div>
                <!--end::Modal body-->
            </div>
        </div>
        <!--end::Modal dialog-->
    </div>
    <div class="modal fade" id="modalSalidaSucursalProducto" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header" id="kt_modal_add_user_header">
                    <h3 class="fw-bold">SALIDA DE STOCK: <span class="text-info" id="nombre_producto_salida"></span></h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body scroll-y">
                    <form id="formularioSalidaSucursal">
                        <input type="hidden" name="salida_producto_id" id="salida_producto_id">
                        <input type="hidden" name="salida_sucursal_id" id="salida_sucursal_id">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold form-label mb-2 required">Sucursal</label>
                                    <input type="text" class="form-control form-control-sm" id="salida_nombre_sucursal"
                                        name="salida_nombre_sucursal" @readonly(true)>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Salida de la cantidad</label>
                                    <input type="number" min="1" step="any" class="form-control form-control-sm" id="cantidad_salida" name="cantidad_salida">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Fecha de Registro</label>
                                    <input type="date" class="form-control form-control-sm" id="fecha"
                                        name="salida_fecha" value="{{ date('Y-m-d') }}" @readonly(true)>
                                    <div class="text-danger error-message" id="error-salida_fecha"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="fw-semibold fs-6 mb-2">Descripcion</label>
                                <textarea class="form-control form-control-sm" name="salida_descripcion" id="salida_descripcion" cols="30" rows="3"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-sm w-100 btn-success" onclick="guardarSalidaSucursal()">Guardar</button>
                        </div>
                    </div>
                </div>
                <!--end::Modal body-->
            </div>
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--Fin modal Stock de Sucursal-->
    <!--Modal tranferencia de sucursal-->
    <div class="modal fade" id="modalTransferenciaSucursal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header" id="kt_modal_add_user_header">
                    <h3 class="fw-bold">TRANSFERENCIA DE PRODUCTO: <span class="text-info"
                            id="nombre_producto_transferencia"></span></h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body scroll-y" id="formulario_transferencia">

                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-sm w-100 btn-success"
                                onclick="guardarTransferenciaSucursal()">Guardar</button>
                        </div>
                    </div>
                </div>
                <!--end::Modal body-->
            </div>
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--Fin modal transferencia de Sucursal-->
    <!--Modal de reportes-->
    <div class="modal fade" id="modalReporte" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header" id="kt_modal_add_user_header">
                    <h3 class="fw-bold">REPORTES<span class="text-info"></span></h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="mb-5 hover-scroll-x">
                                <div class="d-grid">
                                    <ul class="nav nav-tabs flex-nowrap text-nowrap">
                                        <li class="nav-item w-100">
                                            <a class="nav-link active btn btn-active-light-info btn-color-gray-600 btn-active-color-primary rounded-bottom-0"
                                                data-bs-toggle="tab" href="#kt_tab_pane_1">INGRESO</a>
                                        </li>
                                        <li class="nav-item w-100">
                                            <a class="nav-link btn btn-active-light-info btn-color-gray-600 btn-active-color-primary rounded-bottom-0"
                                                data-bs-toggle="tab" href="#kt_tab_pane_2">SALIDA</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
                                    <form method="POST" action="{{ route('producto.generarReporteIngreso') }}"
                                        id="formularioReporteIngreso" target="_blank">
                                        @csrf
                                        <input type="hidden" name="ingreso_producto_id" id="ingreso_producto_id">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="fv-row mb-7">
                                                    <label
                                                        class="fs-6 fw-semibold form-label mb-2 required">Sucursal</label>
                                                    <select data-control="select2" data-placeholder="Seleccione"
                                                        data-dropdown-parent="#formularioReporteIngreso"
                                                        class="form-select form-select-solid fw-bold" name="ingreso_tipo"
                                                        id="ingreso_tipo">
                                                        <option></option>
                                                        <option value="SUCURSAL">SUCURSAL</option>
                                                        <option value="USUARIO">USUARIO</option>
                                                    </select>
                                                    <div class="text-danger error-message" id="error-ingreso_tipo"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="fv-row mb-7">
                                                    <label class="required fw-semibold fs-6 mb-2">Fecha Inicio</label>
                                                    <input type="date" class="form-control form-control-sm"
                                                        id="ingreso_fecha_ini" name="ingreso_fecha_ini" max="{{ date('Y-m-d') }}">
                                                    <div class="text-danger error-message" id="error-ingreso_fecha_ini">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="fv-row mb-7">
                                                    <label class="required fw-semibold fs-6 mb-2">Fecha Fin</label>
                                                    <input type="date" class="form-control form-control-sm"
                                                        id="ingreso_fecha_fin" name="ingreso_fecha_fin" max="{{ date('Y-m-d') }}">
                                                    <div class="text-danger error-message" id="error-ingreso_fecha_fin">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                {{-- <button class="btn btn-sm w-100 btn-success" onclick="generarReporteIngreso()">Imprimir</button> --}}
                                                <button type="submit"
                                                    class="btn btn-sm w-100 btn-success">Imprimir</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
                                    <form method="POST" action="{{ route('producto.generarReporteSalida') }}"
                                        id="formularioReporteSalida" target="_blank">
                                        @csrf
                                        <input type="hidden" name="salida_producto_id" id="salida_producto_id">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="fv-row mb-7">
                                                    <label
                                                        class="fs-6 fw-semibold form-label mb-2 required">Sucursal</label>
                                                    <select data-control="select2" data-placeholder="Seleccione"
                                                        data-dropdown-parent="#formularioReporteSalida"
                                                        class="form-select form-select-solid fw-bold" name="salida_tipo"
                                                        id="salida_tipo">
                                                        <option></option>
                                                        <option value="SUCURSAL">SUCURSAL</option>
                                                        <option value="USUARIO">USUARIO</option>
                                                    </select>
                                                    <div class="text-danger error-message" id="error-salida_tipo"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="fv-row mb-7">
                                                    <label class="required fw-semibold fs-6 mb-2">Fecha Inicio</label>
                                                    <input type="date" class="form-control form-control-sm"
                                                        id="salida_fecha_ini" name="salida_fecha_ini" max="{{ date('Y-m-d') }}">
                                                    <div class="text-danger error-message" id="error-salida_fecha_ini">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="fv-row mb-7">
                                                    <label class="required fw-semibold fs-6 mb-2">Fecha Fin</label>
                                                    <input type="date" class="form-control form-control-sm"
                                                        id="salida_fecha_fin" name="salida_fecha_fin" max="{{ date('Y-m-d') }}">
                                                    <div class="text-danger error-message" id="error-salida_fecha_fin">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                {{-- <button class="btn btn-sm w-100 btn-success" onclick="generarReporteIngreso()">Imprimir</button> --}}
                                                <button type="submit"
                                                    class="btn btn-sm w-100 btn-success">Imprimir</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                        </div>
                    </div>
                </div>
                <!--end::Modal body-->
            </div>
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--Fin modal de reportes-->

    <!--Modal recargar masivo -->
    <div class="modal fade" id="modalRegistroMasivo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header" id="kt_modal_add_user_header">
                    <h3 class="fw-bold">REGISTRO DE PRODUCTO MASIVO: <span class="text-info"
                            id="nombre_registro_masivo"></span></h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body scroll-y">
                    <form id="formulario_importar_servicios_productos_excel">
                        <div class="row">
                            <div class="col-md-11">
                                <input type="file" class="form-control form-control-sm" name="excel_producto_masivo" id="excel_producto_masivo">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-sm w-100 btn-success"
                                onclick="importarServiciosProductosExcel()">Guardar</button>
                        </div>
                    </div>
                </div>
                <!--end::Modal body-->
            </div>
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--Fin modal recargar masivo-->

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
                            LISTADO DE PRODUCTO</h3>
                        <div class="card-toolbar">
                            <div class="row">
                                {{-- <div class="col-md-4">
                                    <a class="btn btn-sm fw-bold btn-danger ml-5" onclick="modalStockMasivo()"><i class="fa fa-upload"></i>Registro Stock Masivo</a>
                                </div>
                                <div class="col-md-4">
                                    <a class="btn btn-sm fw-bold btn-danger ml-5" onclick="modalProductoMasivo()"><i class="fa fa-upload"></i>Registro Masivo</a>
                                </div> --}}
                            </div>
                            <a class="btn btn-sm fw-bold btn-primary my-2" onclick="modalNuevoProducto()"><i class="fa fa-plus"></i>Nuevo</a>
                            {{-- <a class="btn btn-sm fw-bold btn-danger" href="{{ route('producto.pdfProductoStock') }}" target="_blank">Imprimir Productos</a> --}}
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
                url: "{{ route('producto.ajaxListado') }}",
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

        function modalNuevoProducto() {
            limpiarErorres();

            $('#id').val(0);
            $('#nombre').val('');
            $('#codigo').val('');
            $('#precio_compra').val('');
            $('#precio_venta').val('');
            $('#minimo_stock').val('');
            $('#tipo').val('');
            $('#modalProducto').modal('show')
        }

        function guardarProducto() {

            let formulario = $('#formularioProducto')[0];
            let datos = new FormData(formulario); // Aquí usamos FormData

            // let datos = $('#formularioProducto').serializeArray();
            $.ajax({
                url: "{{ route('producto.guardarProducto') }}",
                method: "POST",
                data: datos,
                processData: false, // Muy importante
                contentType: false, // Muy importante
                success: function(resultado) {
                    if (resultado.estado) {
                        Swal.fire({
                            title: "EL REGISTRO FUE EXITOSO.",
                            icon: "success",
                            timer: 3000, // Se cierra en 3 segundos
                            showConfirmButton: false
                        });
                        ajaxListado();
                        $('#modalProducto').modal('hide')
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

        function editarProducto(producto) {
            limpiarErorres();

            Object.keys(producto).forEach(key => {
                let input = $(`#${key}`);

                // Saltar los inputs de tipo file
                if (input.attr('type') === 'file') {
                    return; // ignorar este campo
                }

                if (input.is(':checkbox')) {
                    // Marcar si el valor es 1, true o "on"
                    input.prop('checked', producto[key] == 1 || producto[key] === true || producto[key] === "on");
                } else if (input.is('select')) {
                    // Para selects con librerías como Select2
                    input.val(producto[key]).trigger('change');
                } else if (input.length) {
                    // Para inputs normales (text, number, email, etc.)
                    input.val(producto[key]);
                }
            });
            $('#modalProducto').modal('show');
        }

        function eliminarProducto(producto) {
            Swal.fire({
                title: "Quieres eliminar " + producto.nombre,
                text: "Ya no podras recuperarlo!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, borrar!",
                cancelButtonText: "No, cancelar!",
                reverseButtons: true
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('producto.eliminarProducto') }}",
                        method: "POST",
                        data: producto,
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
        //ADICIONAR STOCK
        function adicionarStockSucursal(producto) {

            $('#nombre_producto').html('')
            $('#tabla_stock').html('');

            $('#nombre_producto_salida').html('')
            $.ajax({
                url: "{{ route('producto.ajaxStockSucursal') }}",
                method: "POST",
                data: {
                    producto_id: producto.id
                },
                success: function(resultado) {

                    if (resultado.estado) {
                        $('#nombre_producto').html(producto.nombre);
                        $('#tabla_stock').html(resultado.data.listado);

                        $('#nombre_producto_salida').html(producto.nombre);

                        $('#modalStockSucursal').modal('show');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error inesperado.',
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error inesperado.',
                    });
                }
            })
        }

        function adicionarStockSucursalProducto(sucursal, producto) {
            $('#nombre_producto_stock').html('');
            limpiarErorres();

            $('#nombre_producto_stock').html(producto.nombre);
            $('#nombre_sucursal').val(sucursal.nombre);
            $('#producto_id').val(producto.id);
            $('#sucursal_id').val(sucursal.id);
            $('#cantidad_ingreso').val('');
            $('#f_precio_compra').val('');
            $('#f_precio_venta').val('');
            $('#descripcion').val('');
            $('#modalStockSucursalProducto').modal('show');

        }

        function guardarStockSucursal() {
            let datos = $('#formularioStockSucursal').serializeArray();
            $.ajax({
                url: "{{ route('producto.guardarStockSucursal') }}",
                method: "POST",
                data: datos,
                success: function(resultado) {
                    if (resultado.estado) {
                        Swal.fire({
                            title: "EL REGISTRO FUE EXITOSO.",
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });
                        adicionarStockSucursal(resultado.data);
                        //ajaxListado();//nuevo
                        $('#modalStockSucursalProducto').modal('hide');
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

        //ADICIONAR SALIDA
        function adicionarSalidaSucursalProducto(sucursal, producto) {
            $('#nombre_producto_salida').html('')
            limpiarErorres();

            $('#nombre_producto_salida').html(producto.nombre)
            $('#salida_nombre_sucursal').val(sucursal.nombre)
            $('#salida_producto_id').val(producto.id)
            $('#salida_sucursal_id').val(sucursal.id)
            $('#salida_stock').val('')
            // $('#fecha').val('')
            $('#salida_descripcion').val('')
            $('#modalSalidaSucursalProducto').modal('show')

        }

        function guardarSalidaSucursal() {
            let datos = $('#formularioSalidaSucursal').serializeArray();
            $.ajax({
                url: "{{ route('producto.guardarSalidaSucursal') }}",
                method: "POST",
                data: datos,
                success: function(resultado) {
                    if (resultado.estado) {
                        Swal.fire({
                            title: "EL REGISTRO FUE EXITOSO.",
                            icon: "success",
                            timer: 2000, // Se cierra en 3 segundos
                            showConfirmButton: false
                        });
                        adicionarStockSucursal(resultado.data);
                        //ajaxListado();//nuevo
                        $('#modalSalidaSucursalProducto').modal('hide');
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

        //TRANFERENCIA SUCURSALES
        function transferenciaSucursal(producto) {
            $('#nombre_producto_transferencia').html('')
            $('#mensaje-salida').html('')
            limpiarErorres();

            $('#nombre_producto_transferencia').html(producto.nombre)
            datos = {
                producto_id: producto.id
            }
            $.ajax({
                url: "{{ route('producto.ajaxFormTransferencia') }}",
                method: "POST",
                data: datos,
                success: function(resultado) {
                    if (resultado.estado) {
                        $('#formulario_transferencia').html(resultado.data.formulario)
                        // Re-inicializamos Select2 en los nuevos selects
                        $('#sucursal1_id, #sucursal2_id').select2({
                            dropdownParent: $('#modalTransferenciaSucursal')
                        });

                        // Configuramos el evento después de insertar el HTML
                        configurarEventoSucursal();

                        $('#modalTransferenciaSucursal').modal('show')
                    }
                }
            });
        }

        function configurarEventoSucursal() {
            const selectSucursal1 = $('#sucursal1_id');
            const selectSucursal2 = $('#sucursal2_id');

            // Guardamos las opciones originales por única vez
            const opcionesSucursal2 = selectSucursal2.html();

            // Evento cuando se selecciona una sucursal de salida
            selectSucursal1.off('select2:select').on('select2:select', function (e) {
                const sucursalSeleccionada = e.params.data.id;

                // Restauramos las opciones originales
                selectSucursal2.html(opcionesSucursal2);

                // Removemos la opción seleccionada en sucursal1 del select sucursal2
                selectSucursal2.find('option[value="' + sucursalSeleccionada + '"]').remove();

                // Refrescamos Select2
                selectSucursal2.val(null).trigger('change');
            });
        }

        function guardarTransferenciaSucursal() {
            let datos = $('#formularioTransferenciaSucursal').serializeArray();
            $.ajax({
                url: "{{ route('producto.guardarTransferenciaSucursal') }}",
                method: "POST",
                data: datos,
                success: function(resultado) {
                    if (resultado.estado) {
                        Swal.fire({
                            title: "EL REGISTRO FUE EXITOSO.",
                            icon: "success",
                            timer: 2000, // Se cierra en 2 segundos
                            showConfirmButton: false
                        });
                        ajaxListado();
                        $('#modalTransferenciaSucursal').modal('hide')
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

        //REPORTES
        function obtenerReporte(producto) {
            limpiarErorres();

            $('#ingreso_producto_id').val(producto.id)
            $('#ingreso_fecha_ini').val('')
            $('#ingreso_fecha_fin').val('')
            $('#ingreso_tipo').val(null).trigger('change')
            $('#salida_producto_id').val(producto.id)
            $('#salida_fecha_ini').val('')
            $('#salida_fecha_fin').val('')
            $('#salida_tipo').val(null).trigger('change')
            $('#modalReporte').modal('show')
        }

        //IMPORTAR EXCEL
        function modalRegistroMasivo() {
            $('#excel_producto_masivo').val('');
            $('#modalRegistroMasivo').modal('show');
        }

        function importarServiciosProductosExcel() {

            if ($("#formulario_importar_servicios_productos_excel")[0].checkValidity()) {
                let datos = new FormData($("#formulario_importar_servicios_productos_excel")[0]);
                $.ajax({
                    url: "{{ route('producto.importarServiciosProductosExcel') }}",
                    method: "POST",
                    data: datos,
                    contentType: false,
                    processData: false,
                    success: function(data) {

                        if (data.estado === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: "EXITO!",
                                text: "SE REGISTRO CON EXITO",
                            })
                            $('#modalRegistroMasivo').modal('hide');
                        } else if (data.estado === 'warning') {

                            // Supongamos que `datosErroneos` es tu array con las observaciones
                            const datosErroneos = data.errores;

                            // Crea un string HTML a partir del array
                            const erroresHtml = datosErroneos.map(error =>
                                `<li>${error.texto} en el fila [ ${error.fila} ]</li>`).join('');

                            Swal.fire({
                                icon: 'warning',
                                title: data.titulo,
                                text: data.text,
                                html: `
                                    SE REGISTRÓ, PERO HAY OBSERVACIONES:<br>
                                    <ul>${erroresHtml}</ul>
                                `,
                            })

                            $('#modalRegistroMasivo').modal('hide');

                        } else if (data.estado === 'error') {
                            Swal.fire({
                                icon: 'error',
                                title: "ERROR!",
                                text: data.text,
                            })
                            $('#modalRegistroMasivo').modal('hide');
                        }

                        ajaxListado();

                    }
                })

            } else {
                $("#formulario_importar_servicios_productos_excel")[0].reportValidity();
            }
        }

    </script>
@endsection
