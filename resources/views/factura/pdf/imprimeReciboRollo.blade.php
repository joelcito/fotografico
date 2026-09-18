<style>
    @page {
        size: 7cm 15cm;
        margin: 0cm;
    }

    body {
        margin-left: 0.3cm;
        margin-right: 0cm;
        margin-top: 0cm;
        margin-bottom: 0cm;
        padding: 0px;
        font-family: sans-serif;
        font-size: 10px;
        box-sizing: border-box;
    }

    .container {
        margin: 5px;
    }

    .header {
        display: flex;
        align-items: center;
    }

    .header img {
        width: 70px;
    }

    .header-text {
        flex-grow: 1;
        text-align: center;
    }

    table {
        width: 100%;
        margin-bottom: 5px;
        border-collapse: collapse;
        box-sizing: border-box;
    }

    th, td {
        border: 1px solid #000;
        padding: 3px;
        text-align: left;
        font-size: 9px;
        overflow-wrap: break-word;
    }

    th {
        background-color: #f2f2f2;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    p {
        margin: 0;
        padding: 0;
    }
</style>


@php
    use Carbon\Carbon;

   /*  $path = public_path('img/logo_deportivo.png');
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data); */

    $cliente = $factura->cliente;
    $sucursal = $factura->sucursal;
    $detalles = $factura->detalles;

@endphp
<div class="container">
    <div style="position: relative; width: 100%; margin-bottom: 1px; height: 90px;">
        <!-- Logo a la izquierda -->
        {{-- <div style="position: absolute; top: 0; left: 0;">
            <img src="{{ $base64 }}" alt="Logo" width="50">
        </div> --}}

        <!-- Texto completamente centrado -->
        <div style="text-align: center;">
            <p style="font-size: 9pt;">
                <strong>{{ 'VENTA N°' }} {{ $factura->numero_recibo }}</strong>
            </p>
            <p style="margin: 1pt 0; font-size: 9pt;"><strong>Sucursal:</strong> {{ $sucursal->nombre }}</p>
            <p style="margin: 1pt 0; font-size: 9pt;"><strong>Fecha:</strong> {{ Carbon::parse($factura->fecha)->format('d/m/Y H:i:s') }}</p>
            <p style="margin: 1pt 0; font-size: 9pt;"><strong>Fecha Impresion:</strong> {{ date('d/m/Y H:i:s') }}</p>
        </div>
    </div>

    <p style="margin: 1pt 0; font-size: 9pt;"><strong>Vendedor:</strong> {{ $factura->vendedor->nombres }}</p>
    <p style="margin: 1pt 0; font-size: 9pt;"><strong>Cliente:</strong> {{ $cliente->nombres." ".($cliente->ap_paterno ?? '')." ".($cliente->ap_materno ?? '') }}</p>

    @php
        $totalSumaSubTotales = 0;
    @endphp
    <table class="table">
        <thead>
            <tr>
                <th>DETALLE</th>
                <th>PRECIO</th>
                <th>CANT.</th>
                <th>TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detalles as $d)
                @php
                    $totalSumaSubTotales = $totalSumaSubTotales + ((float)$d->total - (float)$d->descuento);
                @endphp
                <tr>
                    <td>{{ $d->producto->codigo ? $d->producto->codigo . ' - ' : ''}}{{ $d->nombre_producto }}</td>
                    <td>{{ number_format($d->precio, 2) }}</td>
                    <td>{{ number_format($d->cantidad, 2) }}</td>
                    <td>{{ number_format($d->total - $d->descuento, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table class="table">
        <tbody>
            <tr>
                <td colspan="2"><strong>SUBTOTAL</strong></td>
                {{-- <td>{{ number_format($totalSumaSubTotales, 2) }}</td> --}}
            </tr>
            @foreach ($factura->pagos as $pago)
                <tr>
                    <td>-    {{ $pago->tipo_pago }}</td>
                    <td>{{ number_format($pago->monto, 2) }}</td>
                </tr>
            @endforeach
            <tr>
                <td><strong>DESCUENTO</strong></td>
                <td>{{ number_format($factura->descuento_adicional, 2) }}</td>
            </tr>
            <tr>
                <td><strong>TOTAL</strong></td>
                <td>{{ number_format($factura->total, 2) }}</td>
            </tr>
        </tbody>
    </table>
</div>
