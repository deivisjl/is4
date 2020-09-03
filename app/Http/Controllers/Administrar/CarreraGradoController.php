<?php

namespace App\Http\Controllers\Administrar;

use App\Grado;
use App\Carrera;
use App\CarreraGrado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CarreraGradoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('administrar.carrera-grado.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $carreras = Carrera::all();
        $grados = Grado::all();

        return view('administrar.carrera-grado.create',['carreras' => $carreras, 'grados' => $grados]);
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
            'grado' => 'required|numeric|min:1',
            'carrera' => 'required|numeric|min:1'
        ];            

        $this->validate($request, $rules);

        $grado_carrera = new CarreraGrado();
        $grado_carrera->grado_id = $request->get('grado');
        $grado_carrera->carrera_id = $request->get('carrera');
        $grado_carrera->save();

        return redirect()->route('carrera-grado.index')->with(['mensaje' => 'Registro exitoso']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ordenadores = array("cg.id","c.nombre","g.nombre");

        $columna = $request['order'][0]["column"];
        
        $criterio = $request['search']['value'];


        $carrera_grado = DB::table('carrera_grado as cg')  
                ->join('carrera as c','c.id','=','cg.carrera_id')              
                ->join('grado as g','g.id','=','cg.grado_id')              
                ->select('cg.id','c.nombre as carrera','g.nombre as grado') 
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();
              
        $count = DB::table('carrera_grado as cg')  
                ->join('carrera as c','c.id','=','cg.carrera_id')              
                ->join('grado as g','g.id','=','cg.grado_id')                              
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();
               
        $data = array(
        'draw' => $request->draw,
        'recordsTotal' => $count,
        'recordsFiltered' => $count,
        'data' => $carrera_grado,
        );

        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $registro = CarreraGrado::findOrFail($id);
       $carreras = Carrera::all();
       $grados = Grado::all();

       return view('administrar.carrera-grado.edit',['registro' => $registro,'carreras' => $carreras, 'grados' => $grados]);
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
        $rules = [
            'grado' => 'required|numeric|min:1',
            'carrera' => 'required|numeric|min:1'
        ];            

        $this->validate($request, $rules);

        $grado_carrera = CarreraGrado::findOrFail($id);
        $grado_carrera->grado_id = $request->get('grado');
        $grado_carrera->carrera_id = $request->get('carrera');
        $grado_carrera->save();

        return redirect()->route('carrera-grado.index')->with(['mensaje' => 'Registro actualizado con éxito']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try 
        {
            $registro = CarreraGrado::findOrFail($id);
            $registro->delete();

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
