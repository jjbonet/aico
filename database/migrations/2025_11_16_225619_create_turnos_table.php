<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('turnos', function (Blueprint $table) {
            $table->id('id_turno');

            $table->foreignId('id_paciente')->constrained('pacientes')->onDelete('cascade');
            $table->foreignId('id_usuario')->constrained('users')->onDelete('cascade');
            $table->foreignId('historia_clinica_id');

            $table->date('fecha_turno');
            $table->time('hora_turno')->nullable();
            $table->string('motivo')->nullable();
            $table->string('estado')->default('pendiente');

            $table->timestamps();

            // Foreign key manual
            $table->foreign('historia_clinica_id')
                ->references('id_hc')
                ->on('historias_clinicas')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('turnos');
    }
};
