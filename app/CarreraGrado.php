<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarreraGrado extends Model
{
    protected $table = 'carrera_grado';

    protected $fillable = [
        'id', 'carrera_id','grado_id'
    ];
}
