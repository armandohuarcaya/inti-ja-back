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
        Schema::create('inti_miembros', function (Blueprint $table) {
            $table->integer('id_miembro')->primary();
            $table->string('nombre', 100)->nullable();
            $table->string('ape_paterno', 100)->nullable();
            $table->string('ape_materno', 100)->nullable();
            $table->string('num_documento', 12)->nullable()->unique();
            $table->integer('id_sexo');
            $table->integer('id_tipodocumento');
            $table->string('celular', 20)->nullable();
            $table->string('correo', 100)->nullable();
            $table->char('estado',1)->nullable()->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inti_miembros');
    }
};
