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

class Detalle_reciboController extends Controller
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


            $modulo="recibosemitidos";
            return view('recibosemitidos.index',compact('tipouser','modulo'));
        }
        else
        {
            return redirect('home');            
        }
    }


    public function index(Request $request)
    {   
     $buscar=$request->busca;

     $year=Date('Y');
     $mes=Date('m');
     $fecha=Date('Y/m/d');

     $recibos = DB::table('recibos')
     ->join('personas', 'personas.id', '=', 'recibos.persona_id')
     ->where('recibos.borrado','0')
     ->where('recibos.estado','>','1')
     ->where('recibos.fecha',$fecha)
     ->where(function($query) use ($buscar){
        $query->where('recibos.codigo','like','%'.$buscar.'%');
        $query->orWhere('recibos.secuencia','like','%'.$buscar.'%');
        $query->orWhere('recibos.fecha','like','%'.$buscar.'%');
        $query->orWhere('personas.dni_ruc','like','%'.$buscar.'%');
        $query->orWhere('personas.nombre','like','%'.$buscar.'%');
        })
     ->orderBy('recibos.fecha')
     ->orderBy('recibos.hora_pagada')
     ->select('recibos.id','recibos.efectivo','recibos.vuelto','recibos.extorno','recibos.secuencia','recibos.codigo','recibos.fecha','recibos.hora_pagada','recibos.estado','recibos.fecha_usado','recibos.hora_usada','recibos.tipopago_id','recibos.year','recibos.mes','recibos.borrado','recibos.total','recibos.fechaextorno','recibos.horaextorno','personas.id as idper','personas.nombre as persona','personas.dni_ruc')
     ->paginate(50);


     return [
        'pagination'=>[
            'total'=> $recibos->total(),
            'current_page'=> $recibos->currentPage(),
            'per_page'=> $recibos->perPage(),
            'last_page'=> $recibos->lastPage(),
            'from'=> $recibos->firstItem(),
            'to'=> $recibos->lastItem(),
        ],
        'recibos'=>$recibos,
        'year'=>$year,
        'mes'=>$mes,
        'fecha'=>$fecha
    ];
    }

    public function buscarrecibo(Request $request)
    {
        $idimp=$request->idimp;


        $detallerecibo = DB::table('detalle_recibos')
     ->where('detalle_recibos.recibo_id',$idimp)

     ->select('detalle_recibos.concepto','detalle_recibos.precioUnitario as precioU','detalle_recibos.cantidad as cant','detalle_recibos.precioTotal as precioT')
     ->get();

    return [ 
        'detallerecibo'=>$detallerecibo
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
        //
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

    public function altabaja($id,$estado)
    {
        $result='1';
        $msj='';
        $selector='';


        $fecha="";
        $hora="";
        $proceso="";
        if(strval($estado)=="3"){
            $hora=Date('H:i:s');
            $fecha=Date('Y/m/d');
            $proceso="Extorno de Recibo";
        }elseif(strval($estado)=="2"){
            $hora=Date('H:i:s');
            $fecha=Date('Y/m/d');
            $proceso="Cancelado Extorno de Recibo";
        }

        $newAuditoria=new Recibo_proceso();
        $newAuditoria->fecha=$fecha;
        $newAuditoria->hora=$hora;
        $newAuditoria->accion=$proceso;
        $newAuditoria->user_id=Auth::user()->id;
        $newAuditoria->recibo_id=$id;
        $newAuditoria->save();




        $update = Recibo::findOrFail($id);
        $update->estado=$estado;
        $update->user_id=Auth::user()->id;
        $update->save();

        if(strval($estado)=="3"){
            $msj='El Recibo fue Extornado exitosamente';
        }elseif(strval($estado)=="2"){
            $msj='Se anuló el Extorno del Recibo exitosamente';
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
                    ->join('recibos', 'detalle_recibos.recibo_id', '=', 'recibos.id')
                    ->where('recibos.id',$id)
                    ->where('detalle_recibos.estado','2')
                    ->count();


        if($consulta1>0) {
            $result='0';
            $msj='El Recibo Seleccionado no se puede eliminar debido a que ya ha sido aceptado y utilizado en algún trámite';
        }else{
            $hora=Date('H:i:s');
            $fecha=Date('Y/m/d');

            $newAuditoria=new Recibo_proceso();
        $newAuditoria->fecha=$fecha;
        $newAuditoria->hora=$hora;
        $newAuditoria->accion="Recibo Borrado";
        $newAuditoria->user_id=Auth::user()->id;
        $newAuditoria->recibo_id=$id;
        $newAuditoria->save();



        
        $borrar = Recibo::findOrFail($id);
        //$task->delete();

        $borrar->borrado='1';

        $borrar->save();

        $msj='Recibo eliminado exitosamente';
     }

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
