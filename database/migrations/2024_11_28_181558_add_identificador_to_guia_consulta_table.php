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
        Schema::table('guia_consulta', function (Blueprint $table) {
            $table->string('identificador')->nullable()->after('convenio_id'); // Adiciona a coluna após convenio_id
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guia_consulta', function (Blueprint $table) {
            //
        });
    }
};
