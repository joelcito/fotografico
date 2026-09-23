<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Caja;
use App\Models\Cliente;
use App\Models\Detalle;
use App\Models\Factura;
use App\Models\Movimiento;
use App\Models\Pago;
use App\Models\Producto;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AgendaController extends Controller
{
    public function listado()
    {
        $clientes        = Cliente::all();
        $usuarios        = User::all();
        $sucursales      = Sucursal::all();
        $usuarioLogueado = Auth::user();
        $servicios       = Producto::all();

        return view('agenda.listado', compact('clientes','usuarios','sucursales', 'usuarioLogueado', 'servicios'));
    }

    public function eventos()
    {
        $agendas = Agenda::with([
            'cliente',
            'usuarioAsignado',
            'sucursal'
        ])->get();

        $eventos = [];

        foreach ($agendas as $agenda) {

            $eventos[] = [
                'id'              => $agenda->id,
                'title'           => $agenda->titulo,
                'start'           => $agenda->fecha_inicio,
                'end'             => $agenda->fecha_fin,
                'backgroundColor' => $agenda->color ?? '#3788d8',
                'borderColor'     => $agenda->color ?? '#3788d8',
                'extendedProps'   => [
                    'descripcion'         => $agenda->descripcion,
                    'estado'              => $agenda->estado,
                    'cliente_id'          => $agenda->cliente_id,
                    'usuario_asignado_id' => $agenda->usuario_asignado_id,
                    'sucursal_id'         => $agenda->sucursal_id,
                    'observacion'         => $agenda->observacion,
                    'color'               => $agenda->color,

                    // NUEVO
                    'factura_id'          => $agenda->factura_id,
                ]
            ];
        }

        return response()->json($eventos);
    }

    // public function guardar(Request $request)
    // {
    //     $request->validate([
    //         'titulo' => 'required|string|max:255',
    //         'fecha_inicio' => 'required|date',
    //         'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
    //         'estado' => 'required',
    //     ]);

    //     // SI VIENE ID -> MODIFICAR
    //     if ($request->agenda_id) {

    //         $agenda = Agenda::findOrFail($request->agenda_id);
    //     } else {

    //         // NUEVO
    //         $agenda = new Agenda();

    //         $agenda->usuario_creador_id = Auth::id();
    //     }

    //     $agenda->cliente_id = $request->cliente_id;

    //     $agenda->usuario_asignado_id =
    //         $request->usuario_asignado_id;

    //     $agenda->sucursal_id =
    //         $request->sucursal_id;

    //     $agenda->titulo =
    //         $request->titulo;

    //     $agenda->descripcion =
    //         $request->descripcion;

    //     $agenda->fecha_inicio =
    //         $request->fecha_inicio;

    //     $agenda->fecha_fin =
    //         $request->fecha_fin;

    //     $agenda->estado =
    //         $request->estado;

    //     $agenda->color =
    //         $request->color;

    //     $agenda->observacion =
    //         $request->observacion;

    //     $agenda->save();


    //     return response()->json([
    //         'estado' => true,
    //         'mensaje' => 'La cita fue guardada correctamente.'
    //     ]);
    // }

    public function guardar(Request $request)
    {
        $request->validate([

            'titulo'       => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'nullable|date|after_or_equal:fecha_inicio',
            'estado'       => 'required',

            'cliente_id'   => 'nullable|exists:clientes,id',

            'generar_venta' => 'nullable|boolean',

            'servicio_id' => [
                'nullable',
                'required_if:generar_venta,1',
                'exists:productos,id'
            ],

            'cantidad' => [
                'nullable',
                'required_if:generar_venta,1',
                'numeric',
                'min:1'
            ],

            'precio' => [
                'nullable',
                'required_if:generar_venta,1',
                'numeric',
                'min:0'
            ],

            'monto_pagado' => [
                'nullable',
                'numeric',
                'min:0'
            ],

        ]);

        DB::beginTransaction();

        try {

            $usuario = Auth::user();

            // =========================================================
            // BUSCAR O CREAR AGENDA
            // =========================================================

            if ($request->agenda_id) {

                $agenda = Agenda::findOrFail($request->agenda_id);

            } else {

                $agenda = new Agenda();

                $agenda->usuario_creador_id = $usuario->id;
            }

            // =========================================================
            // DATOS DE LA AGENDA
            // =========================================================

            $agenda->cliente_id          = $request->cliente_id;
            $agenda->usuario_asignado_id = $request->usuario_asignado_id;
            $agenda->sucursal_id         = $request->sucursal_id;
            $agenda->titulo              = $request->titulo;
            $agenda->descripcion         = $request->descripcion;
            $agenda->fecha_inicio        = $request->fecha_inicio;
            $agenda->fecha_fin           = $request->fecha_fin;
            $agenda->estado              = $request->estado;
            $agenda->color               = $request->color;
            $agenda->observacion         = $request->observacion;
            $agenda->save();

            // =========================================================
            // GENERAR VENTA
            // =========================================================

            if ( $request->boolean('generar_venta') && !$agenda->factura_id ) {

                if (!$request->cliente_id) {
                    throw new \Exception(
                        'Debe seleccionar un cliente para generar la venta.'
                    );
                }

                $factura = $this->generarVentaDesdeAgenda(
                    $request,
                    $agenda,
                    $usuario
                );

                // RELACIONAMOS AGENDA CON VENTA
                $agenda->factura_id = $factura->id;
                $agenda->save();
            }


            DB::commit();


            return response()->json([

                'estado' => true,

                'agenda_id' => $agenda->id,

                'factura_id' => $agenda->factura_id,

                'mensaje' => $agenda->factura_id
                    ? 'La cita y la venta fueron registradas correctamente.'
                    : 'La cita fue guardada correctamente.'

            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([

                'estado' => false,

                'message' => $e->getMessage()

            ], 500);
        }
    }

    public function eliminar(Request $request)
    {
        $agenda = Agenda::findOrFail($request->agenda_id);

        if ($agenda->factura_id) {
            return response()->json([
                'estado' => false,
                'mensaje' => 'No puede eliminar esta cita porque tiene una venta asociada.'
            ], 422);
        }

        $agenda->delete();

        return response()->json([
            'estado' => true,
            'mensaje' => 'La cita fue eliminada correctamente.'
        ]);
    }

    public function mover(Request $request)
    {
        $request->validate([
            'agenda_id' => 'required|integer',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date',
        ]);

        $agenda = Agenda::findOrFail($request->agenda_id);

        $agenda->fecha_inicio = $request->fecha_inicio;
        $agenda->fecha_fin = $request->fecha_fin;

        $agenda->save();

        return response()->json([
            'estado' => true,
            'mensaje' => 'La cita fue reprogramada correctamente.'
        ]);
    }

    private function generarVentaDesdeAgenda( Request $request, Agenda $agenda, $usuario ) {

        // =========================================================
        // DATOS PRINCIPALES
        // =========================================================

        $cliente = Cliente::findOrFail(
            $request->cliente_id
        );

        $servicio = Producto::findOrFail(
            $request->servicio_id
        );

        $sucursal_id = $request->sucursal_id
            ?? $usuario->sucursal->id;


        $cantidad = (float) $request->cantidad;

        $precio = (float) $request->precio;

        $monto_total = $cantidad * $precio;

        $monto_pagado = (float) (
            $request->monto_pagado ?? 0
        );


        // =========================================================
        // VALIDACIONES
        // =========================================================

        if ($monto_pagado > $monto_total) {

            throw new \Exception(
                'El monto pagado no puede ser mayor al total de la venta.'
            );
        }


        // =========================================================
        // CAJA
        // =========================================================

        $cajaAbierta = null;

        if ($monto_pagado > 0) {

            $caja = new Caja();

            $cajaAbierta =
                $caja->sacaCajaVigente($usuario->id);

            if (!$cajaAbierta) {

                throw new \Exception(
                    'Debe aperturar una caja para registrar el adelanto.'
                );
            }

            if (!$request->tipo_pago) {

                throw new \Exception(
                    'Debe seleccionar el tipo de pago del adelanto.'
                );
            }
        }


        // =========================================================
        // NUMERO RECIBO
        // =========================================================

        $fac = app(FacturaController::class);
        $numeroFacturaRecibo = $fac->numeroRecibo($sucursal_id);

        $numeroFacturaRecibo =
            $numeroFacturaRecibo == null
                ? 1
                : $numeroFacturaRecibo + 1;


        // =========================================================
        // CREAR FACTURA / RECIBO
        // =========================================================

        $factura                          = new Factura();
        $factura->usuario_creador_id      = $usuario->id;
        $factura->cliente_id              = $cliente->id;
        $factura->sucursal_id             = $sucursal_id;
        $factura->fecha                   = now();
        $factura->numero_recibo           = $numeroFacturaRecibo;
        $factura->facturado               = 'No';
        $factura->total                   = $monto_total;
        $factura->monto_total_subjeto_iva = $monto_total;
        $factura->descuento_adicional     = 0;
        $factura->estado_pago             = $monto_pagado >= $monto_total ? 'PAGADO' : 'DEUDA';
        $factura->descripcion             = $request->descripcion_venta ?? 'VENTA GENERADA DESDE AGENDA';
        $factura->save();

        // =========================================================
        // CREAR DETALLE
        // =========================================================

        $detalle                        = new Detalle();
        $detalle->usuario_creador_id    = $usuario->id;
        $detalle->sucursal_id           = $sucursal_id;
        $detalle->factura_id            = $factura->id;
        $detalle->producto_id           = $servicio->id;
        $detalle->nombre_producto       = $servicio->nombre;
        $detalle->descripcion_adicional = 'Generado desde agenda #' . $agenda->id;
        $detalle->precio                = $precio;
        $detalle->cantidad              = $cantidad;
        $detalle->descuento             = 0;
        $detalle->total                 = $monto_total;
        $detalle->importe               = $monto_total;
        $detalle->fecha                 = now();
        $detalle->estado                = 'Finalizado';
        $detalle->save();


        // =========================================================
        // STOCK
        // =========================================================

        if ($servicio->control_stock == 1) {

            $cantidadAlmacen = $fac->cantidadStockEmpresa($sucursal_id, $servicio->id);

            if (!$cantidadAlmacen->estado) {

                throw new \Exception(
                    'No se pudo verificar el stock.'
                );
            }

            if (
                $cantidad >
                $cantidadAlmacen->data['cantidad']
            ) {

                throw new \Exception(
                    'Cantidad solicitada: ' .
                    $cantidad .
                    '. Cantidad disponible: ' .
                    $cantidadAlmacen->data['cantidad'] .
                    ' del producto ' .
                    $servicio->nombre
                );
            }

            $movimiento                     = new Movimiento();
            $movimiento->usuario_creador_id = $usuario->id;
            $movimiento->sucursal_id        = $sucursal_id;
            $movimiento->producto_id        = $servicio->id;
            $movimiento->detalle_id         = $detalle->id;
            $movimiento->salida             = $cantidad;
            $movimiento->ingreso            = 0;
            $movimiento->fecha              = now();
            $movimiento->descripcion        = 'VENTA DESDE AGENDA';
            $movimiento->save();
        }


        // =========================================================
        // REGISTRAR ADELANTO
        // =========================================================

        if ($monto_pagado > 0) {

            $pago                     = new Pago();
            $pago->usuario_creador_id = $usuario->id;
            $pago->factura_id         = $factura->id;
            $pago->sucursal_id        = $sucursal_id;
            $pago->caja_id            = $cajaAbierta->id;
            $pago->monto              = $monto_pagado;
            $pago->fecha              = now();
            $pago->descripcion        = 'ADELANTO DE AGENDA #' . $agenda->id;
            $pago->apertura_caja      = 'No';
            $pago->tipo_pago          = $request->tipo_pago;
            $pago->estado             = 'INGRESO';
            $pago->save();
        }

        return $factura;
    }
}
