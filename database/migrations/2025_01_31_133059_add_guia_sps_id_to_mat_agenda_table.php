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
        Schema::table('mat_agendas', function (Blueprint $table) {
            $table->unsignedBigInteger('guia_sps_id')->nullable()->after('id');
        });
        Schema::table('med_agendas', function (Blueprint $table) {
            $table->unsignedBigInteger('guia_sps_id')->nullable()->after('id');
        });
        Schema::table('taxa_agendas', function (Blueprint $table) {
            $table->unsignedBigInteger('guia_sps_id')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mat_agenda', function (Blueprint $table) {
            $table->unsignedBigInteger('agenda_id')->nullable()->after('id');
        });
    }
};
