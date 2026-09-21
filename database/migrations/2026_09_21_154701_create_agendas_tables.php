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
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();

            $table->foreign('usuario_creador_id')->references('id')->on('users');
            $table->unsignedBigInteger('usuario_creador_id')->nullable();
            $table->foreign('usuario_modificador_id')->references('id')->on('users');
            $table->unsignedBigInteger('usuario_modificador_id')->nullable();
            $table->foreign('usuario_eliminador_id')->references('id')->on('users');
            $table->unsignedBigInteger('usuario_eliminador_id')->nullable();
            $table->foreignId('usuario_asignado_id')->nullable()->constrained('users');

            $table->foreignId('sucursal_id')->nullable()->constrained('sucursales');
            $table->foreignId('cliente_id')->nullable()->constrained('clientes');

            $table->string('titulo')->nullable();
            $table->text('descripcion')->nullable();

            $table->dateTime('fecha_inicio')->nullable();
            $table->dateTime('fecha_fin')->nullable();

            $table->string('estado')->default('PENDIENTE')->nullable();
            // PENDIENTE
            // CONFIRMADO
            // ATENDIDO
            // CANCELADO

            $table->string('color')->nullable();

            $table->text('observacion')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
