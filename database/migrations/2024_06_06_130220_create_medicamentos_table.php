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
        Schema::create('medicamentos', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->nullable();
            $table->string('marca')->nullable();
            $table->string('tipo')->nullable();
            $table->string('grupo')->nullable();
            $table->string('sub_grupo')->nullable();
            $table->string('produto')->nullable();
            $table->decimal('preco_venda', 10, 2)->default(0)->nullable();
            $table->string('natureza')->nullable();
            $table->string('substancias')->nullable();
            $table->string('ativo')->nullable();
            $table->string('controlado')->nullable();
            $table->string('padrao')->nullable();
            $table->string('ccih')->nullable();
            $table->string('generico')->nullable();
            $table->string('consignado')->nullable();
            $table->string('disp_emergencia')->nullable();
            $table->string('disp_paciente')->nullable();
            $table->string('fracionado')->nullable();
            $table->string('imobilizado')->nullable();
            $table->string('antibiotico')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medicamentos', function (Blueprint $table) {
            //
        });
    }
};
