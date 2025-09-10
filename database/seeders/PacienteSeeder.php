<?php

namespace Database\Seeders;

use App\Models\Paciente;
use Illuminate\Database\Seeder;

class PacienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pacientes = [
            [
                'nombre' => 'María García López',
                'documento' => '12345678',
                'fecha_nacimiento' => '1985-03-15',
                'telefono' => '555-0101',
            ],
            [
                'nombre' => 'Carlos Rodríguez Pérez',
                'documento' => '23456789',
                'fecha_nacimiento' => '1978-07-22',
                'telefono' => '555-0102',
            ],
            [
                'nombre' => 'Ana Martínez Silva',
                'documento' => '34567890',
                'fecha_nacimiento' => '1992-11-08',
                'telefono' => '555-0103',
            ],
            [
                'nombre' => 'Luis Fernando Torres',
                'documento' => '45678901',
                'fecha_nacimiento' => '1965-05-30',
                'telefono' => '555-0104',
            ],
            [
                'nombre' => 'Patricia Jiménez Castro',
                'documento' => '56789012',
                'fecha_nacimiento' => '1988-09-12',
                'telefono' => '555-0105',
            ],
            [
                'nombre' => 'Roberto Sánchez Morales',
                'documento' => '67890123',
                'fecha_nacimiento' => '1975-12-03',
                'telefono' => '555-0106',
            ],
            [
                'nombre' => 'Carmen Delgado Ruiz',
                'documento' => '78901234',
                'fecha_nacimiento' => '1990-01-25',
                'telefono' => '555-0107',
            ],
            [
                'nombre' => 'Miguel Ángel Herrera',
                'documento' => '89012345',
                'fecha_nacimiento' => '1982-04-18',
                'telefono' => '555-0108',
            ],
            [
                'nombre' => 'Elena Vargas Mendoza',
                'documento' => '90123456',
                'fecha_nacimiento' => '1995-08-07',
                'telefono' => '555-0109',
            ],
            [
                'nombre' => 'Francisco Javier Ortiz',
                'documento' => '01234567',
                'fecha_nacimiento' => '1970-06-14',
                'telefono' => '555-0110',
            ],
        ];

        foreach ($pacientes as $pacienteData) {
            Paciente::create($pacienteData);
        }
    }
}
