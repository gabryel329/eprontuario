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
            $table->string('valor')->nullable();
        });

        Schema::table('mat_agendas', function (Blueprint $table) {
            $table->string('valor')->nullable();
        });

        Schema::table('med_agendas', function (Blueprint $table) {
            $table->string('valor')->nullable();
        });

        Schema::table('taxa_agendas', function (Blueprint $table) {
            $table->string('valor')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proc_agendas', function (Blueprint $table) {
            $table->dropColumn('valor');
        });

        Schema::table('mat_agendas', function (Blueprint $table) {
            $table->dropColumn('valor');
        });

        Schema::table('med_agendas', function (Blueprint $table) {
            $table->dropColumn('valor');
        });

        Schema::table('taxa_agendas', function (Blueprint $table) {
            $table->dropColumn('valor');
        });
    }
};
