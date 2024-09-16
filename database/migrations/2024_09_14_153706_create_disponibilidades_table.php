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
            $table->string('porcentagem');
            $table->string('valor');
            $table->string('material')->nullable();
            $table->string('medicamento')->nullable();
            $table->string('manha_dom')->nullable();
            $table->string('manha_seg')->nullable();
            $table->string('manha_ter')->nullable();
            $table->string('manha_qua')->nullable();
            $table->string('manha_qui')->nullable();
            $table->string('manha_sex')->nullable();
            $table->string('manha_sab')->nullable();
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
