<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        if (!Schema::hasColumn('turnos', 'id_usuario')) {
            Schema::table('turnos', function (Blueprint $table) {
                $table->unsignedBigInteger('id_usuario')->after('id_paciente');
            });
        }


        Schema::table('turnos', function (Blueprint $table) {

            $table->dropForeign(['dni_usuario']);


            $table->dropColumn('dni_usuario');
        });
    }

    public function down(): void
    {
        Schema::table('turnos', function (Blueprint $table) {

            $table->string('dni_usuario', 15)->after('id_paciente');


            $table->dropColumn('id_usuario');
        });
    }
};
