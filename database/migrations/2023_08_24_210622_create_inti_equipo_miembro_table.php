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
        Schema::create('inti_equipo_miembro', function (Blueprint $table) {
            $table->integer('id_equipo_miembro')->primary();
            $table->integer('id_equipo');
            $table->integer('id_miembro');
            $table->integer('id_periodo');
            $table->integer('id_diciplina');
            $table->integer('id_categoria');
            $table->char('estado',1)->nullable()->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inti_equipo_miembro');
    }
};
