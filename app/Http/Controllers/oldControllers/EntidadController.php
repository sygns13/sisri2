<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Local;
use App\Entidad;
use Validator;
use Auth;
use DB;

use App\Persona;
use App\Tipouser;
use App\User;

class EntidadController extends Controller
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


            $modulo="entidad";
            return view('entidad.index',compact('tipouser','modulo'));
        }
        else
        {
            return redirect('home');           
        }
    }

    public function index2()
    {
        if(accesoUser([1,2,3,4,5])){


            $idtipouser=Auth::user()->tipouser_id;
            $tipouser=Tipouser::find($idtipouser);


            $modulo="repentidades";
            return view('repentidades.index',compact('tipouser','modulo'));
        }
        else
        {
            return redirect('home');           
        }
    }


    public function index(Request $request)
    {   
     $buscar=$request->busca;

     $entidads = DB::table('entidads')
     ->join('locals', 'locals.id', '=', 'entidads.local_id')
     ->where('entidads.borrado','0')
     ->where(function($query) use ($buscar){
        $query->where('entidads.descripcion','like','%'.$buscar.'%');
        $query->orWhere('entidads.code','like','%'.$buscar.'%');
        $query->orWhere('locals.nombre','like','%'.$buscar.'%');
        })
     ->orderBy('entidads.descripcion')
     ->select('entidads.id','entidads.descripcion','entidads.code','entidads.estado','entidads.activo','entidads.borrado','entidads.local_id','locals.nombre as local','locals.direccion')
     ->paginate(30);

     $locals=Local::where('borrado','0')->where('estado','1')->orderBy('nombre')->get();

     return [
        'pagination'=>[
            'total'=> $entidads->total(),
            'current_page'=> $entidads->currentPage(),
            'per_page'=> $entidads->perPage(),
            'last_page'=> $entidads->lastPage(),
            'from'=> $entidads->firstItem(),
            'to'=> $entidads->lastItem(),
        ],
        'entidads'=>$entidads,
        'locals'=>$locals
    ];
    }

    public function buscarDatosImp(Request $request)
    {   
     $buscar=$request->busca;

     $entidads = DB::table('entidads')
     ->join('locals', 'locals.id', '=', 'entidads.local_id')
     ->where('entidads.borrado','0')
     ->where(function($query) use ($buscar){
        $query->where('entidads.descripcion','like','%'.$buscar.'%');
        $query->orWhere('entidads.code','like','%'.$buscar.'%');
        $query->orWhere('locals.nombre','like','%'.$buscar.'%');
        })
     ->orderBy('entidads.descripcion')
     ->select('entidads.id','entidads.descripcion','entidads.code','entidads.estado','entidads.activo','entidads.borrado','entidads.local_id','locals.nombre as local','locals.direccion')
     ->get();

     return [
        'dataimp'=>$entidads
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
        $descripcion=$request->descripcion;
        $code=$request->code;
        $estado=$request->estado;
        $local_id=$request->local_id;



        $result='1';
        $msj='';
        $selector='';

        $input1  = array('descripcion' => $descripcion);
        $reglas1 = array('descripcion' => 'required');

        $input2 = array('code' => $code);
        $reglas2 = array('code' => 'required');

        $input3  = array('descripcion' => $descripcion);
        $reglas3 = array('descripcion' => 'unique:entidads,descripcion'.',1,borrado');

        $input4  = array('code' => $code);
        $reglas4 = array('code' => 'unique:entidads,code'.',1,borrado');

        $input5 = array('local_id' => $local_id);
        $reglas5 = array('local_id' => 'required');



        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);
        $validator5 = Validator::make($input5, $reglas5);

        if ($validator1->fails())
        {
            $result='0';
            $msj='Complete el descripción de la Entidad';
            $selector='txtdesc';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='Complete el Código de la Entidad';
            $selector='txtcod';
        }
        elseif ($validator3->fails()) {
            $result='0';
            $msj='Ingrese otra descripción de la Entidad, la descripción seleccionada ya se encuentra registrada.';
            $selector='txtdesc';
        }
        elseif ($validator4->fails()) {
            $result='0';
            $msj='Ingrese otro código de Entidad, el código seleccionado ya se encuentra registrado.';
            $selector='txtcod';
        }
        elseif ($validator5->fails()) {
            $result='0';
            $msj='Seleccione un Local Válido.';
            $selector='cbslocal';
        }
        else{

            $newEntidad = new Entidad();
            $newEntidad->descripcion=$descripcion;
            $newEntidad->code=$code;
            $newEntidad->estado=$estado;
            $newEntidad->borrado='0';
            $newEntidad->local_id=$local_id;

            $newEntidad->save();

            $msj='Nueva Entidad registrada con éxito';
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
        $descripcion=$request->descripcion;
        $code=$request->code;
        $estado=$request->estado;
        $local_id=$request->local_id;



        $result='1';
        $msj='';
        $selector='';

        $input1  = array('descripcion' => $descripcion);
        $reglas1 = array('descripcion' => 'required');

        $input2 = array('code' => $code);
        $reglas2 = array('code' => 'required');

        $input3  = array('descripcion' => $descripcion);
        $reglas3 = array('descripcion' => 'unique:entidads,descripcion,'.$id.',id,borrado,0');
        //$reglas4 = array('codigo' => 'unique:dependencias,cod_sis,'.$id.',id,borrado,0');

        $input4  = array('code' => $code);
        $reglas4 = array('code' => 'unique:entidads,code,'.$id.',id,borrado,0');

        $input5 = array('local_id' => $local_id);
        $reglas5 = array('local_id' => 'required');



        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);
        $validator5 = Validator::make($input5, $reglas5);

        if ($validator1->fails())
        {
            $result='0';
            $msj='Complete el descripción de la Entidad';
            $selector='txtdescE';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='Complete el Código de la Entidad';
            $selector='txtcodE';
        }
        elseif ($validator3->fails()) {
            $result='0';
            $msj='Ingrese otra descripción de la Entidad, la descripción seleccionada ya se encuentra registrada.';
            $selector='txtdescE';
        }
        elseif ($validator4->fails()) {
            $result='0';
            $msj='Ingrese otro código de Entidad, el código seleccionado ya se encuentra registrado.';
            $selector='txtcodE';
        }
        elseif ($validator5->fails()) {
            $result='0';
            $msj='Seleccione un Local Válido.';
            $selector='cbslocalE';
        }
        else{


            $editEntidad= Entidad::findOrFail($id);
            $editEntidad->descripcion=$descripcion;
            $editEntidad->code=$code;
            $editEntidad->estado=$estado;
            $editEntidad->local_id=$local_id;

            $editEntidad->save();

            $msj='Entidad modificada con éxito';
        }




       //Areaunasam::create($request->all());

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }



    public function altabaja($id,$estado)
    {
        $result='1';
        $msj='';
        $selector='';

        $update = Entidad::findOrFail($id);
        $update->estado=$estado;
        $update->save();

        if(strval($estado)=="0"){
            $msj='La Entidad fue Desactivada exitosamente';
        }elseif(strval($estado)=="1"){
            $msj='La Entidad fue Activada exitosamente';
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

        $consulta1=DB::table('users')
                    ->join('entidads', 'users.entidad_id', '=', 'entidads.id')
                    ->where('users.borrado','0')
                    ->where('entidads.id',$id)->count();

        $consulta2=DB::table('precios')
        ->join('entidads', 'precios.entidad_id', '=', 'entidads.id')
        ->where('entidads.borrado','0')
        ->where('entidads.id',$id)->count();

        if($consulta1>0) {
            $result='0';
            $msj='La Dependencia Seleccionada no se puede eliminar debido a que cuenta con registros de Usuarios registrados en ella';
        }elseif($consulta2>0) {
            $result='0';
            $msj='La Dependencia Seleccionada no se puede eliminar debido a que cuenta con registros de Precios registrados en ella';
        }else{
        
        $borrar = Entidad::findOrFail($id);
        //$task->delete();

        $borrar->borrado='1';

        $borrar->save();

        $msj='Entidad eliminada exitosamente';
     }

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
