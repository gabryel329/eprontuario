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
        Schema::create('nfeparticula', function (Blueprint $table) {
            $table->id();
            $table->string('nNF')->nullable();
            $table->timestamp('dhEmi')->nullable();
            $table->string('xNome');
            $table->string('CPF');
            $table->string('tPag')->nullable();
            $table->string('vPag')->nullable();
            $table->string('tBand')->nullable();
            $table->string('cAut')->nullable();
            $table->text('xml_gerado')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nfeparticula');
    }
};
