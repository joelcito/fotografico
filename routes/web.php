<?php

use App\Http\Controllers\CajaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return redirect('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/home', [HomeController::class, 'index']);

    // ROL
    Route::prefix('/rol')->group(function(){
        Route::get('/listado', [RolController::class, 'listado'])->name('rol.listado');
        Route::post('/ajaxListado', [RolController::class, 'ajaxListado'])->name('rol.ajaxListado');
        Route::post('/guardarRol', [RolController::class, 'guardarRol'])->name('rol.guardarRol');
        Route::post('/eliminarRol', [RolController::class, 'eliminarRol'])->name('rol.eliminarRol');
    });

    // SUCURSALES
    Route::prefix('/sucursal')->group(function () {
        Route::get('/listado', [SucursalController::class, 'listado'])->name('sucursal.listado');
        Route::post('/ajaxListado', [SucursalController::class, 'ajaxListado'])->name('sucursal.ajaxListado');
        Route::post('/guardarSucursal', [SucursalController::class, 'guardarSucursal'])->name('sucursal.guardarSucursal');
        Route::post('/eliminarSucursal', [SucursalController::class, 'eliminarSucursal'])->name('sucursal.eliminarSucursal');
    });

    // PRODUCTO
    Route::prefix('/producto')->group(function () {
        Route::get('/listado', [ProductoController::class, 'listado'])->name('producto.listado');
        Route::post('/ajaxListado', [ProductoController::class, 'ajaxListado'])->name('producto.ajaxListado');
        Route::post('/guardarProducto', [ProductoController::class, 'guardarProducto'])->name('producto.guardarProducto');
        Route::post('/eliminarProducto', [ProductoController::class, 'eliminarProducto'])->name('producto.eliminarProducto');

        Route::post('/guardarStockSucursal', [ProductoController::class, 'guardarStockSucursal'])->name('producto.guardarStockSucursal');
        Route::post('/ajaxStockSucursal', [ProductoController::class, 'ajaxStockSucursal'])->name('producto.ajaxStockSucursal');

        Route::post('/ajaxFormTransferencia', [ProductoController::class, 'ajaxFormTransferencia'])->name('producto.ajaxFormTransferencia');
        Route::post('/guardarTransferenciaSucursal', [ProductoController::class, 'guardarTransferenciaSucursal'])->name('producto.guardarTransferenciaSucursal');
        Route::post('/guardarSalidaSucursal', [ProductoController::class, 'guardarSalidaSucursal'])->name('producto.guardarSalidaSucursal');

        Route::get('/pdfProductoStock', [ProductoController::class, 'pdfProductoStock'])->name('producto.pdfProductoStock');

        Route::post('/generarReporteIngreso', [ProductoController::class, 'generarReporteIngreso'])->name('producto.generarReporteIngreso');
        Route::post('/generarReporteSalida', [ProductoController::class, 'generarReporteSalida'])->name('producto.generarReporteSalida');

        Route::post('/importarServiciosProductosExcel', [ProductoController::class, 'importarServiciosProductosExcel'])->name('producto.importarServiciosProductosExcel');
    });

    Route::prefix('/usuario')->group(function () {
        Route::get('/listado', [UserController::class, 'listado'])->name('usuario.listado');
        Route::post('/ajaxListado', [UserController::class, 'ajaxListado'])->name('usuario.ajaxListado');
        Route::post('/guardarUsuario', [UserController::class, 'guardarUsuario'])->name('usuario.guardarUsuario');
        Route::post('/eliminarUsuario', [UserController::class, 'eliminarUsuario'])->name('usuario.eliminarUsuario');
        Route::post('/reset-password', [UserController::class, 'resetPassword'])->name('usuario.resetPassword');
    });

    // SERVICIO
    Route::prefix('/servicio')->group(function () {
        Route::get('/listado', [ServicioController::class, 'listado'])->name('servicio.listado');
        Route::post('/ajaxListado', [ServicioController::class, 'ajaxListado'])->name('servicio.ajaxListado');
        Route::post('/guardarServicio', [ServicioController::class, 'guardarServicio'])->name('servicio.guardarServicio');
        Route::post('/eliminarServicio', [ServicioController::class, 'eliminarServicio'])->name('servicio.eliminarServicio');
    });

    //FACTURA
    Route::prefix('/factura')->group(function () {
        Route::get('/formulario', [FacturaController::class, 'formulario'])->name('factura.formulario');
        Route::get('/listado', [FacturaController::class, 'listado'])->name('factura.listado');
        Route::post('/ajaxListadoFacturas', [FacturaController::class, 'ajaxListadoFacturas'])->name('factura.ajaxListadoFacturas');
        Route::post('/ajaxListadoClientesBusqueda', [FacturaController::class, 'ajaxListadoClientesBusqueda'])->name('factura.ajaxListadoClientesBusqueda');
        Route::post('/emitirRecibo', [FacturaController::class, 'emitirRecibo'])->name('factura.emitirRecibo');
        Route::get('/imprimeRecibo/{factura_id}', [FacturaController::class, 'imprimeRecibo']);
        Route::get('/imprimeReciboRollo/{factura_id}', [FacturaController::class, 'imprimeReciboRollo']);
        Route::post('/anularRecibo', [FacturaController::class, 'anularRecibo'])->name('factura.anularRecibo');
        // Route::post('/reportePDF', [FacturaController::class, 'reportePDF'])->name('factura.reportePDF');
        // Route::post('/ajaxServiciosMascota', [FacturaController::class, 'ajaxServiciosMascota'])->name('factura.ajaxServiciosMascota');
    });

    // CAJA
    Route::prefix('/caja')->group(function () {
        Route::get('/listado', [CajaController::class, 'listado'])->name('caja.listado');
        Route::post('/ajaxListado', [CajaController::class, 'ajaxListado']);
        Route::post('/guardarAperturaCaja', [CajaController::class, 'guardarAperturaCaja']);
        Route::post('/guardarCerrarCaja', [CajaController::class, 'guardarCerrarCaja']);
        Route::post('/habilitarCaja', [CajaController::class, 'habilitarCaja'])->name('caja.habilitarCaja');
    });

    // CLIENTE
    Route::prefix('/cliente')->group(function () {
        Route::get('/listado', [ClienteController::class, 'listado'])->name('cliente.listado');
        Route::post('/ajaxListado', [ClienteController::class, 'ajaxListado'])->name('cliente.ajaxListado');
        Route::post('/guardarCliente', [ClienteController::class, 'guardarCliente'])->name('cliente.guardarCliente');
        Route::post('/eliminarCliente', [ClienteController::class, 'eliminarCliente'])->name('cliente.eliminarCliente');
    });

    //PAGO
    Route::prefix('/pago')->group(function () {
        Route::post('/guardarTipoIngresoSalida', [PagoController::class, 'guardarTipoIngresoSalida']);
        Route::get('/listado', [PagoController::class, 'listado'])->name('pago.listado');
        Route::post('/ajaxListado', [PagoController::class, 'ajaxListado'])->name('pago.ajaxListado');
        Route::get('/listadoDeuda', [PagoController::class, 'listadoDeuda'])->name('pago.listadoDeuda');
        Route::post('/ajaxListadoDeuda', [PagoController::class, 'ajaxListadoDeuda'])->name('pago.ajaxListadoDeuda');
        Route::post('/ajaxFormPagoDeuda', [PagoController::class, 'ajaxFormPagoDeuda'])->name('pago.ajaxFormPagoDeuda');
        Route::post('/guardarPagoDeuda', [PagoController::class, 'guardarPagoDeuda'])->name('pago.guardarPagoDeuda');
        Route::post('/ajaxDescargarReportePago', [PagoController::class, 'ajaxDescargarReportePago'])->name('pago.ajaxDescargarReportePago');
        Route::post('/eliminarPago', [PagoController::class, 'eliminarPago'])->name('pago.eliminarPago');
        Route::get('/comprobantePago/{pago_id}', [PagoController::class, 'comprobantePago'])->name('pago.comprobantePago');
    });
});

require __DIR__.'/auth.php';
