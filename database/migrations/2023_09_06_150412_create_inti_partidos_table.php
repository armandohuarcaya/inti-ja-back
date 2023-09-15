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
        Schema::create('inti_partidos', function (Blueprint $table) {
            $table->integer('id_partido')->primary();
            $table->date('fecha')->nullable();
            $table->string('hora_inicio')->nullable();
            $table->string('hora_fin')->nullable();
            $table->string('resultado', 12)->nullable()->default(0);
            $table->integer('id_periodo');
            $table->integer('id_grupo');
            $table->integer('id_categoria');
            $table->integer('id_diciplina');
            $table->integer('id_fase');
            $table->char('finalizado', 2)->nullable()->default('N');
            $table->integer('orden')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inti_partidos');
    }
};
