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
        Schema::table('med_agendas', function (Blueprint $table) {
            $table->string('fator')->nullable();
            $table->string('cd')->nullable();
            $table->string('tabela')->nullable();
            $table->string('valor_total')->nullable();
        });

        // Adicionar coluna 'valor_total' na tabela 'matagenda'
        Schema::table('mat_agendas', function (Blueprint $table) {
            $table->string('valor_total')->nullable();
            $table->string('cd')->nullable();
            $table->string('tabela')->nullable();
            $table->string('fator')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('med_agendas', function (Blueprint $table) {
            //
        });
    }
};
