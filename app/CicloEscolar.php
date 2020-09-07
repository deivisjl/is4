<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CicloEscolar extends Model
{
    protected $table = 'ciclo_escolar';

    protected $fillable = [
        'id', 'nombre','activo'
    ];
}
