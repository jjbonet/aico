<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historias_clinicas', function (Blueprint $table) {
            $table->id('id_hc');

            // FK al paciente
            $table->unsignedBigInteger('id_paciente');

            // FK al usuario de Laravel (tabla users)
            $table->unsignedBigInteger('id_usuario');

            $table->time('hora_consulta')->nullable();
            $table->string('motivo_consulta', 255);
            $table->string('diagnostico_principal', 255)->nullable();
            $table->text('descripcion_tratamiento')->nullable();
            $table->text('observaciones')->nullable();

            $table->timestamps();

            $table->foreign('id_paciente')
                ->references('id_paciente')->on('pacientes')
                ->onDelete('cascade');

            $table->foreign('id_usuario')
                ->references('id')->on('users')   // 👈 USAMOS users.id
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historias_clinicas');
    }
};
