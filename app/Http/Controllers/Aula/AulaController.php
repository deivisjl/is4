<?php

namespace App\Http\Controllers\Aula;

use App\Aula;
use App\Seccion;
use App\CarreraGrado;
use App\CicloEscolar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class AulaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ciclo = CicloEscolar::where('activo',1)->first();

        return view('aula.index',['ciclo' => $ciclo]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $carreras = CarreraGrado::all();
        
        $secciones = Seccion::all();

        return view('aula.create',['carreras' => $carreras, 'secciones' => $secciones]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'carrera' => 'required|numeric|min:1',
            'seccion' => 'required|numeric|min:1',
        ];            

        $this->validate($request, $rules);

        $ciclo = CicloEscolar::where('activo',1)->first();

        $aula = new Aula();
        $aula->carrera_grado_id = $request->get('carrera');
        $aula->seccion_id = $request->get('seccion');
        $aula->ciclo_escolar_id = $ciclo->id;
        $aula->save();

        return redirect()->route('aulas.index')->with(['mensaje' => 'Registro exitoso']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Aula  $aula
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ordenadores = array("a.id","g.nombre","s.nombre");

        $columna = $request['order'][0]["column"];
        
        $criterio = $request['search']['value'];

        $ciclo = CicloEscolar::where('activo',1)->first();

        $aulas = DB::table('aula as a')                
                ->join('seccion as s','s.id','a.seccion_id')
                ->join('carrera_grado as cg','cg.id','a.carrera_grado_id')
                ->join('carrera as c','c.id','cg.carrera_id')
                ->join('grado as g','g.id','cg.grado_id')
                ->select('a.id',DB::raw('CONCAT(g.nombre,", ",c.nombre) as aula'), 's.nombre as seccion') 
                ->where('a.ciclo_escolar_id',$ciclo->id)
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();
              
        $count = DB::table('aula as a')                
                ->join('seccion as s','s.id','a.seccion_id')
                ->join('carrera_grado as cg','cg.id','a.carrera_grado_id')
                ->join('carrera as c','c.id','cg.carrera_id')
                ->join('grado as g','g.id','cg.grado_id') 
                ->where('a.ciclo_escolar_id',$ciclo->id)               
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();
               
        $data = array(
        'draw' => $request->draw,
        'recordsTotal' => $count,
        'recordsFiltered' => $count,
        'data' => $aulas,
        );

        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Aula  $aula
     * @return \Illuminate\Http\Response
     */
    public function edit(Aula $aula)
    {
        $carreras = CarreraGrado::all();
        
        $secciones = Seccion::all();

        return view('aula.edit',['carreras' => $carreras, 'secciones' => $secciones, 'aula' => $aula]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Aula  $aula
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Aula $aula)
    {
        $rules = [
            'carrera' => 'required|numeric|min:1',
            'seccion' => 'required|numeric|min:1',
        ];            

        $this->validate($request, $rules);        

        $aula->carrera_grado_id = $request->get('carrera');
        $aula->seccion_id = $request->get('seccion');
        $aula->save();

        return redirect()->route('aulas.index')->with(['mensaje' => 'Registro actualizado con éxito']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Aula  $aula
     * @return \Illuminate\Http\Response
     */
    public function destroy(Aula $aula)
    {
        try 
        {
            $aula->delete();

            return response()->json(['data' => 'El registro fue borrado con éxito'],200);
        } 
        catch (\Exception $ex) 
        {
            if ($ex instanceof QueryException) {
                $codigo = $ex->errorInfo[1];
    
                if ($codigo == 1451) {
                    return  response()->json(['error' => 'No se puede eliminar el registro porque está relacionado'],423);
                }
            }
            return response()->json(['error' => $ex->getMessage()],423);
        }
    }
}