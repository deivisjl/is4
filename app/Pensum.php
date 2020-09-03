<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pensum extends Model
{
    protected $table = 'pensum';

    protected $fillable = [
        'id', 'curso_id','carrera_grado_id'
    ];
}
