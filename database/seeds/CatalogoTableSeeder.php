<?php

use App\Mes;
use App\Plan;
use App\Grado;
use App\Carrera;
use App\Seccion;
use App\Bimestre;
use App\CicloEscolar;
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

        Plan::insert([
            ['nombre' => 'Plan diario'],
            ['nombre' => 'Plan fin de semana']
        ]);
        
        Bimestre::insert([
            ['nombre' => 'Primer bimestre'],
            ['nombre' => 'Segundo bimestre'],
            ['nombre' => 'Tercer bimestre'],
            ['nombre' => 'Cuarto bimestre'],
        ]);

        CicloEscolar::insert([
            ['nombre' => 2020, 'activo' => 1],
            ['nombre' => 2021, 'activo' => 0],
            ['nombre' => 2022, 'activo' => 0],
            ['nombre' => 2023, 'activo' => 0],
            ['nombre' => 2024, 'activo' => 0],
            ['nombre' => 2025, 'activo' => 0],
        ]);

        Mes::insert([
            ['nombre' => 'Enero'],
            ['nombre' => 'Febrero'],
            ['nombre' => 'Marzo'],
            ['nombre' => 'Abril'],
            ['nombre' => 'Mayo'],
            ['nombre' => 'Junio'],
            ['nombre' => 'Julio'],
            ['nombre' => 'Agosto'],
            ['nombre' => 'Septiembre'],
            ['nombre' => 'Octubre'],
            ['nombre' => 'Noviembre'],
            ['nombre' => 'Diciembre'],
        ]);
    }
}
