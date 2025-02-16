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
    Schema::create('honorarios', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('profissional_id');
        $table->foreign('profissional_id')->references('id')->on('profissionals')->onDelete('cascade');
        
        $table->unsignedBigInteger('convenio_id')->nullable();
        $table->foreign('convenio_id')->references('id')->on('convenios')->onDelete('cascade');
    
        $table->unsignedBigInteger('procedimento_id')->nullable();
        $table->foreign('procedimento_id')->references('id')->on('procedimentos')->onDelete('cascade');
        
        $table->string('porcentagem')->nullable();
        $table->string('codigo')->nullable();
        $table->timestamps();
        $table->softDeletes(); 
    });
    
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('honorarios');
    }
};
