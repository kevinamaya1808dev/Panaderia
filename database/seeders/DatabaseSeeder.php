// database/seeders/DatabaseSeeder.php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // 1. ACLs (Deben ir primero)
            CargoSeeder::class,
            ModuloSeeder::class,
            PermisoSeeder::class, // Ejecuta después de Cargo y Módulo

            // 2. Usuario Inicial (Depende de Cargos)
            UserSeeder::class, 

            // 3. Datos de catálogo
            CategoriaSeeder::class,
            // ProveedorSeeder::class,
            // ClienteSeeder::class,
        ]);
    }
}