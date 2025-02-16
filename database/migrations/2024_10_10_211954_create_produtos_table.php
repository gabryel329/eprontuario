<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->nullable();
            $table->string('marca')->nullable();
            $table->string('tipo')->nullable();
            $table->string('grupo')->nullable();
            $table->string('sub_grupo')->nullable();
            $table->string('produto')->nullable();
            $table->decimal('preco_venda', 10, 2)->default(0);
            $table->string('substancias')->nullable();
            $table->string('natureza')->nullable();
            $table->string('ativo');
            $table->string('controlado');
            $table->string('padrao');
            $table->string('ccih');
            $table->string('generico');
            $table->string('consignado');
            $table->string('disp_emergencia');
            $table->string('disp_paciente');
            $table->string('fracionado');
            $table->string('imobilizado');
            $table->string('antibiotico')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produtos');
    }
};
