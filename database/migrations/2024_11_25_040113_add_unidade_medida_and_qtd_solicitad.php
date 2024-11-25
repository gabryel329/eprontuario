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
        Schema::table('med_agendas', function (Blueprint $table) {
            $table->string('unidade_medida')->nullable()->after('hora'); // Adiciona a coluna 'unidade_medida'
        });
    }

    public function down()
    {
        Schema::table('med_agendas', function (Blueprint $table) {
            $table->dropColumn('unidade_medida'); // Remove a coluna 'unidade_medida'
        });
    }

};
