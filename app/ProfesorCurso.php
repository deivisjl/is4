<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfesorCurso extends Model
{
    protected $table = 'profesor_curso';

    protected $fillable = [
        'id', 'usuario_id','pensum_id','aula_id','ciclo_escolar_id'
    ];

    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }
}
