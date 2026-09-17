<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\SucursalController;
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
});

require __DIR__.'/auth.php';
