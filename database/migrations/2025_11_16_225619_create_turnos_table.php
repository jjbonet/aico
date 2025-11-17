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

            // FK a pacientes.id_paciente
            $table->unsignedBigInteger('id_paciente');

            // DNI del usuario (referencia a users.dni)
            $table->string('dni_usuario', 15);

            $table->date('fecha_turno');
            $table->time('hora_turno')->nullable();
            $table->string('motivo', 255)->nullable();
            $table->string('estado', 50)->default('pendiente');

            $table->timestamps();

            // FK explícita a pacientes.id_paciente
            $table->foreign('id_paciente')
                ->references('id_paciente')
                ->on('pacientes')
                ->onDelete('cascade');

            // FK explícita a users.dni (dni es unique, se puede)
            $table->foreign('dni_usuario')
                ->references('dni')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('turnos');
    }
};
