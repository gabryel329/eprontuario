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
        Schema::create('taxa_agendas', function (Blueprint $table) {
                $table->id(); // ID da tabela MedAgenda
                $table->foreignId('agenda_id')->constrained('agendas')->onDelete('cascade');
                $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');
                $table->foreignId('taxa_id')->constrained('produtos')->onDelete('cascade');
                $table->timestamps(); // Para created_at e updated_at
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taxa_agendas');
    }
};
