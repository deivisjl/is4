<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inscrito extends Model
{
    protected $table = 'inscrito';

    protected $fillable = [
        'id',
        'alumno_id',
        'aula_id',
        'ciclo_escolar_id',
        'promovido',
        'repitente'
    ];
}
