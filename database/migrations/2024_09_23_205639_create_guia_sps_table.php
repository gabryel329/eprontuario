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
        Schema::create('guia_sps', function (Blueprint $table) {
            $table->id();

            // Relacionamentos
            $table->integer('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('convenio_id')->nullable();
            $table->foreign('convenio_id')->references('id')->on('convenios')->onDelete('cascade');
            // Campos da guia
            $table->string('registro_ans')->nullable(); // 1 - Registro ANS
            $table->string('numero_guia_prestador')->nullable(); // 3 - Número da Guia do Prestador
            $table->string('data_autorizacao')->nullable(); // 4 - Data da autorização
            $table->string('senha')->nullable(); // 5 - Senha
            $table->string('validade_senha')->nullable(); // 6 - Data de validade da senha
            $table->string('numero_guia_op')->nullable(); // 7 - Número da Guia Atribuído pela Operadora
            // Dados do Beneficiário
            $table->string('numero_carteira')->nullable(); // 8 - Número da Carteira
            $table->date('validade_carteira')->nullable(); // 9 - Validade da Carteira
            $table->string('nome_social')->nullable(); // 10 - Nome Beneficiário
            $table->string('nome_beneficiario')->nullable(); // 10 - Nome Beneficiário
            $table->string('atendimento_rn')->nullable(); // 12 - Atendimento a RN
            // Dados do Solicitante
            $table->string('codigo_operadora')->nullable(); // 13 - Código na Operadora
            $table->string('nome_contratado')->nullable(); // 14 - Nome do Contratado
            $table->string('nome_profissional_solicitante')->nullable(); // 15 - Nome do Profissional Solicitante
            $table->string('conselho_profissional')->nullable(); // 16 - Conselho Profissional
            $table->string('numero_conselho')->nullable(); // 17 - Número do Conselho
            $table->string('uf_conselho')->nullable(); // 18 - UF do Conselho
            $table->string('codigo_cbo')->nullable(); // 19 - Código CBO
            $table->string('assinatura_profissional')->nullable(); // 20 - Assinatura do Profissional Solicitante
            // Dados da Solicitação
            $table->string('carater_atendimento')->nullable(); // 21 - Caráter do Atendimento
            $table->date('data_solicitacao')->nullable(); // 22 - Data da Solicitação
            $table->string('indicacao_clinica')->nullable(); // 23 - Indicação Clínica
            $table->string('codigo_procedimento_solicitado')->nullable(); // 25 - Código do Procedimento Solicitado
            $table->text('descricao_procedimento')->nullable(); // 26 - Descrição do Procedimento
            // Dados do Contratante Executante
            $table->string('codigo_operadora_executante')->nullable(); // 29 - Código da Operadora
            $table->string('nome_contratado_executante')->nullable(); // 30 - Nome do Contratado Executante
            $table->string('codigo_cnes')->nullable(); // 31 - Código CNES
            // Dados do Atendimento
            $table->string('tipo_atendimento')->nullable(); // 32 - Tipo de Atendimento
            $table->string('indicacao_acidente')->nullable(); // 33 - Indicação de Acidente
            $table->string('tipo_consulta')->nullable(); // 34 - Tipo de Consulta
            $table->string('motivo_encerramento')->nullable(); // 35 - Motivo de Encerramento do Atendimento
            $table->string('regime_atendimento')->nullable(); // 91 - Regime de Atendimento
            $table->string('saude_ocupacional')->nullable(); // 92 - Saúde Ocupacional
            // Procedimentos e Exames Realizados
            $table->string('tabela')->nullable(); // 36 - Tabela
            $table->time('hora_inicio_atendimento')->nullable(); // 37 - Hora Início Atendimento
            $table->time('hora_fim_atendimento')->nullable(); // 38 - Hora Fim Atendimento
            $table->string('codigo_procedimento_realizado')->nullable(); // 39 - Código do Procedimento Realizado
            $table->text('descricao_procedimento_realizado')->nullable(); // 41 - Descrição do Procedimento Realizado
            $table->integer('quantidade_solicitada')->nullable(); // 42 - Quantidade Solicitada
            $table->integer('quantidade_autorizada')->nullable(); // 28 - Quantidade Autorizada
            $table->integer('via')->nullable(); // 43 - Via
            $table->integer('tecnica')->nullable(); // 44 - Técnica
            $table->decimal('valor_unitario', 10, 2)->nullable(); // 46 - Valor Unitário
            $table->decimal('valor_total', 10, 2)->nullable(); // 47 - Valor Total

            // Identificação do(s) Profissional(is) Executante(s)
            $table->string('codigo_operadora_profissional')->nullable(); // 50 - Código da Operadora/CPF
            $table->string('nome_profissional')->nullable(); // 51 - Nome do Profissional
            $table->string('sigla_conselho')->nullable(); // 52 - Sigla do Conselho Profissional
            $table->string('numero_conselho_profissional')->nullable(); // 53 - Número do Conselho Profissional
            $table->string('uf_profissional')->nullable(); // 54 - UF do Conselho Profissional
            $table->string('codigo_cbo_profissional')->nullable(); // 55 - Código CBO Profissional

            // Assinaturas
            $table->date('data_realizacao')->nullable(); // 56 - Data de Realização do Procedimento
            $table->string('assinatura_beneficiario')->nullable(); // 57 - Assinatura do Beneficiário ou Responsável

            // Observações
            $table->text('observacao')->nullable(); // 58 - Observações/Justificativa

            // Hash e timestamps
            $table->string('hash')->nullable(); // Hash para validação de integridade
            $table->timestamps(); // Timestamps para created_at e updated_at
            $table->softDeletes(); // Soft Deletes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guia_sps');
    }
};
