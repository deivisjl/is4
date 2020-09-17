<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bimestre extends Model
{
    protected $table = 'bimestre';

    protected $fillable = [
        'id', 'nombre',
    ];
}
