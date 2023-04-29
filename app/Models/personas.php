<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombreCompleto',
        'telefono',
        'color',
        'estado',
    ];

    public function horarios()
    {
        return $this->belongsToMany(Horarios::class, 'horario_persona')->withPivot('nombreCompleto','observacion');
    }
}
