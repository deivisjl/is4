<?php

namespace App\Http\Controllers\Pensum;

use App\Aula;
use App\Plan;
use App\CicloEscolar;
use App\ProfesorCurso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CursoDocenteController extends Controller
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

        $registro = DB::table('aula as a')
                        ->join('carrera_grado as cg','a.carrera_grado_id','cg.id')
                        ->join('carrera as c','cg.carrera_id','c.id')
                        ->select(DB::raw('DISTINCT(cg.carrera_id) as id'),'c.nombre')
                        ->where('a.ciclo_escolar_id',$ciclo->id)
                        ->get();
                        
        return view('curso-docente.index',['registro' => $registro,'ciclo' => $ciclo,'planes'=>$planes]);
    }

    public function aulas(Request $request)
    {
        try 
        {
            $ciclo = CicloEscolar::where('activo',1)->first();

            $registro = DB::table('aula as a')                
                        ->join('seccion as s','s.id','a.seccion_id')
                        ->join('carrera_grado as cg','cg.id','a.carrera_grado_id')
                        ->join('grado as g','g.id','cg.grado_id')
                        ->select('a.id','g.nombre as aula', 's.nombre as seccion')
                        ->where('a.ciclo_escolar_id',$ciclo->id)
                        ->where('cg.carrera_id',$request->get('carrera'))
                        ->where('a.plan_id',$request->get('plan'))
                        ->get();
            
            return response()->json(['data' => $registro],200);

        } 
        catch (\Exception $ex) 
        {
            return response()->json(['error' => $ex->getMessage()],423);
        }
    }

    public function cursos($id)
    {
        try 
        {
            $registro = DB::table('aula as a')
                        ->join('carrera_grado as cg','a.carrera_grado_id','cg.id')
                        ->join('pensum as p','p.carrera_grado_id','cg.id')
                        ->join('curso as c','p.curso_id','c.id')
                        ->select('p.id','c.nombre')
                        ->where('a.id',$id)
                        ->get();
            
            return response()->json(['data' => $registro],200);
        } 
        catch (\Exception $ex) 
        {
            return response()->json(['error' => $ex->getMessage()],423);
        }
    }

    public function profesores()
    {
        try 
        {
            $rol = 'profesor';

            $registro = DB::table('users as u')
                            ->join('persona as p','u.persona_id','p.id')
                            ->join('rol as r','u.rol_id','r.id')
                            ->select('u.id',DB::raw('CONCAT_WS(" ",primer_nombre,"",segundo_nombre,"",tercer_nombre,"",primer_apellido,"",segundo_apellido) as nombre'))
                            ->where(DB::raw('LOWER(r.nombre)'),$rol)
                            ->get();
            
            return response()->json(['data' => $registro],200);
        } 
        catch (\Exception $ex) 
        {
            return response()->json(['error' => $ex->getMessage()],423);
        }
    }

    public function asignar(Request $request)
    {
        try 
        {
            $rules = [
                'aula_id' => 'required|numeric|min:1',
                'asignacion' => 'required|array'
            ];

            $this->validate($request, $rules);

            $ciclo = CicloEscolar::where('activo',1)->first();

            $this->vaciar_asignacion($request->aula_id, $ciclo->id);

            return DB::transaction(function () use($request, $ciclo){

                foreach ($request->asignacion as $key => $item) {

                    $asignar = new ProfesorCurso();
                    $asignar->usuario_id = $item['profesor_id'];
                    $asignar->pensum_id = $item['id'];
                    $asignar->aula_id = $request->aula_id;
                    $asignar->ciclo_escolar_id = $ciclo->id;
                    $asignar->save();
                }

                return response()->json(['data' => 'Cursos asignados con éxito'],200);
            });
        } 
        catch (\Exception $ex) 
        {
            return response()->json(['error' => $ex->getMessage()],423);
        }
    }

    public function vaciar_asignacion($aula, $ciclo)
    {
        $aula = Aula::find($aula);

        if($aula)
        {
            $aula->profesor_curso()->where('ciclo_escolar_id',$ciclo)->delete();
        }

        return;
    }
}
