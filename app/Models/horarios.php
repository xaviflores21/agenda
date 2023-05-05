<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horarios extends Model
{
    use HasFactory;

    protected $fillable = [
        'horarioInicio',
        'horarioFinal',
        'lunes',
        'martes',
        'miercoles',
        'jueves',
        'viernes',
        'sabado',
        'domingo',
        'estado',
    ];

    public function personas()
    {
        return $this->belongsToMany(Personas::class, 'horario_persona')
                    ->withPivot('nombreCompleto', 'observacion');
    }
}
