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
        Schema::create('inti_fases', function (Blueprint $table) {
            $table->integer('id_fase')->primary();
            $table->string('nombre', 100)->nullable();
            $table->string('codigo', 5)->nullable();
            $table->char('activo', 1)->nullable()->default('N');
            $table->char('estado', 1)->nullable()->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inti_fases');
    }
};
