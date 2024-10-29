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
        Schema::create('tab_amb961', function (Blueprint $table) {
            $table->id();
            
            $table->string('codigo')->nullable();  // CÓDIGO
            $table->string('procedimento')->nullable();  // PROCEDIMENTO
            $table->string('hm')->nullable();  // HM (R$)
            $table->string('cop')->nullable();  // C.Op.(R$)
            $table->string('num_aux')->nullable();  // Nº Aux.
            $table->string('porte')->nullable();  // Porte
            $table->string('incid')->nullable();  // Incid.
            $table->string('filme_m2')->nullable();  // Filme (m2)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tab_amb96_1');
    }
};
