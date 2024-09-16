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
        Schema::create('guia_honorarios', function (Blueprint $table) {
            $table->id();
            $table->string('registro_ans', 255); // Registro ANS 3
            $table->string('num_guia_solicitacao_internacao', 255); // Nº Guia de solicitação de internação 4
            $table->string('senha', 255); // Senha 5
            $table->string('num_guia_atribuido_operadora', 255); // Número da Guia Atribuido pela Operadora
            $table->string('numero_carteira', 255); // Numero da Carteira 41
            $table->string('nome_social', 255)->nullable(); // Nome Social
            $table->boolean('atendimento_rn'); // Atendimento a RN 7
            $table->string('nome', 255); // Nome
        
            // Informações do Hospital/Local
            $table->string('codigo_operadora', 255); // Código na Operadora 10
            $table->string('nome_hospital', 255); // Nome do Hospital/Local 12
            $table->string('codigo_operadora_contratado', 255); // Código na Operadora 13
            $table->string('nome_contratado', 255); // Nome do Contratado 14
            $table->string('codigo_cnes', 255); // Código CNES
        
            // Data do faturamento
            $table->date('data_inicio_faturamento'); // Data do inicio do faturamento 16
            $table->date('data_fim_faturamento'); // Data do fim do faturamento 16
        
            // Procedimento
            $table->date('data'); // Data 18
            $table->time('hora_inicial'); // Hora inicial 19
            $table->time('hora_final'); // Hora final 20
            $table->string('tabela', 255); // Tabela 21
            $table->string('codigo_procedimento', 255); // Código do Procedimento 22
            $table->string('descricao', 255); // Descrição 23
            $table->integer('quantidade'); // Qtde. 24
            $table->string('via', 255); // Via 25
            $table->string('tecnica', 255); // Téc. 26
            $table->decimal('fator_reducao', 8, 2); // Fator Red. 27
            $table->decimal('valor_unitario', 10, 2); // Valor Unitário-R$ 28
            $table->decimal('valor_total', 10, 2); // Valor Total-R$ 28
        
            // Informações dos profissionais
            $table->string('seq_ref', 255); // Seq.Ref 30
            $table->string('grau_part', 255); // Grau Part 31
            $table->string('codigo_operadora_profissional', 255); // Código na operadora 32
            $table->string('cpf_profissional', 255); // CPF 32
            $table->string('nome_profissional', 255); // Nome do profissional 33
            $table->string('conselho', 255); // Conselho 34
            $table->string('numero_conselho', 255); // Número do Conselho 35
            $table->string('uf_conselho', 2); // UF 36
            $table->string('codigo_cbo', 255); // Código CBO 37
        
            // Observações
            $table->text('observacoes')->nullable(); // Observações / Justificativa 38
            $table->decimal('valor_total_honorarios', 10, 2); // Valor Total dos Honorários 39
            $table->date('data_emissao'); // Data de emissão 40
            $table->string('assinatura_profissional', 255); // Assinatura do profissional Executante 41
        
            $table->timestamps(); // Cria os campos created_at e updated_at
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guia_honorarios');
    }
};
