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
        $table->integer('medicamento_id')->unsigned()->change(); // Altera o tipo da coluna existente
    });
}

/**
 * Reverse the migrations.
 */
public function down(): void
{
    Schema::table('med_agendas', function (Blueprint $table) {
        $table->foreignId('medicamento_id')->constrained('medicamentos')->onDelete('cascade')->change();
    });
}

};
