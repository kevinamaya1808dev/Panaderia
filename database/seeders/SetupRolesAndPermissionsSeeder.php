<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;

class SetupRolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // 1) Limpiar caché de permisos/roles
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 2) Permisos EXACTOS usados en tu navigation-menu.blade.php
        $permisos = [
            // Catálogos / módulos
            'ver-categoria', 'ver-presentacione', 'ver-marca',
            'ver-producto', 'ver-inventario', 'ver-kardex',
            'ver-cliente', 'ver-proveedore', 'ver-caja',
            // Compras
            'ver-compra', 'crear-compra',
            // Ventas / POS
            'ver-venta', 'crear-venta',
            // Otros
            'ver-empresa', 'ver-empleado', 'ver-user', 'ver-role',
        ];

        foreach ($permisos as $p) {
            Permission::firstOrCreate(['name' => $p, 'guard_name' => 'web']);
        }

        // 3) Roles
        $admin  = Role::firstOrCreate(['name' => 'administrador', 'guard_name' => 'web']);
        $cajero = Role::firstOrCreate(['name' => 'cajero',        'guard_name' => 'web']);

        // 4) Asignar permisos a cada rol
        $admin->syncPermissions(Permission::all());

        $permisosCajero = [
            'ver-producto','ver-inventario','ver-kardex','ver-cliente',
            'ver-venta','crear-venta',
            'ver-caja',
            // si quieres que el cajero vea compras en solo lectura, agrega 'ver-compra'
        ];
        $cajero->syncPermissions($permisosCajero);

        // 5) (Opcional) Asignar roles a usuarios existentes
        // Cambia los correos por los de tus usuarios reales
        if ($u = User::firstWhere('email', 'admin@demo.com'))  { $u->syncRoles(['administrador']); }
        if ($u = User::firstWhere('email', 'cajero@demo.com')) { $u->syncRoles(['cajero']); }

        // 6) Volver a limpiar caché por seguridad
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
