<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    protected $table = 'aula';

    protected $fillable = [
        'id', 'carrera_grado_id','seccion_id','ciclo_escolar_id','plan_id'
    ];

    public function carrera_grado()
    {
        return $this->belongsTo(CarreraGrado::class);
    }

    public function seccion()
    {
        return $this->belongsTo(Seccion::class);
    }

    public function ciclo_escolar()
    {
        return $this->belongsTo(CicloEscolar::class);
    }

    public function profesor_curso()
    {
        return $this->hasMany(ProfesorCurso::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
