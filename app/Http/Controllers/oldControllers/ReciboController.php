<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;
use App\Tipopago;
use App\Deposito;
use App\Rubro;
use App\Precio;
use App\Entidad;
use App\Recibo;
use App\Detalle_recibo;
use App\Recibo_proceso;

use Validator;
use Auth;
use DB;

use App\Tipouser;
use App\User;

class ReciboController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index1()
    {
        if(accesoUser([1,2,3])){


            $idtipouser=Auth::user()->tipouser_id;
            $tipouser=Tipouser::find($idtipouser);


            $modulo="recibo";
            return view('recibo.index',compact('tipouser','modulo'));
        }
        else
        {
            return redirect('home');          
        }
    }


    public function index2()
    {
        if(accesoUser([1,2,4])){


            $idtipouser=Auth::user()->tipouser_id;
            $tipouser=Tipouser::find($idtipouser);


            $modulo="procesar";
            return view('procesar.index',compact('tipouser','modulo'));
        }
        else
        {
            return redirect('home');          
        }
    }

    public function indexAudi()
    {
        if(accesoUser([1])){


            $idtipouser=Auth::user()->tipouser_id;
            $tipouser=Tipouser::find($idtipouser);


            $modulo="auditarrecibo";
            return view('auditarrecibo.index',compact('tipouser','modulo'));
        }
        else
        {
            return redirect('home');          
        }
    }

    public function index(Request $request)
    {
        $precios=Precio::where('borrado','0')->where('estado','1')->orderBy('codigo')->get();

        $year=Date('Y');
        $mes=Date('m');
        $fecha=Date('Y/m/d');

        $numgen=1;

        $recibo=Recibo::where('user_id',Auth::user()->id)->where('estado',1)->where('year',$year)->where('borrado','0')->first();
        $cantrecibos=Recibo::where('user_id',Auth::user()->id)->where('estado',1)->where('year',$year)->where('borrado','0')->count();

        if($cantrecibos>0)
        {
            $numgen=floatval($recibo->secuencia);
        }
        else{
            $reciboZ=Recibo::where('borrado','0')->where('year',$year)->latest()->first();
            $cantrecibosnum=Recibo::where('borrado','0')->where('year',$year)->count();

            if($cantrecibosnum>0){
                $numgenZ=floatval($reciboZ->secuencia);
                $numgen=$numgenZ+1;
            }


            $newRecibo = new Recibo();
            $newRecibo->efectivo=0;
            $newRecibo->vuelto=0;
            $newRecibo->extorno='0';
            $newRecibo->secuencia=$numgen;
            $newRecibo->codigo=$year.'-'.str_pad($numgen, 8, "0", STR_PAD_LEFT);
            $newRecibo->estado='1';
            $newRecibo->user_id=Auth::user()->id;
            $newRecibo->tipopago_id='1';
            $newRecibo->year=$year;
            $newRecibo->mes=$mes;
            $newRecibo->borrado='0';

            $newRecibo->save();



        }

        $numgen=str_pad($numgen, 8, "0", STR_PAD_LEFT);

        return [
            'precios'=>$precios,
            'year'=>$year,
            'fecha'=>$fecha,
            'numgen'=>$numgen,
        ];

    }

    public function buscarpersona(Request $request)
    {
        $dni_ruc=$request->dni_ruc;

        $persona=Persona::where('dni_ruc',$dni_ruc)->where('activo','1')->where('borrado','0')->get();
        $numPer=Persona::where('dni_ruc',$dni_ruc)->where('activo','1')->where('borrado','0')->count();

        return [
            'persona'=>$persona,
            'numPer'=>$numPer
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
        $detallerecibo=$request->detallerecibo;
        $dni_ruc=$request->dni;
        $nombre=$request->nombre;
        $totalP=$request->totalP;


        $idRecibo=0;

        $year=Date('Y');
        $mes=Date('m');
        $hora=Date('H:i:s');
        $fecha=Date('Y/m/d');


       // var_dump($detallerecibo);

        $persona=Persona::where('dni_ruc',$dni_ruc)->where('activo','1')->where('borrado','0')->first();
        $numPer=Persona::where('dni_ruc',$dni_ruc)->where('activo','1')->where('borrado','0')->count();

        if($numPer==0){

            $persona= new Persona();
            $persona->nombre=$nombre;
            $persona->dni_ruc=$dni_ruc;
            $persona->codigo_alumno='';
            $persona->direccion='';
            $persona->activo='1';
            $persona->borrado='0';
            $persona->tipopersona_id='1';

            $persona->save();
        }



        $result='1';
        $msj='';
        $selector='';

        $input1  = array('dni_ruc' => $dni_ruc);
        $reglas1 = array('dni_ruc' => 'required');

        $input2 = array('nombre' => $nombre);
        $reglas2 = array('nombre' => 'required');



        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);

        if ($validator1->fails())
        {
            $result='0';
            $msj='Complete el DNI de la persona';
            $selector='dni_ruc';

        }elseif (1==2) {
            $result='0';
            $msj='Complete el nombre de la persona';
            $selector='txtdir';
        }
        else{


            
    
            $numgen=1;
    
            $recibo=Recibo::where('user_id',Auth::user()->id)->where('estado',1)->where('year',$year)->where('borrado','0')->first();
            $cantrecibos=Recibo::where('user_id',Auth::user()->id)->where('estado',1)->where('year',$year)->where('borrado','0')->count();
            $idRecibo=$recibo->id;

            if($cantrecibos>0){



            $recibo->efectivo=$totalP;
            $recibo->vuelto=0;
            $recibo->extorno='0';
            $recibo->fecha=$fecha;
            $recibo->hora_pagada=$hora;
            $recibo->persona_id=$persona->id;
            $recibo->estado='2';
            $recibo->user_id=Auth::user()->id;
            $recibo->tipopago_id='1';
            $recibo->year=$year;
            $recibo->mes=$mes;
            $recibo->borrado='0';
            $recibo->total=0;

            $recibo->save();

            

            $msj='Nuevo Recibo registrado con éxito';

            }
            else{


            $reciboZ=Recibo::where('borrado','0')->where('year',$year)->latest()->first();
            $cantrecibosnum=Recibo::where('borrado','0')->where('year',$year)->count();

            if($cantrecibosnum>0){
                $numgenZ=floatval($reciboZ->secuencia);
                $numgen=$numgenZ+1;
            }

            $recibo = new Recibo();
            $recibo->efectivo=$totalP;
            $recibo->vuelto=0;
            $recibo->extorno='0';
            $recibo->secuencia=$numgen;
            $recibo->codigo=$year.'-'.str_pad($numgen, 8, "0", STR_PAD_LEFT);
            $recibo->fecha=$fecha;
            $recibo->hora_pagada=$hora;
            $recibo->persona_id=$persona->id;
            $recibo->estado='2';
            $recibo->user_id=Auth::user()->id;
            $recibo->tipopago_id='1';
            $recibo->year=$year;
            $recibo->mes=$mes;
            $recibo->borrado='0';
            $recibo->total=0;

            $recibo->save();

            $idRecibo=$recibo->id;

            $msj='Nuevo Recibo registrado con éxito';

        }


        $totalactualizar=0;

        foreach ($detallerecibo as $key => $dato) {


            $totalactualizar=$totalactualizar+floatval($dato["precioT"]);
            
            $detallerecibo = new Detalle_recibo();
            $detallerecibo->precio_id=$dato["valuep"];
            $detallerecibo->recibo_id=$recibo->id;
            $detallerecibo->cantidad=$dato["cant"];
            $detallerecibo->precioUnitario=$dato["precioU"];
            $detallerecibo->precioTotal=$dato["precioT"];
            $detallerecibo->fecha_pagada=$fecha;
            $detallerecibo->hora_pagada=$hora;
            $detallerecibo->estado='1';
            $detallerecibo->concepto=$dato["concepto"];

            $detallerecibo->save();

        }

        $vueltoactualizar=floatval($totalP)-$totalactualizar;


            $recibo->efectivo=$totalP;
            $recibo->vuelto=$vueltoactualizar;
            $recibo->total=$totalactualizar;

            $recibo->save();


        $newAuditoria=new Recibo_proceso();
        $newAuditoria->fecha=$fecha;
        $newAuditoria->hora=$hora;
        $newAuditoria->accion="Generación de Recibo";
        $newAuditoria->user_id=Auth::user()->id;
        $newAuditoria->recibo_id=$recibo->id;
        $newAuditoria->save();


        }




       //Areaunasam::create($request->all());

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }



    public function auditarrecibo(Request $request)
    {
        $codRbo=$request->codRbo;
        


        $result='1';
        $msj='';
        $selector='';

        $input1  = array('codRbo' => $codRbo);
        $reglas1 = array('codRbo' => 'required');

        $validator1 = Validator::make($input1, $reglas1);


        $recibo="";
        $persona="";
        $cajero="";

        $procesosRecibo="";
        $detalleRecibos="";
        $detalleProcesos="";


        if ($validator1->fails())
        {
            $result='0';
            $msj='Complete el código del Recibo';
            $selector='codRecibo';

        }
        else{

            $recibo=Recibo::where('codigo',$codRbo)->first();
            $cont=Recibo::where('codigo',$codRbo)->count();

            if($cont==0)
            {
                $result='0';
                $msj='El Código Ingresado no Corresponde a ningún recibo, Recibo No Encontrado';
                $selector='codRecibo';
            }
            else {

                
                $cliente=Persona::where('id',$recibo->persona_id)->first();

                $procesosRecibo = DB::table('recibo_procesos')
     ->join('users', 'users.id', '=', 'recibo_procesos.user_id')
     ->join('personas', 'personas.id', '=', 'users.persona_id')
     ->join('tipousers', 'tipousers.id', '=', 'users.tipouser_id')

     ->where('recibo_procesos.recibo_id',$recibo->id)
     ->orderBy('recibo_procesos.id')
     ->select('recibo_procesos.fecha','recibo_procesos.hora','recibo_procesos.accion','personas.nombre','personas.dni_ruc','users.name','tipousers.tipo')
     ->get();


     $detalleRecibos = DB::table('detalle_recibos')
     ->join('precios', 'precios.id', '=', 'detalle_recibos.precio_id')
     ->join('entidads', 'entidads.id', '=', 'precios.entidad_id')
     ->leftjoin('detalle_procesos', 'detalle_recibos.id', '=', 'detalle_procesos.detalle_recibo_id')

     ->join('rubros', 'rubros.id', '=', 'precios.rubro_id')
     ->join('categorias', 'categorias.id', '=', 'rubros.categoria_id')

     ->where('detalle_recibos.recibo_id',$recibo->id)
     ->groupBy('detalle_recibos.id')
     ->orderBy('detalle_recibos.id')
     ->select('detalle_recibos.id','detalle_recibos.cantidad','detalle_recibos.precioUnitario','detalle_recibos.precioTotal','detalle_recibos.fecha_pagada','detalle_recibos.hora_pagada','detalle_recibos.fecha_usado','detalle_recibos.hora_usado','detalle_recibos.estado','detalle_recibos.concepto','entidads.descripcion as entidad','rubros.descripcion as rubro','categorias.descripcion as categoria', DB::Raw('count( `detalle_procesos`.`id`) as contProcesos'))
     ->get();


     $detalleProcesos = DB::table('detalle_procesos')
     ->join('detalle_recibos', 'detalle_recibos.id', '=', 'detalle_procesos.detalle_recibo_id')
     ->join('users', 'users.id', '=', 'detalle_procesos.user_id')
     ->join('personas', 'personas.id', '=', 'users.persona_id')
     ->join('tipousers', 'tipousers.id', '=', 'users.tipouser_id')

     ->where('detalle_recibos.recibo_id',$recibo->id)
     ->orderBy('detalle_procesos.id')
     ->select('detalle_recibos.id','detalle_procesos.id as idprocesos','detalle_procesos.fecha','detalle_procesos.hora','detalle_procesos.accion','users.name','personas.nombre','tipousers.tipo')->get();

                $msj='Recibo Encontrado, Datos Procesados '.$cont;
            }

            
        }




       //Areaunasam::create($request->all());

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector,'recibo'=>$recibo,'cliente'=>$cliente,'procesosRecibo'=>$procesosRecibo,'detalleRecibos'=>$detalleRecibos,'detalleProcesos'=>$detalleProcesos]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
