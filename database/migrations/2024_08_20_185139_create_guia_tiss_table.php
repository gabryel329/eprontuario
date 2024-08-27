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
            $table->integer('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('convenio_id')->nullable();
            $table->foreign('convenio_id')->references('id')->on('convenios')->onDelete('cascade');
            $table->string('registro_ans')->nullable(); // Registro ANS da operadora
            $table->string('numero_guia_prestador')->nullable(); // Número da guia do prestador
            $table->string('numero_carteira')->nullable(); // Número da carteira do beneficiário
            $table->string('nome_beneficiario')->nullable(); // Nome do beneficiário
            $table->date('data_atendimento')->nullable(); // Data do atendimento
            $table->time('hora_inicio_atendimento')->nullable(); // Hora de início do atendimento
            $table->string('tipo_consulta')->nullable(); // Tipo de consulta
            $table->string('indicacao_acidente')->nullable(); // Indicação de acidente
            $table->string('codigo_tabela')->nullable(); // Código da tabela usada para procedimentos
            $table->string('codigo_procedimento')->nullable(); // Código do procedimento realizado
            $table->decimal('valor_procedimento', 10, 2)->nullable(); // Valor do procedimento realizado
            $table->string('nome_profissional')->nullable(); // Nome do profissional que realizou o atendimento
            $table->string('sigla_conselho')->nullable(); // Sigla do conselho profissional (CRM, etc.)
            $table->string('numero_conselho')->nullable(); // Número do conselho profissional
            $table->string('uf_conselho')->nullable(); // UF do conselho profissional
            $table->string('cbo')->nullable(); // Código CBO (Classificação Brasileira de Ocupações)
            $table->text('observacao')->nullable(); // Observações adicionais
            $table->string('hash')->nullable(); // Hash para validação de integridade
            $table->timestamps(); // Timestamps para created_at e updated_at
            $table->softDeletes();
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
