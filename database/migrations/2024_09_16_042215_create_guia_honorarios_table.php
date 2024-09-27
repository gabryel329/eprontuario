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
            $table->id(); // ID da guia de honorários
            $table->integer('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('convenio_id')->nullable();
            $table->foreign('convenio_id')->references('id')->on('convenios')->onDelete('cascade');
            $table->string('registro_ans', 20)->nullable(); // Campo 1 - Registro ANS
            $table->string('numero_guia_solicitacao', 50)->nullable(); // Campo 3 - Nº Guia de solicitação de internação
            $table->string('numero_guia_prestador')->nullable();
            $table->string('senha', 50)->nullable(); // Campo 4 - Senha
            $table->string('numero_guia_operadora', 50)->nullable(); // Campo 5 - Nº Guia Atribuído pela Operadora
            $table->string('numero_carteira', 50)->nullable(); // Campo 6 - Número da Carteira
            $table->string('nome_social', 100)->nullable(); // Campo 41 - Nome Social
            $table->string('atendimento_rn')->default(false)->nullable(); // Campo 8 - Atendimento RN (booleano)
            $table->string('nome_beneficiario', 100)->nullable(); // Campo 7 - Nome do Beneficiário
            $table->string('codigo_operadora_contratado', 50)->nullable(); // Campo 9 - Código na Operadora (Contratado)
            $table->string('nome_hospital_local', 100)->nullable(); // Campo 10 - Nome do Hospital/Local
            $table->string('codigo_cnes_contratado', 20)->nullable(); // Campo 11 - Código CNES do Contratado
            $table->string('nome_contratado', 100)->nullable(); // Campo 13 - Nome do Contratado
            $table->string('codigo_operadora_executante', 50)->nullable(); // Campo 12 - Código na Operadora (Executante)
            $table->string('codigo_cnes_executante', 20)->nullable(); // Campo 14 - Código CNES do Executante
            $table->date('data_inicio_faturamento')->nullable(); // Campo 15 - Data do início do faturamento
            $table->date('data_fim_faturamento')->nullable(); // Campo 16 - Data do fim do faturamento
            $table->text('observacoes')->nullable();
        
            // Campo 38 - Valor Total dos Honorários
            $table->decimal('valor_total_honorarios', 10, 2)->nullable();
        
            // Campo 39 - Data de emissão
            $table->date('data_emissao')->nullable();
        
            // Campo 40 - Assinatura do profissional executante
            $table->string('assinatura_profissional_executante', 255)->nullable();
        
            $table->timestamps();
            $table->softDeletes();
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
