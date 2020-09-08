<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = 'alumno';

    protected $fillable = [
        'id', 'sire_id','persona_id'
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }
}
