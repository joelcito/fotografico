<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Cliente;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendaController extends Controller
{
    public function listado()
    {
        $clientes   = Cliente::all();
        $usuarios   = User::all();
        $sucursales = Sucursal::all();
        $usuarioLogueado    = Auth::user();

        return view('agenda.listado', compact('clientes','usuarios','sucursales', 'usuarioLogueado'));
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
                ]
            ];
        }

        return response()->json($eventos);
    }


    public function guardar(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'estado' => 'required',
        ]);

        // SI VIENE ID -> MODIFICAR
        if ($request->agenda_id) {

            $agenda = Agenda::findOrFail($request->agenda_id);
        } else {

            // NUEVO
            $agenda = new Agenda();

            $agenda->usuario_creador_id = Auth::id();
        }

        $agenda->cliente_id = $request->cliente_id;

        $agenda->usuario_asignado_id =
            $request->usuario_asignado_id;

        $agenda->sucursal_id =
            $request->sucursal_id;

        $agenda->titulo =
            $request->titulo;

        $agenda->descripcion =
            $request->descripcion;

        $agenda->fecha_inicio =
            $request->fecha_inicio;

        $agenda->fecha_fin =
            $request->fecha_fin;

        $agenda->estado =
            $request->estado;

        $agenda->color =
            $request->color;

        $agenda->observacion =
            $request->observacion;

        $agenda->save();


        return response()->json([
            'estado' => true,
            'mensaje' => 'La cita fue guardada correctamente.'
        ]);
    }


    public function eliminar(Request $request)
    {
        $agenda = Agenda::findOrFail($request->agenda_id);

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
}
