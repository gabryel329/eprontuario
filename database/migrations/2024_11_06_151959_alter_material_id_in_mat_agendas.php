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
    Schema::table('mat_agendas', function (Blueprint $table) {
        $table->integer('material_id')->unsigned()->change(); // Altera o tipo da coluna existente
    });
}

/**
 * Reverse the migrations.
 */
public function down(): void
{
    Schema::table('mat_agendas', function (Blueprint $table) {
        $table->foreignId('material_id')->constrained('produtos')->onDelete('cascade')->change();
    });
}
};
