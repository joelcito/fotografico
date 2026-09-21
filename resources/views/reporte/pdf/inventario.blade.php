<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #343a40;
            color: white;
        }

        th,
        td {
            padding: 6px;
            border: 1px solid #ccc;
        }

        .numero {
            text-align: right;
        }

        .centro {
            text-align: center;
        }

        .bajo {
            font-weight: bold;
        }
    </style>

</head>

<body>

    <h2>REPORTE DE INVENTARIO</h2>

    <table>

        <thead>

            <tr>

                <th>N°</th>
                <th>Código</th>
                <th>Producto</th>
                <th>P. Compra</th>
                <th>P. Venta</th>
                <th>Stock mínimo</th>
                <th>Stock actual</th>
                <th>Estado</th>

            </tr>

        </thead>

        <tbody>

            @foreach($datos as $i => $dato)

            <tr>

                <td class="centro">
                    {{ $i + 1 }}
                </td>

                <td>
                    {{ $dato->codigo }}
                </td>

                <td>
                    {{ $dato->nombre }}
                </td>

                <td class="numero">
                    {{ number_format($dato->precio_compra,2) }}
                </td>

                <td class="numero">
                    {{ number_format($dato->precio_venta,2) }}
                </td>

                <td class="numero">
                    {{ number_format($dato->minimo_stock,2) }}
                </td>

                <td class="numero">
                    {{ number_format($dato->stock,2) }}
                </td>

                <td class="centro">

                    @if($dato->stock <= $dato->minimo_stock)

                        <span class="bajo">
                            STOCK BAJO
                        </span>

                        @else

                        DISPONIBLE

                        @endif

                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

</body>

</html>
