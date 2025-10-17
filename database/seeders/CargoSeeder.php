// database/seeders/CargoSeeder.php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CargoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('cargos')->insert([
            ['nombre' => 'Super Administrador', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Administrador', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Cajero / Vendedor', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Inventario', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}