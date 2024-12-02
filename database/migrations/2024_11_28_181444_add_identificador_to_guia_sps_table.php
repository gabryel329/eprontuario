<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdentificadorToGuiaSpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('guia_sps', function (Blueprint $table) {
            $table->string('identificador')->nullable()->after('convenio_id'); // Adiciona a coluna após convenio_id
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('guia_sps', function (Blueprint $table) {
            $table->dropColumn('identificador');
        });
    }
}
