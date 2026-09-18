<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Utils\Respuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriaController extends Controller
{
    public function listado()
    {
        return view('categoria.listado');
    }

    public function ajaxListado(Request $request)
    {
        if ($request->ajax()) {
            $categorias = Categoria::all();
            $valores = [
                'listado' => view('categoria.ajaxListado')->with(compact('categorias'))->render()
            ];
            $data = Respuesta::success($valores, "Datos obtenidos correctamente");
        } else {
            $data = Respuesta::error(null, "Error al obtener los datos");
        }
        return $data;
    }

    public function guardarCategoria(Request $request)
    {
        if ($request->ajax()) {

            $request->validate([
                'tipo' => 'required',
                'nombre' => 'required',
            ]);

            $id = $request->input('id');

            $nombre  = $request->input('nombre');
            $tipo  = $request->input('tipo');
            $usuario = Auth::user();

            if ($id == 0) {
                $cat = new Categoria();
                $cat->usuario_creador_id = $usuario->id;
            } else {
                $cat = Categoria::find($id);
                $cat->usuario_modificador_id = $usuario->id;
            }

            $cat->nombre = $nombre;
            $cat->tipo = $tipo;
            $cat->save();

            $data = Respuesta::success(null, "Datos obtenidos correctamente");
        } else {
            $data = Respuesta::error(null, "No existe");
        }
        return $data;
    }

    public function eliminarCategoria(Request $request)
    {
        if ($request->ajax()) {

            $id = $request->input('id');
            $usuario = Auth::user();

            $cat = Categoria::find($id);
            $cat->usuario_eliminador_id = $usuario->id;
            $cat->save();

            Categoria::destroy($id);

            $data = Respuesta::success(null, "Datos obtenidos correctamente");
        } else {
            $data = Respuesta::error(null, "No existe");
        }
        return $data;
    }
}
