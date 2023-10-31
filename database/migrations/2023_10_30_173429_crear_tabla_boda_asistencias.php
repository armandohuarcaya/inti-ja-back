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
        Schema::create('boda_asistencias', function (Blueprint $table) {
            $table->integer('id_asistencia')->primary();
            $table->string('nombre', 100)->nullable();
            $table->string('celular', 12)->nullable();
            $table->string('codigo', 5)->nullable();
            $table->char('estado', 1)->nullable()->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boda_asistencias');
    }
};
