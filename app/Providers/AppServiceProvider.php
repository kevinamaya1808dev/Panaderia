<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Permiso;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Schema; // Asegúrate de importar Schema

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        //
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        // 1. Gate para Super Administrador (ID=1)
        // El Super Admin puede hacer todo sin revisar permisos específicos.
        Gate::before(function ($user, $ability) {
            // Asumiendo que el Cargo con ID=1 es 'Super Administrador'
            if ($user->cargo_id == 1) { 
                return true;
            }
        });

        // 2. Gates dinámicos basados en la tabla 'permisos'
        try {
            // Solo intenta cargar los permisos si la tabla existe
            if (Schema::hasTable('permisos') && Schema::hasTable('modulos')) {
                
                // Mapear los nombres internos de los módulos (ej: 'productos' -> id)
                $modulos = \App\Models\Modulo::pluck('nombre', 'id');

                // Cargar todos los permisos
                $permisos = Permiso::with('modulo')->get();

                // Definir los Gates (pueden ser 'alta', 'editar', 'eliminar', 'mostrar')
                foreach ($permisos as $permiso) {
                    
                    $moduloNombre = $permiso->modulo->nombre; // Ej: 'productos'

                    // Gates de ALTA: Ej. 'alta-productos'
                    if ($permiso->alta) {
                         Gate::define("alta-{$moduloNombre}", function (User $user) use ($permiso) {
                            return $user->cargo_id == $permiso->cargo_id;
                        });
                    }

                    // Gates de EDITAR: Ej. 'editar-productos'
                    if ($permiso->editar) {
                         Gate::define("editar-{$moduloNombre}", function (User $user) use ($permiso) {
                            return $user->cargo_id == $permiso->cargo_id;
                        });
                    }

                    // ... Repite para 'eliminar' y 'mostrar' si lo deseas, o usa el Gate más amplio.
                }
            }
        } catch (\Exception $e) {
            // Esto evita fallas si la base de datos no está migrada
        }
    }
}