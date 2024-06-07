<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sobrenome');
            $table->string('email')->nullable();
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
            $table->string('nome_social')->nullable();
            $table->string('nome_pai')->nullable();
            $table->string('nome_mae')->nullable();
            $table->string('acompanhante')->nullable();
            $table->string('genero')->nullable();
            $table->string('rg')->nullable();
            $table->string('certidao')->nullable();
            $table->string('sus')->nullable();
            $table->string('convenio')->nullable();
            $table->string('matricula')->nullable();
            $table->string('cor')->nullable();
            $table->string('imagem')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};