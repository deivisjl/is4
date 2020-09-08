<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarreraGrado extends Model
{
    
    protected $table = 'carrera_grado';

    protected $fillable = [
        'id', 'carrera_id','grado_id'
    ];

    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }

    public function grado()
    {
        return $this->belongsTo(Grado::class);
    }

    public function pensum()
    {
        return $this->hasMany(Pensum::class);
    }

    public function aula()
    {
        return $this->hasMany(Aula::class);
    }
}
