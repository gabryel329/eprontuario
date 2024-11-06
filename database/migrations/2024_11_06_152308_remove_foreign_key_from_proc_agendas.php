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
        Schema::table('proc_agendas', function (Blueprint $table) {
            $table->dropForeign(['procedimento_id']);
        });
    }
    
    public function down()
    {
        Schema::table('proc_agendas', function (Blueprint $table) {
            $table->foreign('procedimento_id')->references('id')->on('procedimentos')->onDelete('cascade');
        });
    }
};
