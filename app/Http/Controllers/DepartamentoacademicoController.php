<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Facultad;
use App\Departamentoacademico;
use Validator;
use Auth;
use DB;

use App\Persona;
use App\Tipouser;
use App\User;

use Excel;
set_time_limit(600);

class DepartamentoacademicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index1()
    {
        if(accesoUser([1,2])){


            $idtipouser=Auth::user()->tipouser_id;
            $tipouser=Tipouser::find($idtipouser);


            $modulo="departamentoacademico";
            return view('departamentoacademico.index',compact('tipouser','modulo'));
        }
        else
        {
            return redirect('home');           
        }
    }

    public function index(Request $request)
    {   
        $buscar=$request->busca;

        $departamentoacademicos = DB::table('departamentoacademicos')
        ->join('facultads', 'facultads.id', '=', 'departamentoacademicos.facultad_id')
        ->where('departamentoacademicos.borrado','0')
        ->where(function($query) use ($buscar){
            $query->where('departamentoacademicos.nombre','like','%'.$buscar.'%');
            $query->orWhere('facultads.nombre','like','%'.$buscar.'%');
            })
        ->orderBy('facultads.nombre')
        ->orderBy('departamentoacademicos.nombre')
        ->orderBy('departamentoacademicos.id')
        ->select('departamentoacademicos.id','departamentoacademicos.nombre','departamentoacademicos.activo','departamentoacademicos.borrado','departamentoacademicos.facultad_id','facultads.nombre as facultad')
        ->paginate(30);

        $facultads=Facultad::where('borrado','0')->where('activo','1')->orderBy('nombre')->get();

        return [
            'pagination'=>[
                'total'=> $departamentoacademicos->total(),
                'current_page'=> $departamentoacademicos->currentPage(),
                'per_page'=> $departamentoacademicos->perPage(),
                'last_page'=> $departamentoacademicos->lastPage(),
                'from'=> $departamentoacademicos->firstItem(),
                'to'=> $departamentoacademicos->lastItem(),
            ],
            'departamentoacademicos'=>$departamentoacademicos,
            'facultads'=>$facultads
        ];
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
        $nombre=$request->nombre;
        $activo=$request->activo;
        $facultad_id=$request->facultad_id;



        $result='1';
        $msj='';
        $selector='';

        $input1  = array('nombre' => $nombre);
        $reglas1 = array('nombre' => 'required');

        $input2  = array('nombre' => $nombre);
        $reglas2 = array('nombre' => 'unique:departamentoacademicos,nombre'.',1,borrado');

        $input3  = array('facultad_id' => $facultad_id);
        $reglas3 = array('facultad_id' => 'required');


        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);


        if ($validator1->fails())
        {
            $result='0';
            $msj='Complete el nombre del Departamento Académico';
            $selector='txtnombre';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='Ingrese otro nombre de Departamento Académico, el nombre ingresado ya se encuentra registrado';
            $selector='txtnombre';
        }
        elseif ($validator3->fails()) {
            $result='0';
            $msj='Seleccione una Facultad';
            $selector='cbsFacultad';
        }
       
        else{

            $newDepartamento = new Departamentoacademico();
            $newDepartamento->nombre=$nombre;
            $newDepartamento->activo=$activo;
            $newDepartamento->borrado='0';
            $newDepartamento->facultad_id=$facultad_id;

            $newDepartamento->save();

            $msj='Nuevo Departamento Académico registrado con éxito';
        }




       //Areaunasam::create($request->all());

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $nombre=$request->nombre;
        $activo=$request->activo;
        $facultad_id=$request->facultad_id;



        $result='1';
        $msj='';
        $selector='';

        $input1  = array('nombre' => $nombre);
        $reglas1 = array('nombre' => 'required');

        $input2  = array('nombre' => $nombre);
        $reglas2 = array('nombre' => 'unique:departamentoacademicos,nombre,'.$id.',id,borrado,0');
        //$reglas4 = array('codigo' => 'unique:dependencias,cod_sis,'.$id.',id,borrado,0');

        $input3  = array('facultad_id' => $facultad_id);
        $reglas3 = array('facultad_id' => 'required');


        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);


        if ($validator1->fails())
        {
            $result='0';
            $msj='Complete el nombre del Departamento Académico';
            $selector='txtnombreE';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='Ingrese otro nombre de Departamento Académico, el Departamento Académico ingresado ya se encuentra registrado';
            $selector='txtnombreE';
        }
        elseif ($validator3->fails()) {
            $result='0';
            $msj='Seleccione una Facultad';
            $selector='cbsFacultadE';
        }
       
        else{

            $editDepartamento = Departamentoacademico::findOrFail($id);
            $editDepartamento->nombre=$nombre;
            $editDepartamento->activo=$activo;
            $editDepartamento->facultad_id=$facultad_id;

            $editDepartamento->save();

            $msj='Departamento Académico modificado con éxito';
        }

       //Areaunasam::create($request->all());

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    public function altabaja($id,$activo)
    {
        $result='1';
        $msj='';
        $selector='';

        $update = Departamentoacademico::findOrFail($id);
        $update->activo=$activo;
        $update->save();

        if(strval($activo)=="0"){
            $msj='El Departamento Académico fue Desactivado exitosamente';
        }elseif(strval($activo)=="1"){
            $msj='El Departamento Académico fue Activado exitosamente';
        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result='1';
        $msj='1';

        $consulta1=DB::table('docentes')
                    ->join('departamentoacademicos', 'docentes.departamentoacademico_id', '=', 'departamentoacademicos.id')
                    ->where('docentes.borrado','0')
                    ->where('departamentoacademicos.id',$id)->count();



        if($consulta1>0) {
            $result='0';
            $msj='El Departamento Académico Seleccionado no se puede eliminar debido a que cuenta con registros de Docentes registrados en él';
        }else{
        
        $borrar = Departamentoacademico::findOrFail($id);
        //$task->delete();

        $borrar->borrado='1';

        $borrar->save();

        $msj='Departamento Académico eliminado exitosamente';
     }

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
