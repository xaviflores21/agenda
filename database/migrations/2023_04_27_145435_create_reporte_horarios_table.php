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
        Schema::create('reporte_horarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idHorarios');
            $table->time('horarioInicio')->nullable();
            $table->time('horarioFinal')->nullable();
            $table->boolean('lunes');
            $table->boolean('martes');
            $table->boolean('miercoles');
            $table->boolean('jueves');
            $table->boolean('viernes');
            $table->boolean('sabado');
            $table->boolean('domingo');
            $table->char('estadoHorarios',1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reporte_horarios');
    }
};
