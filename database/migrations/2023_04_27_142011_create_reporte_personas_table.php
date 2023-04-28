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
        Schema::create('reporte_personas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idPersona');
            $table->string('nombreCompletoPersona',80); 
            $table->string('telefono',30)->nullable();
            $table->string('color',20);
            $table->char('estadoPersona',1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reporte_personas');
    }
};
