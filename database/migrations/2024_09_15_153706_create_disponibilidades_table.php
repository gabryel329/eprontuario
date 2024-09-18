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
        Schema::create('disponibilidades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profissional_id')->constrained('profissionals')->onDelete('cascade');
            $table->foreignId('especialidade_id')->constrained('especialidades')->onDelete('cascade');
            $table->string('turno')->nullable();
            $table->string('hora')->nullable();
            $table->string('material')->nullable();
            $table->string('medicamento')->nullable();
            $table->string('dom')->nullable();
            $table->string('seg')->nullable();
            $table->string('ter')->nullable();
            $table->string('qua')->nullable();
            $table->string('qui')->nullable();
            $table->string('sex')->nullable();
            $table->string('sab')->nullable();
            $table->string('inicio')->nullable();
            $table->string('fim')->nullable();
            $table->string('intervalo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disponibilidades');
    }
};
