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
use App\Local;
use App\Categoria;

use Validator;
use Auth;
use DB;

use App\Tipouser;
use App\User;


class ReporteDetalladoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index1()
    {
        if(accesoUser([1,2,5])){


            $idtipouser=Auth::user()->tipouser_id;
            $tipouser=Tipouser::find($idtipouser);


            $modulo="reportedetallado";
            return view('reportedetallado.index',compact('tipouser','modulo'));
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


            $modulo="recibosprocesados";
            return view('recibosprocesados.index',compact('tipouser','modulo'));
        }
        else
        {
            return redirect('home');          
        }
    }


    public function index(Request $request)
    {   


     $year=Date('Y');
     $fecha=Date('Y/m/d');
     $fecha0=Date('Y-m-d');

     $mes=intval(Date('m'));
     $anio=intval(Date('Y'));

     $years=Recibo::groupBy('year')->orderBy('year')->get();

     $cajeros=DB::table('personas')
     ->join('users', 'personas.id', '=', 'users.persona_id')
     ->join('tipousers', 'tipousers.id', '=', 'users.tipouser_id')
     ->where('users.borrado','0')
     ->where('tipousers.id','<=','3')
     ->orderBy('personas.nombre')
     ->orderBy('users.name')
     ->select('users.id','users.name','users.email','personas.id as idpersona','personas.nombre','personas.dni_ruc')
     ->get();


     $locals=Local::where('borrado','0')->get();

     $categorias=Categoria::where('borrado','0')->get();




     return [
  
        'year'=>$year,
        'fecha'=>$fecha,
        'fecha0'=>$fecha0,
        'mes'=>$mes,
        'years'=>$years,
        'anio'=>$anio,
        'cajeros'=>$cajeros,
        'locals'=>$locals,
        'categorias'=>$categorias
    ];
    }


    public function cambiarlocal($idD){

    $entidads=Entidad::where('borrado','0')->where('local_id',$idD)->get();
   
           return [
               'entidads'=>$entidads
           ];
   
       }

    public function cambiarcategoria($idD){

        $rubros=Rubro::where('borrado','0')->where('categoria_id',$idD)->get();
       
               return [
                   'rubros'=>$rubros
               ];
       
            }

    public function cambiarrubro($idD){

        $precios=Precio::where('borrado','0')->where('rubro_id',$idD)->get();
       
               return [
                   'precios'=>$precios
               ];
       
            }

            public function buscarDatos(Request $request)
            {
                $cbufec=$request->cbufec;
                $fechai=$request->fechai;
                $fechaf=$request->fechaf;
                $anio=$request->anio;
                $mes=$request->mes;
                $fecha0=$request->fecha0;
                $tipo=$request->tipo;
                $cajero=$request->cajero;
                $idpersona=$request->idpersona;

                $local=$request->local;
                $categoria=$request->categoria;

                $entidad=$request->entidad;
                $rubro=$request->rubro;
                $precio=$request->precio;
        
                $buscar="";
                
                
        
                $query = DB::table('recibos')
                ->join('personas as personas', 'personas.id', '=', 'recibos.persona_id')
                ->join('users', 'users.id', '=', 'recibos.user_id')
                ->join('personas as puser', 'puser.id', '=', 'users.persona_id')

                ->join('detalle_recibos', 'recibos.id', '=', 'detalle_recibos.recibo_id')

                ->join('precios', 'precios.id', '=', 'detalle_recibos.precio_id')
                ->join('rubros', 'rubros.id', '=', 'precios.rubro_id')
                ->join('categorias', 'categorias.id', '=', 'rubros.categoria_id')

                ->join('entidads', 'entidads.id', '=', 'precios.entidad_id')
                ->join('locals', 'locals.id', '=', 'entidads.local_id')


                ->where('recibos.borrado','0')
                ->where('recibos.estado','>','1')        
                
                ->where(function($query0) use ($buscar){
                   $query0->where('recibos.codigo','like','%'.$buscar.'%');
                   $query0->orWhere('recibos.secuencia','like','%'.$buscar.'%');
                   $query0->orWhere('recibos.fecha','like','%'.$buscar.'%');
                   $query0->orWhere('personas.dni_ruc','like','%'.$buscar.'%');
                   $query0->orWhere('personas.nombre','like','%'.$buscar.'%');
                   })
                ->orderBy('recibos.fecha')
                ->orderBy('recibos.hora_pagada')
                ->select('recibos.id','recibos.efectivo','recibos.vuelto','recibos.extorno','recibos.secuencia','recibos.codigo','recibos.fecha','recibos.hora_pagada','recibos.estado','recibos.fecha_usado','recibos.hora_usada','recibos.tipopago_id','recibos.year','recibos.borrado','recibos.total','recibos.fechaextorno','recibos.horaextorno','personas.id as idper','personas.nombre as persona','personas.dni_ruc', 'puser.nombre as nomcajero', 'detalle_recibos.id as iddetalle','detalle_recibos.cantidad','detalle_recibos.precioUnitario','detalle_recibos.precioTotal','detalle_recibos.fecha_pagada','detalle_recibos.hora_pagada as horadetallepagada','detalle_recibos.fecha_usado as fechausadodetalle','detalle_recibos.hora_usado as horausadodetalle','detalle_recibos.estado as estadodetalle','detalle_recibos.concepto','precios.id as idprecio','precios.descripcion as preciodes','precios.codigo as codeprecio','precios.estado as estadoprecio','precios.monto as montoprecio','rubros.id as idrubro','rubros.descripcion as rubro','rubros.code as coderubro','rubros.estado as estadorubro','categorias.id as idcat','categorias.descripcion as categoria','categorias.code as codecat','entidads.id as entidadid','entidads.descripcion as entidad','entidads.code as codeentidad','locals.id as idlocal','locals.nombre as local','locals.direccion as direclocal');
        
                if(intval($cbufec)==0){
                    $query->where('recibos.fecha',$fecha0);
                }elseif(intval($cbufec)==1){
                    $query->where('recibos.year',$anio)->where('recibos.mes',$mes);
                }elseif(intval($cbufec)==2){
                    $query->where('recibos.year',$anio);
                }elseif(intval($cbufec)==3){
                    $query->where('recibos.fecha','>=',$fechai)->where('recibos.fecha','<=',$fechaf);
                }
        
        
                if(intval($tipo)==1){
                    $query->where('recibos.estado',2);
                }elseif(intval($tipo)==2){
                    $query->where('recibos.estado',3);
                }
        
                if(intval($cajero)>0){
                    $query->where('recibos.user_id',$cajero);
                }
        
                if(strlen($idpersona)>0){
                    $query->where('recibos.persona_id',$idpersona);
                }

                if(intval($local)>0){
                    $query->where('locals.id',$local);

                    if(intval($entidad)>0){
                        $query->where('entidads.id',$entidad);
                    }
                }


                if(intval($categoria)>0){
                    $query->where('categorias.id',$categoria);

                    if(intval($rubro)>0){
                        $query->where('rubros.id',$rubro);

                        if(intval($precio)>0){
                            $query->where('precios.id',$precio);
                        }
                    }
                }
        
                
                $recibos=$query->paginate(50);
        
        
                $datosrecibos=$query->get();
        
                $totalcobrado=0;
                $totalextornado=0;
                $numcobrados=0;
                $numextornados=0;
        
                foreach ($datosrecibos as $key => $value) {
        
                    if(intval($value->estado)==2)
                    {
                    $totalcobrado=$totalcobrado+$value->precioTotal;
                    $numcobrados++;
                    }elseif(intval($value->estado)==3)
                    {
                    $totalextornado=$totalextornado+$value->precioTotal;
                    $numextornados++;
                    }
                }
        
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
                    'totalcobrado'=>$totalcobrado,
                    'totalextornado'=>$totalextornado,
                    'numcobrados'=>$numcobrados,
                    'numextornados'=>$numextornados
                ];
        
                //return ['recibos'=>$recibos];
        
        
            }



            public function buscarDatosImp(Request $request)
            {
                $cbufec=$request->cbufec;
                $fechai=$request->fechai;
                $fechaf=$request->fechaf;
                $anio=$request->anio;
                $mes=$request->mes;
                $fecha0=$request->fecha0;
                $tipo=$request->tipo;
                $cajero=$request->cajero;
                $idpersona=$request->idpersona;

                $local=$request->local;
                $categoria=$request->categoria;

                $entidad=$request->entidad;
                $rubro=$request->rubro;
                $precio=$request->precio;
        
                $buscar="";
                
                
        
                $query = DB::table('recibos')
                ->join('personas as personas', 'personas.id', '=', 'recibos.persona_id')
                ->join('users', 'users.id', '=', 'recibos.user_id')
                ->join('personas as puser', 'puser.id', '=', 'users.persona_id')

                ->join('detalle_recibos', 'recibos.id', '=', 'detalle_recibos.recibo_id')

                ->join('precios', 'precios.id', '=', 'detalle_recibos.precio_id')
                ->join('rubros', 'rubros.id', '=', 'precios.rubro_id')
                ->join('categorias', 'categorias.id', '=', 'rubros.categoria_id')

                ->join('entidads', 'entidads.id', '=', 'precios.entidad_id')
                ->join('locals', 'locals.id', '=', 'entidads.local_id')


                ->where('recibos.borrado','0')
                ->where('recibos.estado','>','1')        
                
                ->where(function($query0) use ($buscar){
                   $query0->where('recibos.codigo','like','%'.$buscar.'%');
                   $query0->orWhere('recibos.secuencia','like','%'.$buscar.'%');
                   $query0->orWhere('recibos.fecha','like','%'.$buscar.'%');
                   $query0->orWhere('personas.dni_ruc','like','%'.$buscar.'%');
                   $query0->orWhere('personas.nombre','like','%'.$buscar.'%');
                   })
                ->orderBy('recibos.fecha')
                ->orderBy('recibos.hora_pagada')
                ->select('recibos.id','recibos.efectivo','recibos.vuelto','recibos.extorno','recibos.secuencia','recibos.codigo','recibos.fecha','recibos.hora_pagada','recibos.estado','recibos.fecha_usado','recibos.hora_usada','recibos.tipopago_id','recibos.year','recibos.borrado','recibos.total','recibos.fechaextorno','recibos.horaextorno','personas.id as idper','personas.nombre as persona','personas.dni_ruc', 'puser.nombre as nomcajero', 'detalle_recibos.id as iddetalle','detalle_recibos.cantidad','detalle_recibos.precioUnitario','detalle_recibos.precioTotal','detalle_recibos.fecha_pagada','detalle_recibos.hora_pagada as horadetallepagada','detalle_recibos.fecha_usado as fechausadodetalle','detalle_recibos.hora_usado as horausadodetalle','detalle_recibos.estado as estadodetalle','detalle_recibos.concepto','precios.id as idprecio','precios.descripcion as preciodes','precios.codigo as codeprecio','precios.estado as estadoprecio','precios.monto as montoprecio','rubros.id as idrubro','rubros.descripcion as rubro','rubros.code as coderubro','rubros.estado as estadorubro','categorias.id as idcat','categorias.descripcion as categoria','categorias.code as codecat','entidads.id as entidadid','entidads.descripcion as entidad','entidads.code as codeentidad','locals.id as idlocal','locals.nombre as local','locals.direccion as direclocal');
        
                if(intval($cbufec)==0){
                    $query->where('recibos.fecha',$fecha0);
                }elseif(intval($cbufec)==1){
                    $query->where('recibos.year',$anio)->where('recibos.mes',$mes);
                }elseif(intval($cbufec)==2){
                    $query->where('recibos.year',$anio);
                }elseif(intval($cbufec)==3){
                    $query->where('recibos.fecha','>=',$fechai)->where('recibos.fecha','<=',$fechaf);
                }
        
        
                if(intval($tipo)==1){
                    $query->where('recibos.estado',2);
                }elseif(intval($tipo)==2){
                    $query->where('recibos.estado',3);
                }
        
                if(intval($cajero)>0){
                    $query->where('recibos.user_id',$cajero);
                }
        
                if(strlen($idpersona)>0){
                    $query->where('recibos.persona_id',$idpersona);
                }

                if(intval($local)>0){
                    $query->where('locals.id',$local);

                    if(intval($entidad)>0){
                        $query->where('entidads.id',$entidad);
                    }
                }


                if(intval($categoria)>0){
                    $query->where('categorias.id',$categoria);

                    if(intval($rubro)>0){
                        $query->where('rubros.id',$rubro);

                        if(intval($precio)>0){
                            $query->where('precios.id',$precio);
                        }
                    }
                }
        
                
                $recibos=$query->paginate(50);
        
        
                $datosrecibos=$query->get();
        
                $totalcobrado=0;
                $totalextornado=0;
                $numcobrados=0;
                $numextornados=0;
        
                foreach ($datosrecibos as $key => $value) {
        
                    if(intval($value->estado)==2)
                    {
                    $totalcobrado=$totalcobrado+$value->precioTotal;
                    $numcobrados++;
                    }elseif(intval($value->estado)==3)
                    {
                    $totalextornado=$totalextornado+$value->precioTotal;
                    $numextornados++;
                    }
                }
        
                return [

                    'recibosimp'=>$datosrecibos
                ];
        
                //return ['recibos'=>$recibos];
        
        
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
