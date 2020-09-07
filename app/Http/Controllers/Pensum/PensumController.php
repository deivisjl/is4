<?php

namespace App\Http\Controllers\Pensum;

use App\Curso;
use App\Pensum;
use App\Carrera;
use App\CarreraGrado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PensumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $registros = array();

        $carreras = Carrera::with('carrera_grado.grado','carrera_grado.pensum.curso')
                    ->get();

        return view('pensum.index',['carreras' => $carreras]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $registro = CarreraGrado::findOrFail($id);

        $cursos = Curso::all();
        
        return view('pensum.create',['registro' => $registro, 'cursos' => $cursos]);
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
            'registro' => 'required|numeric|min:1',
            'curso' => 'required|numeric|min:1',
        ];            

        $this->validate($request, $rules);
        
        $pensum = new Pensum();
        $pensum->curso_id = $request->get('curso');
        $pensum->carrera_grado_id = $request->get('registro');
        $pensum->save();

        return redirect()->route('pensum-editar',$pensum->carrera_grado_id)->with(['mensaje' => 'Registro exitoso']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pensum  $pensum
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ordenadores = array("p.id","c.nombre");

        $columna = $request['order'][0]["column"];
        
        $criterio = $request['search']['value'];

        $registro = $request['buscar'][0]['registro'];

        $cursos = DB::table('pensum as p')
                ->join('carrera_grado as cg','cg.id','p.carrera_grado_id')
                ->join('curso as c','c.id','p.curso_id')                
                ->select('p.id','c.nombre') 
                ->where('cg.id',$registro)
                ->whereNull('p.deleted_at')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();
              
        $count = DB::table('pensum as p')
                ->join('carrera_grado as cg','cg.id','p.carrera_grado_id')
                ->join('curso as c','c.id','p.curso_id')                
                ->where('cg.id',$registro)
                ->whereNull('p.deleted_at')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();
               
        $data = array(
        'draw' => $request->draw,
        'recordsTotal' => $count,
        'recordsFiltered' => $count,
        'data' => $cursos,
        );

        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pensum  $pensum
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try 
        {   
            $pensum = Pensum::findOrfail($id);
            $pensum->delete();

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

    public function detalle($id)
    {
        $registro = CarreraGrado::findOrFail($id);
        
        return view('pensum.detalle',['registro' => $registro]);
    }
}
