<?php

namespace App\Http\Controllers\Profesor;

use App\CicloEscolar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfesorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::user()->id;

        $ciclo = CicloEscolar::where('activo',1)->first();

        $registros = array();

        $aulas = DB::table('profesor_curso as pc')
                    ->join('aula as a','pc.aula_id','a.id')
                    ->join('plan as p','a.plan_id','p.id')
                    ->join('carrera_grado as cg','a.carrera_grado_id','cg.id')
                    ->join('carrera as c','cg.carrera_id','c.id')
                    ->select(DB::raw('DISTINCT(a.id) as id'),DB::raw('CONCAT(p.nombre,", ",c.nombre) as carrera'))
                    ->where('pc.usuario_id',$id)
                    ->where('a.ciclo_escolar_id',$ciclo->id)
                    ->get();
        
        foreach ($aulas as $key => $aula) 
        {
            $grados = DB::table('aula as a')
                        ->join('carrera_grado as cg','a.carrera_grado_id','cg.id')
                        ->join('grado as g','cg.grado_id','g.id')
                        ->join('seccion as s','a.seccion_id','s.id')
                        ->select('a.id','g.nombre as grado','s.nombre as seccion')
                        ->where('a.id',$aula->id)
                        ->where('a.ciclo_escolar_id',$ciclo->id)  
                        ->get();
            
            $registros[$key]['aulas'] = (array)$aula;
            $registros[$key]['aulas']['grados'] = $grados;
        }

        return view('profesor.index',['registros' => $registros]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ciclo = CicloEscolar::where('activo',1)->first();

        $registros = DB::table('profesor_curso as pc')
                        ->join('pensum as p','pc.pensum_id','p.id')
                        ->join('curso as c','p.curso_id','c.id')    
                        ->select('pc.id','pc.aula_id','pc.pensum_id','c.nombre')
                        ->where('pc.aula_id',$id)
                        ->where('pc.usuario_id',Auth::user()->id)
                        ->where('pc.ciclo_escolar_id',$ciclo->id)  
                        ->get();

        return view('profesor.show',['registros' => $registros]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
