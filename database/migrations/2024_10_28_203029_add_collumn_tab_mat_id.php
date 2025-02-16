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
        Schema::table('convenios', function (Blueprint $table) {
            $table->string('tab_proc_id')->nullable();
            $table->string('tab_med_id')->nullable();
            $table->string('tab_mat_id')->nullable();
            $table->string('tab_taxa_id')->nullable();
            $table->string('tab_cota_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('convenios', function (Blueprint $table) {
            //
        });
    }
};
