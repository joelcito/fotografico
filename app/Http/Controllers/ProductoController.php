<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Sucursal;
use App\Utils\Respuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function listado(){
        $sucursales = Sucursal::all();

        return view('producto.listado')->with(compact(['sucursales']));
    }

    public function ajaxListado(Request $request){
        if($request->ajax()){

            $sucursal_id = Auth::user()->sucursal_id;//nuevo
            $sucursal = Sucursal::find($sucursal_id);//nuevo
            $productos = Producto::where('control_stock', true)->orderBy('id', 'desc')->get();
            $valores = [
                'listado' => view('producto.ajaxListado')->with(compact('productos','sucursal'))->render()
            ];
            $data = Respuesta::success($valores, "Datos obtenidos correctamente");
        }else{
            $data = Respuesta::error(null, "Error al obtener los datos");
        }
        return $data;
    }

    public function guardarProducto(Request $request){
        if($request->ajax()){

            // dd($request->all());

            $request->validate([
                'nombre' => 'required',
                //'codigo' => 'required|unique:productos,codigo',
                'precio_compra' => 'required',
                'precio_venta'  => 'required',
                'minimo_stock'  => 'required',
                // 'tipo' => 'required',
            ]);


            // if($tipo == 'PRODUCTO'){
            //     $request->validate([
            //         'minimo_stock'  => 'required',
            //     ]);
            // }

            $id = $request->input('id');
            $nombre        = $request->input('nombre');
            $codigo        = $request->input('codigo');
            $precio_compra = $request->input('precio_compra');
            $precio_venta  = $request->input('precio_venta');
            $minimo_stock  = $request->input('minimo_stock');
            $usuario       = Auth::user();
            $tipo  = 'PRODUCTO';


            if( $id == 0 ){
                /* $request->validate([
                    'codigo' => 'required|unique:productos,codigo',
                ]); */
                $producto                     = new Producto();
                $producto->usuario_creador_id = $usuario->id;
            }else{
                /* if($existe = Producto::where('codigo', $codigo)->where('id', '!=', $id)->first()){
                    $request->validate([
                        'codigo' => 'required|unique:productos,codigo',
                    ]);
                } */
                $producto = Producto::find($id);
                $producto->usuario_modificador_id = $usuario->id;
            }

            $producto->nombre        = $nombre;
            $producto->codigo        = $codigo;
            $producto->precio_compra = $precio_compra;
            $producto->precio_venta  = $precio_venta;
            $producto->minimo_stock  = $minimo_stock;
            $producto->tipo          = $tipo;
            $producto->control_stock = true;

            // ==================== LÓGICA PARA LA IMAGEN ====================
            if ($request->hasFile('imagen_producto')) {

                // Si el producto ya tenía una imagen anterior al editar, la eliminamos físicamente
                if ($id != 0 && $producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
                    Storage::disk('public')->delete($producto->imagen);
                }

                // Guardamos la nueva imagen en la carpeta 'storage/app/public/productos'
                $rutaImagen = $request->file('imagen_producto')->store('productos', 'public');

                // Guardamos la ruta relativa en la base de datos
                $producto->imagen = $rutaImagen;
            }
            // ===============================================================

            $producto->save();

            $data = Respuesta::success(null, "Datos obtenidos correctamente");

        }else{
            $data = Respuesta::error(null, "No existe");
        }
        return $data;
    }

    public function eliminarProducto(Request $request){
        if($request->ajax()){

            $id = $request->input('id');
            $usuario = Auth::user();

            $producto = Producto::find($id);
            $producto->usuario_eliminador_id = $usuario->id;
            $producto->save();

            Producto::destroy($id);

            $data = Respuesta::success(null, "Datos obtenidos correctamente");

        }else{
            $data = Respuesta::error(null, "No existe");
        }
        return $data;
    }

    //ADICIONES EN MOVIMIENTOS
    public function ajaxStockSucursal(Request $request){
        if($request->ajax()){
            $producto_id = $request->input('producto_id');

            $sucursales = Sucursal::withSum(['movimientos' => function ($query) use($producto_id) {
                                                $query->where('producto_id', $producto_id);
                                            }], 'ingreso')
                                    ->withSum(['movimientos' => function ($query) use($producto_id) {
                                                $query->where('producto_id', $producto_id);
                                            }], 'salida')
                                    ->get();
            $producto = Producto::find($producto_id);
            $valores = [
                'listado' => view('producto.ajaxStockSucursal')->with(compact('sucursales', 'producto'))->render()
            ];
            $data = Respuesta::success($valores, "Datos obtenidos correctamente");
        }else{
            $data = Respuesta::error(null, "Error al obtener los datos");
        }
        return $data;
    }

    // public function guardarStockSucursal(Request $request){
    //     if($request->ajax()){

    //         $request->validate([
    //             'producto_id' => 'required',
    //             'sucursal_id' => 'required',
    //             'f_precio_compra' => 'required',
    //             'f_precio_venta' => 'required',
    //             'cantidad_ingreso' => 'required|min:1',
    //         ]);

    //         $producto_id = $request->input('producto_id');
    //         $sucursal_id = $request->input('sucursal_id');
    //         $precio_compra = $request->input('f_precio_compra');
    //         $precio_venta = $request->input('f_precio_venta');
    //         $descripcion     = $request->input('descripcion');
    //         $usuario         = Auth::user();

    //         $cantidad_ingreso = $request->input('cantidad_ingreso');

    //         $producto = Producto::find($producto_id);
    //         $producto->precio_compra = $precio_compra;
    //         $producto->precio_venta = $precio_venta;
    //         $producto->save();

    //         $nuevo              = new Movimiento();
    //         $nuevo->producto_id = $producto_id;
    //         $nuevo->sucursal_id = $sucursal_id;
    //         $nuevo->ingreso     = $cantidad_ingreso;
    //         $nuevo->salida             = 0;
    //         $nuevo->usuario_creador_id = $usuario->id;
    //         $nuevo->fecha              = date('Y-m-d H:i:s');
    //         $nuevo->descripcion        = $descripcion;
    //         $nuevo->precio_compra      = $precio_compra;
    //         $nuevo->precio_venta       = $precio_venta;
    //         $nuevo->save();

    //         $data = Respuesta::success($producto, "Datos obtenidos correctamente");

    //     }else{
    //         $data = Respuesta::error(null, "No existe");
    //     }
    //     return $data;
    // }

    // public function guardarSalidaSucursal(Request $request){
    //     if($request->ajax()){

    //         $request->validate([
    //             'salida_producto_id' => 'required',
    //             'salida_sucursal_id' => 'required',
    //             'cantidad_salida' => 'required|min:1',
    //         ]);

    //         $producto_id = $request->input('salida_producto_id');
    //         $sucursal_id = $request->input('salida_sucursal_id');
    //         $descripcion     = $request->input('salida_descripcion');
    //         $usuario         = Auth::user();

    //         $cantidad_salida = $request->input('cantidad_salida');

    //         $nuevo              = new Movimiento();
    //         $nuevo->producto_id = $producto_id;
    //         $nuevo->sucursal_id = $sucursal_id;

    //         $producto = Producto::find($producto_id);

    //         $nuevo->salida       = $cantidad_salida;
    //         $nuevo->ingreso             = 0;
    //         $nuevo->usuario_creador_id = $usuario->id;
    //         $nuevo->fecha              = date('Y-m-d H:i:s');
    //         $nuevo->descripcion        = $descripcion;
    //         $nuevo->save();

    //         $data = Respuesta::success($producto, "Datos obtenidos correctamente");

    //     }else{
    //         $data = Respuesta::error(null, "No existe");
    //     }
    //     return $data;
    // }
}
