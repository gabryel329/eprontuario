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
        Schema::create('profissionals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sobrenome');
            $table->string('email')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->date('nasc')->nullable();
            $table->string('cpf')->nullable();
            $table->string('cep')->nullable();
            $table->string('rua')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('uf')->nullable();
            $table->string('numero')->nullable();
            $table->string('complemento')->nullable();
            $table->string('telefone')->nullable();
            $table->string('celular')->nullable();
            $table->string('genero')->nullable();
            $table->string('rg')->nullable();
            $table->string('crm')->nullable();
            $table->string('corem')->nullable();
            $table->string('cor')->nullable();
            $table->string('imagem')->nullable();
            $table->integer('permisoes_id')->nullable();
            $table->foreign('permisoes_id')->references('id')->on('permisoes')->onDelete('cascade');
            $table->integer('especialidade_id')->nullable();
            $table->foreign('especialidade_id')->references('id')->on('especialidades')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profissionals');
    }
};
