<?php

namespace App\Http\Controllers\Alumno;

use App\Alumno;
use App\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('alumno.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('alumno.create');
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
            "primer_nombre" => 'required|string|max:100',
            "segundo_nombre" => 'nullable|string|max:100',
            "tercer_nombre" => 'nullable|string|max:100',
            "primer_apellido" => 'required|string|max:100',
            "segundo_apellido" => 'nullable|string|max:100',
            "codigo_sire" => 'nullable|string|max:100',
            "genero" => 'required|numeric|min:1|max:2',
            "direccion" => 'required|string',
        ];            

        $this->validate($request, $rules);

        return DB::transaction(function () use($request){

            $persona = new Persona();
            $persona->primer_nombre = $request->get('primer_nombre');
            $persona->segundo_nombre = $request->get('segundo_nombre');
            $persona->tercer_nombre = $request->get('tercer_nombre');
            $persona->primer_apellido = $request->get('primer_apellido');
            $persona->segundo_apellido = $request->get('segundo_apellido');
            $persona->genero = $request->get('genero') == 1 ? 'M' : 'F';
            $persona->direccion = $request->get('direccion');
            $persona->save();

            $alumno = new Alumno();
            $alumno->sire_id = $request->get('codigo_sire');
            $alumno->persona_id = $persona->id;
            $alumno->save();

            return redirect()->route('alumnos.index')->with(['mensaje' => 'Registro exitoso']);
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ordenadores = array("a.id","p.primer_nombre","p.primer_apellido");

        $columna = $request['order'][0]["column"];
        
        $criterio = $request['search']['value'];


        $alumnos = DB::table('alumno as a')
                ->join('persona as p','p.id','a.persona_id')                
                ->select('a.id',DB::raw('CONCAT_WS(" ",p.primer_nombre," ",p.segundo_nombre," ",p.tercer_nombre) as nombres'),DB::raw('CONCAT_WS(" ",p.primer_apellido," ",p.segundo_apellido) as apellidos')) 
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();
              
        $count = DB::table('alumno as a')
                ->join('persona as p','p.id','a.persona_id')                
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();
               
        $data = array(
        'draw' => $request->draw,
        'recordsTotal' => $count,
        'recordsFiltered' => $count,
        'data' => $alumnos,
        );

        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function edit(Alumno $alumno)
    {
        return view('alumno.edit',['alumno'=> $alumno]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Alumno $alumno)
    {
        $rules = [
            "primer_nombre" => 'required|string|max:100',
            "segundo_nombre" => 'nullable|string|max:100',
            "tercer_nombre" => 'nullable|string|max:100',
            "primer_apellido" => 'required|string|max:100',
            "segundo_apellido" => 'nullable|string|max:100',
            "codigo_sire" => 'nullable|string|max:100',
            "genero" => 'required|numeric|min:1|max:2',
            "direccion" => 'required|string',
        ];            

        $this->validate($request, $rules);

        return DB::transaction(function () use($request, $alumno){

            $persona = Persona::findOrfail($alumno->persona_id);
            $persona->primer_nombre = $request->get('primer_nombre');
            $persona->segundo_nombre = $request->get('segundo_nombre');
            $persona->tercer_nombre = $request->get('tercer_nombre');
            $persona->primer_apellido = $request->get('primer_apellido');
            $persona->segundo_apellido = $request->get('segundo_apellido');
            $persona->genero = $request->get('genero') == 1 ? 'M' : 'F';
            $persona->direccion = $request->get('direccion');
            $persona->save();

            $alumno->sire_id = $request->get('codigo_sire');
            $alumno->persona_id = $persona->id;
            $alumno->save();

            return redirect()->route('alumnos.index')->with(['mensaje' => 'Registro actualizado con éxito']);
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alumno $alumno)
    {
        try 
        {
            return DB::transaction(function () use($alumno){
                
                $persona = Persona::findOrfail($alumno->persona_id);

                $alumno->delete();
                $persona->delete();

                return response()->json(['data' => 'El registro fue borrado con éxito'],200);
            });
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
