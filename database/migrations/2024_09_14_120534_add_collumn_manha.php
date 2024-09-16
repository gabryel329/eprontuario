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
            // Campos para os dias da manh�
        $table->string('manha_dom')->nullable();
        $table->string('manha_seg')->nullable();
        $table->string('manha_ter')->nullable();
        $table->string('manha_qua')->nullable();
        $table->string('manha_qui')->nullable();
        $table->string('manha_sex')->nullable();
        $table->string('manha_sab')->nullable();
        
        // Campos para os hor�rios da manh�
        $table->string('inihonorariomanha')->nullable();
        $table->string('interhonorariomanha')->nullable();
        $table->string('fimhonorariomanha')->nullable();

        // Campos para os dias da tarde
        $table->string('tarde_dom')->nullable();
        $table->string('tarde_seg')->nullable();
        $table->string('tarde_ter')->nullable();
        $table->string('tarde_qua')->nullable();
        $table->string('tarde_qui')->nullable();
        $table->string('tarde_sex')->nullable();
        $table->string('tarde_sab')->nullable();

        // Campos para os hor�rios da tarde
        $table->string('inihonorariotarde')->nullable();
        $table->string('interhonorariotarde')->nullable();
        $table->string('fimhonorariotarde')->nullable();

        // Campos para os dias da noite
        $table->string('noite_dom')->nullable();
        $table->string('noite_seg')->nullable();
        $table->string('noite_ter')->nullable();
        $table->string('noite_qua')->nullable();
        $table->string('noite_qui')->nullable();
        $table->string('noite_sex')->nullable();
        $table->string('noite_sab')->nullable();

        // Campos para os hor�rios da noite
        $table->string('inihonorarionoite')->nullable();
        $table->string('interhonorarionoite')->nullable();
        $table->string('fimhonorarionoite')->nullable();
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
