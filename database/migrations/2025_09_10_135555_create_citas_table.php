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
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');
            $table->date('fecha');
            $table->time('hora');
            $table->text('motivo');
            $table->enum('estado', ['programada', 'confirmada', 'cancelada', 'completada'])->default('programada');
            $table->timestamps();

            // Índices para mejorar consultas
            $table->index(['fecha', 'hora']);
            $table->index('paciente_id');
            $table->index('estado');

            // Evitar citas duplicadas en el mismo horario
            $table->unique(['fecha', 'hora']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
