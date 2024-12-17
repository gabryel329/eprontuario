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
        Schema::create('contas_financeiras', function (Blueprint $table) {
            $table->id();

            // Dados principais
            $table->string('status')->nullable();
            $table->string('tipo_conta')->nullable();
            $table->date('data_emissao')->nullable();
            $table->date('competencia')->nullable();
            $table->date('data_vencimento')->nullable();
            $table->string('referencia')->nullable();
            $table->string('tipo_doc')->nullable();
            $table->string('documento')->nullable();
            $table->string('nao_contabil')->nullable();
            $table->string('parcelas')->nullable();
            $table->string('centro_custos')->nullable();
            $table->string('natureza_operacao')->nullable();
            $table->string('historico')->nullable();

            // Relacionamentos
            $table->foreignId('fornecedor_id')->nullable()->constrained('fornecedores')->onDelete('cascade');

            // Valores financeiros
            $table->decimal('valor')->nullable();
            $table->decimal('desconto')->nullable();
            $table->decimal('taxa_juros')->nullable();
            $table->decimal('icms')->nullable();
            $table->decimal('pis')->nullable();
            $table->decimal('cofins')->nullable();
            $table->decimal('csl')->nullable();
            $table->decimal('iss')->nullable();
            $table->decimal('irrf')->nullable();
            $table->decimal('inss')->nullable();
            $table->decimal('total')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contas_financeiras');
    }
};
