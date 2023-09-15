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
        Schema::create('inti_grupos', function (Blueprint $table) {
            $table->integer('id_grupo')->primary();
            $table->integer('id_periodo');
            $table->string('nombre', 100)->nullable();
            $table->char('estado',1)->nullable()->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inti_grupos');
    }
};
