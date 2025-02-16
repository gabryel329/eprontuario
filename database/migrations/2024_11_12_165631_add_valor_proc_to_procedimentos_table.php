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
        Schema::table('procedimentos', function (Blueprint $table) {
            $table->string('valor_proc')->nullable(); // Adiciona o campo `valor_proc`
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('procedimentos', function (Blueprint $table) {
            //
        });
    }
};
