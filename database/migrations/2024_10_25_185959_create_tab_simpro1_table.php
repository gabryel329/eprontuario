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
        Schema::create('tab_simpro1', function (Blueprint $table) {
            $table->id();
            $table->string('SEQUENCIA')->notNullable();
            $table->string('CD_SIMPRO')->nullable();
            $table->string('DESCRICAO')->notNullable();
            $table->string('VIGENCIA')->nullable();
            $table->string('PC_FR_FAB')->nullable();
            $table->string('TP_EMBAL' )->nullable();
            $table->string('TP_FRACAO')->nullable();
            $table->string('CD_MERCACAO')->nullable();
            $table->string('FABRICA')->nullable();
            $table->string('PC_FR_VEND')->nullable();
            $table->string('PAGINA')->nullable();
            $table->string('DATA2')->nullable();
            $table->string('DATASINC')->nullable();
            $table->string('TUSS')->nullable();
            $table->string('ANVISA')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tab_simpro1');
    }
};
