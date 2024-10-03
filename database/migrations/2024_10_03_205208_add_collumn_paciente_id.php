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
        Schema::table('guia_consulta', function (Blueprint $table) {
            $table->integer('paciente_id')->nullable();
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
            $table->integer('profissional_id')->nullable();
            $table->foreign('profissional_id')->references('id')->on('profissionals')->onDelete('cascade');
            $table->integer('agenda_id')->nullable();
            $table->foreign('agenda_id')->references('id')->on('agendas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guia_consulta', function (Blueprint $table) {
            //
        });
    }
};
