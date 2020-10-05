<?php

namespace App\Http\Controllers\Administrar;

use App\Rol;
use App\User;
use App\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('administrar.usuarios.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Rol::all();

        return view('administrar.usuarios.create',['roles' => $roles]);   
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

                'primer_nombre' => 'required|string|max:100',
                'segundo_nombre' => 'nullable|string|max:100',
                'tercer_nombre' => 'nullable|string|max:100',
                'primer_apellido' => 'required|string|max:100',
                'segundo_apellido' => 'nullable|string|max:100',
                'genero' => 'required|string|max:1',
                'direccion' => 'required|string',
                'rol' => 'required|numeric|min:1',
                'dpi' => 'required|numeric',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:5|confirmed',               
            ];            

        $this->validate($request, $rules);

        return DB::transaction(function() use($request) {

            $persona = new Persona();
            $persona->primer_nombre = $request->get('primer_nombre');
            $persona->segundo_nombre = $request->get('segundo_nombre');
            $persona->tercer_nombre = $request->get('tercer_nombre');
            $persona->primer_apellido = $request->get('primer_apellido');
            $persona->segundo_apellido = $request->get('segundo_apellido');
            $persona->genero = $request->get('genero');
            $persona->direccion = $request->get('direccion');
            $persona->save();

            $usuario = new User();
            $usuario->rol_id = $request->get('rol');
            $usuario->persona_id = $persona->id;
            $usuario->dpi = $request->get('dpi');
            $usuario->email = $request->get('email');
            $usuario->password = bcrypt($request->get('password'));
            $usuario->save();

            return redirect()->route('usuarios.index')->with(['mensaje' => 'Registro exitoso']);

        });
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ordenadores = array("users.id","users.email","rol.nombre","users.dpi");

        $columna = $request['order'][0]["column"];
        
        $criterio = $request['search']['value'];


        $usuarios = DB::table('persona')
                ->join('users','users.persona_id','=','persona.id')
                 ->join('rol','users.rol_id','=','rol.id')
                ->select('users.id',DB::raw('CONCAT_WS(" ",persona.primer_nombre," ",persona.segundo_nombre," ",persona.tercer_nombre," ",persona.primer_apellido," ",persona.segundo_apellido) as nombre'),'rol.nombre as rol','users.dpi','users.email') 
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();
              
        $count = DB::table('persona')
                ->join('users','users.persona_id','=','persona.id')
                 ->join('rol','users.rol_id','=','rol.id')
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();
               
        $data = array(
        'draw' => $request->draw,
        'recordsTotal' => $count,
        'recordsFiltered' => $count,
        'data' => $usuarios,
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
        $usuario = User::findOrFail($id);
        $roles = Rol::all();

        return view('administrar.usuarios.edit',['usuario'=> $usuario, 'roles' => $roles]);
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
            'primer_nombre' => 'required|string',
            'segundo_nombre' => 'nullable|string',
            'tercer_nombre' => 'nullable|string',
            'primer_apellido' => 'required|string',
            'segundo_apellido' => 'nullable|string',
            'genero' => 'required|string|max:1',
            'direccion' => 'required|string',
            'rol' => 'required|numeric|min:1',
            'dpi' => 'required|numeric',
            'email' => 'required|email|unique:users,email,'.$id,
        ];

        $this->validate($request, $rules);

        return DB::transaction(function() use($request, $id) {

            $usuario = User::findOrfail($id);
            $usuario->rol_id = $request->get('rol');
            $usuario->dpi = $request->get('dpi');
            $usuario->email = $request->get('email');
            $usuario->save();

            $persona = Persona::findOrfail($usuario->persona_id);
            $persona->primer_nombre = $request->get('primer_nombre');
            $persona->segundo_nombre = $request->get('segundo_nombre');
            $persona->tercer_nombre = $request->get('tercer_nombre');
            $persona->primer_apellido = $request->get('primer_apellido');
            $persona->segundo_apellido = $request->get('segundo_apellido');
            $persona->genero = $request->get('genero');
            $persona->direccion = $request->get('direccion');
            $persona->save();

            return redirect()->route('usuarios.index')->with(['mensaje' => 'Actualización exitoso']);

        });

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
            if($id == Auth::user()->id)
            {
                throw new \Exception("No se puede eliminar el usuario en sesión", 1);
                
            }
            
            return DB::transaction(function () use($id){
                
                $usuario = User::findOrFail($id);
                $usuario->delete();

                $persona = Persona::findOrFail($usuario->persona_id);
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

    public function cambiarCredencial()
    {
        return view('administrar.usuarios.cambiar-credencial');
    }

    public function guardarNuevaCredencial(Request $request)
    {
        $rules = [
            'password' => 'required|min:5|confirmed'
        ];

        $this->validate($request, $rules);

        try 
        {
            $usuario = Auth::user();
            $usuario->password = bcrypt($request->get('password'));
            $usuario->save();

            return redirect()->route('home')->with(['mensaje' => 'Actualización exitosa']);
            
        } 
        catch (\Exception $ex) 
        {
            return redirect()->route('home');        
        }
    }
}
