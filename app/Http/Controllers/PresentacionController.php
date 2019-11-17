<?php

namespace App\Http\Controllers;

use App\Presentacion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Taller;
use Validator;
use Auth;
use DB;

use App\Persona;
use App\Tipouser;
use App\User;

use Excel;
set_time_limit(600);
class PresentacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index1($idTaller)
    {
        if(accesoUser([1,2])){


            $idtipouser=Auth::user()->tipouser_id;
            $tipouser=Tipouser::find($idtipouser);

            $taller=Taller::find($idTaller);
            $modulo="presentaciones";

            return view('presentaciones.index',compact('tipouser','modulo','taller'));

            
        }
        else
        {
            return redirect('home');          
        }
    }


    public function index(Request $request)
    {   
     $buscar=$request->busca;
     $taller=$request->taller;

      
     $presentacions = DB::table('presentacions')
     ->join('tallers', 'tallers.id', '=', 'presentacions.taller_id')

     ->where('tallers.id',$taller)
     ->where('presentacions.borrado','0')

     ->orderBy('presentacions.fecha')
     ->orderBy('presentacions.id')

     ->select('presentacions.id','presentacions.fecha','presentacions.asistentes','presentacions.detalle','presentacions.taller_id','presentacions.observaciones')
     ->paginate(50);




     return [
        'pagination'=>[
            'total'=> $presentacions->total(),
            'current_page'=> $presentacions->currentPage(),
            'per_page'=> $presentacions->perPage(),
            'last_page'=> $presentacions->lastPage(),
            'from'=> $presentacions->firstItem(),
            'to'=> $presentacions->lastItem(),
        ],
        'presentacions'=>$presentacions
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
        $fecha=$request->fecha;
        $asistentes=$request->asistentes;
        $detalle=$request->detalle;
        $taller_id=$request->taller_id;
        $observaciones=$request->observaciones;

        $result='1';
        $msj='';
        $selector='';

        if (strlen($fecha)==0)
        {
            $result='0';
            $msj='Ingrese una fecha válida';
            $selector='txtfecha';

        }
   

        elseif (intval($asistentes)<0)
        {
            $result='0';
            $msj='Ingrese una cantidad de asistentes válida mayor o igual a cero';
            $selector='txtasistentes';

        }

        else{

            $presentacions = new Presentacion();

            $presentacions->fecha=$fecha;
            $presentacions->asistentes=intval($asistentes);
            $presentacions->detalle=$detalle;
            $presentacions->taller_id=$taller_id;
            $presentacions->observaciones=$observaciones;

            $presentacions->activo='1';
            $presentacions->borrado='0';

            $presentacions->save();

            $msj='Nuevo Registro de Presentaciones registrado con éxito';
        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Presentacion  $presentacion
     * @return \Illuminate\Http\Response
     */
    public function show(Presentacion $presentacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Presentacion  $presentacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Presentacion $presentacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Presentacion  $presentacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $fecha=$request->fecha;
        $asistentes=$request->asistentes;
        $detalle=$request->detalle;
        $taller_id=$request->taller_id;
        $observaciones=$request->observaciones;

        $result='1';
        $msj='';
        $selector='';

        if (strlen($fecha)==0)
        {
            $result='0';
            $msj='Ingrese una fecha válida';
            $selector='txtfechaE';

        }
   

        elseif (intval($asistentes)<0)
        {
            $result='0';
            $msj='Ingrese una cantidad de asistentes válida mayor o igual a cero';
            $selector='txtasistentesE';

        }

        else{

            $presentacions =Presentacion::find($id);

            $presentacions->fecha=$fecha;
            $presentacions->asistentes=intval($asistentes);
            $presentacions->detalle=$detalle;
            $presentacions->taller_id=$taller_id;
            $presentacions->observaciones=$observaciones;


            $presentacions->save();

            $msj='Registro de Presentaciones modificado con éxito';
        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Presentacion  $presentacion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result='1';
        $msj='1';

   
        
        $borrar = Presentacion::destroy($id);
        //$task->delete();


        $msj='Registro Seleccionado eliminado exitosamente';
   

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }


    public function descargarExcel(Request $request)
    {   
        $buscar=$request->busca;
        $taller=$request->taller;

        $talleres=Taller::find($taller);

        Excel::create('Presentaciones del Taller - '.$talleres->nombre, function($excel) use($buscar,$talleres)  {
            $excel->sheet('BD Talleres', function($sheet) use($buscar,$talleres){

                $sheet->setAutoSize(true);
                /* $sheet->mergeCells('B1:D1');
                $sheet->mergeCells('B2:H2'); */

                $sheet->mergeCells('A3:F3');
                $sheet->cells('A3:F3',function($cells)
                {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
                $sheet->setBorder('A3:F3', 'thin');
                $sheet->cells('A3:F3', function($cells)
                {
                    $cells->setBackground('#0C73E8');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontSize(15);

                    #Borders
                });
                
                $sheet->cells('A4:F4', function($cells)
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
                    'C'=>'25',
                    'D'=>'25',
                    'E'=>'65',
                    'F'=>'65',
                )
                );

                $sheet->setHeight(array
                (
                '3'=>'24'
                )
                );

                $titulo='BASE DE DATOS DE PRESENTACIONES DEL TALLER '.$talleres->nombre;

                array_push($data, array(''));
                array_push($data, array(''));
                array_push($data, array($titulo));

                $sheet->setBorder('A4:F4', 'thin');
                array_push($data, array('N°','TALLER', 'FECHA', 'CANTIDAD DE ASISTENTES', 'DETALLES DE LA PRESENTACIÓN','OBSERVACIONES'));


                $cont=5;
                $cont2=5;

                $presentacions = DB::table('presentacions')
                ->join('tallers', 'tallers.id', '=', 'presentacions.taller_id')
           
                ->where('tallers.id',$talleres->id)
                ->where('presentacions.borrado','0')
           
                ->orderBy('presentacions.fecha')
                ->orderBy('presentacions.id')
           
                ->select('presentacions.id','presentacions.fecha','presentacions.asistentes','presentacions.detalle','presentacions.taller_id','presentacions.observaciones')
                ->get();


        foreach ($presentacions as $key => $dato) {
            $rango='A'.strval((intval($cont)+intval($key))).':F'.strval((intval($cont)+intval($key)));
            $sheet->setBorder($rango, 'thin');

            array_push($data, array($key+1,
            $talleres->nombre,
            pasFechaVista($dato->fecha),
            $dato->asistentes,
            $dato->detalle,
            $dato->observaciones
         
         ));
            
            $cont2++;
        }



                $sheet->fromArray($data, null, 'A1', false, false);
            
            });
            })->download('xlsx');  
   


      
    }
}
