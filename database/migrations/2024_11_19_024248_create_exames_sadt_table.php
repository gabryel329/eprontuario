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
        Schema::create('exames_sadt', function (Blueprint $table) {
            $table->id(); // Chave primária
            $table->unsignedBigInteger('guia_sps_id'); // Relacionamento com guia_sps
            $table->string('tabela')->nullable(); // Campo tabela
            $table->string('codigo_procedimento_solicitado')->nullable(); // Código do procedimento solicitado
            $table->string('descricao_procedimento')->nullable(); // Descrição do procedimento
            $table->integer('qtd_sol')->nullable(); // Quantidade solicitada
            $table->integer('qtd_aut')->nullable(); // Quantidade autorizada
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
        Schema::table('exames_sadt', function (Blueprint $table) {
            //
        });
    }
};
