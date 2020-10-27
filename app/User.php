<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    const ADMINISTRADOR = 'ADMINISTRADOR';
    const PROFESOR = 'PROFESOR';
    const DIGITADOR = 'SECRETARIA';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'dpi','email', 'password','rol_id','persona_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }

    public function esAdministrador()
    {
        return strtoupper($this->rol->nombre) == User::ADMINISTRADOR;
    }

    public function esProfesor()
    {
        return strtoupper($this->rol->nombre) == User::PROFESOR;
    }

    public function esDigitador()
    {
        return strtoupper($this->rol->nombre) == User::DIGITADOR;
    }
}
