<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('historias_clinicas', function (Blueprint $table) {
            if (!Schema::hasColumn('historias_clinicas', 'fecha_consulta')) {
                $table->date('fecha_consulta')
                    ->nullable()
                    ->after('id_usuario');
            }
        });
    }

    public function down(): void
    {
        Schema::table('historias_clinicas', function (Blueprint $table) {
            if (Schema::hasColumn('historias_clinicas', 'fecha_consulta')) {
                $table->dropColumn('fecha_consulta');
            }
        });
    }
};
