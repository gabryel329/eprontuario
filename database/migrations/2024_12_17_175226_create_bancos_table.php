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
        Schema::create('bancos', function (Blueprint $table) {
            $table->id(); // Chave primária
            $table->string('nome'); // Nome do banco
            $table->string('codigo_banco')->unique(); // Código do banco
            $table->string('agencia'); // Agência bancária
            $table->string('numero_conta'); // Número da conta
            $table->string('tipo_conta'); // Tipo de conta (corrente, poupança)
            $table->string('titular'); // Nome do titular
            $table->string('cpf_cnpj'); // CPF ou CNPJ do titular
            $table->string('telefone')->nullable(); // Telefone do titular
            $table->string('email')->nullable(); // E-mail do titular
            $table->text('observacoes')->nullable(); // Observações adicionais
            $table->softDeletes();
            $table->timestamps(); // Datas de criação e atualização
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bancos');
    }
};
