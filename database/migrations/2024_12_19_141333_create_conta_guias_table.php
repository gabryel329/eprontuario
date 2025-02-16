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
        Schema::create('conta_guias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conta_financeira_id')->constrained('contas_financeiras')->onDelete('cascade');
            $table->unsignedBigInteger('guia_id')->nullable(); // ID genérico para guias
            $table->string('tipo_guia'); // Consulta ou SP
            $table->string('lote')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conta_guias');
    }
};
