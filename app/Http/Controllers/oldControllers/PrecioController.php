<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidad;
use App\Rubro;
use App\Precio;
use Validator;
use Auth;
use DB;

use App\Persona;
use App\Tipouser;
use App\User;

class PrecioController extends Controller
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


            $modulo="precio";
            return view('precio.index',compact('tipouser','modulo'));
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


            $modulo="repprecios";
            return view('repprecios.index',compact('tipouser','modulo'));
        }
        else
        {
            return redirect('home');           
        }
    }


    public function index(Request $request)
    {   
     $buscar=$request->busca;

     $precios = DB::table('precios')
     ->join('rubros', 'rubros.id', '=', 'precios.rubro_id')
     ->join('entidads', 'entidads.id', '=', 'precios.entidad_id')
     ->where('precios.borrado','0')
     ->where(function($query) use ($buscar){
        $query->where('precios.descripcion','like','%'.$buscar.'%');
        $query->orWhere('precios.codigo','like','%'.$buscar.'%');
        $query->orWhere('rubros.descripcion','like','%'.$buscar.'%');
        $query->orWhere('entidads.descripcion','like','%'.$buscar.'%');
        })
     ->orderBy('entidads.descripcion')
     ->orderBy('rubros.descripcion')
     ->orderBy('precios.descripcion')
     ->orderBy('precios.id')
     ->select('precios.id','precios.descripcion','precios.codigo','precios.estado','precios.monto','precios.borrado','precios.rubro_id','precios.entidad_id','rubros.id as idRub','rubros.descripcion as rubro','entidads.id as idEnti','entidads.descripcion as entidad')
     ->paginate(30);

     $entidads=Entidad::where('borrado','0')->where('estado','1')->orderBy('descripcion')->get();
     $rubros=Rubro::where('borrado','0')->where('estado','1')->orderBy('descripcion')->get();

     return [
        'pagination'=>[
            'total'=> $precios->total(),
            'current_page'=> $precios->currentPage(),
            'per_page'=> $precios->perPage(),
            'last_page'=> $precios->lastPage(),
            'from'=> $precios->firstItem(),
            'to'=> $precios->lastItem(),
        ],
        'precios'=>$precios,
        'entidads'=>$entidads,
        'rubros'=>$rubros
    ];
    }


    public function buscarDatosImp(Request $request)
    {   
     $buscar=$request->busca;

     $precios = DB::table('precios')
     ->join('rubros', 'rubros.id', '=', 'precios.rubro_id')
     ->join('entidads', 'entidads.id', '=', 'precios.entidad_id')
     ->where('precios.borrado','0')
     ->where(function($query) use ($buscar){
        $query->where('precios.descripcion','like','%'.$buscar.'%');
        $query->orWhere('precios.codigo','like','%'.$buscar.'%');
        $query->orWhere('rubros.descripcion','like','%'.$buscar.'%');
        $query->orWhere('entidads.descripcion','like','%'.$buscar.'%');
        })
     ->orderBy('entidads.descripcion')
     ->orderBy('rubros.descripcion')
     ->orderBy('precios.descripcion')
     ->orderBy('precios.id')
     ->select('precios.id','precios.descripcion','precios.codigo','precios.estado','precios.monto','precios.borrado','precios.rubro_id','precios.entidad_id','rubros.id as idRub','rubros.descripcion as rubro','entidads.id as idEnti','entidads.descripcion as entidad')
     ->get();

     return [

        'dataimp'=>$precios
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
        $codigo=$request->codigo;
        $estado=$request->estado;
        $monto=$request->monto;
        $entidad_id=$request->entidad_id;
        $rubro_id=$request->rubro_id;



        $result='1';
        $msj='';
        $selector='';

        $input1  = array('descripcion' => $descripcion);
        $reglas1 = array('descripcion' => 'required');

        $input2  = array('descripcion' => $descripcion);
        $reglas2 = array('descripcion' => 'unique:precios,descripcion'.',1,borrado');

        $input3  = array('codigo' => $codigo);
        $reglas3 = array('codigo' => 'required');

        $input4  = array('codigo' => $codigo);
        $reglas4 = array('codigo' => 'unique:precios,codigo'.',1,borrado');

        $input5  = array('monto' => $monto);
        $reglas5 = array('monto' => 'required');

        $input6  = array('entidad_id' => $entidad_id);
        $reglas6 = array('entidad_id' => 'required');

        $input7  = array('rubro_id' => $rubro_id);
        $reglas7 = array('rubro_id' => 'required');


        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);
        $validator5 = Validator::make($input5, $reglas5);
        $validator6 = Validator::make($input6, $reglas6);
        $validator7 = Validator::make($input7, $reglas7);


        if ($validator1->fails())
        {
            $result='0';
            $msj='Complete la Descripción del Concepto de Pago';
            $selector='txtdesc';

        }elseif (1==2) {
            $result='0';
            $msj='El Concepto de Pago ingresado ya se encuentra registrado, por favor registre otra descripción';
            $selector='txtdesc';
        }
        elseif ($validator3->fails()) {
            $result='0';
            $msj='Complete el Código del Concepto de Pago';
            $selector='txtcod';
        }
        elseif ($validator4->fails()) {
            $result='0';
            $msj='El Código ingresado ya se encuentra registrado, por favor registre otro';
            $selector='txtcod';
        }
        elseif ($validator5->fails() || floatval($monto)==0) {
            $result='0';
            $msj='Complete el Monto del Concepto de Pago';
            $selector='txtmonto';
        }
        elseif ($validator6->fails()) {
            $result='0';
            $msj='Seleccione una Entidad Válida';
            $selector='cbsEntidad';
        }
        elseif ($validator7->fails()) {
            $result='0';
            $msj='Seleccione un Rubro Válido';
            $selector='cbsRubro';
        }
        else{

            $newPrecio = new Precio();
            $newPrecio->descripcion=$descripcion;
            $newPrecio->codigo=$codigo;
            $newPrecio->estado=$estado;
            $newPrecio->monto=$monto;
            $newPrecio->entidad_id=$entidad_id;
            $newPrecio->rubro_id=$rubro_id;
            $newPrecio->borrado='0';

            $newPrecio->save();

            $msj='Nuevo Concepto de Pago registrado con éxito';
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
        $codigo=$request->codigo;
        $estado=$request->estado;
        $monto=$request->monto;
        $entidad_id=$request->entidad_id;
        $rubro_id=$request->rubro_id;



        $result='1';
        $msj='';
        $selector='';

        $input1  = array('descripcion' => $descripcion);
        $reglas1 = array('descripcion' => 'required');

        $input2  = array('descripcion' => $descripcion);
        $reglas2 = array('descripcion' => 'unique:precios,descripcion,'.$id.',id,borrado,0');
        //$reglas4 = array('codigo' => 'unique:dependencias,cod_sis,'.$id.',id,borrado,0');

        $input3  = array('codigo' => $codigo);
        $reglas3 = array('codigo' => 'required');

        $input4  = array('codigo' => $codigo);
        $reglas4 = array('codigo' => 'unique:precios,codigo,'.$id.',id,borrado,0');
        //$reglas4 = array('codigo' => 'unique:dependencias,cod_sis,'.$id.',id,borrado,0');

        $input5  = array('monto' => $monto);
        $reglas5 = array('monto' => 'required');

        $input6  = array('entidad_id' => $entidad_id);
        $reglas6 = array('entidad_id' => 'required');

        $input7  = array('rubro_id' => $rubro_id);
        $reglas7 = array('rubro_id' => 'required');


        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);
        $validator5 = Validator::make($input5, $reglas5);
        $validator6 = Validator::make($input6, $reglas6);
        $validator7 = Validator::make($input7, $reglas7);


        if ($validator1->fails())
        {
            $result='0';
            $msj='Complete la Descripción del Concepto de Pago';
            $selector='txtdescE';

        }elseif (1==2) {
            $result='0';
            $msj='El Concepto de Pago ingresado ya se encuentra registrado, por favor registre otra descripción';
            $selector='txtdescE';
        }
        elseif ($validator3->fails()) {
            $result='0';
            $msj='Complete el Código del Concepto de Pago';
            $selector='txtcodE';
        }
        elseif ($validator4->fails()) {
            $result='0';
            $msj='El Código ingresado ya se encuentra registrado, por favor registre otro';
            $selector='txtcodE';
        }
        elseif ($validator5->fails() || floatval($monto)==0) {
            $result='0';
            $msj='Complete el Monto del Concepto de Pago';
            $selector='txtmontoE';
        }
        elseif ($validator6->fails()) {
            $result='0';
            $msj='Seleccione una Entidad Válida';
            $selector='cbsEntidadE';
        }
        elseif ($validator7->fails()) {
            $result='0';
            $msj='Seleccione un Rubro Válido';
            $selector='cbsRubroE';
        }
        else{

            $newPrecio =Precio::findOrFail($id);
            $newPrecio->descripcion=$descripcion;
            $newPrecio->codigo=$codigo;
            $newPrecio->estado=$estado;
            $newPrecio->monto=$monto;
            $newPrecio->entidad_id=$entidad_id;
            $newPrecio->rubro_id=$rubro_id;

            $newPrecio->save();

            $msj='Concepto de Pago registrada con éxito';
        }




       //Areaunasam::create($request->all());

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    public function altabaja($id,$estado)
    {
        $result='1';
        $msj='';
        $selector='';

        $update = Precio::findOrFail($id);
        $update->estado=$estado;
        $update->save();

        if(strval($estado)=="0"){
            $msj='El Concepto de Pago fue Desactivado exitosamente';
        }elseif(strval($estado)=="1"){
            $msj='El Concepto de Pago fue Activado exitosamente';
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

        $consulta1=DB::table('detalle_recibos')
                    ->join('precios', 'detalle_recibos.precio_id', '=', 'precios.id')
                    ->where('precios.id',$id)->count();



        if($consulta1>0) {
            $result='0';
            $msj='El Concepto de Pago no se puede eliminar puesto que ya cuenta con registros de pagos realizados';
        }else{
        
        $borrar = Precio::findOrFail($id);
        //$task->delete();

        $borrar->borrado='1';

        $borrar->save();

        $msj='Concepto de Pago eliminado exitosamente';
     }

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
