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
        Schema::create('inti_partidos_detalle', function (Blueprint $table) {
            $table->integer('id_partido_detalle')->primary();
            $table->integer('id_grupo_equipo');
            $table->char('gano', 1)->nullable()->default('N');
            $table->integer('id_partido');
            $table->integer('resultado')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inti_partidos_detalle');
    }
};
