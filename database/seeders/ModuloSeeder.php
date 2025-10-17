// database/seeders/ModuloSeeder.php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuloSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('modulos')->insert([
            ['nombre' => 'usuarios', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'cargos', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'productos', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'inventario', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'proveedores', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'ventas', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'compras', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'cajas', 'created_at' => now(), 'updated_at' => now()],
            // Puedes agregar más: 'reportes', 'clientes', etc.
        ]);
    }
}