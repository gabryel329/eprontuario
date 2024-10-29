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
        Schema::create('tab_amb921', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->nullable();  // Código
            $table->string('descricao')->nullable();  // Descrição
            $table->string('m2')->nullable();  // m²
            $table->string('filme')->nullable();  // Filme
            $table->string('auxiliares')->nullable();  // Auxiliares
            $table->string('incidencia')->nullable();  // Incidência
            $table->string('porte')->nullable();  // Porte
            $table->string('anestesico')->nullable();  // Anestésico
            $table->string('tabela')->nullable();  // Tabela
            $table->string('valor_co')->nullable();  // Valor CO
            $table->string('valor_total')->nullable();  // Valor Total
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tab_amb92_1');
    }
};
