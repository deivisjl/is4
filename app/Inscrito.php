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

    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }
}
