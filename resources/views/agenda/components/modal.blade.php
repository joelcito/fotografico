<div class="modal fade" id="modalAgenda" tabindex="-1">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="tituloModal">
                    Nueva cita
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">

                <form id="formAgenda">

                    @csrf

                    <input type="hidden" id="agenda_id">

                    <div class="row">

                        <div class="col-md-8 mb-3">
                            <label>Título *</label>

                            <input type="text" id="titulo" class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Estado</label>

                            <select id="estado" class="form-control">
                                <option value="PENDIENTE">Pendiente</option>
                                <option value="CONFIRMADO">Confirmado</option>
                                <option value="ATENDIDO">Atendido</option>
                                <option value="CANCELADO">Cancelado</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Fecha y hora inicio *</label>

                            <input type="datetime-local" id="fecha_inicio" class="form-control" required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Fecha y hora fin</label>

                            <input type="datetime-local" id="fecha_fin" class="form-control">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Cliente</label>

                            <select id="cliente_id" class="form-control">
                                <option value="">Seleccione</option>
                                @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nombres." ".$cliente->ap_paterno." ".$cliente->ap_materno }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Usuario</label>
                            <select id="usuario_asignado_id" class="form-control">
                                <option value="">Seleccione</option>
                                @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->id }}" {{ $usuarioLogueado->id == $usuario->id? 'selected': '' }}>{{ $usuario->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Sucursal</label>

                            <select id="sucursal_id" class="form-control">

                                <option value="">
                                    Seleccione
                                </option>

                                @foreach($sucursales as $sucursal)

                                <option value="{{ $sucursal->id }}">
                                    {{ $sucursal->nombre }}
                                </option>

                                @endforeach

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Color</label>

                            <input type="color" id="color" class="form-control" value="#3788d8">

                        </div>

                        <div class="col-md-12 mb-3">

                            <label>Descripción</label>

                            <textarea id="descripcion" class="form-control" rows="3"></textarea>

                        </div>

                        <div class="col-md-12">

                            <label>Observación</label>

                            <textarea id="observacion" class="form-control" rows="2"></textarea>

                        </div>

                    </div>

                    <hr>

                    <div id="alertaVentaExistente" class="alert alert-success d-none mb-3">

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-check-circle"></i>
                                <strong>Esta cita ya tiene una venta generada.</strong>
                                <br>
                                <small>Venta N°<span id="numeroVentaAgenda"></span>
                                </small>
                            </div>
                            <a href="#" id="btnVerVentaAgenda" class="btn btn-sm btn-success" target="_blank">
                                <i class="fas fa-receipt"></i>
                                Ver recibo
                            </a>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="generar_venta"
                                    value="1">

                                <label class="form-check-label fw-bold" for="generar_venta">
                                    Generar venta con esta cita
                                </label>
                            </div>
                        </div>
                    </div>

                    <div id="bloqueVentaAgenda" style="display:none;" class="mt-3">

                        <div class="row">

                            <div class="col-md-4">
                                <label>Servicio</label>

                                <select id="servicio_id_agenda"
                                        class="form-control form-control-sm">

                                    <option value="">SELECCIONE</option>

                                    @foreach($servicios as $servicio)
                                        <option value="{{ $servicio->id }}"
                                                data-precio="{{ $servicio->precio_venta }}">
                                            {{ $servicio->nombre }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-md-2">
                                <label>Cantidad</label>

                                <input type="number"
                                    id="cantidad_agenda"
                                    class="form-control form-control-sm"
                                    value="1"
                                    min="1">
                            </div>

                            <div class="col-md-3">
                                <label>Precio</label>

                                <input type="number"
                                    id="precio_agenda"
                                    class="form-control form-control-sm"
                                    value="0"
                                    step="0.01">
                            </div>

                            <div class="col-md-3">
                                <label>Total</label>

                                <input type="number"
                                    id="total_agenda"
                                    class="form-control form-control-sm"
                                    value="0"
                                    readonly>
                            </div>

                        </div>

                        <div class="row mt-3">

                            <div class="col-md-4">
                                <label>Adelanto</label>

                                <input type="number"
                                    id="monto_pagado_agenda"
                                    class="form-control form-control-sm"
                                    value="0"
                                    min="0"
                                    step="0.01">
                            </div>

                            <div class="col-md-4">
                                <label>Tipo de pago</label>

                                <select id="tipo_pago_agenda"
                                        class="form-control form-control-sm">

                                    <option value="">SIN PAGO</option>
                                    <option value="EFECTIVO">EFECTIVO</option>
                                    <option value="QR">QR</option>
                                    <option value="TRANSFERENCIA">TRANSFERENCIA</option>

                                </select>
                            </div>

                            <div class="col-md-4">
                                <label>Descripción venta</label>

                                <input type="text"
                                    id="descripcion_venta_agenda"
                                    class="form-control form-control-sm"
                                    placeholder="Ej. Reserva sesión fotográfica">
                            </div>

                        </div>

                    </div>

                </form>

            </div>

            <div class="modal-footer">

                <button type="button" id="btnEliminar" class="btn btn-danger me-auto d-none">

                    <i class="fas fa-trash"></i>
                    Eliminar

                </button>

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                    Cancelar

                </button>

                <button type="button" id="btnGuardar" class="btn btn-primary">

                    <i class="fas fa-save"></i>
                    Guardar

                </button>

            </div>

        </div>

    </div>
</div>
