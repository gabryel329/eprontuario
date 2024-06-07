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
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->string('hora')->nullable();
            $table->date('data')->nullable();
            $table->string('procedimento_id')->nullable();
            $table->string('status')->nullable();
            $table->string('name')->nullable();
            $table->string('sobrenome')->nullable();
            $table->integer('profissional_id')->nullable();
            $table->foreign('profissional_id')->references('id')->on('profissionals')->onDelete('cascade');
            $table->integer('paciente_id')->nullable();
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
