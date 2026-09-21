<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    use AuthorizesRequests;

    public function index() {

        $hoy = Carbon::today();

        $fechaInicio = $hoy->copy()->startOfDay();
        $fechaFin = $hoy->copy()->endOfDay();

        $usuario = Auth::user();


        // =========================================================
        // FILTRO SUCURSAL
        // =========================================================
        // Si quieres que cada usuario vea solamente su sucursal.
        // Si el administrador debe ver todo, luego podemos aplicar
        // condición según rol.
        // =========================================================

        $sucursalId = $usuario->sucursal_id ?? null;


        // =========================================================
        // USUARIOS
        // =========================================================

        $cantidadUsuario = DB::table('users')
            ->whereNull('deleted_at')
            ->count();


        // =========================================================
        // VENTAS DE HOY
        // =========================================================

        $ventasHoyQuery = DB::table('facturas')
            ->whereNull('deleted_at')
            ->whereBetween('fecha', [
                $fechaInicio,
                $fechaFin
            ])
            ->where(function ($query) {
                $query->whereNull('estado')
                    ->orWhere('estado', '!=', 'Anulado');
            });


        if ($sucursalId) {
            $ventasHoyQuery->where(
                'sucursal_id',
                $sucursalId
            );
        }


        $cantidadVentasHoy =
            (clone $ventasHoyQuery)->count();


        $totalVentasHoy =
            (clone $ventasHoyQuery)->sum('total');


        // =========================================================
        // PAGOS DE HOY
        // =========================================================

        $pagosHoy = DB::table('pagos')
            ->whereNull('deleted_at')
            ->whereBetween('fecha', [
                $fechaInicio,
                $fechaFin
            ]);


        if ($sucursalId) {
            $pagosHoy->where(
                'sucursal_id',
                $sucursalId
            );
        }


        // =========================================================
        // APERTURA DE CAJA
        // =========================================================

        $aperturaHoy = (clone $pagosHoy)
            ->whereRaw("UPPER(apertura_caja) = 'SI'")
            ->sum('monto');


        // =========================================================
        // INGRESOS DE HOY
        // Sin contar apertura
        // =========================================================

        $ingresosHoy = (clone $pagosHoy)
            ->where('estado', 'INGRESO')
            ->where(function ($query) {

                $query->whereNull('apertura_caja')
                    ->orWhereRaw(
                        "UPPER(apertura_caja) <> 'SI'"
                    );
            })
            ->sum('monto');


        // =========================================================
        // SALIDAS DE HOY
        // =========================================================

        $salidasHoy = (clone $pagosHoy)
            ->where('estado', 'SALIDA')
            ->sum('monto');


        // =========================================================
        // SALDO DE CAJA
        // =========================================================

        $saldoHoy =
            $aperturaHoy +
            $ingresosHoy -
            $salidasHoy;


        // =========================================================
        // CUENTAS POR COBRAR
        // =========================================================

        $pagosPorFactura = DB::table('pagos')
            ->select(
                'factura_id',
                DB::raw('SUM(monto) as pagado')
            )
            ->whereNull('deleted_at')
            ->whereNotNull('factura_id')
            ->where('estado', 'INGRESO')
            ->groupBy('factura_id');


        $cuentasCobrarQuery = DB::table('facturas as f')

            ->leftJoinSub(
                $pagosPorFactura,
                'p',
                function ($join) {

                    $join->on(
                        'p.factura_id',
                        '=',
                        'f.id'
                    );
                }
            )

            ->whereNull('f.deleted_at')
            ->where(function ($query) {
                $query->whereNull('f.estado')
                    ->orWhere('f.estado', '!=', 'Anulado');
            })
            ->whereRaw('f.total > COALESCE(p.pagado, 0)');


        if ($sucursalId) {

            $cuentasCobrarQuery->where(
                'f.sucursal_id',
                $sucursalId
            );
        }


        $totalPorCobrar = $cuentasCobrarQuery
            ->selectRaw(
                'SUM(
                    f.total - COALESCE(p.pagado, 0)
                ) AS saldo'
            )
            ->value('saldo') ?? 0;


        // =========================================================
        // VENTAS ÚLTIMOS 12 MESES
        // =========================================================

        $meses = [];
        $ventasMensuales = [];
        $ingresosMensuales = [];
        $salidasMensuales = [];


        for ($i = 11; $i >= 0; $i--) {

            $mes = now()
                ->copy()
                ->subMonths($i);

            $inicioMes =
                $mes->copy()->startOfMonth();

            $finMes =
                $mes->copy()->endOfMonth();


            $meses[] = ucfirst(
                $mes->locale('es')
                    ->translatedFormat('M')
            );


            // VENTAS
            $queryVenta = DB::table('facturas')
                ->whereNull('deleted_at')
                ->where(function ($query) {
                    $query->whereNull('estado')
                        ->orWhere('estado', '!=', 'Anulado');
                })
                ->whereBetween(
                    'fecha',
                    [$inicioMes, $finMes]
                );

            if ($sucursalId) {
                $queryVenta->where(
                    'sucursal_id',
                    $sucursalId
                );
            }

            $ventasMensuales[] =
                (float) $queryVenta->sum('total');


            // INGRESOS
            $queryIngreso = DB::table('pagos')
                ->whereNull('deleted_at')
                ->where('estado', 'INGRESO')
                ->whereBetween(
                    'fecha',
                    [$inicioMes, $finMes]
                )
                ->where(function ($query) {

                    $query->whereNull('apertura_caja')
                        ->orWhereRaw(
                            "UPPER(apertura_caja) <> 'SI'"
                        );
                });


            if ($sucursalId) {

                $queryIngreso->where(
                    'sucursal_id',
                    $sucursalId
                );
            }


            $ingresosMensuales[] =
                (float) $queryIngreso->sum('monto');


            // SALIDAS
            $querySalida = DB::table('pagos')
                ->whereNull('deleted_at')
                ->where('estado', 'SALIDA')
                ->whereBetween(
                    'fecha',
                    [$inicioMes, $finMes]
                );


            if ($sucursalId) {

                $querySalida->where(
                    'sucursal_id',
                    $sucursalId
                );
            }


            $salidasMensuales[] =
                (float) $querySalida->sum('monto');
        }


        // =========================================================
        // FORMAS DE PAGO DEL MES
        // =========================================================

        $formasPagoQuery = DB::table('pagos')
            ->select(
                'tipo_pago',
                DB::raw('SUM(monto) as total')
            )
            ->whereNull('deleted_at')
            ->where('estado', 'INGRESO')
            ->where(function ($query) {

                $query->whereNull('apertura_caja')
                    ->orWhereRaw(
                        "UPPER(apertura_caja) <> 'SI'"
                    );
            })
            ->whereBetween(
                'fecha',
                [
                    now()->startOfMonth(),
                    now()->endOfMonth()
                ]
            );


        if ($sucursalId) {

            $formasPagoQuery->where(
                'sucursal_id',
                $sucursalId
            );
        }


        $formasPago = $formasPagoQuery
            ->groupBy('tipo_pago')
            ->orderByDesc('total')
            ->get();


        $formasPagoLabels =
            $formasPago->pluck('tipo_pago')->values();

        $formasPagoSeries =
            $formasPago
            ->pluck('total')
            ->map(fn($valor) => (float) $valor)
            ->values();


        // =========================================================
        // ESTADO DE LAS VENTAS DEL MES
        // =========================================================

        $estadoVentasQuery = DB::table('facturas')
            ->select(
                'estado_pago',
                DB::raw('COUNT(*) as cantidad')
            )
            ->whereNull('deleted_at')
            ->where(function ($query) {
                $query->whereNull('estado')
                    ->orWhere('estado', '!=', 'Anulado');
            })
            ->whereBetween(
                'fecha',
                [
                    now()->copy()->startOfMonth(),
                    now()->copy()->endOfMonth()
                ]
            );

        if ($sucursalId) {
            $estadoVentasQuery->where(
                'sucursal_id',
                $sucursalId
            );
        }

        $estadoVentas = $estadoVentasQuery
            ->groupBy('estado_pago')
            ->get();

        $estadoVentasLabels = $estadoVentas
            ->pluck('estado_pago')
            ->map(function ($estado) {
                return $estado ?: 'SIN ESTADO';
            })
            ->values();

        $estadoVentasSeries = $estadoVentas
            ->pluck('cantidad')
            ->map(function ($valor) {
                return (int) $valor;
            })
            ->values();


        // =========================================================
        // PRODUCTOS CON STOCK BAJO
        // =========================================================

        $stockQuery = DB::table('productos as p')

            ->leftJoin(
                'movimientos as m',
                function ($join) use ($sucursalId) {

                    $join->on(
                        'm.producto_id',
                        '=',
                        'p.id'
                    );

                    $join->whereNull(
                        'm.deleted_at'
                    );


                    if ($sucursalId) {

                        $join->where(
                            'm.sucursal_id',
                            '=',
                            $sucursalId
                        );
                    }
                }
            )

            ->whereNull('p.deleted_at')

            ->where(
                'p.control_stock',
                1
            )

            ->select(
                'p.id',
                'p.codigo',
                'p.nombre',
                'p.minimo_stock',

                DB::raw(
                    'COALESCE(SUM(m.ingreso), 0)
                     -
                     COALESCE(SUM(m.salida), 0)
                     AS stock'
                )
            )

            ->groupBy(
                'p.id',
                'p.codigo',
                'p.nombre',
                'p.minimo_stock'
            )

            ->havingRaw(
                '(COALESCE(SUM(m.ingreso), 0)
                -
                COALESCE(SUM(m.salida), 0))
                <= p.minimo_stock'
            )

            ->orderBy('stock', 'asc')

            ->limit(10)

            ->get();


        // =========================================================
        // ENVIAR A VISTA
        // =========================================================

        return view(
            'home.inicio',
            compact(
                'cantidadUsuario',

                'cantidadVentasHoy',
                'totalVentasHoy',

                'aperturaHoy',
                'ingresosHoy',
                'salidasHoy',
                'saldoHoy',

                'totalPorCobrar',

                'meses',
                'ventasMensuales',
                'ingresosMensuales',
                'salidasMensuales',

                'formasPagoLabels',
                'formasPagoSeries',

                'estadoVentasLabels',
                'estadoVentasSeries',

                'stockQuery'
            )
        );


    }
}

