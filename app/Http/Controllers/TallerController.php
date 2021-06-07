<?php

namespace App\Http\Controllers;

use App\Taller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Semestre;
use App\Administrativo;
use App\Escuela;
use App\Facultad;
use App\Local;

use Validator;
use Auth;
use DB;

use App\Docente;
use App\Persona;
use App\Tipouser;
use App\User;

use Excel;
set_time_limit(600);

use App\Submodulo;
use App\Permisomodulo;
use App\Permisossubmodulo;


class TallerController extends Controller
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

            $escuelas = DB::table('escuelas')
            ->join('facultads', 'facultads.id', '=', 'escuelas.facultad_id')
            ->where('escuelas.borrado','0')
  
            ->orderBy('facultads.nombre')
            ->orderBy('escuelas.nombre')
            ->select('escuelas.id','escuelas.nombre','escuelas.activo','escuelas.borrado','escuelas.facultad_id','facultads.nombre as facultad')
            ->get();

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

            $submodulo=Submodulo::find(30);
            $activoModulo = 0; //Estado Cerrado sin Importar la Programacion

            if($submodulo->estado == '1'){
                $activoModulo = 1; //Estado Abierto sin Importar la Programacion
            }
            elseif($submodulo->estado == '2'){

                $h=Date('Y-m-d');
                $hoy = new DateTime($h);

                $fechaini = new DateTime($submodulo->fechaini);
                $fechafin = new DateTime($submodulo->fechafin);

                if($fechaini >$hoy){
                    $activoModulo = 2; //Estado Programado: La fecha de programacion aun no inicia
                }
                elseif($hoy >=$fechaini && $hoy<=$fechafin){
                    $activoModulo = 3; //Estado Programado: La fecha de programacion esta vigente
                }
                elseif($hoy>$fechafin){
                    $activoModulo = 4; //Estado Programado: La fecha de programacion ya finalizo
                }
            }

            $permisoModulos=Permisomodulo::where('user_id',Auth::user()->id)->get();
            $permisoSubModulos=Permisossubmodulo::where('user_id',Auth::user()->id)->get();


            $modulo="tallers";
            return view('tallers.index',compact('tipouser','modulo','escuelas','semestres','semestresel','contse','semestreNombre','submodulo','activoModulo','permisoModulos','permisoSubModulos'));
        }
        else
        {
            return redirect('home');           
        }
    }


    public function index(Request $request)
    {   
     $buscar=$request->busca;
     $semestre_id=$request->semestre_id;

    
     $tallers = DB::table('tallers')
     ->join('semestres as semestre', 'semestre.id', '=', 'tallers.semestre_id')

     ->where('tallers.borrado','0')
     ->where('semestre.id',$semestre_id)
     ->where(function($query) use ($buscar){
        $query->where('tallers.nombre','like','%'.$buscar.'%');
        $query->orwhere('tallers.descripcion','like','%'.$buscar.'%');
        $query->orwhere('tallers.docentecargo','like','%'.$buscar.'%');
        $query->orwhere('tallers.dnidocente','like','%'.$buscar.'%');

        })

     ->orderBy('tallers.nombre')
     ->orderBy('tallers.docentecargo')
     ->orderBy('tallers.id')

     ->select('tallers.id',
     'tallers.nombre','tallers.descripcion','tallers.docentecargo','tallers.dnidocente','tallers.docente_id','tallers.semestre_id')
     ->paginate(50);


     $docentes = DB::table('docentes')
     ->join('personas', 'personas.id', '=', 'docentes.persona_id')
     ->join('semestres', 'semestres.id', '=', 'docentes.semestre_id')
     ->leftjoin('facultads', 'facultads.id', '=', 'docentes.facultad_id')
     ->leftjoin('escuelas', 'escuelas.id', '=', 'docentes.escuela_id')
     ->where('docentes.borrado','0')
     ->where('semestres.id',$semestre_id)

     ->orderBy('personas.apellidopat')
     ->orderBy('personas.apellidomat')
     ->orderBy('personas.nombres')
     ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono','docentes.id',
    'docentes.personalacademico','docentes.cargogeneral','docentes.descripcioncargo','docentes.maximogrado','docentes.descmaximogrado','docentes.universidadgrado','docentes.lugarmaximogrado','docentes.paismaximogrado','docentes.otrogrado','docentes.estadootrogrado','docentes.univotrogrado','docentes.lugarotrogrado','docentes.paisotrogrado','docentes.titulo','docentes.descripciontitulo','docentes.condicion','docentes.categoria','docentes.regimen','docentes.investigador','docentes.pregrado','docentes.postgrado','docentes.esdestacado','docentes.fechaingreso','docentes.modalidadingreso','docentes.observaciones','docentes.persona_id','docentes.horaslectivas','docentes.horasnolectivas','docentes.horasinvestigacion','docentes.horasdedicacion','docentes.escuela_id','docentes.facultad_id', 'docentes.dependencia','docentes.semestre_id','semestres.nombre as semestre',DB::Raw("IFNULL( `facultads`.`nombre` , '' ) as facultad"),DB::Raw("IFNULL( `escuelas`.`nombre` , '' ) as escuela"))->get();




   


     return [
        'pagination'=>[
            'total'=> $tallers->total(),
            'current_page'=> $tallers->currentPage(),
            'per_page'=> $tallers->perPage(),
            'last_page'=> $tallers->lastPage(),
            'from'=> $tallers->firstItem(),
            'to'=> $tallers->lastItem(),
        ],
        'tallers'=>$tallers,
        'docentes'=>$docentes,
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
        $docente_id=$request->docente_id;
        $semestre_id=$request->semestre_id;


        $docentecargo="";
        $dnidocente="";


        if(intval($docente_id)>0){

            $docente=Docente::find($docente_id);
            $persona=Persona::find($docente->persona_id);
            
            $docentecargo=$persona->nombres.' '.$persona->apellidopat.' '.$persona->apellidomat;
            $dnidocente=$persona->doc;
        }
            
        $result='1';
        $msj='';
        $selector='';

  
        $input15  = array('nombre' => $nombre);
        $reglas15 = array('nombre' => 'required');
   
        $validator15 = Validator::make($input15, $reglas15);



     if ($validator15->fails()) {
            $result='0';
            $msj='Ingrese el nombre del Taller';
            $selector='txtnombre';
        }
        elseif (intval($docente_id)==0) {
            $result='0';
            $msj='Seleccione un Docente a Cargo';
            $selector='cbudocente_id';
        }
       

        else{



        $newTaller = new Taller();
        $newTaller->nombre=$nombre;
        $newTaller->descripcion=$descripcion;
        $newTaller->docentecargo=$docentecargo;
        $newTaller->dnidocente=$dnidocente;
        $newTaller->docente_id=$docente_id;
        $newTaller->semestre_id=$semestre_id;

        $newTaller->activo='1';
        $newTaller->borrado='0';

        $newTaller->save();

           

            $msj='Nuevo Taller registrado con éxito';
        }


        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Taller  $taller
     * @return \Illuminate\Http\Response
     */
    public function show(Taller $taller)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Taller  $taller
     * @return \Illuminate\Http\Response
     */
    public function edit(Taller $taller)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Taller  $taller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $nombre=$request->nombre;
        $descripcion=$request->descripcion;
        $docente_id=$request->docente_id;
        $semestre_id=$request->semestre_id;


        $docentecargo="";
        $dnidocente="";


        if(intval($docente_id)>0){

            $docente=Docente::find($docente_id);
            $persona=Persona::find($docente->persona_id);
            
            $docentecargo=$persona->nombres.' '.$persona->apellidopat.' '.$persona->apellidomat;
            $dnidocente=$persona->doc;
        }
            
        $result='1';
        $msj='';
        $selector='';

  
        $input15  = array('nombre' => $nombre);
        $reglas15 = array('nombre' => 'required');
   
        $validator15 = Validator::make($input15, $reglas15);



     if ($validator15->fails()) {
            $result='0';
            $msj='Ingrese el nombre del Taller';
            $selector='txtnombreE';
        }
        elseif (intval($docente_id)==0) {
            $result='0';
            $msj='Seleccione un Docente a Cargo';
            $selector='cbudocente_idE';
        }
       

        else{

        $newTaller =Taller::find($id);
        $newTaller->nombre=$nombre;
        $newTaller->descripcion=$descripcion;
        $newTaller->docentecargo=$docentecargo;
        $newTaller->dnidocente=$dnidocente;
        $newTaller->docente_id=$docente_id;
        $newTaller->semestre_id=$semestre_id;

        $newTaller->save();

        
            $msj='Taller modificado con éxito';
        }


        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Taller  $taller
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result='1';
        $msj='1';

        $consulta1=DB::table('participantes')
                    ->join('tallers', 'participantes.taller_id', '=', 'tallers.id')
                    ->where('tallers.id',$id)->count();

        $consulta2=DB::table('presentacions')
        ->join('tallers', 'presentacions.taller_id', '=', 'tallers.id')
        ->where('tallers.id',$id)->count();



        if($consulta1>0) {
            $result='0';
            $msj='El Taller no puede ser eliminado debido a que cuenta con registro de participantes en el, primero elimine los participantes de este taller, para luego poder eliminar el taller';
        }
        elseif($consulta2>0) {
            $result='0';
            $msj='El Taller no puede ser eliminado debido a que cuenta con registro de presentaciones en el, primero elimine las presentaciones asociadas a este taller, para luego poder eliminar el taller';
        }
        else{
        
        $borrar = Taller::findOrFail($id);
        //$task->delete();

        $borrar->borrado='1';

        $borrar->save();

        $msj='Taller eliminado exitosamente';
     }

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }


    public function descargarExcel(Request $request)
    {   
        $buscar=$request->busca;
        $semestre_id=$request->semestre_id;

        $semestre=Semestre::find($semestre_id);


        Excel::create('Talleres - '.$semestre->nombre, function($excel) use($buscar,$semestre)  {
            $excel->sheet('BD Talleres', function($sheet) use($buscar,$semestre){

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
                'C'=>'65',
                'D'=>'20',
                'E'=>'45',
                'F'=>'22'
                )
                );

                $sheet->setHeight(array
                (
                '3'=>'24'
                )
                );

                $titulo='BASE DE DATOS TALLERES - SEMESTRE '.$semestre->nombre;

                array_push($data, array(''));
                array_push($data, array(''));
                array_push($data, array($titulo));

                $sheet->setBorder('A4:F4', 'thin');
                array_push($data, array('N°','TALLER','DESCRIPCIÓN','SEMESTRE','DOCENTE A CARGO','DNI DOCENTE'));

                $cont=5;
                $cont2=5;

                $tallers = DB::table('tallers')
     ->join('semestres as semestre', 'semestre.id', '=', 'tallers.semestre_id')

     ->where('tallers.borrado','0')
     ->where('semestre.id',$semestre->id)
     ->where(function($query) use ($buscar){
        $query->where('tallers.nombre','like','%'.$buscar.'%');
        $query->orwhere('tallers.descripcion','like','%'.$buscar.'%');
        $query->orwhere('tallers.docentecargo','like','%'.$buscar.'%');
        $query->orwhere('tallers.dnidocente','like','%'.$buscar.'%');

        })

     ->orderBy('tallers.nombre')
     ->orderBy('tallers.docentecargo')
     ->orderBy('tallers.id')

     ->select('tallers.id',
     'tallers.nombre','tallers.descripcion','tallers.docentecargo','tallers.dnidocente','tallers.docente_id','tallers.semestre_id')
     ->get();

        foreach ($tallers as $key => $dato) {
            $rango='A'.strval((intval($cont)+intval($key))).':F'.strval((intval($cont)+intval($key)));
            $sheet->setBorder($rango, 'thin');


           array_push($data, array($key+1,
           $dato->nombre,
           $dato->descripcion,
           $semestre->nombre,
           $dato->docentecargo,
           $dato->dnidocente
        ));
            
            $cont2++;
        }



                $sheet->fromArray($data, null, 'A1', false, false);
            
            });
            })->download('xlsx');  
   

        return response()->json(["buscar"=>$buscar,'tipo'=>$tipo]);
    }


}
