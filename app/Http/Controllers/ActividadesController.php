<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Actividades;
use Validator;
use Auth;
use DB;

use App\Semestre;
use App\Persona;
use App\Tipouser;
use App\User;

use Excel;
set_time_limit(600);

class ActividadesController extends Controller
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

            $semestres=Semestre::where('activo','1')->where('borrado','0')->orderBy('fechafin','desc')->get();

            $semestresel="0";
            $contse=0;
            $semestreNombre="";
            foreach ($semestres as $key => $dato) {
                $contse++;
                if($dato->estado="1"){
                    $semestresel=$dato->id;
                    $semestreNombre=$dato->nombre;
                    break;
                }
            }


            $modulo="actividades";
            return view('actividades.index',compact('tipouser','modulo','semestres','semestresel','contse','semestreNombre'));
        }
        else
        {
            return redirect('home');           
        }
    }


    public function index(Request $request)
    {   
     $buscar=$request->busca;
        
     $actividades = DB::table('actividades')
     ->where('actividades.borrado','0')
     ->where(function($query) use ($buscar){
        $query->where('actividades.actividad','like','%'.$buscar.'%');
        $query->orWhere('actividades.descripcion','like','%'.$buscar.'%');
        $query->orWhere('actividades.oficinas','like','%'.$buscar.'%');
        $query->orWhere('actividades.lugar','like','%'.$buscar.'%');
        $query->orWhere('actividades.fecha','like','%'.$buscar.'%');
        })
     ->orderBy('actividades.fecha')
     ->orderBy('actividades.id')
     ->select('actividades.id','actividades.actividad','actividades.descripcion','actividades.oficinas','actividades.lugar','actividades.beneficiarios','actividades.organizadores','actividades.fecha', 'actividades.activo')
     ->paginate(50);



     return [
        'pagination'=>[
            'total'=> $actividades->total(),
            'current_page'=> $actividades->currentPage(),
            'per_page'=> $actividades->perPage(),
            'last_page'=> $actividades->lastPage(),
            'from'=> $actividades->firstItem(),
            'to'=> $actividades->lastItem(),
        ],
        'actividades'=>$actividades
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
        $actividad=$request->actividad;
        $descripcion=$request->descripcion;
        $oficinas=$request->oficinas;
        $lugar=$request->lugar;
        $beneficiarios=$request->beneficiarios;
        $organizadores=$request->organizadores;
        $fecha=$request->fecha;

        $result='1';
        $msj='';
        $selector='';

        $input1  = array('actividad' => $actividad);
        $reglas1 = array('actividad' => 'required');

        $input2  = array('descripcion' => $descripcion);
        $reglas2 = array('descripcion' => 'required');

        $input3  = array('oficinas' => $oficinas);
        $reglas3 = array('oficinas' => 'required');

        $input4  = array('lugar' => $lugar);
        $reglas4 = array('lugar' => 'required');

        $input5  = array('beneficiarios' => $beneficiarios);
        $reglas5 = array('beneficiarios' => 'required');

        $input6  = array('organizadores' => $organizadores);
        $reglas6 = array('organizadores' => 'required');

        $input7  = array('fecha' => $fecha);
        $reglas7 = array('fecha' => 'required');

        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);
        $validator5 = Validator::make($input5, $reglas5);
        $validator6 = Validator::make($input6, $reglas6);
        $validator7 = Validator::make($input7, $reglas7);

        if($validator1->fails()){
            $result='0';
            $msj='Ingrese el nombre de la actividad';
            $selector='txtactividad';
        }
        elseif ($validator2->fails())
        {
            $result='0';
            $msj='Ingrese la descripción de la actividad';
            $selector='txtdescripcion';

        }
        elseif ($validator3->fails()) {
            $result='0';
            $msj='Ingrese las oficinas de apoyo de la actividad';
            $selector='txtoficinas';
        }
        elseif ($validator4->fails()) {
            $result='0';
            $msj='Ingrese el lugar de la actividad';
            $selector='txtlugar';
        }
        elseif ($validator5->fails() || intval($beneficiarios)<0) {
            $result='0';
            $msj='Ingrese la cantidad de beneficiarios de la actividad, debe ser una cantidad mayor o igual a cero';
            $selector='txtbeneficiarios';
        }
        elseif ($validator6->fails() || intval($organizadores)<0) {
            $result='0';
            $msj='Ingrese la cantidad de organizadores de la actividad, debe ser una cantidad mayor o igual a cero';
            $selector='txtorganizadores';
        }
        elseif ($validator7->fails()) {
            $result='0';
            $msj='Ingrese la fecha de actividad';
            $selector='txtfecha';
        }
        else{
            $newActividad = new Actividades();
            $newActividad->actividad=$actividad;
            $newActividad->descripcion=$descripcion;
            $newActividad->oficinas=$oficinas;
            $newActividad->lugar=$lugar;
            $newActividad->beneficiarios=$beneficiarios;
            $newActividad->organizadores=$organizadores;
            $newActividad->fecha=$fecha;
            $newActividad->activo='1';
            $newActividad->borrado='0';

            $newActividad->save();

            $msj='Actividad registrada con éxito';
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
        $actividad=$request->actividad;
        $descripcion=$request->descripcion;
        $oficinas=$request->oficinas;
        $lugar=$request->lugar;
        $beneficiarios=$request->beneficiarios;
        $organizadores=$request->organizadores;
        $fecha=$request->fecha;

        $result='1';
        $msj='';
        $selector='';

        $input1  = array('actividad' => $actividad);
        $reglas1 = array('actividad' => 'required');

        $input2  = array('descripcion' => $descripcion);
        $reglas2 = array('descripcion' => 'required');

        $input3  = array('oficinas' => $oficinas);
        $reglas3 = array('oficinas' => 'required');

        $input4  = array('lugar' => $lugar);
        $reglas4 = array('lugar' => 'required');

        $input5  = array('beneficiarios' => $beneficiarios);
        $reglas5 = array('beneficiarios' => 'required');

        $input6  = array('organizadores' => $organizadores);
        $reglas6 = array('organizadores' => 'required');

        $input7  = array('fecha' => $fecha);
        $reglas7 = array('fecha' => 'required');

        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);
        $validator5 = Validator::make($input5, $reglas5);
        $validator6 = Validator::make($input6, $reglas6);
        $validator7 = Validator::make($input7, $reglas7);

        if($validator1->fails()){
            $result='0';
            $msj='Ingrese el nombre de la actividad';
            $selector='txtactividadE';
        }
        elseif ($validator2->fails())
        {
            $result='0';
            $msj='Ingrese la descripción de la actividad';
            $selector='txtdescripcionE';

        }
        elseif ($validator3->fails()) {
            $result='0';
            $msj='Ingrese las oficinas de apoyo de la actividad';
            $selector='txtoficinasE';
        }
        elseif ($validator4->fails()) {
            $result='0';
            $msj='Ingrese el lugar de la actividad';
            $selector='txtlugarE';
        }
        elseif ($validator5->fails() || intval($beneficiarios)<0) {
            $result='0';
            $msj='Ingrese la cantidad de beneficiarios de la actividad, debe ser una cantidad mayor o igual a cero';
            $selector='txtbeneficiariosE';
        }
        elseif ($validator6->fails() || intval($organizadores)<0) {
            $result='0';
            $msj='Ingrese la cantidad de organizadores de la actividad, debe ser una cantidad mayor o igual a cero';
            $selector='txtorganizadoresE';
        }
        elseif ($validator7->fails()) {
            $result='0';
            $msj='Ingrese la fecha de actividad';
            $selector='txtfechaE';
        }
        else{
            $editActividad = Actividades::find($id);;
            $editActividad->actividad=$actividad;
            $editActividad->descripcion=$descripcion;
            $editActividad->oficinas=$oficinas;
            $editActividad->lugar=$lugar;
            $editActividad->beneficiarios=$beneficiarios;
            $editActividad->organizadores=$organizadores;
            $editActividad->fecha=$fecha;

            $editActividad->save();

            $msj='Actividad modificada con éxito';
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

   
        
        $borrar = Actividades::destroy($id);
        //$task->delete();


        $msj='Actividad eliminada exitosamente';
   

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }

    public function descargarExcel(Request $request)
    { 

        $buscar=$request->busca;


        Excel::create('Condición Económica de Estudiantes - '.$semestre->nombre, function($excel) use($buscar)  {
            $excel->sheet('BD Condicion Economica', function($sheet) use($buscar){

                $sheet->setAutoSize(true);

                $sheet->mergeCells('A3:H3');
                $sheet->cells('A3:H3',function($cells)
                {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
                $sheet->setBorder('A3:H3', 'thin');
                $sheet->cells('A3:H3', function($cells)
                {
                    $cells->setBackground('#0C73E8');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontSize(15);

                    #Borders
                });
                
                $sheet->cells('A4:H4', function($cells)
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
                'C'=>'60',
                'D'=>'60',
                'E'=>'60',
                'F'=>'30',
                'G'=>'30',
                'H'=>'20'
                )
                );

                $sheet->setHeight(array
                (
                '3'=>'24'
                )
                );

                $titulo='BASE DE DATOS ALUMNOS BENEFICIARIOS DEL COMEDOR UNIVERSITARIO - SEMESTRE '.$semestre->nombre;

                array_push($data, array(''));
                array_push($data, array(''));
                array_push($data, array($titulo));

                $sheet->setBorder('A4:P4', 'thin');
                array_push($data, array('N°','ACTIVIDAD', 'DESCRIPCIÓN DE ACTIVIDAD', 'OFICINAS DE APOYO', 'LUGAR DONDE SE DESARROLLÓ LA ACTIVIDAD','CANTIDAD DE BENEFICIARIOS','CANTIDAD DE ORGANIZADORES','FECHA'));

                $cont=5;
                $cont2=5;

                $actividades = DB::table('actividades')
                ->where('actividades.borrado','0')
                ->where(function($query) use ($buscar){
                   $query->where('actividades.actividad','like','%'.$buscar.'%');
                   $query->orWhere('actividades.descripcion','like','%'.$buscar.'%');
                   $query->orWhere('actividades.oficinas','like','%'.$buscar.'%');
                   $query->orWhere('actividades.lugar','like','%'.$buscar.'%');
                   $query->orWhere('actividades.fecha','like','%'.$buscar.'%');
                   })
                ->orderBy('actividades.fecha')
                ->orderBy('actividades.id')
                ->select('actividades.id','actividades.actividad','actividades.descripcion','actividades.oficinas','actividades.lugar','actividades.beneficiarios','actividades.organizadores','actividades.fecha', 'actividades.activo')
                ->paginate(50);

        foreach ($actividades as $key => $dato) {
            $rango='A'.strval((intval($cont)+intval($key))).':H'.strval((intval($cont)+intval($key)));
            $sheet->setBorder($rango, 'thin');

           array_push($data, array($key+1,
           $dato->actividad,
           $dato->descripcion,
           $dato->oficinas,
           $dato->lugar,
           $dato->beneficiarios,
           $dato->organizadores,
           $dato->fecha
        
        ));
            
            $cont2++;
        }

                $sheet->fromArray($data, null, 'A1', false, false);
            
            });
            })->download('xlsx');  
   

        return response()->json(["buscar"=>$buscar,'tipo'=>$tipo]);
    }
}
