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
        Schema::create('reportes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idUser');
            $table->string('userNombre',255);
            $table->integer('idEvento');
            $table->string('encargadaEvento',255);
            $table->string('cliente',255);
            $table->integer('habitacion')->nullable();
            $table->text('servicio');
            $table->string('color',20);
            $table->char('estado',1);
            $table->string('textColor',20);
            $table->dateTime('start');
            $table->dateTime('end');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes');
    }
};
