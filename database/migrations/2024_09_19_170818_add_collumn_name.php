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
        Schema::table('disponibilidades', function (Blueprint $table) {
            $table->date('data')->nullable();
            $table->string('procedimento_id')->nullable();
            $table->string('name')->nullable();
            $table->string('celular')->nullable();
            $table->string('matricula')->nullable();
            $table->string('codigo')->nullable();
            $table->integer('convenio_id')->nullable();
            $table->foreign('convenio_id')->references('id')->on('convenios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('disponibilidades', function (Blueprint $table) {
            //
        });
    }
};
