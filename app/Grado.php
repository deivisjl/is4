<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grado extends Model
{
    protected $table = 'grado';

    protected $fillable = [
        'id', 'nombre',
    ];

    public function carrera_grado()
    {
        return $this->hasMany(CarreraGrado::class);
    }
}
