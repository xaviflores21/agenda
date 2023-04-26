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
        Schema::create('personas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('dias',30)->nullable();
            $table->string('nombreCompleto',80);
            $table->string('color',20);
            $table->time('horarioInicio')->nullable();
            $table->time('horarioFinal')->nullable();
            $table->char('estado',1);
            $table->integer('idAnterior')->nullable();
            $table->dateTime('start')->nullable();
            $table->dateTime('end')->nullable();
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
