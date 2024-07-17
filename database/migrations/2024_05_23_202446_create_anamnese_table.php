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
        Schema::create('anamneses', function (Blueprint $table) {
            $table->id();
            $table->integer('paciente_id')->nullable();
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
            $table->integer('profissional_id')->nullable();
            $table->foreign('profissional_id')->references('id')->on('profissionals')->onDelete('cascade');
            $table->string('pa')->nullable();
            $table->string('temp')->nullable();
            $table->string('peso')->nullable();
            $table->string('altura')->nullable();
            $table->string('imc')->nullable();
            $table->string('classificacao')->nullable();
            $table->string('gestante')->nullable();
            $table->string('dextro')->nullable();
            $table->string('spo2')->nullable();
            $table->string('fc')->nullable();
            $table->string('fr')->nullable();
            $table->string('acolhimento')->nullable();
            $table->string('acolhimento1')->nullable();
            $table->string('acolhimento2')->nullable();
            $table->string('acolhimento3')->nullable();
            $table->string('acolhimento4')->nullable();
            $table->string('alergia1')->nullable();
            $table->string('alergia2')->nullable();
            $table->string('alergia3')->nullable();
            $table->string('anamnese')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anamneses');
    }
};
