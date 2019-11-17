<?php

namespace App\Http\Controllers;

use App\Programassalud;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



use Validator;
use Auth;
use DB;

use App\Persona;
use App\Tipouser;
use App\User;

use Excel;
set_time_limit(600);

class ProgramassaludController extends Controller
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


            $modulo="programassalud";
            return view('programassalud.index',compact('tipouser','modulo'));
        }
        else
        {
            return redirect('home');          
        }
    }


    public function index2()
    {
        if(accesoUser([1,2])){


            $idtipouser=Auth::user()->tipouser_id;
            $tipouser=Tipouser::find($idtipouser);


            $modulo="campadbu";
            return view('campadbu.index',compact('tipouser','modulo'));
        }
        else
        {
            return redirect('home');          
        }
    }



    public function index(Request $request)
    {   
     $buscar=$request->busca;
     $tipo=$request->tipo;

     $programassaluds = Programassalud::where('borrado','0')
     ->where('tipo',$tipo)
     ->where(function($query) use ($buscar){
        $query->where('nombre','like','%'.$buscar.'%');
        $query->orwhere('descripcion','like','%'.$buscar.'%');
        })
     ->orderBy('id')->paginate(30);

     return [
        'pagination'=>[
            'total'=> $programassaluds->total(),
            'current_page'=> $programassaluds->currentPage(),
            'per_page'=> $programassaluds->perPage(),
            'last_page'=> $programassaluds->lastPage(),
            'from'=> $programassaluds->firstItem(),
            'to'=> $programassaluds->lastItem(),
        ],
        'programassaluds'=>$programassaluds
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
        $tipo=$request->tipo;

        $cantidadAtenciones=null;
        $fechaini=null;
        $fechafin=null;
        $lugar=null;

        if(intval($tipo)==2)
        {
            $cantidadAtenciones=$request->cantidadAtenciones;
            $fechaini=$request->fechaini;
            $fechafin=$request->fechafin;
            $lugar=$request->lugar;

        }



        $result='1';
        $msj='';
        $selector='';

        $input1  = array('nombre' => $nombre);
        $reglas1 = array('nombre' => 'required');
        
        $input2  = array('cantidadAtenciones' => $cantidadAtenciones);
        $reglas2 = array('cantidadAtenciones' => 'required');

        $input3  = array('fechaini' => $fechaini);
        $reglas3 = array('fechaini' => 'required');

        $input4  = array('fechafin' => $fechafin);
        $reglas4 = array('fechafin' => 'required');

        $input5  = array('lugar' => $lugar);
        $reglas5 = array('lugar' => 'required');


        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);
        $validator5 = Validator::make($input5, $reglas5);

        if ($validator1->fails() && intval($tipo)==1)
        {
            $result='0';
            $msj='Ingrese el nombre del Programa de Salud';
            $selector='txtnombre';

        }
        elseif ($validator1->fails() && intval($tipo)==2)
        {
            $result='0';
            $msj='Ingrese el nombre de la Campaña de Salud';
            $selector='txtnombre';

        }
        elseif ($validator2->fails() && intval($tipo)==2)
        {
            $result='0';
            $msj='Ingrese la Cantidad de Atenciones de la Campaña de Salud';
            $selector='txtcantidadAtenciones';

        }
        elseif ($validator3->fails() && intval($tipo)==2)
        {
            $result='0';
            $msj='Ingrese la fecha de inicio de la Campaña de Salud';
            $selector='txtfechaini';

        }
        elseif ($validator4->fails() && intval($tipo)==2)
        {
            $result='0';
            $msj='Ingrese la fecha de finalización de la Campaña de Salud';
            $selector='txtfechafin';

        }
        elseif ($validator5->fails() && intval($tipo)==2)
        {
            $result='0';
            $msj='Ingrese el lugar donde fue realizado de la Campaña de Salud';
            $selector='txtlugar';

        }
        else{

            $newProgramaSalud = new Programassalud();
            $newProgramaSalud->nombre=$nombre;
            $newProgramaSalud->descripcion=$descripcion;
            $newProgramaSalud->cantidadAtenciones=$cantidadAtenciones;
            $newProgramaSalud->fechaini=$fechaini;
            $newProgramaSalud->fechafin=$fechafin;
            $newProgramaSalud->tipo=$tipo;
            $newProgramaSalud->lugar=$lugar;
            $newProgramaSalud->activo='1';
            $newProgramaSalud->borrado='0';

            $newProgramaSalud->save();

            if(intval($tipo)==1)
            {
                $msj='Nuevo Programa de Salud registrado con éxito';
            }
            elseif(intval($tipo)==1)
            {
                $msj='Nueva Campaña de Salud registrada con éxito';
            }
        }


        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Programassalud  $programassalud
     * @return \Illuminate\Http\Response
     */
    public function show(Programassalud $programassalud)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Programassalud  $programassalud
     * @return \Illuminate\Http\Response
     */
    public function edit(Programassalud $programassalud)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Programassalud  $programassalud
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $nombre=$request->nombre;
        $descripcion=$request->descripcion;
        $tipo=$request->tipo;

        $cantidadAtenciones=null;
        $fechaini=null;
        $fechafin=null;
        $lugar=null;

        if(intval($tipo)==2)
        {
            $cantidadAtenciones=$request->cantidadAtenciones;
            $fechaini=$request->fechaini;
            $fechafin=$request->fechafin;
            $lugar=$request->lugar;

        }



        $result='1';
        $msj='';
        $selector='';

        $input1  = array('nombre' => $nombre);
        $reglas1 = array('nombre' => 'required');
        
        $input2  = array('cantidadAtenciones' => $cantidadAtenciones);
        $reglas2 = array('cantidadAtenciones' => 'required');

        $input3  = array('fechaini' => $fechaini);
        $reglas3 = array('fechaini' => 'required');

        $input4  = array('fechafin' => $fechafin);
        $reglas4 = array('fechafin' => 'required');

        $input5  = array('lugar' => $lugar);
        $reglas5 = array('lugar' => 'required');


        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);
        $validator5 = Validator::make($input5, $reglas5);

        if ($validator1->fails() && intval($tipo)==1)
        {
            $result='0';
            $msj='Ingrese el nombre del Programa de Salud';
            $selector='txtnombreE';

        }
        elseif ($validator1->fails() && intval($tipo)==2)
        {
            $result='0';
            $msj='Ingrese el nombre de la Campaña de Salud';
            $selector='txtnombreE';

        }
        elseif ($validator2->fails() && intval($tipo)==2)
        {
            $result='0';
            $msj='Ingrese la Cantidad de Atenciones de la Campaña de Salud';
            $selector='txtcantidadAtencionesE';

        }
        elseif ($validator3->fails() && intval($tipo)==2)
        {
            $result='0';
            $msj='Ingrese la fecha de inicio de la Campaña de Salud';
            $selector='txtfechainiE';

        }
        elseif ($validator4->fails() && intval($tipo)==2)
        {
            $result='0';
            $msj='Ingrese la fecha de finalización de la Campaña de Salud';
            $selector='txtfechafinE';

        }
        elseif ($validator5->fails() && intval($tipo)==2)
        {
            $result='0';
            $msj='Ingrese el lugar donde fue realizado de la Campaña de Salud';
            $selector='txtlugarE';

        }
        else{

            $newProgramaSalud =Programassalud::find($id);
            $newProgramaSalud->nombre=$nombre;
            $newProgramaSalud->descripcion=$descripcion;
            $newProgramaSalud->cantidadAtenciones=$cantidadAtenciones;
            $newProgramaSalud->fechaini=$fechaini;
            $newProgramaSalud->fechafin=$fechafin;
            $newProgramaSalud->lugar=$lugar;

            $newProgramaSalud->save();

            if(intval($tipo)==1)
            {
                $msj='Programa de Salud modificada con éxito';
            }
            elseif(intval($tipo)==1)
            {
                $msj='Campaña de Salud modificada con éxito';
            }
        }


        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Programassalud  $programassalud
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result='1';
        $msj='1';

        $consulta1=DB::table('medicos')
                    ->join('programassaluds', 'medicos.programassalud_id', '=', 'programassaluds.id')
                    ->where('programassaluds.id',$id)->count();

        $consulta3=DB::table('atencions')
        ->join('programassaluds', 'atencions.programassalud_id', '=', 'programassaluds.id')
        ->where('programassaluds.id',$id)->count();

        $consulta2=DB::table('beneficiarios')
        ->join('programassaluds', 'beneficiarios.programassalud_id', '=', 'programassaluds.id')
        ->where('programassaluds.id',$id)->count();


        if($consulta1>0) {
            $result='0';
            $msj='El Programa de Salud no puede ser eliminado porque cuenta con registros de médicos asociados a él, elimine primero a los médicos del programa de salud para poder eliminar este último.';
        }
        elseif($consulta2>0) {
            $result='0';
            $msj='El Programa de Salud no puede ser eliminado porque cuenta con registros de beneficiarios asociados a él, elimine primero a los beneficiarios del programa de salud para poder eliminar este último.';
        }
        elseif($consulta3>0) {
            $result='0';
            $msj='El Programa de Salud no puede ser eliminado porque cuenta con registros de atenciones asociados a él, elimine primero las atenciones del programa de salud para poder eliminar este último.';
        }else{
        
        $borrar = Programassalud::findOrFail($id);
        //$task->delete();

        $borrar->borrado='1';

        $borrar->save();

        $msj='Programa de Salud eliminado exitosamente';
     }

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }

    public function descargarExcel(Request $request)
    {   
        $buscar=$request->busca;
        $tipo=$request->tipo;



        Excel::create('Programas de Salud', function($excel) use($buscar,$tipo)  {
            $excel->sheet('BD Programas Salud', function($sheet) use($buscar,$tipo){

                $sheet->setAutoSize(true);
                /* $sheet->mergeCells('B1:D1');
                $sheet->mergeCells('B2:H2'); */

                $sheet->mergeCells('A3:C3');
                $sheet->cells('A3:C3',function($cells)
                {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
                $sheet->setBorder('A3:C3', 'thin');
                $sheet->cells('A3:C3', function($cells)
                {
                    $cells->setBackground('#0C73E8');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontSize(15);

                    #Borders
                });
                
                $sheet->cells('A4:C4', function($cells)
                {
                    $cells->setBackground('#B4B9E1');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');

                });

              

                

                $data=[];

                $sheet->setWidth(array
                (
                'A'=>'7',
                'B'=>'45',
                'C'=>'85'
                )
                );

                $sheet->setHeight(array
                (
                '3'=>'24'
                )
                );

                $titulo='BASE DE DATOS PROGRAMAS DE SALUD';

                array_push($data, array(''));
                array_push($data, array(''));
                array_push($data, array($titulo));

                $sheet->setBorder('A4:C4', 'thin');
                array_push($data, array('N°','NOMBRE', 'DESCRIPCIÓN'));

                $cont=5;
                $cont2=5;

    $programassaluds = Programassalud::where('borrado','0')
     ->where('tipo',$tipo)
     ->where(function($query) use ($buscar){
        $query->where('nombre','like','%'.$buscar.'%');
        $query->orwhere('descripcion','like','%'.$buscar.'%');
        })
     ->orderBy('id')->get();

        foreach ($programassaluds as $key => $dato) {
            $rango='A'.strval((intval($cont)+intval($key))).':C'.strval((intval($cont)+intval($key)));
            $sheet->setBorder($rango, 'thin');


           array_push($data, array($key+1,
           $dato->nombre,
           $dato->descripcion
        ));
            
            $cont2++;
        }



                $sheet->fromArray($data, null, 'A1', false, false);
            
            });
            })->download('xlsx');  
   

        return response()->json(["buscar"=>$buscar,'tipo'=>$tipo]);
    }







    public function descargarExcel2(Request $request)
    {   
        $buscar=$request->busca;
        $tipo=$request->tipo;



        Excel::create('Campañas de Salud', function($excel) use($buscar,$tipo)  {
            $excel->sheet('BD Campañas Salud', function($sheet) use($buscar,$tipo){

                $sheet->setAutoSize(true);
                /* $sheet->mergeCells('B1:D1');
                $sheet->mergeCells('B2:H2'); */

                $sheet->mergeCells('A3:G3');
                $sheet->cells('A3:G3',function($cells)
                {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
                $sheet->setBorder('A3:G3', 'thin');
                $sheet->cells('A3:G3', function($cells)
                {
                    $cells->setBackground('#0C73E8');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontSize(15);

                    #Borders
                });
                
                $sheet->cells('A4:G4', function($cells)
                {
                    $cells->setBackground('#B4B9E1');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');

                });

              

                

                $data=[];

                $sheet->setWidth(array
                (
                'A'=>'7',
                'B'=>'45',
                'C'=>'45',
                'D'=>'20',
                'E'=>'20',
                'F'=>'25',
                'G'=>'65'
                )
                );

                $sheet->setHeight(array
                (
                '3'=>'24'
                )
                );

                $titulo='BASE DE DATOS CAMPAÑAS DE SALUD';

                array_push($data, array(''));
                array_push($data, array(''));
                array_push($data, array($titulo));

                $sheet->setBorder('A4:G4', 'thin');
                array_push($data, array('N°','NOMBRE','LUGAR','FECHA DE INICIO','FECHA FINAL','CANTIDAD DE ATENCIONES','DESCRIPCIÓN'));

                $cont=5;
                $cont2=5;

    $programassaluds = Programassalud::where('borrado','0')
     ->where('tipo',$tipo)
     ->where(function($query) use ($buscar){
        $query->where('nombre','like','%'.$buscar.'%');
        $query->orwhere('descripcion','like','%'.$buscar.'%');
        })
     ->orderBy('id')->get();

        foreach ($programassaluds as $key => $dato) {
            $rango='A'.strval((intval($cont)+intval($key))).':G'.strval((intval($cont)+intval($key)));
            $sheet->setBorder($rango, 'thin');


           array_push($data, array($key+1,
           $dato->nombre,
           $dato->lugar,
           pasFechaVista($dato->fechaini),
           pasFechaVista($dato->fechafin),
           $dato->cantidadAtenciones,
           $dato->descripcion
        ));
            
            $cont2++;
        }



                $sheet->fromArray($data, null, 'A1', false, false);
            
            });
            })->download('xlsx');  
   

        return response()->json(["buscar"=>$buscar,'tipo'=>$tipo]);
    }



}
