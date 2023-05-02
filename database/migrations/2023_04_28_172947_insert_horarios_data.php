<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::table('horarios')->insert([
            [
                'horarioInicio' => '08:00',
                'horarioFinal' => '17:00',
                'lunes' => true,
                'martes' => true,
                'miercoles' => true,
                'jueves' => true,
                'viernes' => true,
                'sabado' => false,
                'domingo' => false,
                'estado'=>'C',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // add more records here
        ]);
    }
    
    public function down()
    {
        DB::table('horarios')->delete();
    }
    
    
};
