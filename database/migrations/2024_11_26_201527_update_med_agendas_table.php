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
            // Renomeia a coluna 'dose' para 'qtd'
            $table->renameColumn('dose', 'quantidade');

            // Renomeia a coluna 'hora' para 'codigo'
            $table->renameColumn('hora', 'codigo');
        });

        Schema::table('med_agendas', function (Blueprint $table) {
            // Altera o tipo da coluna 'codigo' para string
            $table->string('codigo')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
