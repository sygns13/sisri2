<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Local;
use Validator;
use Auth;
use DB;

use App\Persona;
use App\Tipouser;
use App\User;
use App\Paise;
use App\Departamento;
use App\Provincia;
use App\Distrito;

use App\Permisomodulo;
use App\Permisossubmodulo;

use Excel;
set_time_limit(600);

class LocalController extends Controller
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

            $permisoModulos=Permisomodulo::where('user_id',Auth::user()->id)->get();
            $permisoSubModulos=Permisossubmodulo::where('user_id',Auth::user()->id)->get();


            $modulo="local";
            return view('local.index',compact('tipouser','modulo','permisoModulos','permisoSubModulos'));
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


            $modulo="replocales";
            return view('replocales.index',compact('tipouser','modulo'));
        }
        else
        {
            return redirect('home');           
        }
    }


    public function index(Request $request)
    {   
     $buscar=$request->busca;

     $locals = DB::table('locals')
     ->join('distritos', 'distritos.id', '=', 'locals.distrito_id')
     ->join('provincias', 'provincias.id', '=', 'distritos.provincia_id')
     ->join('departamentos', 'departamentos.id', '=', 'provincias.departamento_id')
     ->join('paises', 'paises.id', '=', 'departamentos.paise_id')


     ->where('locals.borrado','0')
     ->where(function($query) use ($buscar){
        $query->where('locals.nombre','like','%'.$buscar.'%');
        $query->orWhere('distritos.nombre','like','%'.$buscar.'%');
        $query->orWhere('provincias.nombre','like','%'.$buscar.'%');
        $query->orWhere('departamentos.nombre','like','%'.$buscar.'%');
        $query->orWhere('paises.nombre','like','%'.$buscar.'%');
        })
     ->orderBy('nombre')
     ->select('locals.id','locals.nombre','locals.direccion','locals.activo','locals.borrado','locals.distrito_id','distritos.nombre as distrito','provincias.nombre as provincia','departamentos.nombre as departamento','paises.nombre as pais' , 'distritos.id as idDis','provincias.id as idProv','departamentos.id as idDep','paises.id as idPa')
     ->paginate(30);

     return [
        'pagination'=>[
            'total'=> $locals->total(),
            'current_page'=> $locals->currentPage(),
            'per_page'=> $locals->perPage(),
            'last_page'=> $locals->lastPage(),
            'from'=> $locals->firstItem(),
            'to'=> $locals->lastItem(),
        ],
        'locals'=>$locals
    ];
    }


    public function cambiarPais($id)
    {
        $departamentos=Departamento::where('activo','1')->where('borrado','0')->where('paise_id',$id)->orderBy('nombre')->get();

        return [
            'departamentos'=>$departamentos
        ];
    }
    public function cambiarDepartamento($id)
    {
        $provincias=Provincia::where('activo','1')->where('borrado','0')->where('departamento_id',$id)->orderBy('nombre')->get();

        return [
            'provincias'=>$provincias
        ];
    }
    public function cambiarProvincia($id)
    {
        $distritos=Distrito::where('activo','1')->where('borrado','0')->where('provincia_id',$id)->orderBy('nombre')->get();

        return [
            'distritos'=>$distritos
        ];
    }


    public function buscarDatosImp(Request $request)
    {   
     $buscar=$request->busca;

     $locals = DB::table('locals')
     ->join('distritos', 'distritos.id', '=', 'locals.distrito_id')
     ->join('provincias', 'provincias.id', '=', 'distritos.provincia_id')
     ->join('paises', 'paises.id', '=', 'provincias.paise_id')


     ->where('locals.borrado','0')
     ->where(function($query) use ($buscar){
        $query->where('locals.nombre','like','%'.$buscar.'%');
        $query->orWhere('distritos.nombre','like','%'.$buscar.'%');
        $query->orWhere('provincias.nombre','like','%'.$buscar.'%');
        $query->orWhere('paises.nombre','like','%'.$buscar.'%');
        })
     ->orderBy('nombre')
     ->select('locals.id','locals.nombre','locals.direccion','locals.activo','locals.borrado','locals.distrito_id','distritos.nombre as distrito','provincias.nombre as provincia','paises.nombre as pais')
     ->get();

    

     return [
        'dataimp'=>$locals
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
        $direccion=$request->direccion;
        $estado=$request->estado;
        $distrito_id=$request->distrito_id;



        $result='1';
        $msj='';
        $selector='';

        $input1  = array('nombre' => $nombre);
        $reglas1 = array('nombre' => 'required');

        $input2 = array('direccion' => $direccion);
        $reglas2 = array('direccion' => 'required');

        $input3 = array('distrito_id' => $distrito_id);
        $reglas3 = array('distrito_id' => 'required');



        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);

        if ($validator1->fails())
        {
            $result='0';
            $msj='Complete el nombre del local';
            $selector='txtnom';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='Complete la dirección del local';
            $selector='txtdir';
        }
        elseif ($validator3->fails() || intval($distrito_id)<1) {
            $result='0';
            $msj='Seleccione un Distrito Válido';
            $selector='cbuDistrito';
        }
        else{

            $newLocal = new Local();
            $newLocal->nombre=$nombre;
            $newLocal->direccion=$direccion;
            $newLocal->activo=$estado;
            $newLocal->borrado='0';
            $newLocal->distrito_id=$distrito_id;

            $newLocal->save();

            $msj='Nuevo Local registrado con éxito';
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
        $direccion=$request->direccion;
        $estado=$request->activo;

        $distrito_id=$request->distrito_id;



        $result='1';
        $msj='';
        $selector='';

        $input1  = array('nombre' => $nombre);
        $reglas1 = array('nombre' => 'required');

        $input2 = array('direccion' => $direccion);
        $reglas2 = array('direccion' => 'required');

        $input3 = array('distrito_id' => $distrito_id);
        $reglas3 = array('distrito_id' => 'required');



        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);

        if ($validator1->fails())
        {
            $result='0';
            $msj='Complete el nombre del local';
            $selector='txtnomE';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='Complete la dirección del local';
            $selector='txtdirE';
        }
        elseif ($validator3->fails() || intval($distrito_id)<1) {
            $result='0';
            $msj='Seleccione un Distrito Válido';
            $selector='cbuDistritoE';
        }
        else{

            $editLocal = Local::findOrFail($id);
            $editLocal->nombre=$nombre;
            $editLocal->direccion=$direccion;
            $editLocal->activo=$estado;
            $editLocal->distrito_id=$distrito_id;

            $editLocal->save();

            $msj='El Local ha sido modificado con éxito';
        }




       //Areaunasam::create($request->all());

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function altabaja($id,$estado)
    {
        $result='1';
        $msj='';
        $selector='';

        $update = Local::findOrFail($id);
        $update->activo=$estado;
        $update->save();

        if(strval($estado)=="0"){
            $msj='El Local fue Desactivado exitosamente';
        }elseif(strval($estado)=="1"){
            $msj='El Local fue Activado exitosamente';
        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);

    }


    public function destroy($id)
    {
        $result='1';
        $msj='1';

        $consulta1=DB::table('facultads')
                    ->join('locals', 'facultads.local_id', '=', 'locals.id')
                    ->where('facultads.borrado','0')
                    ->where('locals.id',$id)->count();

       /*  $consulta2=DB::table('entidads')
        ->join('locals', 'entidads.local_id', '=', 'locals.id')
        ->where('entidads.borrado','0')
        ->where('locals.id',$id)->count(); */

        if($consulta1>0) {
            $result='0';
            $msj='El Local Seleccionado no se puede eliminar debido a que cuenta con registros de facultades registrados en el';
        }/* elseif($consulta2>0) {
            $result='0';
            $msj='El Local Seleccionado no se puede eliminar debido a que cuenta con registros de entidades registrados en el';
        } */else{
        
        $borrar = Local::findOrFail($id);
        //$task->delete();

        $borrar->borrado='1';

        $borrar->save();

        $msj='Local eliminado exitosamente';
     }

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }



    public function descargarExcel(Request $request)
    {   
        $buscar=$request->busca;


        Excel::create('Locales de la UNASAM', function($excel) use($buscar)  {
            $excel->sheet('Base de Datos Locales', function($sheet) use($buscar){

                $sheet->setAutoSize(true);
                /* $sheet->mergeCells('B1:D1');
                $sheet->mergeCells('B2:H2'); */

                $sheet->mergeCells('A3:I3');
                $sheet->cells('A3:I3',function($cells)
                {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
                $sheet->setBorder('A3:I3', 'thin');
                $sheet->cells('A3:I3', function($cells)
                {
                    $cells->setBackground('#0C73E8');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontSize(15);

                    #Borders
                });
                
                $sheet->cells('A4:A4', function($cells)
                {
                    $cells->setBackground('#B4B9E1');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');

                });

                $sheet->cells('B4:B4', function($cells)
                {
                    $cells->setBackground('#E02F2F');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');

                });

                $sheet->cells('C4:I4', function($cells)
                {
                    $cells->setBackground('#B4B9E1');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');

                });

              

                

                $data=[];

                $sheet->setWidth(array
                (
                'A'=>'7',
                'B'=>'40',
                'C'=>'50',
                'D'=>'45',
                'E'=>'25',
                'F'=>'25',
                'G'=>'25',
                'H'=>'25',
                'I'=>'20',
                )
                );

                $sheet->setHeight(array
                (
                '3'=>'24'
                )
                );

                $titulo='BASE DE DATOS LOCALES DE LA UNASAM';

                array_push($data, array(''));
                array_push($data, array(''));
                array_push($data, array($titulo));

                $sheet->setBorder('A4:I4', 'thin');
                array_push($data, array('N°','CÓDIGO PARA IMPORTACIÓN DE DATOS','NOMBRE','DIRECCIÓN','PAÍS','DEPARRTAMENTO','PROVINCIA','DISTRITO','ESTADO'));

                $cont=5;
                $cont2=5;

				$locals = DB::table('locals')
     ->join('distritos', 'distritos.id', '=', 'locals.distrito_id')
     ->join('provincias', 'provincias.id', '=', 'distritos.provincia_id')
     ->join('departamentos', 'departamentos.id', '=', 'provincias.departamento_id')
     ->join('paises', 'paises.id', '=', 'departamentos.paise_id')


     ->where('locals.borrado','0')
     ->where(function($query) use ($buscar){
        $query->where('locals.nombre','like','%'.$buscar.'%');
        $query->orWhere('distritos.nombre','like','%'.$buscar.'%');
        $query->orWhere('provincias.nombre','like','%'.$buscar.'%');
        $query->orWhere('departamentos.nombre','like','%'.$buscar.'%');
        $query->orWhere('paises.nombre','like','%'.$buscar.'%');
        })
     ->orderBy('nombre')
     ->select('locals.id','locals.nombre','locals.direccion','locals.activo','locals.borrado','locals.distrito_id','distritos.nombre as distrito','provincias.nombre as provincia','departamentos.nombre as departamento','paises.nombre as pais' , 'distritos.id as idDis','provincias.id as idProv','departamentos.id as idDep','paises.id as idPa')
     ->get();

        foreach ($locals as $key => $dato) {
            $rango='A'.strval((intval($cont)+intval($key))).':I'.strval((intval($cont)+intval($key)));
            $sheet->setBorder($rango, 'thin');


           array_push($data, array($key+1,
           $dato->id,
		   $dato->nombre,
		   $dato->direccion,
		   $dato->pais,
		   $dato->departamento,
		   $dato->provincia,
		   $dato->distrito,
		   activoInactivo($dato->activo)     
        ));
            
            $cont2++;
        }



                $sheet->fromArray($data, null, 'A1', false, false);
            
            });
            })->download('xlsx');  
   

        return response()->json(["buscar"=>$buscar,'tipo'=>$tipo]);
    }


}
