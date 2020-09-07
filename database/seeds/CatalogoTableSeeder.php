<?php

use App\Grado;
use App\Carrera;
use App\Seccion;
use Illuminate\Database\Seeder;

class CatalogoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Carrera::insert([
            ['nombre' => 'Bachillerato en Computación'],
            ['nombre' => 'Ciclo de Educación Básica']
        ]);

        Grado::insert([
            ['nombre' => 'Primero'],
            ['nombre' => 'Segundo'],
            ['nombre' => 'Tercero'],
            ['nombre' => 'Cuarto'],
            ['nombre' => 'Quinto'],
            ['nombre' => 'Sexto']
        ]);

        Seccion::insert([
            ['nombre' => 'A'],
            ['nombre' => 'B'],
            ['nombre' => 'C']
        ]);
    }
}
