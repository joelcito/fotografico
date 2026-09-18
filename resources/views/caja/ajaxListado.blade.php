<div style="overflow-x: auto;">
    <!--begin::Table-->
    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
        <thead>
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                <th>#</th>
                <th>Usuario</th>
                <th>Sucursal</th>
                <th>Descripcion</th>
                <th>Fecha Apertura</th>
                <th>Monto Apertura</th>
                <th>Fecha Cierre</th>
                <th>Monto Cierre</th>
                <th>Total Venta</th>
                <th>Total Contado</th>
                {{-- <th>Total Credito</th> --}}
                <th>Otro Ingreso</th>
                {{-- <th>Total Ingreso</th> --}}
                <th>QR</th>
                <th>Transferencia</th>
                <th>Total Salida</th>
                <th>Saldo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 fw-semibold">
            @forelse ( $cajas as $caja)
                <tr>
                    <td>{{ $caja->id }}</td>
                    <td>{{ $caja->usuario->name }}</td>
                    <td>{{ $caja->sucursal->nombre }}</td>
                    <td>{{ $caja->descripcion }}</td>
                    <td>{{ $caja->fecha_apertura }}</td>
                    <td>{{ $caja->monto_apertura }}</td>
                    <td>{{ $caja->fecha_cierre }}</td>
                    <td>{{ $caja->monto_cierre }}</td>
                    <td>{{ $caja->total_venta }}</td>
                    <td>{{ $caja->venta_contado }}</td>
                    {{-- <td>{{ $caja->venta_credito }}</td> --}}
                    <td>{{ $caja->otro_ingreso }}</td>
                    {{-- <td>{{ $caja->total_ingreso }}</td> --}}
                    <td>{{ $caja->total_qr }}</td>
                    <td>{{ $caja->total_transferencia }}</td>
                    <td>{{ $caja->total_salida }}</td>
                    <td>
                        @if ($caja->saldo == 0)
                            <span class="badge badge-success">{{ $caja->saldo }}</span>
                        @elseif($caja->saldo < 0)
                            <span class="badge badge-danger">{{ $caja->saldo }}</span>
                        @elseif($caja->saldo > 0)
                            <span class="badge badge-warning">{{ $caja->saldo }}</span>
                        @endif
                    </td>
                    <td>
                        @if ($caja->estado == 'Cerrado')
                            <span class="badge badge-danger">{{ $caja->estado }}</span>
                        @else
                            <span class="badge badge-success">{{ $caja->estado }}</span>
                        @endif
                    </td>
                    <td>
                        {{-- @rol(1,5) --}}
                            @if ($caja->estado == 'Cerrado' && \Carbon\Carbon::parse($caja->fecha_cierre)->isSameDay(now()))
                                <button class="btn btn-icon btn-sm btn-info btn-circle" title="Habilitar caja" onclick="habilitarCaja({{ json_encode($caja) }})"><i class="fa fa-edit"></i></button>
                            @endif
                        {{-- @endrol --}}
                    </td>
                </tr>
            @empty
                <h4 class="text-danger">No hay datos</h4>
            @endforelse
        </tbody>
    </table>
    <!--end::Table-->
</div>

<script>
    $(document).ready(function() {
            $('#kt_table_users').DataTable({
                lengthMenu: [10, 25, 50, 100], // Opciones de longitud de página
                dom: '<"dt-head row"<"col-md-6"l><"col-md-6"f>><"clear">t<"dt-footer row"<"col-md-5"i><"col-md-7"p>>', // Use dom for basic layout
                language: {
                paginate: {
                    first : 'Primero',
                    last : 'Último',
                    next : 'Siguiente',
                    previous: 'Anterior'
                },
                search : 'Buscar:',
                lengthMenu: 'Mostrar _MENU_ registros por página',
                info : 'Mostrando _START_ a _END_ de _TOTAL_ registros',
                emptyTable: 'No hay datos disponibles'
                },
                order:[],
                //  searching: true,
                responsive: true
            });


        });
</script>
