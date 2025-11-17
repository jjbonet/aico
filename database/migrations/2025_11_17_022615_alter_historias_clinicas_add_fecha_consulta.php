<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('historias_clinicas', function (Blueprint $table) {

            $table->date('fecha_consulta')->after('id_usuario')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('historias_clinicas', function (Blueprint $table) {
            $table->dropColumn('fecha_consulta');
        });
    }
};
