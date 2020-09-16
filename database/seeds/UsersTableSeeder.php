<?php

use App\User;
use App\Rol;
use App\Persona;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Rol::create([
    		'nombre' =>'Administrador',
    		'descripcion' =>'Posee permisos globales',
		]);
		
		Rol::create([
    		'nombre' =>'Profesor',
    		'descripcion' =>'Posee permisos para evaluar alumnos',
		]);
		
		Rol::create([
    		'nombre' =>'Digitador',
    		'descripcion' =>'Posee permisos para digitar datos',
    	]);

    	Persona::create([
			'primer_nombre' => 'Jairo',
			'segundo_nombre' => '',
			'tercer_nombre' => '',
			'primer_apellido' => 'Melgar',
			'segundo_apellido' => '',
			'genero' => 'M',
			'direccion' => 'Ciudad',
    	]);

    	$persona = Persona::firstOrFail();
    	$rol = Rol::firstOrFail();

        User::create([
        	'dpi'=> '1234567890101',
			'email'=> 'jairo@gmail.com',
			'password'=> bcrypt('12345'),
			'rol_id'=> $rol->id,
			'persona_id'=>$persona->id,
        ]);
    }
}
