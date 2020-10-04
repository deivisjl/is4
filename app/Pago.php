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

    public function ciclo_escolar()
    {
        return $this->belongsTo(CicloEscolar::class);
    }

    public function mes()
    {
        return $this->belongsTo(Mes::class);
    }
}
