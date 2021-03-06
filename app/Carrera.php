<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    protected $table = 'carrera';

    protected $fillable = [
        'id', 'nombre',
    ];

    public function carrera_grado()
    {
        return $this->hasMany(CarreraGrado::class);
    }
}
