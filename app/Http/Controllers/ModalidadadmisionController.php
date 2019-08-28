<?php

namespace App\Http\Controllers;

use App\Modalidadadmision;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use Validator;
use Auth;
use DB;

use App\Persona;
use App\Tipouser;
use App\User;


class ModalidadadmisionController extends Controller
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


            $modulo="modadmision";
            return view('modadmision.index',compact('tipouser','modulo'));
        }
        else
        {
            return redirect('home');           
        }
    }


    public function index(Request $request)
    {   
     $buscar=$request->busca;
        
     $modadmisions=Modalidadadmision::where('borrado','0')
     ->where(function($query) use ($buscar){
        $query->where('nombre','like','%'.$buscar.'%');
        $query->orWhere('descripcion','like','%'.$buscar.'%');
        })    
     ->paginate(30);

     return [
        'pagination'=>[
            'total'=> $modadmisions->total(),
            'current_page'=> $modadmisions->currentPage(),
            'per_page'=> $modadmisions->perPage(),
            'last_page'=> $modadmisions->lastPage(),
            'from'=> $modadmisions->firstItem(),
            'to'=> $modadmisions->lastItem(),
        ],
        'modadmisions'=>$modadmisions
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
        $descripcion=$request->descripcion;
        $activo=$request->activo;

        $result='1';
        $msj='';
        $selector='';

        $input1  = array('nombre' => $nombre);
        $reglas1 = array('nombre' => 'required');

        $input2 = array('nombre' => $nombre);
        $reglas2 = array('nombre' => 'unique:modalidadadmisions,nombre'.',1,borrado');

        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);


        if ($validator1->fails())
        {
            $result='0';
            $msj='Complete el nombre del la Modalidad de Admisión';
            $selector='txtnom';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='La Modalidad de Admisión ingresada ya se encuentra registrada, consigne otro nombre';
            $selector='txtnom';
        }

        else{

            $newModalidadAdmision = new Modalidadadmision();
            $newModalidadAdmision->nombre=$nombre;
            $newModalidadAdmision->descripcion=$descripcion;
            $newModalidadAdmision->activo=$activo;
            $newModalidadAdmision->borrado='0';

            $newModalidadAdmision->save();

            $msj='Modalidad de Admisión registrada con éxito';
        }




       //Areaunasam::create($request->all());

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Modalidadadmision  $modalidadadmision
     * @return \Illuminate\Http\Response
     */
    public function show(Modalidadadmision $modalidadadmision)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Modalidadadmision  $modalidadadmision
     * @return \Illuminate\Http\Response
     */
    public function edit(Modalidadadmision $modalidadadmision)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Modalidadadmision  $modalidadadmision
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $nombre=$request->nombre;
        $descripcion=$request->descripcion;
        $activo=$request->activo;

        $result='1';
        $msj='';
        $selector='';

        $input1  = array('nombre' => $nombre);
        $reglas1 = array('nombre' => 'required');

        $input2 = array('nombre' => $nombre);
        $reglas2 = array('nombre' => 'unique:modalidadadmisions,nombre,'.$id.',id,borrado,0');

        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);


        if ($validator1->fails())
        {
            $result='0';
            $msj='Complete el nombre del la Modalidad de Admisión';
            $selector='txtnomE';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='La Modalidad de Admisión ingresada ya se encuentra registrada, consigne otro nombre';
            $selector='txtnomE';
        }

        else{

            $editModalidadAdmision =Modalidadadmision::findOrFail($id);
            $editModalidadAdmision->nombre=$nombre;
            $editModalidadAdmision->descripcion=$descripcion;
            $editModalidadAdmision->activo=$activo;

            $editModalidadAdmision->save();

            $msj='Modalidad de Admisión modificada con éxito';
        }




       //Areaunasam::create($request->all());

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Modalidadadmision  $modalidadadmision
     * @return \Illuminate\Http\Response
     */

    public function altabaja($id,$estado)
    {
        $result='1';
        $msj='';
        $selector='';

        $update = Modalidadadmision::findOrFail($id);
        $update->activo=$estado;
        $update->save();

        if(strval($estado)=="0"){
            $msj='La Modalidad de Admisión fue Desactivada exitosamente';
        }elseif(strval($estado)=="1"){
            $msj='La Modalidad de Admisión fue Activada exitosamente';
        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);

    }


    public function destroy($id)
    {
        $result='1';
        $msj='1';

        $consulta1=DB::table('postulantes')
                    ->join('modalidadadmisions', 'postulantes.modalidadadmision_id', '=', 'modalidadadmisions.id')
                    ->where('postulantes.borrado','0')
                    ->where('modalidadadmisions.id',$id)->count();

       /*  $consulta2=DB::table('entidads')
        ->join('locals', 'entidads.local_id', '=', 'locals.id')
        ->where('entidads.borrado','0')
        ->where('locals.id',$id)->count(); */

        if($consulta1>0) {
            $result='0';
            $msj='La Modalidad de Admisión no se puede eliminar debido a que cuenta con registros de postulantes registrados en ellla';
        }/* elseif($consulta2>0) {
            $result='0';
            $msj='El Local Seleccionado no se puede eliminar debido a que cuenta con registros de entidades registrados en el';
        } */else{
        
        $borrar = Modalidadadmision::findOrFail($id);
        //$task->delete();

        $borrar->borrado='1';

        $borrar->save();

        $msj='Modalidad de Admisión eliminada exitosamente';
     }

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
