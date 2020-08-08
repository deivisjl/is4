<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'persona';

    protected $fillable = [
       'id',
		'primer_nombre',
		'segundo_nombre',
		'tercer_nombre',
		'primer_apellido',
		'segundo_apellido',
		'genero',
		'direccion',
    ];
}
