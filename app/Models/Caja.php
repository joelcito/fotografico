<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Caja extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'cajas';

    protected $fillable = [
        'usuario_creador_id',
        'usuario_modificador_id',
        'usuario_eliminador_id',
        'usuario_id',
        'fecha_apertura',
        'fecha_cierre',
        'monto_apertura',
        'monto_cierre',
        'descripcion',
        'total_venta',
        'venta_contado',
        'venta_credito',
        'otro_ingreso',
        'total_ingreso',
        'total_qr_transferencia',
        'total_salida',
        'saldo',
        'estado',
        'deleted_at'
    ];

    public function puntoVenta(){
        return $this->belongsTo('App\Models\PuntoVenta', 'punto_venta_id');
    }

    public function usuario(){
        return $this->belongsTo('App\Models\User', 'usuario_apertura_id');
    }

    public function usuarioCierre()
    {
        return $this->belongsTo('App\Models\User', 'usuario_cierre_id');
    }
    public function sacaCajaVigente($sucursal_id){
    // public function sacaCajaVigente(){
        return Caja::select('cajas.*')
                    ->join('punto_ventas', 'punto_ventas.id', '=', 'cajas.punto_venta_id')
                    ->where('cajas.estado', 'Abierta')
                    ->where('punto_ventas.sucursal_id', $sucursal_id)
                    // ->where('usuario_id',$usuario_id)
                    ->first();
    }

    public function sacarCajasRangoFechas($fechaIni, $fechafin){

        return Caja::where('created_at','>=',$fechaIni.' 00:00:00')
                    ->where('created_at','<=',$fechafin.' 00:00:00')
                    ->get();
    }

    public function cajasUsuario($usuario_id, $admin, $sucursal_id){

        // dd($usuario_id, $admin);

        if($admin){
            return $this->select('cajas.*', 'punto_ventas.sucursal_id')
                        ->join('punto_ventas', 'punto_ventas.id', '=', 'cajas.punto_venta_id')
                        ->orderBy('cajas.id', 'desc')
                        ->get();
        }else{
            return $this->select('cajas.*', 'punto_ventas.sucursal_id')
                        ->join('punto_ventas', 'punto_ventas.id', '=', 'cajas.punto_venta_id')
                        ->where('punto_ventas.sucursal_id', $sucursal_id)
                        ->orderBy('cajas.id', 'desc')
                        // ->where('usuario_apertura_id', $usuario_id)
                        ->get();
        }
    }
}
