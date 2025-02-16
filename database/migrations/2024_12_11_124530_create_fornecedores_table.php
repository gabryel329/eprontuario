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
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->id();
            $table->string('cnpj')->nullable();
            $table->string('cpf')->nullable();
            $table->string('name')->nullable();
            $table->string('fantasia')->nullable();
            $table->string('insc_est')->nullable();
            $table->string('insc_municipal')->nullable();
            $table->string('cep')->nullable();
            $table->string('rua')->nullable();
            $table->string('numero')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('uf')->nullable();
            $table->string('tipo')->nullable();
            $table->string('tipo_cf_a')->nullable();
            $table->string('grupo')->nullable();
            $table->string('site')->nullable();
            $table->string('contato_principal')->nullable();
            $table->string('senha')->nullable();
            $table->string('prazo')->nullable();
            $table->string('email')->nullable();
            $table->string('telefone')->nullable();
            $table->string('valor_mensal')->nullable();
            $table->date('ultimo_reajuste')->nullable();
            $table->date('dia_vencimento')->nullable();
            $table->date('valido_ate')->nullable();
            $table->string('juros_dia')->nullable();
            $table->string('multa')->nullable();
            $table->string('multa_dia')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fornecedores');
    }
};
