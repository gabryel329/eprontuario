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
        Schema::create('convenios', function (Blueprint $table) {
            $table->id();
            $table->string('cnpj')->nullable();
            $table->string('ans')->nullable();
            $table->string('nome')->nullable();
            $table->string('cep')->nullable();
            $table->string('rua')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('uf')->nullable();
            $table->string('numero')->nullable();
            $table->string('complemento')->nullable();
            $table->string('telefone')->nullable();
            $table->string('celular')->nullable();
            $table->string('multa')->nullable();
            $table->string('juros')->nullable();
            $table->string('dias_desc')->nullable();
            $table->string('desconto')->nullable();
            $table->string('agfaturamento')->nullable();
            $table->string('pagamento')->nullable();
            $table->string('impmedico')->nullable();
            $table->string('inss')->nullable();
            $table->string('iss')->nullable();
            $table->string('ir')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('convenios');
    }
};
