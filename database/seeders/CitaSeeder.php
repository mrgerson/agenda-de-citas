<?php

namespace Database\Seeders;

use App\Models\Cita;
use App\Models\Paciente;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CitaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todos los pacientes existentes
        $pacientes = Paciente::all();

        if ($pacientes->isEmpty()) {
            $this->command->warn('No hay pacientes en la base de datos. Ejecuta primero el PacienteSeeder.');
            return;
        }

        // Motivos comunes para citas médicas
        $motivos = [
            'Consulta general - Revisión de rutina y chequeo de salud general',
            'Dolor de cabeza persistente - Evaluación de cefaleas recurrentes',
            'Control de presión arterial - Seguimiento de hipertensión',
            'Consulta por dolor abdominal - Evaluación de molestias digestivas',
            'Chequeo preventivo - Examen médico anual de prevención',
            'Consulta por fiebre - Evaluación de síntomas gripales',
            'Control de diabetes - Seguimiento de glucosa en sangre',
            'Dolor de espalda - Evaluación de molestias lumbares',
            'Consulta dermatológica - Revisión de lesiones en la piel',
            'Control post-operatorio - Seguimiento después de cirugía',
            'Consulta por alergias - Evaluación de reacciones alérgicas',
            'Examen oftalmológico - Revisión de la vista',
            'Consulta cardiológica - Evaluación del sistema cardiovascular',
            'Control de colesterol - Seguimiento de lípidos en sangre',
            'Consulta por insomnio - Evaluación de trastornos del sueño'
        ];

        $estados = ['programada', 'confirmada', 'cancelada', 'completada'];

        // Crear citas para los próximos días y algunos días pasados
        $fechasBase = [];

        // Citas pasadas (últimos 7 días)
        for ($i = 7; $i >= 1; $i--) {
            $fechasBase[] = Carbon::now()->subDays($i);
        }

        // Citas futuras (próximos 14 días)
        for ($i = 0; $i <= 14; $i++) {
            $fechasBase[] = Carbon::now()->addDays($i);
        }

        $citasCreadas = 0;
        $horariosUsados = [];

        foreach ($fechasBase as $fecha) {
            // Solo crear citas en días laborables
            if ($fecha->isWeekend()) {
                continue;
            }

            // Crear entre 2 y 6 citas por día
            $citasPorDia = rand(2, 6);
            $horariosDelDia = [];

            for ($j = 0; $j < $citasPorDia; $j++) {
                // Generar horario aleatorio entre 8:00 y 17:30
                $hora = rand(8, 17);
                $minutos = [0, 30][rand(0, 1)]; // Solo :00 o :30

                $horarioCompleto = sprintf('%02d:%02d', $hora, $minutos);
                $fechaHorario = $fecha->format('Y-m-d') . ' ' . $horarioCompleto;

                // Evitar duplicados en el mismo día
                if (in_array($fechaHorario, $horariosUsados)) {
                    continue;
                }

                $horariosUsados[] = $fechaHorario;

                // Seleccionar paciente aleatorio
                $paciente = $pacientes->random();

                // Determinar estado basado en la fecha
                if ($fecha->isPast()) {
                    // Citas pasadas: mayoría completadas, algunas canceladas
                    $estado = rand(1, 10) <= 8 ? 'completada' : 'cancelada';
                } elseif ($fecha->isToday()) {
                    // Citas de hoy: confirmadas o programadas
                    $estado = rand(1, 10) <= 7 ? 'confirmada' : 'programada';
                } else {
                    // Citas futuras: mayoría programadas, algunas confirmadas
                    $estado = rand(1, 10) <= 6 ? 'programada' : 'confirmada';
                }

                Cita::create([
                    'paciente_id' => $paciente->id,
                    'fecha' => $fecha->format('Y-m-d'),
                    'hora' => $horarioCompleto,
                    'motivo' => $motivos[array_rand($motivos)],
                    'estado' => $estado,
                    'created_at' => now()->subDays(rand(1, 5)),
                    'updated_at' => now()->subDays(rand(0, 2)),
                ]);

                $citasCreadas++;
            }
        }

        $this->command->info("Se crearon {$citasCreadas} citas de prueba.");

        // Mostrar estadísticas
        $stats = Cita::selectRaw('estado, COUNT(*) as total')
            ->groupBy('estado')
            ->get()
            ->pluck('total', 'estado')
            ->toArray();

        $this->command->info('Estadísticas de citas creadas:');
        foreach ($stats as $estado => $total) {
            $this->command->info("- {$estado}: {$total} citas");
        }
    }
}
