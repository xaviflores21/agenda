<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reporte extends Model
{
    use HasFactory;

    protected $fillable = [
        'idUser', 
        'userNombre', 
        'idEvento', 
        'encargadaEvento', 
        'cliente', 
        'habitacion', 
        'servicio', 
        'color', 
        'estado', 
        'textColor', 
        'start', 
        'end'
    ];
}
