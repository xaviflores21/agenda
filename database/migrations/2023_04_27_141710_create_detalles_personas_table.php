<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesPersonasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('horario_persona', function (Blueprint $table) {
            $table->datetime('fecha');
            $table->unsignedBigInteger('personas_id');
            $table->unsignedBigInteger('horarios_id');
            $table->string('nombreCompleto', 30);
            $table->string('horarios',255);
            $table->string('observacion')->nullable();

            $table->foreign('personas_id')->references('id')->on('personas');
            $table->foreign('horarios_id')->references('id')->on('horarios');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('horario_persona', function (Blueprint $table) {
            $table->dropForeign(['personas_id']);
            $table->dropForeign(['horarios_id']);
        });
        
        Schema::dropIfExists('horario_persona');
    }
    
      /**
    
     * Get the migrations that this migration depends on.
     *
     * @return array
     */
    public function dependsOn()
    {
        return [
            '2023_04_27_141666_create_horarios_table',
            '2023_04_11_203043_create_personas_table',
        ];
    }
}
