<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('mat_agendas', function (Blueprint $table) {
            $table->string('quantidade')->nullable()->after('material_id'); // Adiciona a coluna 'unidade_medida'
            $table->string('unidade_medida')->nullable()->after('material_id'); // Adiciona a coluna 'unidade_medida'
        });
    }

    public function down()
    {
        Schema::table('mat_agendas', function (Blueprint $table) {
            $table->string('quantidade')->nullable()->after('material_id'); // Adiciona a coluna 'unidade_medida'
            $table->string('unidade_medida')->nullable()->after('material_id'); // Adiciona a coluna 'unidade_medida'
        });
    }
};
