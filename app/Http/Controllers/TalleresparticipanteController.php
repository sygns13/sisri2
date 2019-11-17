<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Eventocultural;
use App\Talleresparticipante;
use App\Http\Controllers\Controller;

use Validator;
use Auth;
use DB;

use App\Persona;
use App\Tipouser;
use App\User;

use Excel;
set_time_limit(600);
class TalleresparticipanteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index1($idevento)
    {
        if(accesoUser([1,2])){


            $idtipouser=Auth::user()->tipouser_id;
            $tipouser=Tipouser::find($idtipouser);

            $evento=Eventocultural::find($idevento);
            $modulo="talleresparticipantes";

            return view('talleresparticipantes.index',compact('tipouser','modulo','evento'));

            
        }
        else
        {
            return redirect('home');          
        }
    }



    public function index(Request $request)
    {   
     $buscar=$request->busca;
     $evento=$request->evento;

      
     $talleresparticipantes = DB::table('talleresparticipantes')
     ->join('eventoculturals', 'eventoculturals.id', '=', 'talleresparticipantes.eventocultural_id')

     ->where('eventoculturals.id',$evento)
     ->where('talleresparticipantes.borrado','0')

     ->orderBy('talleresparticipantes.fecha')
     ->orderBy('talleresparticipantes.nombre')
     ->orderBy('talleresparticipantes.id')

     ->select('talleresparticipantes.id','talleresparticipantes.nombre','talleresparticipantes.fecha','talleresparticipantes.participantes','talleresparticipantes.eventocultural_id','talleresparticipantes.observaciones')
     ->paginate(50);




     return [
        'pagination'=>[
            'total'=> $talleresparticipantes->total(),
            'current_page'=> $talleresparticipantes->currentPage(),
            'per_page'=> $talleresparticipantes->perPage(),
            'last_page'=> $talleresparticipantes->lastPage(),
            'from'=> $talleresparticipantes->firstItem(),
            'to'=> $talleresparticipantes->lastItem(),
        ],
        'talleresparticipantes'=>$talleresparticipantes
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
        $fecha=$request->fecha;
        $participantes=$request->participantes;
        $eventocultural_id=$request->eventocultural_id;
        $observaciones=$request->observaciones;

        $result='1';
        $msj='';
        $selector='';

        if (strlen($nombre)==0)
        {
            $result='0';
            $msj='Ingrese un taller válido';
            $selector='txtnombre';

        }
        elseif (strlen($fecha)==0)
        {
            $result='0';
            $msj='Ingrese una fecha válida';
            $selector='txtfecha';

        }

        elseif (intval($participantes)<0)
        {
            $result='0';
            $msj='Ingrese una cantidad de participantes válida mayor o igual a cero';
            $selector='txtparticipantes';

        }

        else{

            $talleresparticipantes = new Talleresparticipante();
            $talleresparticipantes->nombre=$nombre;
            $talleresparticipantes->fecha=$fecha;
            $talleresparticipantes->participantes=intval($participantes);
            $talleresparticipantes->eventocultural_id=$eventocultural_id;
            $talleresparticipantes->observaciones=$observaciones;

            $talleresparticipantes->activo='1';
            $talleresparticipantes->borrado='0';

            $talleresparticipantes->save();

            $msj='Nuevo Registro de Talleres Participantes registrado con éxito';
        }

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
        $fecha=$request->fecha;
        $participantes=$request->participantes;
        $eventocultural_id=$request->eventocultural_id;
        $observaciones=$request->observaciones;

        $result='1';
        $msj='';
        $selector='';

        if (strlen($nombre)==0)
        {
            $result='0';
            $msj='Ingrese un taller válido';
            $selector='txtnombreE';

        }
        elseif (strlen($fecha)==0)
        {
            $result='0';
            $msj='Ingrese una fecha válida';
            $selector='txtfechaE';

        }

        elseif (intval($participantes)<0)
        {
            $result='0';
            $msj='Ingrese una cantidad de participantes válida mayor o igual a cero';
            $selector='txtparticipantesE';

        }

        else{

            $talleresparticipantes =Talleresparticipante::find($id);
            $talleresparticipantes->nombre=$nombre;
            $talleresparticipantes->fecha=$fecha;
            $talleresparticipantes->participantes=intval($participantes);
            $talleresparticipantes->eventocultural_id=$eventocultural_id;
            $talleresparticipantes->observaciones=$observaciones;

            $talleresparticipantes->activo='1';
            $talleresparticipantes->borrado='0';

            $talleresparticipantes->save();

            $msj='Registro de Talleres Participantes modificado con éxito';
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

   
        
        $borrar = Talleresparticipante::destroy($id);
        //$task->delete();


        $msj='Registro Seleccionado eliminado exitosamente';
   

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }

    public function descargarExcel(Request $request)
    {   
        $buscar=$request->busca;
        $evento=$request->evento;

        $enventos=Eventocultural::find($evento);

        Excel::create('Talleres y Participantes del Evento Cultural - '.$enventos->nombre, function($excel) use($buscar,$enventos)  {
            $excel->sheet('BD Talleres', function($sheet) use($buscar,$enventos){

                $sheet->setAutoSize(true);
                /* $sheet->mergeCells('B1:D1');
                $sheet->mergeCells('B2:H2'); */

                $sheet->mergeCells('A3:E3');
                $sheet->cells('A3:E3',function($cells)
                {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
                $sheet->setBorder('A3:E3', 'thin');
                $sheet->cells('A3:E3', function($cells)
                {
                    $cells->setBackground('#0C73E8');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontSize(15);

                    #Borders
                });
                
                $sheet->cells('A4:E4', function($cells)
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
                )
                );

                $sheet->setHeight(array
                (
                '3'=>'24'
                )
                );

                $titulo='BASE DE DATOS DE TALLERES Y PARTICIPANTES DEL EVENTO CULTURAL '.$enventos->nombre;

                array_push($data, array(''));
                array_push($data, array(''));
                array_push($data, array($titulo));

                $sheet->setBorder('A4:E4', 'thin');
                array_push($data, array('N°','TALLER', 'FECHA', 'CANTIDAD DE PARTICIPANTES','OBSERVACIONES'));

                $cont=5;
                $cont2=5;

                $talleresparticipantes = DB::table('talleresparticipantes')
     ->join('eventoculturals', 'eventoculturals.id', '=', 'talleresparticipantes.eventocultural_id')

     ->where('eventoculturals.id',$enventos->id)
     ->where('talleresparticipantes.borrado','0')

     ->orderBy('talleresparticipantes.fecha')
     ->orderBy('talleresparticipantes.nombre')
     ->orderBy('talleresparticipantes.id')

     ->select('talleresparticipantes.id','talleresparticipantes.nombre','talleresparticipantes.fecha','talleresparticipantes.participantes','talleresparticipantes.eventocultural_id','talleresparticipantes.observaciones')
     ->get();


        foreach ($talleresparticipantes as $key => $dato) {
            $rango='A'.strval((intval($cont)+intval($key))).':E'.strval((intval($cont)+intval($key)));
            $sheet->setBorder($rango, 'thin');

           array_push($data, array($key+1,
           $dato->nombre,
           pasFechaVista($dato->fecha),
           $dato->participantes,
           $dato->observaciones
        
        ));
            
            $cont2++;
        }



                $sheet->fromArray($data, null, 'A1', false, false);
            
            });
            })->download('xlsx');  
   


      
    }


}
