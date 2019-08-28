<?php

namespace App\Http\Controllers;

use App\Semestre;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Validator;
use Auth;
use DB;

use App\Persona;
use App\Tipouser;
use App\User;

class SemestreController extends Controller
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


            $modulo="semestres";
            return view('semestres.index',compact('tipouser','modulo'));
        }
        else
        {
            return redirect('home');          
        }
    }


    public function index(Request $request)
    {   
     $buscar=$request->busca;

     $semestres = Semestre::where('borrado','0')
     ->where(function($query) use ($buscar){
        $query->where('nombre','like','%'.$buscar.'%');
        })
     ->orderBy('fechafin','desc')->paginate(30);

     return [
        'pagination'=>[
            'total'=> $semestres->total(),
            'current_page'=> $semestres->currentPage(),
            'per_page'=> $semestres->perPage(),
            'last_page'=> $semestres->lastPage(),
            'from'=> $semestres->firstItem(),
            'to'=> $semestres->lastItem(),
        ],
        'semestres'=>$semestres
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
        $ciclo=$request->Ciclo;
    	$fecIni=$request->fecIni;
    	$fecFin=$request->fecFin;
    	$estado=$request->estado;

    	$input1  = array('ciclo' => $ciclo);
    	$reglas1 = array('ciclo' => 'required');

    	$input2  = array('ciclo' => $ciclo);
    	$reglas2 = array('ciclo' => 'unique:semestres,nombre'.',1,borrado');

    	$validator1 = Validator::make($input1, $reglas1);
    	$validator2 = Validator::make($input2, $reglas2);

    	$result='1';
    	$msj='';
    	$selector='';

    	if ($validator1->fails())
    	{
    		$result='0';
    		$msj='Debe completar el Nombre del Semestre';
    		$selector='txtciclo';

    	}elseif ($validator2->fails()) {
    		$result='0';
    		$msj='El Semestre consignado ya se encuentra registrado';
    		$selector='txtciclo';
    	}elseif(!validaFecha($fecIni)){
    		$result='0';
    		$msj='La Fecha Inicial ingresada es Incorrecta';
    		$selector='txtfecIni';
    	}elseif(!validaFecha($fecFin)){
    		$result='0';
    		$msj='La Fecha Final ingresada es Incorrecta';
    		$selector='txtFecFin';
    	}
    	else{

    		if($estado=='1'){
    			Semestre::where('estado','1')->update(['estado' => '0']);
    		}

    		$newSemestre = new Semestre();
    		$newSemestre->nombre=$ciclo;
    		$newSemestre->fechainicio=$fecIni;
    		$newSemestre->fechafin=$fecFin;
    		$newSemestre->estado=$estado;

    		$newSemestre->activo='1';
    		$newSemestre->borrado='0';
    		$newSemestre->user_id=Auth::user()->id;

    		$newSemestre->save();

    		$msj='Nuevo Semestre Académico creada con éxito';

    }

    return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);

}

    /**
     * Display the specified resource.
     *
     * @param  \App\Semestre  $semestre
     * @return \Illuminate\Http\Response
     */
    public function show(Semestre $semestre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Semestre  $semestre
     * @return \Illuminate\Http\Response
     */
    public function edit(Semestre $semestre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Semestre  $semestre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ciclo=$request->semestre;
    	$fecIni=$request->fechainicio;
    	$fecFin=$request->fechafin;
    	$estado=$request->estado;

    	$input1  = array('ciclo' => $ciclo);
    	$reglas1 = array('ciclo' => 'required');

    	$input2  = array('ciclo' => $ciclo);
    	$reglas2 = array('ciclo' => 'unique:semestres,nombre,'.$id.',id,borrado,0');

    	$validator1 = Validator::make($input1, $reglas1);
    	$validator2 = Validator::make($input2, $reglas2);

    	$result='1';
    	$msj='';
    	$selector='';

    	if ($validator1->fails())
    	{
    		$result='0';
    		$msj='Debe completar el Nombre del Semestre';
    		$selector='txtcicloE';

    	}elseif ($validator2->fails()) {
    		$result='0';
    		$msj='El Semestre consignado ya se encuentra registrado en otro registro';
    		$selector='txtcicloE';
    	}
    	elseif(!validaFecha($fecIni)){
    		$result='0';
    		$msj='La Fecha Inicial ingresada es Incorrecta';
    		$selector='txtfecIniE';
    	}elseif(!validaFecha($fecFin)){
    		$result='0';
    		$msj='La Fecha Final ingresada es Incorrecta';
    		$selector='txtFecFinE';
    	}
    	else{

    		if($estado=='1'){
    			Semestre::where('estado','1')->update(['estado' => '0']);
    		}

    		$updateSemestre = Semestre::findOrFail($id);
    		$updateSemestre->nombre=$ciclo;
    		$updateSemestre->fechainicio=$fecIni;
    		$updateSemestre->fechafin=$fecFin;
    		$updateSemestre->estado=$estado;
    		$updateSemestre->user_id=Auth::user()->id;

    		$updateSemestre->save();

    		$msj='El Semestre Académico ha sido modificado con éxito';
    	}




       //Areaunasam::create($request->all());

    	return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }


    public function activar($id,$estado)
    {

    	$result='1';
    	$msj='';
    	$selector='';

    	Semestre::where('estado','1')->update(['estado' => '0']);

    	$updateSemestre = Semestre::findOrFail($id);
    	$updateSemestre->estado=$estado;
    	$updateSemestre->save();

    	if(strval($estado)=="0"){
    		$msj='El Semestre seleccionado fue Desactivado exitosamente';
    	}elseif(strval($estado)=="1"){
    		$msj='El Semestre seleccionado fue Activado exitosamente';
    	}

    	return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Semestre  $semestre
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result='1';
    	$msj='1';

    	$consulta=DB::table('semestres')
    	->join('alumnos', 'alumnos.semestre_id', '=', 'semestres.id')
    	->where('alumnos.borrado','0')
    	->where('semestres.id',$id)->count();

    	if ($consulta>0) {
    		$result='0';
    		$msj='No se puede eliminar dicho Semestre, debido a que cuenta con alumnos resgistrados en él.';
    	}else{

    		$borrarSemestre = Semestre::findOrFail($id);
        //$task->delete();

    		$borrarSemestre->borrado='1';

    		$borrarSemestre->save();

    		$msj='Semestre eliminado exitosamente';
    	}

    	return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
