<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    protected $table = 'nota';

    protected $fillable = [
        'id',
        'pensum_id',
        'inscrito_id',
        'bimestre_id',
        'nota',
        'ciclo_escolar_id',
    ];

    public function inscrito()
    {
        return $this->belongsTo(Inscrito::class);
    }
}
