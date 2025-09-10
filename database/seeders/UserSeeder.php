<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario administrador de prueba
        User::create([
            'name' => 'Administrador',
            'username' => 'admin',
            'email' => 'admin@sistema.com',
            'password' => Hash::make('123456'),
            'email_verified_at' => now(),
        ]);

        // Crear usuario doctor de prueba
        User::create([
            'name' => 'Dr. Juan Pérez',
            'username' => 'doctor',
            'email' => 'doctor@sistema.com',
            'password' => Hash::make('123456'),
            'email_verified_at' => now(),
        ]);
    }
}
