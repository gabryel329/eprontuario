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
        Schema::create('convenio_procedimento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('convenio_id')->constrained('convenios')->onDelete('cascade');
            $table->foreignId('procedimento_id')->constrained('procedimentos')->onDelete('cascade');
            $table->string('valor')->nullable();
            $table->string('codigo')->nullable();
            $table->timestamps();
            $table->unique(['convenio_id', 'procedimento_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('convenio_procedimento');
    }
};
