<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admisiones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cita_id')->constrained('citas')->onDelete('cascade');
            $table->boolean('asistencia')->default(false); // Si el paciente asistió o no
            $table->text('notas')->nullable(); // Notas de admisión
            $table->datetime('fecha_admision')->nullable(); // Cuándo se registró la admisión
            $table->string('estado')->default('pendiente'); // pendiente, admitido, no_asistio
            $table->timestamps();

            // Índices para mejorar consultas
            $table->index('cita_id');
            $table->index('estado');
            $table->index('fecha_admision');

            // Una cita solo puede tener una admisión
            $table->unique('cita_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admisiones');
    }
};
