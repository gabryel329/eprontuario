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
        Schema::table('disponibilidades', function (Blueprint $table) {
            $table->unsignedBigInteger('paciente_id')->nullable()->after('name');
        });
    }

    public function down()
    {
        Schema::table('disponibilidades', function (Blueprint $table) {
            $table->dropColumn('paciente_id');
        });
    }

};
