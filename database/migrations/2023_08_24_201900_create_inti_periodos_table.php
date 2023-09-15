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
        Schema::create('inti_periodos', function (Blueprint $table) {
            $table->integer('id_periodo')->primary();
            $table->integer('id_anho');
            $table->integer('id_tipo_evento');
            $table->string('nombre', 100)->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->string('comentario',250)->nullable();
            $table->char('estado',1)->nullable()->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inti_periodos');
    }
};
