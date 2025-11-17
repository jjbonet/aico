<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estudios', function (Blueprint $table) {
            $table->id('id_estudio');

            $table->unsignedBigInteger('id_paciente');

            $table->text('descripcion')->nullable();
            $table->string('archivo_url', 255)->nullable();
            $table->string('tipo_archivo', 50)->nullable();
            $table->timestamp('ts_subida')->useCurrent();

            $table->timestamps();

            $table->foreign('id_paciente')
                ->references('id_paciente')->on('pacientes')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estudios');
    }
};
