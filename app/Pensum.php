<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pensum extends Model
{
    use SoftDeletes;
    
    protected $table = 'pensum';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id', 'curso_id','carrera_grado_id'
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}
