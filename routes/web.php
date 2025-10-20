<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\CargoController; // AGREGADO
use App\Http\Controllers\PermisoController; // AGREGADO

/*
|--------------------------------------------------------------------------
| Rutas Públicas (Autenticación)
|--------------------------------------------------------------------------
| Estas rutas permiten iniciar sesión y ver la página principal (welcome).
*/

Route::get('/', function () {
    return view('welcome');
});

// Rutas de Login y Logout usando nuestro AuthController personalizado
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);


/*
|--------------------------------------------------------------------------
| Rutas Protegidas (Requiere Sesión y Autorización)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    
    // 1. DASHBOARD
    // Ahora usa el DashboardController y NO requiere 'verified'
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. PERFIL DE USUARIO (Si lo quieres mantener)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // 3. LOGOUT (Método POST seguro)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // 4. MÓDULOS DE RECURSOS (Aquí aplicarías los Gates de permiso)
    Route::resource('empleados', EmpleadoController::class);
    Route::resource('clientes', ClienteController::class);
    
    // ==========================================================
    // INICIO: RUTAS DE GESTIÓN DE ROLES Y PERMISOS (RBAC)
    // ==========================================================

    // CRUD completo para Cargos (Roles)
    Route::resource('cargos', CargoController::class);
    
    // Rutas específicas para la MATRIZ de Permisos (vinculadas a un Cargo)
    // Muestra la matriz de permisos
    Route::get('cargos/{cargo}/permisos', [PermisoController::class, 'index'])->name('cargos.permisos.index');
    
    // Guarda/Actualiza los cambios en la matriz
    Route::put('cargos/{cargo}/permisos', [PermisoController::class, 'update'])->name('cargos.permisos.update');
    
    // ==========================================================
    // FIN: RUTAS DE GESTIÓN DE ROLES Y PERMISOS (RBAC)
    // ==========================================================
    
    // AÑADE AQUÍ EL RESTO DE TUS CONTROLADORES (Productos, Ventas, Cajas, etc.)

});
