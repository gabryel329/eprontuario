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
        Schema::create('guia_tiss', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Dados da Guia
            $table->string('registro_ans')->nullable(); // 1 - Registro ANS
            $table->string('numero_guia_operadora')->nullable(); // 3 - Número da Guia Atribuído pela Operadora
            
            // Dados do Beneficiário
            $table->string('numero_carteira')->nullable(); // 4 - Número da Carteira
            $table->date('validade_carteira')->nullable(); // 5 - Validade da Carteira
            $table->boolean('atendimento_rn')->nullable(); // 6 - Atendimento a RN (Sim ou Não)
            $table->string('nome_social')->nullable(); // 26 - Nome Social
            $table->string('nome_beneficiario')->nullable(); // 7 - Nome do Beneficiário
            
            // Dados do Contratado
            $table->string('codigo_operadora')->nullable(); // 9 - Código na Operadora
            $table->string('nome_contratado')->nullable(); // 10 - Nome do Contratado
            $table->string('codigo_cnes')->nullable(); // 11 - Código CNES
            
            // Dados do Profissional Executante
            $table->string('nome_profissional_executante')->nullable(); // 12 - Nome do Profissional Executante
            $table->string('conselho_profissional')->nullable(); // 13 - Conselho Profissional
            $table->string('numero_conselho')->nullable(); // 14 - Número no Conselho
            $table->string('uf_conselho')->nullable(); // 15 - UF do Conselho
            $table->string('codigo_cbo')->nullable(); // 16 - Código CBO
            
            // Dados do Atendimento / Procedimento Realizado
            $table->string('indicacao_acidente')->nullable(); // 17 - Indicação de Acidente (acidente ou doença relacionada)
            $table->string('indicacao_cobertura_especial')->nullable(); // 27 - Indicação de Cobertura Especial
            $table->string('regime_atendimento')->nullable(); // 28 - Regime de Atendimento
            $table->string('saude_ocupacional')->nullable(); // 29 - Saúde Ocupacional
            $table->date('data_atendimento')->nullable(); // 18 - Data do Atendimento
            $table->string('tipo_consulta')->nullable(); // 19 - Tipo de Consulta
            $table->string('codigo_tabela')->nullable(); // 20 - Código da Tabela
            $table->string('codigo_procedimento')->nullable(); // 21 - Código do Procedimento
            $table->decimal('valor_procedimento', 10, 2)->nullable(); // 22 - Valor do Procedimento
            
            // Observações e Assinaturas
            $table->text('observacao')->nullable(); // 23 - Observação / Justificativa
            $table->string('assinatura_profissional_executante')->nullable(); // 24 - Assinatura do Profissional Executante
            $table->string('assinatura_beneficiario')->nullable(); // 25 - Assinatura do Beneficiário ou Responsável
            
            // Hash e timestamps
            $table->string('hash')->nullable(); // Hash para validação de integridade
            $table->timestamps(); // Timestamps para created_at e updated_at
            $table->softDeletes(); // Soft Deletes

            $table->integer('convenio_id')->nullable();
            $table->foreign('convenio_id')->references('id')->on('convenios')->onDelete('cascade');
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guia_tiss');
    }
};
