<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\homeController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\logoutController;

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\categoriaController;
use App\Http\Controllers\clienteController;
use App\Http\Controllers\compraController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ExportExcelController;
use App\Http\Controllers\ExportPDFController;
use App\Http\Controllers\ImportExcelController;
use App\Http\Controllers\InventarioControlller;
use App\Http\Controllers\KardexController;
use App\Http\Controllers\marcaController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\presentacioneController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\profileController;
use App\Http\Controllers\proveedorController;
use App\Http\Controllers\roleController;
use App\Http\Controllers\userController;
use App\Http\Controllers\ventaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing pública
Route::view('/', 'welcome')->name('welcome');

// Panel (protegido)
Route::get('/panel', [homeController::class, 'index'])
    ->middleware('auth')
    ->name('panel');

/* ============================================================
|  RUTAS COMPARTIDAS (CAJERO + GERENTE + ADMINISTRADOR)
============================================================ */
Route::group([
    'middleware' => ['auth', 'role:cajero|gerente|administrador'],
    'prefix'     => 'admin'
], function () {
    Route::resource('ventas', ventaController::class)->only(['index','create','store','show']);

    Route::resource('cajas', CajaController::class)->only(['index','create','store','destroy']);
    Route::resource('movimientos', MovimientoController::class)->only(['index','store']);

    Route::resource('productos', ProductoController::class)->only(['index','show']);
    Route::resource('inventario', InventarioControlller::class)->only(['index']);
    Route::resource('kardex', KardexController::class)->only(['index']);

    Route::resource('clientes', clienteController::class)->only(['index','show']);

    // 👇 Compras SOLO lectura para cajero/gerente/admin
    Route::resource('compras', compraController::class)->only(['index','show']);

    Route::get('/export-pdf-comprobante-venta/{id}', [ExportPDFController::class, 'exportPdfComprobanteVenta'])
        ->name('export.pdf-comprobante-venta');
    Route::get('/export-excel-vental-all', [ExportExcelController::class, 'exportExcelVentasAll'])
        ->name('export.excel-ventas-all');

    Route::post('/notifications/mark-as-read', function () {
        Auth::user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    })->name('notifications.markAsRead');

    Route::resource('profile', profileController::class)->only(['index','update']);
});

/* ============================================================
|  RUTAS SOLO ADMINISTRADOR
============================================================ */
Route::group([
    'middleware' => ['auth', 'role:administrador'],
    'prefix'     => 'admin'
], function () {
    Route::resource('categorias', categoriaController::class)->except('show');
    Route::resource('presentaciones', presentacioneController::class)->except('show');
    Route::resource('marcas', marcaController::class)->except('show');

    Route::resource('productos', ProductoController::class)->except(['index','show','destroy']);
    Route::resource('proveedores', proveedorController::class)->except('show');

    // 👇 Compras SOLO creación (sin index/show aquí)
    Route::resource('compras', compraController::class)->only(['create','store']);

    Route::resource('inventario', InventarioControlller::class)->only(['create','store']);

    Route::resource('empresa', EmpresaController::class)->only(['index','update']);
    Route::resource('empleados', EmpleadoController::class)->except('show');
    Route::resource('users', userController::class)->except('show');
    Route::resource('roles', roleController::class)->except('show');
    Route::resource('activityLog', ActivityLogController::class)->only('index');

    Route::post('/importar-excel-empleados', [ImportExcelController::class, 'importExcelEmpleados'])
        ->name('import.excel-empleados');

    Route::resource('clientes', clienteController::class)->only(['create','store','edit','update','destroy']);
});

/* ============================================================
|  LOGOUT (solo auth, SIN role)
============================================================ */
Route::middleware('auth')->get('/logout', [logoutController::class, 'logout'])->name('logout');

// Login (público, solo para invitados)
Route::get('/login', [loginController::class, 'index'])->middleware('guest')->name('login.index');
Route::post('/login', [loginController::class, 'login'])->middleware('guest')->name('login.login');
