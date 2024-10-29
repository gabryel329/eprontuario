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
        Schema::create('tab_brasindice1', function (Blueprint $table) {
            $table->id();
            $table->string('COD_LAB');
            $table->string('LABORATORIO');
            $table->string('COD_ITEM');
            $table->string('ITEM');
            $table->string('COD_APR');
            $table->string('APRESENTACAO');
            $table->string('PRECO');
            $table->string('QTDE_FRACIONAMENTO');
            $table->string('PMC_PFB');
            $table->string('PRECO_FRACAO');
            $table->string('EDICAO');
            $table->string('IPI');
            $table->string('PORTARIA_PIS_COFINS');
            $table->string('EAN');
            $table->string('TISS');
            $table->string('GENERICO');
            $table->string('TUSS')->nullable();
            $table->timestamps();  // Se 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tab_brasindice1');
    }
};
