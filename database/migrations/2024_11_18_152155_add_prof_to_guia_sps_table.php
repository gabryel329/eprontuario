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
        Schema::table('guia_sps', function (Blueprint $table) {
            $table->string('codigo_operadora_profissional1')->nullable(); // 50 - Código da Operadora/CPF
            $table->string('nome_profissional1')->nullable(); // 51 - Nome do Profissional
            $table->string('sigla_conselho1')->nullable(); // 52 - Sigla do Conselho Profissional
            $table->string('numero_conselho_profissional1')->nullable(); // 53 - Número do Conselho Profissional
            $table->string('uf_profissional1')->nullable(); // 54 - UF do Conselho Profissional
            $table->string('codigo_cbo_profissional1')->nullable(); 
            $table->string('codigo_operadora_profissional2')->nullable(); // 50 - Código da Operadora/CPF
            $table->string('nome_profissional2')->nullable(); // 51 - Nome do Profissional
            $table->string('sigla_conselho2')->nullable(); // 52 - Sigla do Conselho Profissional
            $table->string('numero_conselho_profissional2')->nullable(); // 53 - Número do Conselho Profissional
            $table->string('uf_profissional2')->nullable(); // 54 - UF do Conselho Profissional
            $table->string('codigo_cbo_profissional2')->nullable(); 
            $table->string('grua')->nullable(); // 54 - UF do Conselho Profissional
            $table->string('sequencia')->nullable(); 
            $table->string('grau1')->nullable(); // 54 - UF do Conselho Profissional
            $table->string('sequencia1')->nullable(); 
            $table->string('grau2')->nullable(); // 54 - UF do Conselho Profissional
            $table->string('sequencia2')->nullable(); 

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guia_sps', function (Blueprint $table) {
            //
        });
    }
};
