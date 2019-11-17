<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Atencion;
use App\Programassalud;
use Validator;
use Auth;
use DB;

use App\Persona;
use App\Tipouser;
use App\User;

use Excel;
set_time_limit(600);
class AtencionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index1($idprogramassaluds)
    {
        if(accesoUser([1,2])){


            $idtipouser=Auth::user()->tipouser_id;
            $tipouser=Tipouser::find($idtipouser);

            $programassalud=Programassalud::find($idprogramassaluds);
            $modulo="atencions";

            return view('atencions.index',compact('tipouser','modulo','programassalud'));

            
        }
        else
        {
            return redirect('home');          
        }
    }


    public function index(Request $request)
    {   
     $buscar=$request->busca;
     $programasalud=$request->programasalud;

      
     $atencions = DB::table('atencions')
     ->join('programassaluds', 'programassaluds.id', '=', 'atencions.programassalud_id')

     ->where('programassaluds.id',$programasalud)
     ->where('atencions.borrado','0')

     ->orderBy('atencions.anio','desc')
     ->orderBy('atencions.mes')

     ->select('atencions.id','atencions.anio','atencions.mes','atencions.cantidad','atencions.tipobeneficiario','atencions.observaciones','atencions.programassalud_id')
     ->paginate(50);




     return [
        'pagination'=>[
            'total'=> $atencions->total(),
            'current_page'=> $atencions->currentPage(),
            'per_page'=> $atencions->perPage(),
            'last_page'=> $atencions->lastPage(),
            'from'=> $atencions->firstItem(),
            'to'=> $atencions->lastItem(),
        ],
        'atencions'=>$atencions
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
        $anio=$request->anio;
        $mes=$request->mes;
        $cantidad=$request->cantidad;
        $programassalud_id=$request->programassalud_id;
        $tipobeneficiario=$request->tipobeneficiario;
        $observaciones=$request->observaciones;


        $result='1';
        $msj='';
        $selector='';

        $regla0=Atencion::where('anio',intval($anio))
        ->where('mes',intval($mes))
        ->where('programassalud_id',$programassalud_id)
        ->where('tipobeneficiario',$tipobeneficiario)->count();

        if ($regla0>0 )
        {
            $result='0';
            $msj='Ya registrada una cantidad de atenciones para el año, mes, tipo de beneficiario y programa de salud ingresado';
            $selector='txtanio';

        }
        elseif (intval($anio)<0 )
        {
            $result='0';
            $msj='Ingrese un año válido';
            $selector='txtanio';

        }
        elseif (intval($mes)<1 || intval($mes)>12 )
        {
            $result='0';
            $msj='Ingrese un mes válido';
            $selector='txtmes';

        }

        elseif (intval($cantidad)<0)
        {
            $result='0';
            $msj='Ingrese una cantidad válida mayor o igual a cero';
            $selector='txtcantidad';

        }

        else{

            $newAtencion = new Atencion();
            $newAtencion->anio=intval($anio);
            $newAtencion->mes=$mes;
            $newAtencion->cantidad=intval($cantidad);
            $newAtencion->programassalud_id=$programassalud_id;
            $newAtencion->tipobeneficiario=$tipobeneficiario;
            $newAtencion->observaciones=$observaciones;
            $newAtencion->activo='1';
            $newAtencion->borrado='0';

            $newAtencion->save();

            $msj='Nuevo Registro de Atenciones registrado con éxito';
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
        $anio=$request->anio;
        $mes=$request->mes;
        $cantidad=$request->cantidad;
        $programassalud_id=$request->programassalud_id;
        $tipobeneficiario=$request->tipobeneficiario;
        $observaciones=$request->observaciones;


        $result='1';
        $msj='';
        $selector='';

        $regla0=Atencion::where('anio',intval($anio))
        ->where('mes',intval($mes))
        ->where('id','<>',$id)
        ->where('programassalud_id',$programassalud_id)
        ->where('tipobeneficiario',$tipobeneficiario)->count();

        if ($regla0>0 )
        {
            $result='0';
            $msj='Ya registrada una cantidad de atenciones para el año, mes, tipo de beneficiario y programa de salud ingresado';
            $selector='txtanioE';

        }
        elseif (intval($anio)<0 )
        {
            $result='0';
            $msj='Ingrese un año válido';
            $selector='txtanioE';

        }
        elseif (intval($mes)<1 || intval($mes)>12 )
        {
            $result='0';
            $msj='Ingrese un mes válido';
            $selector='txtmesE';

        }

        elseif (intval($cantidad)<0)
        {
            $result='0';
            $msj='Ingrese una cantidad válida mayor o igual a cero';
            $selector='txtcantidadE';

        }

        else{

            $newAtencion = Atencion::find($id);
            $newAtencion->anio=intval($anio);
            $newAtencion->mes=$mes;
            $newAtencion->cantidad=intval($cantidad);
            $newAtencion->programassalud_id=$programassalud_id;
            $newAtencion->tipobeneficiario=$tipobeneficiario;
            $newAtencion->observaciones=$observaciones;


            $newAtencion->save();

            $msj='Registro de Atenciones modificado con éxito';
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
    public function destroy($id)
    {
        $result='1';
        $msj='1';

   
        
        $borrar = Atencion::destroy($id);
        //$task->delete();


        $msj='Registro Seleccionado eliminado exitosamente';
   

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }

    public function descargarExcel(Request $request)
    {   
        $buscar=$request->busca;
        $programasalud=$request->programasalud;

        $programas=Programassalud::find($programasalud);

        Excel::create('Atenciones del Programa de Salud - '.$programas->nombre, function($excel) use($buscar,$programas)  {
            $excel->sheet('BD Atenciones', function($sheet) use($buscar,$programas){

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
                'B'=>'20',
                'C'=>'25',
                'D'=>'25',
                'E'=>'20',
                'F'=>'65',
                )
                );

                $sheet->setHeight(array
                (
                '3'=>'24'
                )
                );

                $titulo='BASE DE DATOS DE ATENCIONES DEL PROGRAMA DE SALUD '.$programas->nombre;

                array_push($data, array(''));
                array_push($data, array(''));
                array_push($data, array($titulo));

                $sheet->setBorder('A4:F4', 'thin');
                array_push($data, array('N°','AÑO', 'MES', 'CANTIDAD DE ATENCIONES', 'TIPO DE BENEFICIARIOS','OBSERVACIONES'));

                $cont=5;
                $cont2=5;

                $atencions = DB::table('atencions')
     ->join('programassaluds', 'programassaluds.id', '=', 'atencions.programassalud_id')

     ->where('programassaluds.id',$programas->id)
     ->where('atencions.borrado','0')

     ->orderBy('atencions.anio','desc')
     ->orderBy('atencions.mes')

     ->select('atencions.id','atencions.anio','atencions.mes','atencions.cantidad','atencions.tipobeneficiario','atencions.observaciones','atencions.programassalud_id')
     ->get();

        foreach ($atencions as $key => $dato) {
            $rango='A'.strval((intval($cont)+intval($key))).':F'.strval((intval($cont)+intval($key)));
            $sheet->setBorder($rango, 'thin');

/*
$sheet->setBorder('A4:S4', 'thin');
                array_push($data, array('N°','TIPO DE DOCUMENTO', 'NÚMERO DE DOCUMENTO', 'APELLIDO PATERNO', 'APELLIDO MATERNO','NOMBRES','GÉNERO','FECHA DE NACIMIENTO','ESTADO CIVIL','SUFRE DISCAPACIDAD','DISCAPACIDAD QUE PADECE','PROGRAMA DE SALUD','TIPO DE BENEFICIARIO','CÓDIGO','FECHA DE ATENCIÓN','OBSERVACIONES'));
 */
           array_push($data, array($key+1,
           $dato->anio,
           strtoupper(nombremes($dato->mes)),
           $dato->cantidad,
           strtoupper(tipoBeneficiariosPlural($dato->tipobeneficiario)),
           $dato->observaciones
        
        ));
            
            $cont2++;
        }



                $sheet->fromArray($data, null, 'A1', false, false);
            
            });
            })->download('xlsx');  
   


        

        return response()->json(["buscar"=>$buscar,'programasalud'=>$programasalud]);
    }
}
