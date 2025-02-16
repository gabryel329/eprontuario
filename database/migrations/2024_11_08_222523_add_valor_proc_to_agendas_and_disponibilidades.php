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
        Schema::table('agendas', function (Blueprint $table) {
            $table->string('valor_proc')->nullable();
        });

        Schema::table('disponibilidades', function (Blueprint $table) {
            $table->string('valor_proc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agendas', function (Blueprint $table) {
            $table->dropColumn('valor_proc');
        });

        Schema::table('disponibilidades', function (Blueprint $table) {
            $table->dropColumn('valor_proc');
        });
    }
};
