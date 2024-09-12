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
        Schema::table('profissionals', function (Blueprint $table) {
            $table->string('valor')->nullable();
            $table->string('porcentagem')->nullable();
            $table->string('material')->nullable();
            $table->string('medicamento')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profissionals', function (Blueprint $table) {
            //
        });
    }
};
