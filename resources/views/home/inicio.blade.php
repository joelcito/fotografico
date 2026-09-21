@extends('layouts.app')
@section('css')

@endsection

@section('content')
    <!--begin::Row-->
    <div class="row g-5 gx-xl-10 mb-5 mb-xl-10">

        <div class="col-xxl-12">
            <div class="card card-flush h-md-100">
                <div class="card-body d-flex flex-column justify-content-between mt-9 bgi-no-repeat bgi-size-cover bgi-position-x-center pb-0"
                    style="background-position: 100% 50%; background-image:url('assets/media/stock/900x600/42.png')">
                    <div class="mb-10">
                        <div class="fs-2hx fw-bold text-gray-800 text-center mb-13">
                            <span class="me-2">
                                Sistema de Control de Studio Fotográfico
                                <br>
                                <span class="position-relative d-inline-block text-danger">
                                    Panel de Control
                                </span>
                            </span>
                        </div>
                    </div>

                    <div class="row g-5 mb-5">


                        {{-- ====================================================== --}}
                        {{-- VENTAS DE HOY --}}
                        {{-- ====================================================== --}}

                        <div class="col-xl-3 col-md-6">

                            <div class="card card-flush h-100" style="background-color:#009ef7;">

                                <div class="card-body">

                                    <div class="d-flex justify-content-between">

                                        <div>

                                            <span class="fs-2hx fw-bold text-white">
                                                Bs {{ number_format($totalVentasHoy, 2) }}
                                            </span>

                                            <div class="text-white opacity-75 fw-semibold">
                                                Ventas de hoy
                                            </div>

                                            <small class="text-white opacity-75">
                                                {{ $cantidadVentasHoy }} ventas registradas
                                            </small>

                                        </div>

                                        <i class="fas fa-shopping-cart fa-3x text-white opacity-50"></i>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- ====================================================== --}}
                        {{-- INGRESOS --}}
                        {{-- ====================================================== --}}

                        <div class="col-xl-3 col-md-6">

                            <div class="card card-flush h-100" style="background-color:#50cd89;">

                                <div class="card-body">

                                    <div class="d-flex justify-content-between">

                                        <div>

                                            <span class="fs-2hx fw-bold text-white">

                                                Bs {{ number_format($ingresosHoy, 2) }}

                                            </span>

                                            <div class="text-white opacity-75 fw-semibold">

                                                Ingresos de hoy

                                            </div>

                                        </div>

                                        <i class="fas fa-arrow-circle-down fa-3x text-white opacity-50"></i>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- ====================================================== --}}
                        {{-- SALIDAS --}}
                        {{-- ====================================================== --}}

                        <div class="col-xl-3 col-md-6">

                            <div class="card card-flush h-100" style="background-color:#f1416c;">

                                <div class="card-body">

                                    <div class="d-flex justify-content-between">

                                        <div>

                                            <span class="fs-2hx fw-bold text-white">

                                                Bs {{ number_format($salidasHoy, 2) }}

                                            </span>

                                            <div class="text-white opacity-75 fw-semibold">

                                                Salidas de hoy

                                            </div>

                                        </div>

                                        <i class="fas fa-arrow-circle-up fa-3x text-white opacity-50"></i>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- ====================================================== --}}
                        {{-- SALDO --}}
                        {{-- ====================================================== --}}

                        <div class="col-xl-3 col-md-6">

                            <div class="card card-flush h-100" style="background-color:#7239ea;">

                                <div class="card-body">

                                    <div class="d-flex justify-content-between">

                                        <div>

                                            <span class="fs-2hx fw-bold text-white">

                                                Bs {{ number_format($saldoHoy, 2) }}

                                            </span>

                                            <div class="text-white opacity-75 fw-semibold">

                                                Saldo de caja

                                            </div>

                                            <small class="text-white opacity-75">

                                                Apertura:
                                                Bs {{ number_format($aperturaHoy, 2) }}

                                            </small>

                                        </div>

                                        <i class="fas fa-wallet fa-3x text-white opacity-50"></i>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="row g-5 mb-10">

                        {{-- CUENTAS POR COBRAR --}}

                        <div class="col-xl-4 col-md-6">

                            <div class="card card-flush h-100">

                                <div class="card-body">

                                    <div class="d-flex align-items-center">

                                        <div class="symbol symbol-60px me-5">

                                            <span class="symbol-label bg-light-warning">

                                                <i class="fas fa-hand-holding-usd fs-2x text-warning"></i>

                                            </span>

                                        </div>

                                        <div>

                                            <span class="fs-2 fw-bold">

                                                Bs {{ number_format($totalPorCobrar, 2) }}

                                            </span>

                                            <div class="text-muted">

                                                Cuentas por cobrar

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- USUARIOS --}}

                        <div class="col-xl-4 col-md-6">

                            <div class="card card-flush h-100">

                                <div class="card-body">

                                    <div class="d-flex align-items-center">

                                        <div class="symbol symbol-60px me-5">

                                            <span class="symbol-label bg-light-primary">

                                                <i class="fas fa-users fs-2x text-primary"></i>

                                            </span>

                                        </div>

                                        <div>

                                            <span class="fs-2 fw-bold">

                                                {{ $cantidadUsuario }}

                                            </span>

                                            <div class="text-muted">

                                                Usuarios registrados

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- STOCK BAJO --}}

                        <div class="col-xl-4 col-md-6">

                            <div class="card card-flush h-100">

                                <div class="card-body">

                                    <div class="d-flex align-items-center">

                                        <div class="symbol symbol-60px me-5">

                                            <span class="symbol-label bg-light-danger">

                                                <i class="fas fa-box-open fs-2x text-danger"></i>

                                            </span>

                                        </div>

                                        <div>

                                            <span class="fs-2 fw-bold">

                                                {{ $stockQuery->count() }}

                                            </span>

                                            <div class="text-muted">

                                                Productos con stock bajo

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="row g-5 mb-10">


                        {{-- FORMAS DE PAGO --}}

                        <div class="col-xl-6">

                            <div class="card card-flush h-100">

                                <div class="card-header">

                                    <div class="card-title">

                                        <h3 class="fw-bold">
                                            Formas de pago del mes
                                        </h3>

                                    </div>

                                </div>

                                <div class="card-body">

                                    <div id="grafico_formas_pago" style="height: 320px;">
                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- ESTADO DE VENTAS --}}

                        <div class="col-xl-6">

                            <div class="card card-flush h-100">

                                <div class="card-header">

                                    <div class="card-title">

                                        <h3 class="fw-bold">
                                            Estado de ventas del mes
                                        </h3>

                                    </div>

                                </div>

                                <div class="card-body">

                                    <div id="grafico_estado_ventas" style="height: 320px;">
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="card card-flush mb-10">

                        <div class="card-header">

                            <div class="card-title">

                                <h3 class="fw-bold">
                                    Productos con stock bajo
                                </h3>

                            </div>

                        </div>


                        <div class="card-body">

                            <div class="table-responsive">

                                <table class="table table-row-bordered align-middle">

                                    <thead>

                                        <tr class="fw-bold text-muted">

                                            <th>
                                                Código
                                            </th>

                                            <th>
                                                Producto
                                            </th>

                                            <th class="text-center">
                                                Stock actual
                                            </th>

                                            <th class="text-center">
                                                Stock mínimo
                                            </th>

                                            <th class="text-center">
                                                Estado
                                            </th>

                                        </tr>

                                    </thead>


                                    <tbody>

                                        @forelse($stockQuery as $producto)

                                        <tr>

                                            <td>
                                                {{ $producto->codigo }}
                                            </td>

                                            <td class="fw-bold">
                                                {{ $producto->nombre }}
                                            </td>

                                            <td class="text-center">

                                                {{ number_format($producto->stock, 2) }}

                                            </td>

                                            <td class="text-center">

                                                {{ number_format($producto->minimo_stock, 2) }}

                                            </td>

                                            <td class="text-center">

                                                @if($producto->stock <= 0) <span class="badge badge-light-danger">
                                                    SIN STOCK
                                                    </span>

                                                    @else

                                                    <span class="badge badge-light-warning">
                                                        STOCK BAJO
                                                    </span>

                                                    @endif

                                            </td>

                                        </tr>

                                        @empty

                                        <tr>

                                            <td colspan="5" class="text-center text-muted py-10">

                                                No existen productos con stock bajo.

                                            </td>

                                        </tr>

                                        @endforelse

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    {{-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> --}}
    <script>
        $(document).ready(function () {

        let element = document.getElementById('kt_apexcharts_1');

        if (element) {

            let options = {

                series: [
                    {
                        name: 'Ventas',
                        data: @json($ventasMensuales)
                    },
                    {
                        name: 'Ingresos',
                        data: @json($ingresosMensuales)
                    },
                    {
                        name: 'Salidas',
                        data: @json($salidasMensuales)
                    }
                ],

                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: {
                        show: false
                    }
                },

                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        borderRadius: 4
                    }
                },

                dataLabels: {
                    enabled: false
                },

                xaxis: {
                    categories: @json($meses)
                },

                yaxis: {
                    labels: {
                        formatter: function (value) {

                            return 'Bs ' +
                                Number(value)
                                    .toLocaleString(
                                        'es-BO',
                                        {
                                            minimumFractionDigits: 0,
                                            maximumFractionDigits: 0
                                        }
                                    );
                        }
                    }
                },

                tooltip: {

                    y: {

                        formatter: function (value) {

                            return 'Bs ' +
                                Number(value)
                                    .toLocaleString(
                                        'es-BO',
                                        {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        }
                                    );
                        }
                    }
                },

                legend: {
                    position: 'top'
                }

            };


            let chart =
                new ApexCharts(
                    element,
                    options
                );

            chart.render();
        }

        // ================================================================
        // FORMAS DE PAGO
        // ================================================================

        let elementoPago =
            document.getElementById(
                'grafico_formas_pago'
            );

        if (elementoPago) {

            let opcionesPago = {

                series: @json($formasPagoSeries),

                labels: @json($formasPagoLabels),

                chart: {
                    type: 'donut',
                    height: 320
                },

                legend: {
                    position: 'bottom'
                },

                tooltip: {

                    y: {

                        formatter: function (value) {

                            return 'Bs ' +
                                Number(value)
                                    .toLocaleString(
                                        'es-BO',
                                        {
                                            minimumFractionDigits: 2
                                        }
                                    );
                        }
                    }
                },

                noData: {
                    text: 'Sin movimientos'
                }

            };


            new ApexCharts(
                elementoPago,
                opcionesPago
            ).render();
        }



        // ================================================================
        // ESTADO DE VENTAS
        // ================================================================

        let elementoEstado =
            document.getElementById(
                'grafico_estado_ventas'
            );

        if (elementoEstado) {

            let opcionesEstado = {

                series: @json($estadoVentasSeries),

                labels: @json($estadoVentasLabels),

                chart: {
                    type: 'donut',
                    height: 320
                },

                legend: {
                    position: 'bottom'
                },

                noData: {
                    text: 'Sin ventas'
                }

            };


            new ApexCharts(
                elementoEstado,
                opcionesEstado
            ).render();
        }

    });

    </script>
@endsection
