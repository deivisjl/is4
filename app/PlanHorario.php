<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanHorario extends Model
{
    protected $table = 'plan_horario';

    protected $fillable = [
        'id', 'plan_id','horario_id'
    ];
}
