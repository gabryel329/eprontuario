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
        Schema::table('contas_financeiras', function (Blueprint $table) {
            $table->text('motivo_glosa')->nullable()->after('status')->comment('Motivo da Glosa da conta financeira');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contas_financeiras', function (Blueprint $table) {
            $table->dropColumn('motivo_glosa');
        });
    }
};
