// database/seeders/UserSeeder.php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Asegúrate de que los cargos ya existen
        $superAdminCargoId = DB::table('cargos')->where('nombre', 'Super Administrador')->value('id');

        DB::table('users')->insert([
            'name' => 'Super Administrador',
            'email' => 'admin@panaderia.com',
            'password' => Hash::make('password'), // Utiliza una contraseña segura en producción
            'id_cargo_fk' => $superAdminCargoId, // Asigna el Cargo ID 1 (Super Admin)
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}