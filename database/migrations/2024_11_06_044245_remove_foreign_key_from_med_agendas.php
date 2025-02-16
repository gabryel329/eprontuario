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
            $table->dropForeign(['medicamento_id']);
        });
    }
    
    public function down()
    {
        Schema::table('med_agendas', function (Blueprint $table) {
            $table->foreign('medicamento_id')->references('id')->on('medicamentos')->onDelete('cascade');
        });
    }
    
};
