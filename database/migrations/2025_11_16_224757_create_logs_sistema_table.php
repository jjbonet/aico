<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id('id_log');

            $table->unsignedBigInteger('usuario_id')->nullable(); // referencia a users.id
            $table->string('nivel', 50)->default('INFO');
            $table->string('evento', 255);
            $table->text('descripcion')->nullable();
            $table->string('ip_origen', 45)->nullable();

            $table->timestamp('created_at')->useCurrent();

            $table->foreign('usuario_id')
                ->references('id')->on('users')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
