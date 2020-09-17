<?php

namespace App\Http\Controllers\Docentes;

use App\CicloEscolar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DocenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rol = 'profesor';

        $ciclo = CicloEscolar::where('activo',1)->first();

        $docentes = DB::table('users as u')
                        ->join('rol as r','r.id','u.rol_id')
                        ->join('persona as p','u.persona_id','p.id')
                        ->join('profesor_curso as pc','u.id','pc.usuario_id')
                        ->select(DB::raw('COUNT(pc.pensum_id) as cursos'),'u.id',DB::raw('CONCAT_WS("",p.primer_nombre,"",p.segundo_nombre,"",p.tercer_nombre," ",p.primer_apellido,"",p.segundo_apellido) as nombre'))
                        ->where(DB::raw('LOWER(r.nombre)'), $rol)
                        ->where('pc.ciclo_escolar_id',$ciclo->id)
                        ->groupBy('u.id','p.primer_nombre','p.segundo_nombre','p.tercer_nombre','p.primer_apellido','p.segundo_apellido')
                        ->get();
        
        return view('docente.index', ['docentes' => $docentes, 'ciclo' => $ciclo]);
    }

    public function detalle($id)
    {
        $ciclo = CicloEscolar::where('activo',1)->first();

        $registros = array();

        $registro = DB::table('users as u')
                        ->join('profesor_curso as pc','u.id','pc.usuario_id')
                        ->join('aula as a','pc.aula_id','a.id')
                        ->join('carrera_grado as cg','a.carrera_grado_id','cg.id')
                        ->join('carrera as c','cg.carrera_id','c.id')
                        ->join('grado as g','cg.grado_id','g.id')
                        ->join('seccion as s','a.seccion_id','s.id')
                        ->select('a.id as aula_id',DB::raw('CONCAT(c.nombre,", ",g.nombre) as grado'),'s.nombre as seccion')
                        ->where('pc.ciclo_escolar_id',$ciclo->id)
                        ->where('u.id',$id)
                        ->groupBy('a.id','c.nombre','g.nombre','s.nombre')
                        ->get();

        foreach ($registro as $key => $aula) 
        {
            $cursos = DB::table('profesor_curso as pc')
                            ->join('pensum as p','p.id','pc.pensum_id')
                            ->join('curso as c','c.id','p.curso_id')
                            ->select('c.nombre')
                            ->where('pc.usuario_id',$id)
                            ->where('pc.aula_id',$aula->aula_id)
                            ->where('pc.ciclo_escolar_id',$ciclo->id)
                            ->get();
            
            $registros[$key]['aula'] = (array)$aula;
            $registros[$key]['aula']['cursos'] = $cursos; 
        }
        
        return view('docente.detalle',['registros' => $registros,'ciclo' => $ciclo]);
    }
}