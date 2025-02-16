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
        Schema::create('baixas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conta_financeira_id')->constrained('contas_financeiras')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('tipo_pagamento')->default('Total');
            $table->decimal('valor_pagamento', 15, 2)->nullable();
            $table->foreignId('banco_id')->nullable()->constrained('bancos')->onDelete('set null');
            $table->string('forma_pagamento')->nullable(); // Ex.: PIX, Boleto, Transferência
            $table->string('numero_documento')->nullable(); // Número de comprovante
            $table->text('observacao')->nullable(); // Para comentários adicionais
            // Relacionamentos genéricos para guias
            $table->unsignedBigInteger('guia_id')->nullable();  // ID da guia
            $table->string('tipo_guia')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baixas');
    }
};
