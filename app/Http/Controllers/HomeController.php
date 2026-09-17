<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use AuthorizesRequests;

    public function index() {

        // $cantidadUsuario = User::all()->count();

        // // PARA LOS PAGOS POR SUCURSAL
        // $series = [];
        // $sucursal = Sucursal::all();
        // $anio = date('Y');
        // // $anio = 2025;
        // foreach ($sucursal as $key => $sucursal) {

        //     $meses = [];

        //     for ($i=1; $i <=12 ; $i++) {

        //         $mes = ($i < 10 ) ? '0'.$i : $i ;

        //         $fechaIni = $anio.'-'.$mes.'-01 00:00:00';
        //         $fechaFin = $anio.'-'.$mes.'-31 23:59:59';

        //         $ingresos = pago::select('*')
        //                         ->join('punto_ventas', 'pagos.punto_venta_id', '=', 'punto_ventas.id')
        //                         ->where('punto_ventas.sucursal_id', $sucursal->id)
        //                         ->where('pagos.estado', 'INGRESO')
        //                         ->whereBetween('pagos.fecha',[$fechaIni, $fechaFin])
        //                         ->sum('pagos.monto');

        //         $salidas = pago::select('*')
        //                         ->join('punto_ventas', 'pagos.punto_venta_id', '=', 'punto_ventas.id')
        //                         ->where('punto_ventas.sucursal_id', $sucursal->id)
        //                         ->where('pagos.estado', 'SALIDA')
        //                         ->whereBetween('pagos.fecha', [$fechaIni, $fechaFin])
        //                         ->sum('pagos.monto');

        //         $pagoTotal = $ingresos - $salidas;

        //         $meses[] = $pagoTotal;

        //     }


        //     $series[] = [
        //         'name' => $sucursal->nombre,
        //         'data' => $meses
        //     ];

        // }

        $cantidadUsuario = 0;
        $series = null;

        return view('home.inicio')->with(compact('cantidadUsuario', 'series'));
    }
}

