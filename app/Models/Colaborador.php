<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colaborador extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_completo',
        'empresa',
        'area',
        'departamento',
        'puesto',
        'fotografia',
        'fecha_de_alta',
        'estatus',
    ];
}
