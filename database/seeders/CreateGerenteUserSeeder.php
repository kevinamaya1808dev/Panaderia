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

        // 2) Permisos usados en navegación, controladores y vistas
        $permisos = [
            // Catálogos / módulos
            'ver-categoria','crear-categoria','editar-categoria','eliminar-categoria',
            'ver-presentacione','crear-presentacione','editar-presentacione','eliminar-presentacione',
            'ver-marca','crear-marca','editar-marca','eliminar-marca',
            'ver-producto','crear-producto','editar-producto','eliminar-producto',
            'ver-inventario','crear-inventario', // (si tu controller lo usa)
            'ver-kardex',

            'ver-cliente','crear-cliente','editar-cliente','eliminar-cliente',
            'ver-proveedore','crear-proveedore','editar-proveedore','eliminar-proveedore',

            // Caja / Movimientos
            'ver-caja','aperturar-caja','ver-movimiento','cerrar-caja',

            // Compras
            'ver-compra','crear-compra','mostrar-compra', // 'mostrar-compra' lo usas para botón "Ver"

            // Ventas / POS
            'ver-venta','crear-venta', // si tienes 'mostrar-venta', agrégalo aquí

            // Otros (administración)
            'ver-empresa','editar-empresa',
            'ver-empleado','crear-empleado','editar-empleado','eliminar-empleado',
            'ver-user','crear-user','editar-user','eliminar-user',
            'ver-role','crear-role','editar-role','eliminar-role',
        ];

        foreach ($permisos as $p) {
            Permission::firstOrCreate(['name' => $p, 'guard_name' => 'web']);
        }

        // 3) Roles
        $admin   = Role::firstOrCreate(['name' => 'administrador', 'guard_name' => 'web']);
        $cajero  = Role::firstOrCreate(['name' => 'cajero',        'guard_name' => 'web']);
        $gerente = Role::firstOrCreate(['name' => 'gerente',       'guard_name' => 'web']);

        // 4) Asignación de permisos
        // Admin: todos
        $admin->syncPermissions(Permission::all());

        // Cajero: SOLO Caja, Ventas y Kardex (como pediste)
        $permisosCajero = [
            // Caja
            'ver-caja','aperturar-caja','ver-movimiento','cerrar-caja',
            // Ventas
            'ver-venta','crear-venta',
            // Kardex
            'ver-kardex',
        ];
        $cajero->syncPermissions($permisosCajero);

        // Gerente: mismo operativo que tenía "cajero" antes (puedes ajustar)
        $permisosGerente = [
            'ver-producto','ver-inventario','ver-kardex','ver-cliente',
            'ver-venta','crear-venta',
            'ver-caja','aperturar-caja','ver-movimiento','cerrar-caja',
            // Si quieres que el gerente vea compras en solo lectura, descomenta:
            // 'ver-compra',
        ];
        $gerente->syncPermissions($permisosGerente);

        // 5) (Opcional) Asignar roles a usuarios existentes (si están creados)
        if ($u = User::firstWhere('email', 'admin@demo.com'))    { $u->syncRoles(['administrador']); }
        if ($u = User::firstWhere('email', 'cajero@demo.com'))   { $u->syncRoles(['cajero']); }
        if ($u = User::firstWhere('email', 'gerente@demo.com'))  { $u->syncRoles(['gerente']); }

        // 6) Limpiar caché nuevamente
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
