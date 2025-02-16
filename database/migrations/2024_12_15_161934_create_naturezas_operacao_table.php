<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('naturezas_operacao', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_cfop')->unique(); // Código CFOP (ex: 5101)
            $table->string('descricao'); // Descrição da Natureza da Operação
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('naturezas_operacao');
    }
};
