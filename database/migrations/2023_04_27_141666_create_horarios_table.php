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
        Schema::create('horarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->time('horarioInicio')->nullable();
            $table->time('horarioFinal')->nullable();
            $table->boolean('lunes');
            $table->boolean('martes');
            $table->boolean('miercoles');
            $table->boolean('jueves');
            $table->boolean('viernes');
            $table->boolean('sabado');
            $table->boolean('domingo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
    
};
