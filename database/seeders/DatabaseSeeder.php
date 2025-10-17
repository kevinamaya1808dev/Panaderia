<?php

namespace Database\Seeders; // Esta debe ser la primera línea de código después de <?php

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
            // CategoriaSeeder::class, // Asegúrate de tener este Seeder
            // ProveedorSeeder::class, // Asegúrate de tener este Seeder
            // ClienteSeeder::class, // Asegúrate de tener este Seeder
        ]);
    }
}