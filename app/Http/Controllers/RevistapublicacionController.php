<?php

namespace App\Http\Controllers;

use App\Revistapublicacion;
use App\Autor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Facultad;
use App\Escuela;
use App\Modalidadadmision;
use App\Semestre;
use Validator;
use Auth;
use DB;

use App\Persona;
use App\Tipouser;
use App\User;

use Storage;
use stdClass;

use Excel;
set_time_limit(600);

use App\Submodulo;
use App\Permisomodulo;
use App\Permisossubmodulo;
class RevistapublicacionController extends Controller
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


            $submodulo=Submodulo::find(20);
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



            $modulo="revistas";
            return view('revistas.index',compact('tipouser','modulo','escuelas','submodulo','activoModulo','permisoModulos','permisoSubModulos'));
        }
        else
        {
            return redirect('home');           
        }
    }


    public function index(Request $request)
    {   
     $buscar=$request->busca;


     $revistas = DB::table('revistaspublicacions')

     ->join('escuelas', 'escuelas.id', '=', 'revistaspublicacions.escuela_id')
     ->join('facultads', 'facultads.id', '=', 'escuelas.facultad_id')
     ->where('revistaspublicacions.borrado','0')

     ->where(function($query) use ($buscar){
        $query->where('revistaspublicacions.titulo','like','%'.$buscar.'%');
        $query->orWhere('revistaspublicacions.descripcion','like','%'.$buscar.'%');
        $query->orWhere('revistaspublicacions.tipoPublicacion','like','%'.$buscar.'%');
        $query->orWhere('revistaspublicacions.numero','like','%'.$buscar.'%');
        $query->orWhere('escuelas.nombre','like','%'.$buscar.'%');
        $query->orWhere('facultads.nombre','like','%'.$buscar.'%');
        })
     ->select('revistaspublicacions.id',
    'revistaspublicacions.tipoPublicacion','revistaspublicacions.titulo','revistaspublicacions.descripcion','revistaspublicacions.escuela_id','revistaspublicacions.fechaPublicado','revistaspublicacions.indexada','revistaspublicacions.lugarIndexada','revistaspublicacions.numero','revistaspublicacions.rutadoc','revistaspublicacions.archivonombre',DB::Raw("IFNULL( `facultads`.`nombre` , '' ) as facultad"),DB::Raw("IFNULL( `escuelas`.`nombre` , '' ) as escuela"))->paginate(50); 

/* 
    $investigacions=Investigacion::paginate(50);
 */

 $revista=$revistas->items();

 $autoresRevistas = array();


 foreach ($revista as $key => $dato) {
     
    $autors=DB::table('revistaspublicacions')
    ->join('autors', 'revistaspublicacions.id', '=', 'autors.revistaspublicacion_id')
    ->join('personas', 'personas.id', '=', 'autors.persona_id')
    ->where('autors.borrado','0')
    ->where('personas.borrado','0')
    ->where('revistaspublicacions.id',$dato->id)

    ->select('autors.id',
    'autors.persona_id','autors.cargo','autors.revistaspublicacion_id','personas.nombres','personas.apellidopat','personas.apellidomat','personas.tipodoc','personas.doc')->get(); 


    foreach ($autors as $key2 => $value) {
        $autoresRevistas[]= $value;
    }


 }

     return [
        'pagination'=>[
            'total'=> $revistas->total(),
            'current_page'=> $revistas->currentPage(),
            'per_page'=> $revistas->perPage(),
            'last_page'=> $revistas->lastPage(),
            'from'=> $revistas->firstItem(),
            'to'=> $revistas->lastItem(),
        ],
        'revistas'=>$revistas,
        'autoresRevistas'=>$autoresRevistas
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
        ini_set('memory_limit','256M');

        $result='1';
        $msj='';
        $selector='';

        $titulo=$request->titulo;
        $tipoPublicacion=$request->tipoPublicacion;
        $descripcion=$request->descripcion;
        $escuela_id=$request->escuela_id;
        $fechaPublicado=$request->fechaPublicado;
        $indexada=$request->indexada;
        $lugarIndexada=$request->lugarIndexada;
        $numero=$request->numero;


        $nombreArchivo="";
        
        $archivo="";
        $file = $request->archivo;
        $segureFile=0;


        if(intval($indexada)==0)
        {
            $lugarIndexada="";
        }



        if ($request->hasFile('archivo')) { 

            $nombreArchivo=$request->archivonombre;

            $input  = array('archivo' => $file) ;
            $reglas = array('archivo' => 'required|mimes:.pdf, .doc, .docx, .xls, .xlsx, ppt, .pptx, .PDF, .DOC, .DOCX, .XLS, .XLSX, .PPT, .PTTX');
            $validator = Validator::make($input, $reglas);

            $inputNA  = array('archivonombre' => $nombreArchivo);
            $reglasNA = array('archivonombre' => 'required');
            $validatorNA = Validator::make($inputNA, $reglasNA);

            if (1==2)
            {

                $segureFile=1;
                $msj="El archivo adjunto ingresado tiene una extensión no válida, ingrese otro archivo o limpie el formulario";
                $result='0';
                $selector='archivo2';
            }
            elseif($validatorNA->fails()){
                $segureFile=1;
                $msj="Si va a registrar un archivo adjunto, debe de ingresar un nombre válido con el que se verá en el sistema";
                $result='0';
                $selector='txtArchivoAdjunto';
            }   

            else
            {   
                $fecha=Date('Y-m-d');
                $hora=Date('H-i-s');

                $nombre=$file->getClientOriginalName();
                $extension=$file->getClientOriginalExtension();
                $nuevoNombre=$nombre.$fecha.$hora.".".$extension;
                $subir=Storage::disk('revistas')->put($nuevoNombre, \File::get($file));

                if($extension=="pdf" || $extension=="doc" || $extension=="docx" || $extension=="xls" || $extension=="xlsx" || $extension=="ppt" || $extension=="pptx" || $extension=="PDF" || $extension=="DOC" || $extension=="DOCX" || $extension=="XLS" || $extension=="XLSX" || $extension=="PPT" || $extension=="PTTX")
                {


                if($subir){
                    $archivo=$nuevoNombre;
                    $nombreArchivo=$nombreArchivo;
                }
                else{
                    $msj="Error al subir el archivo adjunto, intentelo nuevamente luego";
                    $segureFile=1;
                    $result='0';
                    $selector='archivo2';
                }
            }
            else {
                $segureFile=1;
                $msj="El archivo adjunto ingresado tiene una extensión no válida, ingrese otro archivo o limpie el formulario";
                $result='0';
                $selector='archivo2';
            }
            }

        }

        if($segureFile==1){ 
            Storage::disk('revistas')->delete($archivo);
        }
        else{



            $input1  = array('titulo' => $titulo);
            $reglas1 = array('titulo' => 'required');

            $input2  = array('tipoPublicacion' => $tipoPublicacion);
            $reglas2 = array('tipoPublicacion' => 'required');

            $input3  = array('numero' => $numero);
            $reglas3 = array('numero' => 'required');

            $input4  = array('fechaPublicado' => $fechaPublicado);
            $reglas4 = array('fechaPublicado' => 'required');

            $input5  = array('lugarIndexada' => $lugarIndexada);
            $reglas5 = array('lugarIndexada' => 'required');


            $validator1 = Validator::make($input1, $reglas1);
            $validator2 = Validator::make($input2, $reglas2);
            $validator3 = Validator::make($input3, $reglas3);
            $validator4 = Validator::make($input4, $reglas4);
            $validator5 = Validator::make($input5, $reglas5);


            if ($validator1->fails())
            {
                $result='0';
                $msj='Ingrese el título de la Revista o Publicación';
                $selector='txttitulo';
            }elseif ($validator2->fails()) {
                $result='0';
                $msj='Ingrese el Tipo de Publicación';
                $selector='txttipoPublicacion';
            }elseif ($validator3->fails()) {
                $result='0';
                $msj='Ingrese el Número de la Revista o Publicación';
                $selector='txtnumero';
            }
            elseif ($validator4->fails()) {
                $result='0';
                $msj='Ingrese la fecha de publicación';
                $selector='txtfechaPublicado';
            }
          
            elseif ($validator5->fails() && intval($indexada)==1) {
                $result='0';
                $msj='Ingrese el Lugar de Indexación';
                $selector='txtlugarIndexada';
            }
            elseif (intval($escuela_id)==0) {
                $result='0';
                $msj='Seleccione una Escuela Profesional Válida';
                $selector='cbuescuela_id';
            }
            else{
 
    
                    $newRevista = new Revistapublicacion();

                    $newRevista->tipoPublicacion=$tipoPublicacion;
                    $newRevista->titulo=$titulo;
                    $newRevista->descripcion=$descripcion;
                    $newRevista->escuela_id=$escuela_id;
                    $newRevista->fechaPublicado=$fechaPublicado;
                    $newRevista->indexada=$indexada;
                    $newRevista->lugarIndexada=$lugarIndexada;
                    $newRevista->numero=$numero;
                    $newRevista->rutadoc=$archivo;
                    $newRevista->archivonombre=$nombreArchivo;
      
                    $newRevista->activo='1';
                    $newRevista->borrado='0';                   

                    $newRevista->save();

                    $msj='Nuevo Registro de Revista o Publicación registrado con éxito';
                }
            }


    return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
}

    /**
     * Display the specified resource.
     *
     * @param  \App\Revistapublicacion  $revistapublicacion
     * @return \Illuminate\Http\Response
     */
    public function show(Revistapublicacion $revistapublicacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Revistapublicacion  $revistapublicacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Revistapublicacion $revistapublicacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Revistapublicacion  $revistapublicacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $result='1';
       $msj='';
       $selector='';

       $titulo=$request->titulo;
       $tipoPublicacion=$request->tipoPublicacion;
       $descripcion=$request->descripcion;
       $escuela_id=$request->escuela_id;
       $fechaPublicado=$request->fechaPublicado;
       $indexada=$request->indexada;
       $lugarIndexada=$request->lugarIndexada;
       $numero=$request->numero;
       $rutadoc=$request->rutadoc;

        $archivo=$request->rutadoc;
        $file = $request->archivo;
        $segureFile=0;

        $nombreArchivo="";

        $oldFile=$request->oldfile;

        if(strlen($oldFile)>0)
        {
            $nombreArchivo=$request->archivonombre;
        }

        if(intval($indexada)==0)
        {
            $lugarIndexada="";
        }

       if ($request->hasFile('archivo')) { 

        $nombreArchivo=$request->archivonombre;

        $input  = array('file' => $file) ;
        $reglas = array('file' => 'required|mimes:png,jpg,jpeg,gif,jpe,PNG,JPG,JPEG,GIF,JPE,doc,xls,ppt,pptx,pdf,txt,DOC,XLS,PPT,PPTX,PDF,TXT');
        $validator = Validator::make($input, $reglas);

        $inputNA  = array('archivonombre' => $nombreArchivo);
        $reglasNA = array('archivonombre' => 'required');
        $validatorNA = Validator::make($inputNA, $reglasNA);

        if (1==2)
        {

            $segureFile=1;
            $msj="El archivo ingresado no es válido, ingrese otro archivo o limpie el formulario";
            $result='0';
            $selector='archivo2E';
        }

        elseif($validatorNA->fails()){
            $segureFile=1;
            $msj="Si va a registrar un archivo adjunto, debe de ingresar un nombre válido con el que se verá en el sistema";
            $result='0';
            $selector='txtArchivoAdjuntoE';
        }

        else
        {   
                $fecha=Date('Y-m-d');
                $hora=Date('H-i-s');

            $nombre=$file->getClientOriginalName();
            $extension=$file->getClientOriginalExtension();
            $nuevoNombre=$nombre.$fecha.$hora.".".$extension;
            $subir=Storage::disk('revistas')->put($nuevoNombre, \File::get($file));

            if($extension=="pdf" || $extension=="doc" || $extension=="docx" || $extension=="xls" || $extension=="xlsx" || $extension=="ppt" || $extension=="pptx" || $extension=="PDF" || $extension=="DOC" || $extension=="DOCX" || $extension=="XLS" || $extension=="XLSX" || $extension=="PPT" || $extension=="PTTX")
            {

            if($subir){
                $archivo=$nuevoNombre;

                if(strlen($oldFile)>0){
                    Storage::disk('revistas')->delete($oldFile);
                }
            }
            else{
                $msj="Error al subir el archivo adjunto, intentelo nuevamente luego";
                    $segureFile=1;
                    $result='0';
                    $selector='archivo2E';
            }
        }
            else {
                $segureFile=1;
                $msj="El archivo adjunto ingresado tiene una extensión no válida, ingrese otro archivo o limpie el formulario";
                $result='0';
                $selector='archivo2E';
            }
        

        }
    }

    if($segureFile==1){ 
        Storage::disk('revsita')->delete($archivo);
    }
    else
    {
        $input1  = array('titulo' => $titulo);
        $reglas1 = array('titulo' => 'required');

        $input2  = array('tipoPublicacion' => $tipoPublicacion);
        $reglas2 = array('tipoPublicacion' => 'required');

        $input3  = array('numero' => $numero);
        $reglas3 = array('numero' => 'required');

        $input4  = array('fechaPublicado' => $fechaPublicado);
        $reglas4 = array('fechaPublicado' => 'required');

        $input5  = array('lugarIndexada' => $lugarIndexada);
        $reglas5 = array('lugarIndexada' => 'required');


        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);
        $validator5 = Validator::make($input5, $reglas5);


        if ($validator1->fails())
        {
            $result='0';
            $msj='Ingrese el título de la Revista o Publicación';
            $selector='txttituloE';
        }elseif ($validator2->fails()) {
            $result='0';
            $msj='Ingrese el Tipo de Publicación';
            $selector='txttipoPublicacionE';
        }elseif ($validator3->fails()) {
            $result='0';
            $msj='Ingrese el Número de la Revista o Publicación';
            $selector='txtnumeroE';
        }
        elseif ($validator4->fails()) {
            $result='0';
            $msj='Ingrese la fecha de publicación';
            $selector='txtfechaPublicadoE';
        }
      
        elseif ($validator5->fails() && intval($indexada)==1) {
            $result='0';
            $msj='Ingrese el Lugar de Indexación';
            $selector='txtlugarIndexadaE';
        }
        elseif (intval($escuela_id)==0) {
            $result='0';
            $msj='Seleccione una Escuela Profesional Válida';
            $selector='cbuescuela_idE';
        }

  
     
            else
            {


                $editRevista = Revistapublicacion::find($id);

                    $editRevista->tipoPublicacion=$tipoPublicacion;
                    $editRevista->titulo=$titulo;
                    $editRevista->descripcion=$descripcion;
                    $editRevista->escuela_id=$escuela_id;
                    $editRevista->fechaPublicado=$fechaPublicado;
                    $editRevista->indexada=$indexada;
                    $editRevista->lugarIndexada=$lugarIndexada;
                    $editRevista->numero=$numero;
                    $editRevista->rutadoc=$archivo;
                    $editRevista->archivonombre=$nombreArchivo;    

                $editRevista->save();

          $msj='Registro de Revista o Publicación modificado con éxito';

      }

  }

  return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
  }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Revistapublicacion  $revistapublicacion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result='1';
        $msj='1';

        $consulta1=DB::table('detalleinvestigacions')
                    ->join('investigacions', 'detalleinvestigacions.investigacion_id', '=', 'investigacions.id')
                    ->where('investigacions.id',$id)->count();





        if($consulta1>0) {
            $result='0';
            $msj='La Revista o Publicación no se puede eliminar debido a que cuenta con registros de autores asociadas a ella, primero elimine el registro de autores de la publicación, para poder eliminarla';
        }
 
        else{
        
        $borrar =Revistapublicacion::findOrFail($id);
        //$task->delete();

        $borrar->borrado='1';

        $borrar->save();

        $msj='Registro de Revista o Publicación eliminado exitosamente';
     }

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }

  






    public function descargarExcel(Request $request)
    {   
        $buscar=$request->busca;
        $tipo=$request->tipo;

        Excel::create('Revistas Publicaciones UNASAM', function($excel) use($buscar)  {
            $excel->sheet('BD de Publicaciones', function($sheet) use($buscar){

                $sheet->setAutoSize(true);
                /* $sheet->mergeCells('B1:D1');
                $sheet->mergeCells('B2:H2'); */

                $sheet->mergeCells('A3:K3');
                $sheet->cells('A3:K3',function($cells)
                {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
                $sheet->setBorder('A3:k3', 'thin');
                $sheet->cells('A3:k3', function($cells)
                {
                    $cells->setBackground('#0C73E8');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontSize(15);

                    #Borders
                });
                
                $sheet->cells('A4:k4', function($cells)
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
                'D'=>'30',
                'E'=>'55',
                'F'=>'25',
                'G'=>'85',
                'H'=>'65',
                'I'=>'25',
                'J'=>'15',
                'K'=>'45'

                )
                );

                $sheet->setHeight(array
                (
                '3'=>'24'
                )
                );

                $titulo='BASE DE DATOS DE REVISTAS Y PUBLICACIONES - UNASAM';

                array_push($data, array(''));
                array_push($data, array(''));
                array_push($data, array($titulo));

                $sheet->setBorder('A4:k4', 'thin');
                array_push($data, array('N°','FACULTAD', 'ESCUELA PROFESIONAL','TIPO DE PUBLICACIÓN','TÍTULO','NÚMERO','AUTORES','DESCRIPCIÓN','FECHA DE PUBLICACIÓN','INDEXADA','LUGAR DE INDEXACIÓN'));

                $cont=5;
                $cont2=5;

                $revistas = DB::table('revistaspublicacions')

                ->join('escuelas', 'escuelas.id', '=', 'revistaspublicacions.escuela_id')
                ->join('facultads', 'facultads.id', '=', 'escuelas.facultad_id')
                ->where('revistaspublicacions.borrado','0')
           
                ->where(function($query) use ($buscar){
                   $query->where('revistaspublicacions.titulo','like','%'.$buscar.'%');
                   $query->orWhere('revistaspublicacions.descripcion','like','%'.$buscar.'%');
                   $query->orWhere('revistaspublicacions.tipoPublicacion','like','%'.$buscar.'%');
                   $query->orWhere('revistaspublicacions.numero','like','%'.$buscar.'%');
                   $query->orWhere('escuelas.nombre','like','%'.$buscar.'%');
                   $query->orWhere('facultads.nombre','like','%'.$buscar.'%');
                   })
                ->select('revistaspublicacions.id',
               'revistaspublicacions.tipoPublicacion','revistaspublicacions.titulo','revistaspublicacions.descripcion','revistaspublicacions.escuela_id','revistaspublicacions.fechaPublicado','revistaspublicacions.indexada','revistaspublicacions.lugarIndexada','revistaspublicacions.numero','revistaspublicacions.rutadoc','revistaspublicacions.archivonombre',DB::Raw("IFNULL( `facultads`.`nombre` , '' ) as facultad"),DB::Raw("IFNULL( `escuelas`.`nombre` , '' ) as escuela"))->get(); 

        foreach ($revistas as $key => $dato) {
            $rango='A'.strval((intval($cont)+intval($key))).':k'.strval((intval($cont)+intval($key)));
            $sheet->setBorder($rango, 'thin');

/*
array_push($data, array('N°','FACULTAD', 'ESCUELA PROFESIONAL','TIPO DE PUBLICACIÓN','TÍTULO','NÚMERO','AUTORES','DESCRIPCIÓN','FECHA DE PUBLICACIÓN','INDEXADA','LUGAR DE INDEXACIÓN'));
*/

$autores="";
$autoresRegis = DB::table('personas')
     ->join('autors', 'personas.id', '=', 'autors.persona_id')
     ->join('revistaspublicacions', 'revistaspublicacions.id', '=', 'autors.revistaspublicacion_id')
     ->where('autors.borrado','0')
     ->where('revistaspublicacions.id',$dato->id)

     ->orderBy('personas.apellidopat')
     ->orderBy('personas.apellidomat')
     ->orderBy('personas.nombres')
     ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono','autors.id','autors.cargo','autors.persona_id','autors.revistaspublicacion_id')->get();


    foreach ($autoresRegis as $keyAutor => $datoAutor) {
        $autores.=$datoAutor->cargo.' '.$datoAutor->doc.' '.$datoAutor->apellidopat.' '.$datoAutor->apellidomat.' '.$datoAutor->nombres.'. ';
    }

           array_push($data, array($key+1,
           $dato->facultad,
           $dato->escuela,
           $dato->tipoPublicacion,
           $dato->titulo,
           $dato->numero,
           $autores,
           $dato->descripcion,
           pasFechaVista($dato->fechaPublicado),
           SiUnoNoCero($dato->indexada),
           $dato->lugarIndexada        
        ));
            
            $cont2++;
        }



                $sheet->fromArray($data, null, 'A1', false, false);
            
            });
            })->download('xlsx');  
   

        return response()->json(["buscar"=>$buscar,'tipo'=>$tipo]);
    }
}
