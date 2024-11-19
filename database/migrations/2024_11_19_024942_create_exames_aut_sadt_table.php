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
        Schema::create('exames_aut_sadt', function (Blueprint $table) {
            $table->id(); // Chave primária
            $table->unsignedBigInteger('guia_sps_id'); // Relacionamento com guia_sps
            $table->date('data_real')->nullable(); // Data do atendimento
            $table->string('hora_inicio_atendimento')->nullable(); // Hora de início
            $table->string('hora_fim_atendimento')->nullable(); // Hora de término
            $table->string('tabela')->default('22'); // Campo tabela com valor padrão
            $table->string('codigo_procedimento_realizado')->nullable(); // Código do procedimento realizado
            $table->string('descricao_procedimento_realizado')->nullable(); // Descrição do procedimento realizado
            $table->string('quantidade_autorizada')->nullable(); // Quantidade autorizada
            $table->string('via')->nullable(); // Via (Unidade, Múltiplo, etc.)
            $table->string('tecnica')->nullable(); // Técnica (Unilateral, Bilateral, etc.)
            $table->string('fator_red_acres')->nullable(); // Fator redutor/acrescentador
            $table->string('valor_unitario')->nullable(); // Valor unitário
            $table->string('valor_total')->nullable(); // Valor total
            $table->timestamps();

            // Chave estrangeira para garantir integridade referencial
            $table->foreign('guia_sps_id')->references('id')->on('guia_sps')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exames_aut_sadt', function (Blueprint $table) {
            //
        });
    }
};
