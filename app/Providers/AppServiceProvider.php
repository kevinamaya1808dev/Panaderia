<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Empleado;
use App\Models\Permiso;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [];

    public function boot()
    {
        $this->registerPolicies();

        // Obtener todos los permisos y definir los Gates
        try {
            if (\Schema::hasTable('permisos')) {
                // Usamos un nombre de clase explícito para evitar problemas de binding
                $permisos = Permiso::all();

                foreach ($permisos as $permiso) {
                    // Define un Gate con el nombre del permiso (ej: 'manage-categorias')
                    Gate::define($permiso->nombre, function (Empleado $empleado) use ($permiso) {
                        
                        // Busca si el cargo del empleado tiene asociado este permiso
                        return $empleado->cargo->permisos->contains('nombre', $permiso->nombre);
                    });
                }
            }
        } catch (\Exception $e) {
            // Esto evita que falle si la base de datos o la tabla 'permisos' no están listas
            \Log::warning('Error al cargar Gates de permisos: ' . $e->getMessage());
        }
    }
}
