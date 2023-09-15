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
        Schema::create('inti_grupo_equipo', function (Blueprint $table) {
            $table->integer('id_grupo_equipo')->primary();
            $table->integer('id_grupo');
            $table->integer('id_equipo');
            $table->integer('id_categoria');
            $table->integer('id_diciplina');
            $table->integer('id_periodo');
            $table->integer('partido_jugado')->nullable()->default(0);
            $table->integer('ganado')->nullable()->default(0);
            $table->integer('empate')->nullable()->default(0);
            $table->integer('perdido')->nullable()->default(0);
            $table->integer('goles_favor')->nullable()->default(0);
            $table->integer('goles_contra')->nullable()->default(0);
            $table->integer('diferencia_goles')->nullable()->default(0);
            $table->integer('puntos')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inti_grupo_equipo');
    }
};
