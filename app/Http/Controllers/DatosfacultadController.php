<?php

namespace App\Http\Controllers;

use App\Datosfacultad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Local;
use App\Facultad;
use Validator;
use Auth;
use DB;

use App\Persona;
use App\Tipouser;
use App\User;
use App\Tipodato;
use App\Semestre;

class DatosfacultadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index1($id)
    {
        if(accesoUser([1,2])){


            $idtipouser=Auth::user()->tipouser_id;
            $tipouser=Tipouser::find($idtipouser);


            $modulo="datosFacultad";

            $facultad=Facultad::find($id);

            //return $facultad;

            $tipodato=Tipodato::where('activo','1')->where('borrado','0')->get();

            $semestres=Semestre::where('activo','1')->where('borrado','0')->orderBy('fechafin','desc')->get();

           


            return view('datosFacultad.index',compact('tipouser','modulo','facultad','tipodato','semestres'));
        }
        else
        {
            return redirect('home');           
        }
    }


    public function index(Request $request)
    {
        $buscar=$request->busca;
        $idFacu=$request->idFacu;

        $datosfacultad = DB::table('datosfacultads')
        ->join('semestres', 'semestres.id', '=', 'datosfacultads.semestre_id')
        ->join('facultads', 'facultads.id', '=', 'datosfacultads.facultad_id')
        ->join('tipodatos', 'tipodatos.id', '=', 'datosfacultads.tipodato_id')
        ->where('datosfacultads.borrado','0')
        ->where('datosfacultads.facultad_id',$idFacu)
  /*       ->where(function($query) use ($buscar){
           $query->where('facultads.nombre','like','%'.$buscar.'%');
           $query->orWhere('locals.nombre','like','%'.$buscar.'%');
           }) */
        ->orderBy('semestres.id')
        ->orderBy('datosfacultads.id')
        ->select('datosfacultads.id','datosfacultads.nombre','datosfacultads.descripcion','datosfacultads.cantidad','datosfacultads.subnombre','datosfacultads.descripcion2','datosfacultads.cantidad2','datosfacultads.activo','semestres.nombre as semestre','tipodatos.tipo','datosfacultads.tipodato_id','tipodatos.titulo as tipodato','datosfacultads.semestre_id','datosfacultads.facultad_id')
        ->get();
   
        $locals=Local::where('borrado','0')->where('activo','1')->orderBy('nombre')->get();
   
        return [

           'datosfacultad'=>$datosfacultad,

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
        $facultad_id=$request->facultad_id;
        $tipodato_id=$request->tipodato_id;
        $semestre_id=$request->semestre_id;
        $nombre=$request->nombre;
        $cantidad=$request->cantidad;
        $cantidad2=$request->cantidad2;
        $tiporeg=$request->tiporeg;

        $cantregs=Datosfacultad::where('facultad_id',$facultad_id)->where('semestre_id',$semestre_id)->where('tipodato_id',$tipodato_id)->count();



        $result='1';
        $msj='';
        $selector='';

        $input1  = array('facultad_id' => $facultad_id);
        $reglas1 = array('facultad_id' => 'required');

        $input2  = array('semestre_id' => $semestre_id);
        $reglas2 = array('semestre_id' => 'required');

        $input3  = array('nombre' => $nombre);
        $reglas3 = array('nombre' => 'required');

        $input4  = array('cantidad' => $cantidad);
        $reglas4 = array('cantidad' => 'required');

        $input5  = array('cantidad2' => $cantidad2);
        $reglas5 = array('cantidad2' => 'required');


        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);
        $validator5 = Validator::make($input5, $reglas5);

        if($cantregs>0){
            $result='0';
            $msj='Ya se tiene consignado este tipo de registro para el semestre seleccionado de esta facultad, ingrese otro registro, o seleccione un semestre que aun no tenga este tipo de registro';
            $selector='cbuSemestre';
        }   
        elseif ($validator1->fails())
        {
            $result='0';
            $msj='Vuelva a cargar la página, no se seleccionó adecuadamente la Facultad';
            $selector='cbuSemestre';

        }elseif ($validator2->fails() || intval($semestre_id)<1) {
            $result='0';
            $msj='Seleccione un Semestre válido';
            $selector='cbuSemestre';
        }
        elseif ($validator3->fails() && intval($tiporeg)>2) {
            $result='0';
            $msj='Registre una descripción válida del Tipo de Dato Registrado';
            $selector='txtdesc';
        }
        elseif ($validator4->fails() && intval($tiporeg)<4) {
            $result='0';
            $msj='Registre una cantidad válida';
            $selector='txtcant';
        }
        elseif ($validator5->fails() && intval($tiporeg)==2) {
            $result='0';
            $msj='Registre una cantidad válida de Computadoras Promedio por centro de Cómputo';
            $selector='txtcant2';
        }
       
        else{

            if(intval($tiporeg)!=2)
            {
                $cantidad2=0;
            }

            $datoFacultad = new Datosfacultad();
            $datoFacultad->nombre=$nombre;
            $datoFacultad->descripcion='';
            $datoFacultad->cantidad=$cantidad;
            $datoFacultad->subnombre='';
            $datoFacultad->descripcion2='';
            $datoFacultad->cantidad2=$cantidad2;
            $datoFacultad->activo='1';
            $datoFacultad->borrado='0';
            $datoFacultad->tipodato_id=$tipodato_id;
            $datoFacultad->facultad_id=$facultad_id;
            $datoFacultad->semestre_id=$semestre_id;

            $datoFacultad->save();

            $msj='Nuevo Registro de Datos registrado con éxito';
        }




       //Areaunasam::create($request->all());

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Datosfacultad  $datosfacultad
     * @return \Illuminate\Http\Response
     */
    public function show(Datosfacultad $datosfacultad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Datosfacultad  $datosfacultad
     * @return \Illuminate\Http\Response
     */
    public function edit(Datosfacultad $datosfacultad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Datosfacultad  $datosfacultad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $facultad_id=$request->facultad_id;
        $tipodato_id=$request->tipodato_id;
        $semestre_id=$request->semestre_id;
        $nombre=$request->nombre;
        $cantidad=$request->cantidad;
        $cantidad2=$request->cantidad2;
        $tiporeg=$request->tiporeg;

        $cantregs=Datosfacultad::where('facultad_id',$facultad_id)->where('semestre_id',$semestre_id)->where('tipodato_id',$tipodato_id)->where('id','<>',$id)->count();



        $result='1';
        $msj='';
        $selector='';

        $input1  = array('facultad_id' => $facultad_id);
        $reglas1 = array('facultad_id' => 'required');

        $input2  = array('semestre_id' => $semestre_id);
        $reglas2 = array('semestre_id' => 'required');

        $input3  = array('nombre' => $nombre);
        $reglas3 = array('nombre' => 'required');

        $input4  = array('cantidad' => $cantidad);
        $reglas4 = array('cantidad' => 'required');

        $input5  = array('cantidad2' => $cantidad2);
        $reglas5 = array('cantidad2' => 'required');


        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);
        $validator5 = Validator::make($input5, $reglas5);

        if($cantregs>0){
            $result='0';
            $msj='Ya se tiene consignado este tipo de registro para el semestre seleccionado de esta facultad, ingrese otro registro, o seleccione un semestre que aun no tenga este tipo de registro';
            $selector='cbuSemestreE';
        }   
        elseif ($validator1->fails())
        {
            $result='0';
            $msj='Vuelva a cargar la página, no se seleccionó adecuadamente la Facultad';
            $selector='cbuSemestreE';

        }elseif ($validator2->fails() || intval($semestre_id)<1) {
            $result='0';
            $msj='Seleccione un Semestre válido';
            $selector='cbuSemestreE';
        }
        elseif ($validator3->fails() && intval($tiporeg)>2) {
            $result='0';
            $msj='Registre una descripción válida del Tipo de Dato Registrado';
            $selector='txtdescE';
        }
        elseif ($validator4->fails() && intval($tiporeg)<4) {
            $result='0';
            $msj='Registre una cantidad válida';
            $selector='txtcantE';
        }
        elseif ($validator5->fails() && intval($tiporeg)==2) {
            $result='0';
            $msj='Registre una cantidad válida de Computadoras Promedio por centro de Cómputo';
            $selector='txtcant2E';
        }
       
        else{

            if(intval($tiporeg)!=2)
            {
                $cantidad2=0;
            }

            $datoFacultad =Datosfacultad::findOrFail($id);
            $datoFacultad->nombre=$nombre;
            $datoFacultad->cantidad=$cantidad;
            $datoFacultad->cantidad2=$cantidad2;
            $datoFacultad->tipodato_id=$tipodato_id;
            $datoFacultad->facultad_id=$facultad_id;
            $datoFacultad->semestre_id=$semestre_id;

            $datoFacultad->save();

            $msj='Registro de Datos Modificado con éxito';
        }




       //Areaunasam::create($request->all());

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Datosfacultad  $datosfacultad
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result='1';
        $msj='1';

 
        $borrar = Datosfacultad::destroy($id);
  

        $msj='Facultad eliminada exitosamente';
   

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
