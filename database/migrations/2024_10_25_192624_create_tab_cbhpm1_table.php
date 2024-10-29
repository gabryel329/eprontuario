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
        Schema::create('tab_cbhpm1', function (Blueprint $table) {
            $table->id();
            $table->string('particular')->nullable();  // Campo 'particular'
            $table->string('servico')->nullable();  // Campo 'serviço'
            $table->string('descricao')->nullable();  // Campo 'descrição'
            $table->string('aux')->nullable();  // Campo 'aux'
            $table->string('m2')->nullable();  // Campo 'm2'
            $table->string('indice')->nullable();  // Campo 'índice'
            $table->string('pa')->nullable();  // Campo 'pa'
            $table->string('ps')->nullable();  // Campo 'ps'
            $table->string('valor')->nullable();  // Campo 'valor'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tab_cbhpm1');
    }
};
