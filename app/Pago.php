<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pago';

    protected $fillable = [
            'id',
            'inscrito_id',
            'mes_id',
            'ciclo_escolar_id',
            'monto'
    ];
}
