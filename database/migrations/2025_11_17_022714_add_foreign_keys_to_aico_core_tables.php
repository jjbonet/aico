<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {

        Schema::table('turnos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_usuario')->nullable()->change();
        });


        DB::table('turnos')->update(['id_usuario' => null]);

        Schema::table('turnos', function (Blueprint $table) {
            $table->foreign('id_usuario', 'turnos_id_usuario_foreign')
                ->references('id')
                ->on('users')
                ->nullOnDelete();   // ON DELETE SET NULL
        });
    }

    public function down(): void
    {
        Schema::table('turnos', function (Blueprint $table) {

            $table->dropForeign('turnos_id_usuario_foreign');
        });
    }
};
