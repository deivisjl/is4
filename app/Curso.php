<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'curso';

    protected $fillable = [
        'id', 'nombre',
    ];

    public function pensum()
    {
        return $this->belongsToMany(Pensum::class);
    }
}
