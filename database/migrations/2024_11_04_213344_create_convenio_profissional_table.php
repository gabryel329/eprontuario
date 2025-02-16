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
        Schema::create('convenio_profissional', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profissional_id');
            $table->unsignedBigInteger('convenio_id');
            $table->string('codigo_operadora')->nullable();
            $table->foreign('profissional_id')->references('id')->on('profissionals')->onDelete('cascade');
            $table->foreign('convenio_id')->references('id')->on('convenios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('convenio_profissional');
    }
};
