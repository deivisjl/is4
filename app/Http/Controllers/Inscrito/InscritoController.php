<?php

namespace App\Http\Controllers\Inscrito;

use App\Plan;
use App\Inscrito;
use App\CicloEscolar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class InscritoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ciclo = CicloEscolar::where('activo',1)->first();

        $planes = Plan::all();
        
        $aulas = DB::table('aula as a')
                        ->join('carrera_grado as cg','a.carrera_grado_id','cg.id')
                        ->join('carrera as c','cg.carrera_id','c.id')
                        ->select(DB::raw('DISTINCT(cg.carrera_id) as id'),'c.nombre as nombre')
                        ->where('a.ciclo_escolar_id',$ciclo->id)
                        ->get();
        
        return view('inscrito.index',['aulas' => $aulas,'ciclo' => $ciclo, 'planes' => $planes]);
    }

    public function alumnos()
    {
        try 
        {
            $ciclo = CicloEscolar::where('activo',1)->first();

            $inscritos = Inscrito::where('ciclo_escolar_id','=',$ciclo->id)->get(['alumno_id'])->toArray();

            $registros = DB::table('alumno as a')  
                        ->join('persona as p', 'a.persona_id', '=', 'p.id')            
                        ->select('a.id', DB::raw('CONCAT_WS(" ",p.primer_nombre," ",p.segundo_nombre," ",p.tercer_nombre) as nombres'),DB::raw('CONCAT_WS(" ",p.primer_apellido," ",p.segundo_apellido) as apellidos'),'a.sire_id') 
                        ->whereNotIn('a.id',$inscritos)
                        ->orderBy('p.primer_nombre','asc')
                        ->get();
            
            return response()->json(['data' => $registros],200);
        } 
        catch (\Exception $ex) 
        {
            return response()->json(['error' => $ex->getMessage()],423);
        }
    }

    public function inscribir_alumnos(Request $request)
    {
        try 
        {
            $rules = [
                'aula_id'=>'required|numeric|min:1',
                'alumno_id'=>'required|numeric|min:1'
            ];

            $this->validate($request, $rules);

            $ciclo = CicloEscolar::where('activo',1)->first();

            $registro = new Inscrito();
            $registro->alumno_id = $request->get('alumno_id');
            $registro->aula_id = $request->get('aula_id');
            $registro->ciclo_escolar_id = $ciclo->id;
            $registro->save();

            return response()->json(['data' => 'Alumno inscrito con éxito'],200);
        } 
        catch (\Exception $ex) 
        {
            return response()->json(['error' => $ex->getMessage()],423);
        }
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
     * @param  \App\Inscrito  $inscrito
     * @return \Illuminate\Http\Response
     */
    public function show(Inscrito $inscrito)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inscrito  $inscrito
     * @return \Illuminate\Http\Response
     */
    public function edit(Inscrito $inscrito)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inscrito  $inscrito
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inscrito $inscrito)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inscrito  $inscrito
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inscrito $inscrito)
    {
        //
    }
}
