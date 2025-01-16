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
        Schema::table('exames_sadt', function (Blueprint $table) {
            // Adiciona a coluna agenda_id como unsignedBigInteger e permite valores nulos
            $table->unsignedBigInteger('agenda_id')->nullable()->after('id');

            // Opcional: Se quiser fazer referência à tabela agendas
            // $table->foreign('agenda_id')->references('id')->on('agendas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exames_sadt', function (Blueprint $table) {
            //
        });
    }
};
