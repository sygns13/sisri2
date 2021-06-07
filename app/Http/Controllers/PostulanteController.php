<?php

namespace App\Http\Controllers;

use App\Postulante;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



use App\Escuela;
use App\Modalidadadmision;
use App\Semestre;
use Validator;
use Auth;
use DB;

use App\Persona;
use App\Tipouser;
use App\User;


use Excel;
set_time_limit(600);

use Storage;
use DateTime;

use App\Submodulo;
use App\Permisomodulo;
use App\Permisossubmodulo;

class PostulanteController extends Controller
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
            $modalidadAdmision=Modalidadadmision::where('activo','1')->where('borrado','0')->get();

            $submodulo=Submodulo::find(6);
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


            $modulo="postulantes";
            return view('postulantes.index',compact('tipouser','modulo','escuelas','semestres','modalidadAdmision','semestresel','contse','semestreNombre','submodulo','activoModulo','permisoModulos','permisoSubModulos'));
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

            $escuelas = DB::table('escuelas')
            ->join('facultads', 'facultads.id', '=', 'escuelas.facultad_id')
            ->where('escuelas.borrado','0')
  
            ->orderBy('facultads.nombre')
            ->orderBy('escuelas.nombre')
            ->select('escuelas.id','escuelas.nombre','escuelas.activo','escuelas.borrado','escuelas.facultad_id','facultads.nombre as facultad')
            ->get();

            $semestres=Semestre::where('activo','1')->where('borrado','0')->orderBy('fechafin','desc')->get();
            $modalidadAdmision=Modalidadadmision::where('activo','1')->where('borrado','0')->get();

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

            $submodulo=Submodulo::find(9);
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


            $modulo="postulantespostgrado";
            return view('postulantespostgrado.index',compact('tipouser','modulo','escuelas','semestres','modalidadAdmision','semestresel','contse','semestreNombre','submodulo','activoModulo','permisoModulos','permisoSubModulos'));
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
     $tipo=$request->tipo;

     $postulantes="";

     if($tipo==1)
     {
        $postulantes = DB::table('postulantes')
        ->join('personas', 'personas.id', '=', 'postulantes.persona_id')
        ->join('semestres', 'semestres.id', '=', 'postulantes.semestre_id')
        ->join('modalidadadmisions', 'modalidadadmisions.id', '=', 'postulantes.modalidadadmision_id')
        ->join('escuelas as escuela1', 'escuela1.id', '=', 'postulantes.escuela_id')
        ->leftjoin('escuelas as escuela2', 'escuela2.id', '=', 'postulantes.escuela_id2')
        ->leftjoin('escuelas as escuelaing', 'escuelaing.id', '=', 'postulantes.opcioningreso')
        ->where('postulantes.borrado','0')
        ->where('postulantes.tipo',$tipo)
        ->where('semestres.id',$semestre_id)
        ->where(function($query) use ($buscar){
           $query->where('personas.nombres','like','%'.$buscar.'%');
           $query->orWhere('personas.apellidopat','like','%'.$buscar.'%');
           $query->orWhere('personas.apellidomat','like','%'.$buscar.'%');
           $query->orWhere('personas.doc','like','%'.$buscar.'%');
           $query->orWhere('postulantes.codigo','like','%'.$buscar.'%');
           })
        ->orderBy('personas.apellidopat')
        ->orderBy('personas.apellidomat')
        ->orderBy('personas.nombres')
        ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono','postulantes.id','postulantes.codigo','postulantes.semestre_id','postulantes.escuela_id','postulantes.colegio','postulantes.modalidadadmision_id','postulantes.modalidadestudios','postulantes.puntaje','postulantes.estado','postulantes.opcioningreso','postulantes.persona_id','postulantes.observaciones','postulantes.tipo','postulantes.email','postulantes.escuela_id2','postulantes.tipogestioncolegio','postulantes.opcioningreso','semestres.nombre as semestre','modalidadadmisions.id as idmodadmi','modalidadadmisions.nombre as modalidadadmision','escuela1.nombre as escuela1',DB::Raw("IFNULL( `escuela2`.`nombre` , 'No hubo 2° Opción' ) as escuela2"),DB::Raw("IFNULL( `escuelaing`.`nombre` , 'No Ingresó' ) as escuelaing"),'postulantes.grado','postulantes.nombreGrado','postulantes.universidadCulminoPregrado')
        ->paginate(50);
     }

     elseif($tipo==2)
     {
        $postulantes = DB::table('postulantes')
        ->join('personas', 'personas.id', '=', 'postulantes.persona_id')
        ->join('semestres', 'semestres.id', '=', 'postulantes.semestre_id')
        ->join('modalidadadmisions', 'modalidadadmisions.id', '=', 'postulantes.modalidadadmision_id')

        ->where('postulantes.borrado','0')
        ->where('postulantes.tipo',$tipo)
        ->where('semestres.id',$semestre_id)
        ->where(function($query) use ($buscar){
           $query->where('personas.nombres','like','%'.$buscar.'%');
           $query->orWhere('personas.apellidopat','like','%'.$buscar.'%');
           $query->orWhere('personas.apellidomat','like','%'.$buscar.'%');
           $query->orWhere('personas.doc','like','%'.$buscar.'%');
           $query->orWhere('postulantes.codigo','like','%'.$buscar.'%');
           })
        ->orderBy('personas.apellidopat')
        ->orderBy('personas.apellidomat')
        ->orderBy('personas.nombres')
        ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono','postulantes.id','postulantes.codigo','postulantes.semestre_id','postulantes.escuela_id','postulantes.colegio','postulantes.modalidadadmision_id','postulantes.modalidadestudios','postulantes.puntaje','postulantes.estado','postulantes.opcioningreso','postulantes.persona_id','postulantes.observaciones','postulantes.tipo','postulantes.email','postulantes.escuela_id2','postulantes.tipogestioncolegio','postulantes.opcioningreso','semestres.nombre as semestre','modalidadadmisions.id as idmodadmi','modalidadadmisions.nombre as modalidadadmision','postulantes.grado','postulantes.nombreGrado','postulantes.universidadCulminoPregrado')
        ->paginate(50);
     }



     return [
        'pagination'=>[
            'total'=> $postulantes->total(),
            'current_page'=> $postulantes->currentPage(),
            'per_page'=> $postulantes->perPage(),
            'last_page'=> $postulantes->lastPage(),
            'from'=> $postulantes->firstItem(),
            'to'=> $postulantes->lastItem(),
        ],
        'postulantes'=>$postulantes
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

        $tipodoc=$request->tipodoc;
        $doc=$request->doc;
        $nombres=$request->nombres;
        $apellidopat=$request->apellidopat;
        $apellidomat=$request->apellidomat;
        $genero=$request->genero;
        $estadocivil=$request->estadocivil;
        $fechanac=$request->fechanac;
        $esdiscapacitado=$request->esdiscapacitado;
        $discapacidad=$request->discapacidad;
        $pais=$request->pais;
        $departamento=$request->departamento;
        $provincia=$request->provincia;
        $distrito=$request->distrito;
        $direccion=$request->direccion;
        $email=$request->email;
        $telefono=$request->telefono;
        $codigo=$request->codigo;
        $semestre_id=$request->semestre_id;
        $escuela_id=$request->escuela_id;
        $colegio=$request->colegio;
        $modalidadadmision_id=$request->modalidadadmision_id;
        $modalidadestudios=$request->modalidadestudios;
        $puntaje=$request->puntaje;
        $estado=$request->estado;
        $opcioningreso=$request->opcioningreso;
        $observaciones=$request->observaciones;
        $escuela_id2=$request->escuela_id2;
        $tipogestioncolegio=$request->tipogestioncolegio;
        $persona_id=$request->persona_id;
        $tipo=$request->tipo;


        if(intval($esdiscapacitado)==0)
        {
            $discapacidad="";
        }

        $grado=0;
        $nombreGrado="";
        $universidadCulminoPregrado="";

        if(intval($tipo)==2)
        {
            $grado=$request->grado;
            $nombreGrado=$request->nombreGrado;
            $universidadCulminoPregrado=$request->universidadCulminoPregrado;
        }


        $result='1';
        $msj='';
        $selector='';


        $regla0=DB::table('postulantes')
        ->join('personas', 'personas.id', '=', 'postulantes.persona_id')
        ->where('personas.tipodoc',$tipodoc)
        ->where('personas.doc',$doc)
        ->where('postulantes.tipo',$tipo)
        ->where('postulantes.semestre_id',$semestre_id)
        ->where('postulantes.modalidadadmision_id',$modalidadadmision_id)->count();

        $input1  = array('tipodoc' => $tipodoc);
        $reglas1 = array('tipodoc' => 'required');

        $input2  = array('doc' => $doc);
        $reglas2 = array('doc' => 'required');

        $input3  = array('nombres' => $nombres);
        $reglas3 = array('nombres' => 'required');

        $input4  = array('apellidopat' => $apellidopat);
        $reglas4 = array('apellidopat' => 'required');

        $input5  = array('apellidomat' => $apellidomat);
        $reglas5 = array('apellidomat' => 'required');

        $input6  = array('genero' => $genero);
        $reglas6 = array('genero' => 'required');

        $input7  = array('estadocivil' => $estadocivil);
        $reglas7 = array('estadocivil' => 'required');

        $input8  = array('fechanac' => $fechanac);
        $reglas8 = array('fechanac' => 'required');

        $input9  = array('esdiscapacitado' => $esdiscapacitado);
        $reglas9 = array('esdiscapacitado' => 'required');

        $input10  = array('pais' => $pais);
        $reglas10 = array('pais' => 'required');

        $input11  = array('departamento' => $departamento);
        $reglas11 = array('departamento' => 'required');

        $input12  = array('provincia' => $provincia);
        $reglas12 = array('provincia' => 'required');

        $input13  = array('distrito' => $distrito);
        $reglas13 = array('distrito' => 'required');

        $input14  = array('direccion' => $direccion);
        $reglas14 = array('direccion' => 'required');

        $input15  = array('codigo' => $codigo);
        $reglas15 = array('codigo' => 'required');

        $input16  = array('semestre_id' => $semestre_id);
        $reglas16 = array('semestre_id' => 'required');

        $input17  = array('escuela_id' => $escuela_id);
        $reglas17 = array('escuela_id' => 'required');

        $input18  = array('colegio' => $colegio);
        $reglas18 = array('colegio' => 'required');

        $input19  = array('modalidadadmision_id' => $modalidadadmision_id);
        $reglas19 = array('modalidadadmision_id' => 'required');

        $input20  = array('modalidadestudios' => $modalidadestudios);
        $reglas20 = array('modalidadestudios' => 'required');

        $input21  = array('puntaje' => $puntaje);
        $reglas21 = array('puntaje' => 'required');

        $input22  = array('estado' => $estado);
        $reglas22 = array('estado' => 'required');

        $input23  = array('tipogestioncolegio' => $tipogestioncolegio);
        $reglas23 = array('tipogestioncolegio' => 'required');



        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);
        $validator5 = Validator::make($input5, $reglas5);
        $validator6 = Validator::make($input6, $reglas6);
        $validator7 = Validator::make($input7, $reglas7);
        $validator8 = Validator::make($input8, $reglas8);
        $validator9 = Validator::make($input9, $reglas9);
        $validator10 = Validator::make($input10, $reglas10);
        $validator11 = Validator::make($input11, $reglas11);
        $validator12 = Validator::make($input12, $reglas12);
        $validator13 = Validator::make($input13, $reglas13);
        $validator14 = Validator::make($input14, $reglas14);
        $validator15 = Validator::make($input15, $reglas15);
        $validator16 = Validator::make($input16, $reglas16);
        $validator17 = Validator::make($input17, $reglas17);
        $validator18 = Validator::make($input18, $reglas18);
        $validator19 = Validator::make($input19, $reglas19);
        $validator20 = Validator::make($input20, $reglas20);
        $validator21 = Validator::make($input21, $reglas21);
        $validator22 = Validator::make($input22, $reglas22);
        $validator23 = Validator::make($input23, $reglas23);

        if($regla0>0){
            $result='0';
            $msj='Ya se encuentra registrado un Postulante con el Tipo y Documento de Identidad ingresado, del semestre y modalidad de admisión seleccionada';
            $selector='txtDNI';
        }
        elseif($validator1->fails()){
            $result='0';
            $msj='Seleccione un tipo de Documento Válido';
            $selector='cbutipodoc';
        }
        elseif ($validator2->fails())
        {
            $result='0';
            $msj='Complete el Documento de Identidad del Postulante';
            $selector='txtDNI';

        }
        elseif (strlen($doc)<8)
        {
            $result='0';
            $msj='Complete un N° de Documento de Identidad Válido';
            $selector='txtDNI';

        }
        elseif ($validator3->fails()) {
            $result='0';
            $msj='Ingrese los nombres del Postulante';
            $selector='txtnombres';
        }
        elseif ($validator4->fails()) {
            $result='0';
            $msj='Ingrese el apellido paterno del Postulante';
            $selector='txtapepat';
        }
        elseif ($validator5->fails()) {
            $result='0';
            $msj='Ingrese el apellido materno del Postulante';
            $selector='txtapemat';
        }
        elseif ($validator6->fails()) {
            $result='0';
            $msj='Seleccione el Género del Postulante';
            $selector='cbugenero';
        }
        elseif ($validator7->fails()) {
            $result='0';
            $msj='Seleccione el Estado Civil del Postulante';
            $selector='cbuestadocivil';
        }
        elseif ($validator8->fails()) {
            $result='0';
            $msj='Ingrese la Fecha de Nacimiento del Postulante';
            $selector='txtfechanac';
        }
        elseif ($validator9->fails()) {
            $result='0';
            $msj='Seleccione si el Postulante es Discapacitado';
            $selector='cbugenero';
        }
        elseif (intval($esdiscapacitado)==1 && strlen($discapacidad)==0) {
            $result='0';
            $msj='Si ha indicado que el Postulante es discapacitado, ingrese la discapacidad que padece';
            $selector='txtdiscapacidad';
        }

        elseif ($validator10->fails()) {
            $result='0';
            $msj='Ingrese el País de procedencia del Postulante';
            $selector='txtpais';
        }
        elseif ($validator11->fails()) {
            $result='0';
            $msj='Ingrese el Departamento de procedencia del Postulante';
            $selector='txtdep';
        }
        elseif ($validator12->fails()) {
            $result='0';
            $msj='Ingrese la Provincia de procedencia del Postulante';
            $selector='txtprov';
        }
        elseif ($validator13->fails()) {
            $result='0';
            $msj='Ingrese el Distrito de procedencia del Postulante';
            $selector='txtdist';
        }
        elseif ($validator14->fails()) {
            $result='0';
            $msj='Ingrese la Dirección del Postulante';
            $selector='txtDir';
        }
        elseif ($validator15->fails()) {
            $result='0';
            $msj='Ingrese el Código del Postulante';
            $selector='txtcodigo';
        }
        elseif ($validator16->fails()) {
            $result='0';
            $msj='Seleccione el Semestre de Postulación del Postulante';
            $selector='cbusemestre';
        }
        elseif (($validator17->fails() || intval($escuela_id)==0) && intval($tipo)==1) {
            $result='0';
            $msj='Seleccione el Programa Profesional de primera opción del postulante';
            $selector='cbucarrera1';
        }
        elseif ($validator18->fails() && intval($tipo)==1) {
            $result='0';
            $msj='Ingrese el Colegio de Procedencia del Postulante';
            $selector='txtcolegio';
        }
        elseif ($validator19->fails() || intval($modalidadadmision_id)==0) {
            $result='0';
            $msj='Seleccione la Modalidad de Admisión del Postulante';
            $selector='cbumodalidadadmision';
        }
        elseif ($validator20->fails() || intval($modalidadestudios)==0) {
            $result='0';
            $msj='Seleccione la Modalidad de Estudios del Postulante';
            $selector='cbumodalidadestudios';
        }

        elseif ($validator21->fails()) {
            $result='0';
            $msj='Ingrese el Puntaje que obtuvo el postulante';
            $selector='txtpuntaje';
        }
        elseif ($validator22->fails()) {
            $result='0';
            $msj='Ingrese el estado de Ingreso del postulante';
            $selector='cbuestadoingreso';
        }
        elseif ($validator23->fails() && intval($tipo)==1) {
            $result='0';
            $msj='Seleccione el tipo de Gestión Administrativa del Colegio de Procedencia del Postulante';
            $selector='cbutipogestion';
        }

        elseif (intval($estado)==1 && intval($opcioningreso)==0 && intval($tipo)==1) {
            $result='0';
            $msj='Si ha seleccionado que el postulante ingresó a un Programa Profesional, indicar a cual fue';
            $selector='cbucarreraing';
        }

        elseif (intval($tipo)==2 && strlen($nombreGrado)==0) {
            $result='0';
            $msj='Ingrese el nombre y mensión del Grado al que Postula';
            $selector='txtgrado';
        }

        elseif (intval($tipo)==2 && strlen($universidadCulminoPregrado)==0) {
            $result='0';
            $msj='Ingrese el nombre de la Universidad en la que Culminó su Pregrado';
            $selector='txtuniversidadterminoestudios';
        }

      
        else{



            /*      
            
            $grado=$request->grado;
            $nombreGrado=$request->nombreGrado;
            $universidadCulminoPregrado=$request->universidadCulminoPregrado;


        $tipodoc=$request->tipodoc;
        $doc=$request->doc;
        $nombres=$request->nombres;
        $apellidopat=$request->apellidopat;
        $apellidomat=$request->apellidomat;
        $genero=$request->genero;
        $estadocivil=$request->estadocivil;
        $fechanac=$request->fechanac;
        $esdiscapacitado=$request->esdiscapacitado;
        $discapacidad=$request->discapacidad;
        $pais=$request->pais;
        $departamento=$request->departamento;
        $provincia=$request->provincia;
        $distrito=$request->distrito;
        $direccion=$request->direccion;
        $email=$request->email;
        $telefono=$request->telefono;
        $codigo=$request->codigo;
        $semestre_id=$request->semestre_id;
        $escuela_id=$request->escuela_id;
        $colegio=$request->colegio;
        $modalidadadmision_id=$request->modalidadadmision_id;
        $modalidadestudios=$request->modalidadestudios;
        $puntaje=$request->puntaje;
        $estado=$request->estado;
        $opcioningreso=$request->opcioningreso;
        $observaciones=$request->observaciones;
        $escuela_id2=$request->escuela_id2;
        $tipogestioncolegio=$request->tipogestioncolegio;
        $persona_id=$request->persona_id;
        
        */

        if(intval($persona_id)!=0)
        {
            $editPersona =Persona::find($persona_id);
            $editPersona->tipodoc=$tipodoc;
            $editPersona->doc=$doc;
            $editPersona->nombres=$nombres;
            $editPersona->apellidopat=$apellidopat;
            $editPersona->apellidomat=$apellidomat;
            $editPersona->genero=$genero;
            $editPersona->estadocivil=$estadocivil;
            $editPersona->fechanac=$fechanac;
            $editPersona->esdiscapacitado=$esdiscapacitado;
            $editPersona->discapacidad=$discapacidad;
            $editPersona->pais=$pais;
            $editPersona->departamento=$departamento;
            $editPersona->provincia=$provincia;
            $editPersona->distrito=$distrito;
            $editPersona->direccion=$direccion;
            $editPersona->email=$email;
            $editPersona->telefono=$telefono;

            $editPersona->save();
        }
        else{
            $newPersona = new Persona();
            $newPersona->tipodoc=$tipodoc;
            $newPersona->doc=$doc;
            $newPersona->nombres=$nombres;
            $newPersona->apellidopat=$apellidopat;
            $newPersona->apellidomat=$apellidomat;
            $newPersona->genero=$genero;
            $newPersona->estadocivil=$estadocivil;
            $newPersona->fechanac=$fechanac;
            $newPersona->esdiscapacitado=$esdiscapacitado;
            $newPersona->discapacidad=$discapacidad;
            $newPersona->pais=$pais;
            $newPersona->departamento=$departamento;
            $newPersona->provincia=$provincia;
            $newPersona->distrito=$distrito;
            $newPersona->direccion=$direccion;
            $newPersona->email=$email;
            $newPersona->telefono=$telefono;
            $newPersona->activo='1';
            $newPersona->borrado='0';

            $newPersona->save();

            $persona_id=$newPersona->id;
        }


        if($tipo==1)
        {
            $newPostulante = new Postulante();
        $newPostulante->codigo=$codigo;
        $newPostulante->semestre_id=$semestre_id;
        $newPostulante->escuela_id=$escuela_id;
        $newPostulante->colegio=$colegio;
        $newPostulante->modalidadadmision_id=$modalidadadmision_id;
        $newPostulante->modalidadestudios=$modalidadestudios;
        $newPostulante->puntaje=$puntaje;
        $newPostulante->estado=$estado;
        $newPostulante->opcioningreso=$opcioningreso;
        $newPostulante->persona_id=$persona_id;
        $newPostulante->observaciones=$observaciones;
        $newPostulante->tipo=$tipo;
        $newPostulante->email=$email;
        $newPostulante->escuela_id2=$escuela_id2;
        $newPostulante->tipogestioncolegio=$tipogestioncolegio;

        $newPostulante->activo='1';
        $newPostulante->borrado='0';

        $newPostulante->save();
        }
        elseif($tipo==2)
        {
            $newPostulante = new Postulante();
        $newPostulante->codigo=$codigo;
        $newPostulante->semestre_id=$semestre_id;
        $newPostulante->modalidadadmision_id=$modalidadadmision_id;
        $newPostulante->modalidadestudios=$modalidadestudios;
        $newPostulante->puntaje=$puntaje;
        $newPostulante->estado=$estado;
        $newPostulante->persona_id=$persona_id;
        $newPostulante->observaciones=$observaciones;
        $newPostulante->tipo=$tipo;
        $newPostulante->email=$email;
        $newPostulante->grado=$grado;
        $newPostulante->nombreGrado=$nombreGrado;
        $newPostulante->universidadCulminoPregrado=$universidadCulminoPregrado;
        $newPostulante->activo='1';
        $newPostulante->borrado='0';

        $newPostulante->save();
        }
        

           

            $msj='Nuevo Postulante registrado con éxito';
        }


/*
        $grado=$request->grado;
            $nombreGrado=$request->nombreGrado;
            $universidadCulminoPregrado=$request->universidadCulminoPregrado;
*/

       //Areaunasam::create($request->all());

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Postulante  $postulante
     * @return \Illuminate\Http\Response
     */
    public function show(Postulante $postulante)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Postulante  $postulante
     * @return \Illuminate\Http\Response
     */
    public function edit(Postulante $postulante)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Postulante  $postulante
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tipodoc=$request->tipodoc;
        $doc=$request->doc;
        $nombres=$request->nombres;
        $apellidopat=$request->apellidopat;
        $apellidomat=$request->apellidomat;
        $genero=$request->genero;
        $estadocivil=$request->estadocivil;
        $fechanac=$request->fechanac;
        $esdiscapacitado=$request->esdiscapacitado;
        $discapacidad=$request->discapacidad;
        $pais=$request->pais;
        $departamento=$request->departamento;
        $provincia=$request->provincia;
        $distrito=$request->distrito;
        $direccion=$request->direccion;
        $email=$request->email;
        $telefono=$request->telefono;
        $codigo=$request->codigo;
        $semestre_id=$request->semestre_id;
        $escuela_id=$request->escuela_id;
        $colegio=$request->colegio;
        $modalidadadmision_id=$request->modalidadadmision_id;
        $modalidadestudios=$request->modalidadestudios;
        $puntaje=$request->puntaje;
        $estado=$request->estado;
        $opcioningreso=$request->opcioningreso;
        $observaciones=$request->observaciones;
        $escuela_id2=$request->escuela_id2;
        $tipogestioncolegio=$request->tipogestioncolegio;
        $tipo=$request->tipo;
        
        $persona_id=$request->persona_id;

        if(intval($esdiscapacitado)==0)
        {
            $discapacidad="";
        }

        $grado=0;
        $nombreGrado="";
        $universidadCulminoPregrado="";

        if(intval($tipo)==2)
        {
            $grado=$request->grado;
            $nombreGrado=$request->nombreGrado;
            $universidadCulminoPregrado=$request->universidadCulminoPregrado;
        }


        $result='1';
        $msj='';
        $selector='';


        $regla0=DB::table('postulantes')
        ->join('personas', 'personas.id', '=', 'postulantes.persona_id')
        ->where('postulantes.id','<>',$id)
        ->where('personas.tipodoc',$tipodoc)
        ->where('personas.doc',$doc)
        ->where('postulantes.tipo',$tipo)
        ->where('postulantes.semestre_id',$semestre_id)
        ->where('postulantes.modalidadadmision_id',$modalidadadmision_id)->count();

        $input1  = array('tipodoc' => $tipodoc);
        $reglas1 = array('tipodoc' => 'required');

        $input2  = array('doc' => $doc);
        $reglas2 = array('doc' => 'required');

        $input3  = array('nombres' => $nombres);
        $reglas3 = array('nombres' => 'required');

        $input4  = array('apellidopat' => $apellidopat);
        $reglas4 = array('apellidopat' => 'required');

        $input5  = array('apellidomat' => $apellidomat);
        $reglas5 = array('apellidomat' => 'required');

        $input6  = array('genero' => $genero);
        $reglas6 = array('genero' => 'required');

        $input7  = array('estadocivil' => $estadocivil);
        $reglas7 = array('estadocivil' => 'required');

        $input8  = array('fechanac' => $fechanac);
        $reglas8 = array('fechanac' => 'required');

        $input9  = array('esdiscapacitado' => $esdiscapacitado);
        $reglas9 = array('esdiscapacitado' => 'required');

        $input10  = array('pais' => $pais);
        $reglas10 = array('pais' => 'required');

        $input11  = array('departamento' => $departamento);
        $reglas11 = array('departamento' => 'required');

        $input12  = array('provincia' => $provincia);
        $reglas12 = array('provincia' => 'required');

        $input13  = array('distrito' => $distrito);
        $reglas13 = array('distrito' => 'required');

        $input14  = array('direccion' => $direccion);
        $reglas14 = array('direccion' => 'required');

        $input15  = array('codigo' => $codigo);
        $reglas15 = array('codigo' => 'required');

        $input16  = array('semestre_id' => $semestre_id);
        $reglas16 = array('semestre_id' => 'required');

        $input17  = array('escuela_id' => $escuela_id);
        $reglas17 = array('escuela_id' => 'required');

        $input18  = array('colegio' => $colegio);
        $reglas18 = array('colegio' => 'required');

        $input19  = array('modalidadadmision_id' => $modalidadadmision_id);
        $reglas19 = array('modalidadadmision_id' => 'required');

        $input20  = array('modalidadestudios' => $modalidadestudios);
        $reglas20 = array('modalidadestudios' => 'required');

        $input21  = array('puntaje' => $puntaje);
        $reglas21 = array('puntaje' => 'required');

        $input22  = array('estado' => $estado);
        $reglas22 = array('estado' => 'required');

        $input23  = array('tipogestioncolegio' => $tipogestioncolegio);
        $reglas23 = array('tipogestioncolegio' => 'required');

        



        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);
        $validator5 = Validator::make($input5, $reglas5);
        $validator6 = Validator::make($input6, $reglas6);
        $validator7 = Validator::make($input7, $reglas7);
        $validator8 = Validator::make($input8, $reglas8);
        $validator9 = Validator::make($input9, $reglas9);
        $validator10 = Validator::make($input10, $reglas10);
        $validator11 = Validator::make($input11, $reglas11);
        $validator12 = Validator::make($input12, $reglas12);
        $validator13 = Validator::make($input13, $reglas13);
        $validator14 = Validator::make($input14, $reglas14);
        $validator15 = Validator::make($input15, $reglas15);
        $validator16 = Validator::make($input16, $reglas16);
        $validator17 = Validator::make($input17, $reglas17);
        $validator18 = Validator::make($input18, $reglas18);
        $validator19 = Validator::make($input19, $reglas19);
        $validator20 = Validator::make($input20, $reglas20);
        $validator21 = Validator::make($input21, $reglas21);
        $validator22 = Validator::make($input22, $reglas22);
        $validator23 = Validator::make($input23, $reglas23);


        if($regla0>0){
            $result='0';
            $msj='Ya se encuentra registrado un Postulante con el Tipo y Documento de Identidad ingresado, del semestre y modalidad de admisión seleccionada';
            $selector='txtDNIE';
        }
        elseif($validator1->fails()){
            $result='0';
            $msj='Seleccione un tipo de Documento Válido';
            $selector='cbutipodocE';
        }
        elseif ($validator2->fails())
        {
            $result='0';
            $msj='Complete el Documento de Identidad del Postulante';
            $selector='txtDNIE';

        }
        elseif (strlen($doc)<8)
        {
            $result='0';
            $msj='Complete un N° de Documento de Identidad Válido';
            $selector='txtDNIE';

        }
        elseif ($validator3->fails()) {
            $result='0';
            $msj='Ingrese los nombres del Postulante';
            $selector='txtnombresE';
        }
        elseif ($validator4->fails()) {
            $result='0';
            $msj='Ingrese el apellido paterno del Postulante';
            $selector='txtapepatE';
        }
        elseif ($validator5->fails()) {
            $result='0';
            $msj='Ingrese el apellido materno del Postulante';
            $selector='txtapematE';
        }
        elseif ($validator6->fails()) {
            $result='0';
            $msj='Seleccione el Género del Postulante';
            $selector='cbugeneroE';
        }
        elseif ($validator7->fails()) {
            $result='0';
            $msj='Seleccione el Estado Civil del Postulante';
            $selector='cbuestadocivilE';
        }
        elseif ($validator8->fails()) {
            $result='0';
            $msj='Ingrese la Fecha de Nacimiento del Postulante';
            $selector='txtfechanacE';
        }
        elseif ($validator9->fails()) {
            $result='0';
            $msj='Seleccione si el Postulante es Discapacitado';
            $selector='cbugeneroE';
        }
        elseif (intval($esdiscapacitado)==1 && strlen($discapacidad)==0) {
            $result='0';
            $msj='Si ha indicado que el Postulante es discapacitado, ingrese la discapacidad que padece';
            $selector='txtdiscapacidadE';
        }

        elseif ($validator10->fails()) {
            $result='0';
            $msj='Ingrese el País de procedencia del Postulante';
            $selector='txtpaisE';
        }
        elseif ($validator11->fails()) {
            $result='0';
            $msj='Ingrese el Departamento de procedencia del Postulante';
            $selector='txtdepE';
        }
        elseif ($validator12->fails()) {
            $result='0';
            $msj='Ingrese la Provincia de procedencia del Postulante';
            $selector='txtprovE';
        }
        elseif ($validator13->fails()) {
            $result='0';
            $msj='Ingrese el Distrito de procedencia del Postulante';
            $selector='txtdistE';
        }
        elseif ($validator14->fails()) {
            $result='0';
            $msj='Ingrese la Dirección del Postulante';
            $selector='txtDirE';
        }
        elseif ($validator15->fails()) {
            $result='0';
            $msj='Ingrese el Código del Postulante';
            $selector='txtcodigoE';
        }
        elseif ($validator16->fails()) {
            $result='0';
            $msj='Seleccione el Semestre de Postulación del Postulante';
            $selector='cbusemestreE';
        }
        elseif (($validator17->fails() || intval($escuela_id)==0)&& intval($tipo)==1) {
            $result='0';
            $msj='Seleccione el Programa Profesional de primera opción del postulante';
            $selector='cbucarrera1E';
        }
        elseif ($validator18->fails() && intval($tipo)==1) {
            $result='0';
            $msj='Ingrese el Colegio de Procedencia del Postulante';
            $selector='txtcolegioE';
        }
        elseif ($validator19->fails() || intval($modalidadadmision_id)==0) {
            $result='0';
            $msj='Seleccione la Modalidad de Admisión del Postulante';
            $selector='cbumodalidadadmisionE';
        }
        elseif ($validator20->fails() || intval($modalidadestudios)==0) {
            $result='0';
            $msj='Seleccione la Modalidad de Estudios del Postulante';
            $selector='cbumodalidadestudiosE';
        }

        elseif ($validator21->fails()) {
            $result='0';
            $msj='Ingrese el Puntaje que obtuvo el postulante';
            $selector='txtpuntajeE';
        }
        elseif ($validator22->fails()) {
            $result='0';
            $msj='Ingrese el estado de Ingreso del postulante';
            $selector='cbuestadoingresoE';
        }
        elseif ($validator23->fails() && intval($tipo)==1) {
            $result='0';
            $msj='Seleccione el tipo de Gestión Administrativa del Colegio de Procedencia del Postulante';
            $selector='cbutipogestionE';
        }

        elseif (intval($estado)==1 && intval($opcioningreso)==0 && intval($tipo)==1) {
            $result='0';
            $msj='Si ha seleccionado que el postulante ingresó a un Programa Profesional, indicar a cual fue';
            $selector='cbucarreraingE';
        }

        elseif (intval($tipo)==2 && strlen($nombreGrado)==0) {
            $result='0';
            $msj='Ingrese el nombre y mensión del Grado al que Postula';
            $selector='txtgradoE';
        }

        elseif (intval($tipo)==2 && strlen($universidadCulminoPregrado)==0) {
            $result='0';
            $msj='Ingrese el nombre de la Universidad en la que Culminó su Pregrado';
            $selector='txtuniversidadterminoestudiosE';
        }

      
        else{




            $editPersona =Persona::find($persona_id);
            $editPersona->tipodoc=$tipodoc;
            $editPersona->doc=$doc;
            $editPersona->nombres=$nombres;
            $editPersona->apellidopat=$apellidopat;
            $editPersona->apellidomat=$apellidomat;
            $editPersona->genero=$genero;
            $editPersona->estadocivil=$estadocivil;
            $editPersona->fechanac=$fechanac;
            $editPersona->esdiscapacitado=$esdiscapacitado;
            $editPersona->discapacidad=$discapacidad;
            $editPersona->pais=$pais;
            $editPersona->departamento=$departamento;
            $editPersona->provincia=$provincia;
            $editPersona->distrito=$distrito;
            $editPersona->direccion=$direccion;
            $editPersona->email=$email;
            $editPersona->telefono=$telefono;

            $editPersona->save();
      

            if($tipo==1)
            {
                $editPostulante =Postulante::find($id);
        $editPostulante->codigo=$codigo;
        $editPostulante->semestre_id=$semestre_id;
        $editPostulante->escuela_id=$escuela_id;
        $editPostulante->colegio=$colegio;
        $editPostulante->modalidadadmision_id=$modalidadadmision_id;
        $editPostulante->modalidadestudios=$modalidadestudios;
        $editPostulante->puntaje=$puntaje;
        $editPostulante->estado=$estado;
        $editPostulante->opcioningreso=$opcioningreso;
        $editPostulante->persona_id=$persona_id;
        $editPostulante->observaciones=$observaciones;

        $editPostulante->email=$email;
        $editPostulante->escuela_id2=$escuela_id2;
        $editPostulante->tipogestioncolegio=$tipogestioncolegio;


        $editPostulante->save();
            }
        

        elseif($tipo==2)
        {
            $editPostulante = Postulante::find($id);
        $editPostulante->codigo=$codigo;
        $editPostulante->semestre_id=$semestre_id;
        $editPostulante->modalidadadmision_id=$modalidadadmision_id;
        $editPostulante->modalidadestudios=$modalidadestudios;
        $editPostulante->puntaje=$puntaje;
        $editPostulante->estado=$estado;
        $editPostulante->persona_id=$persona_id;
        $editPostulante->observaciones=$observaciones;

        $editPostulante->email=$email;
        $editPostulante->grado=$grado;
        $editPostulante->nombreGrado=$nombreGrado;
        $editPostulante->universidadCulminoPregrado=$universidadCulminoPregrado;


        $editPostulante->save();
        }

        

           

            $msj='Postulante modificado con éxito';
        }




       //Areaunasam::create($request->all());

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Postulante  $postulante
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result='1';
        $msj='1';

   
        
        $borrar = Postulante::destroy($id);
        //$task->delete();


        $msj='Postulante Seleccionado eliminado exitosamente';
   

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }


    public function descargarExcel(Request $request)
    {   
        $buscar=$request->busca;
        $tipo=$request->tipo;
        $semestre_id=$request->semestre_id;

        $semestre=Semestre::find($semestre_id);

        Excel::create('Postulantes de Pregrado del '.$semestre->nombre, function($excel) use($buscar,$tipo,$semestre)  {
            $excel->sheet('Base de Datos de Postulantes', function($sheet) use($buscar,$tipo,$semestre){

                $sheet->setAutoSize(true);
                /* $sheet->mergeCells('B1:D1');
                $sheet->mergeCells('B2:H2'); */

                $sheet->mergeCells('A3:AF3');
                $sheet->cells('A3:AF3',function($cells)
                {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
                $sheet->setBorder('A3:AF3', 'thin');
                $sheet->cells('A3:AF3', function($cells)
                {
                    $cells->setBackground('#0C73E8');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontSize(15);

                    #Borders
                });
                
                $sheet->cells('A4:AF4', function($cells)
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
                'F'=>'20',
                'G'=>'30',
                'H'=>'15',
                'I'=>'20',
                'J'=>'15',
                'K'=>'20',
                'L'=>'30',
                'M'=>'30',
                'N'=>'50',
                'O'=>'40',
                'P'=>'40',
                'Q'=>'30',
                'R'=>'25',
                'S'=>'19',
                'T'=>'20',
                'U'=>'40',
                'V'=>'40',
                'W'=>'25',
                'X'=>'30',
                'Y'=>'30',
                'Z'=>'30',
                'AA'=>'50',
                'AB'=>'25',
                'AC'=>'50',
                'AD'=>'40',
                'AE'=>'15',
                'AF'=>'65',
                )
                );

                $sheet->setHeight(array
                (
                '3'=>'24'
                )
                );

                $titulo='BASE DE DATOS ALUMNOS POSTULANTES DEL NIVEL PREGRADO - SEMESTRE '.$semestre->nombre;

                array_push($data, array(''));
                array_push($data, array(''));
                array_push($data, array($titulo));

                $sheet->setBorder('A4:AF4', 'thin');
                array_push($data, array('N°','TIPO DE DOCUMENTO', 'NÚMERO DE DOCUMENTO', 'CÓDIGO DE POSTULANTE', 'APELLIDO PATERNO', 'APELLIDO MATERNO','NOMBRES','GÉNERO','FECHA DE NACIMIENTO','ESTADO CIVIL','SUFRE DISCAPACIDAD','DISCAPACIDAD QUE PADECE','PERIODO DE POSTULACIÓN','LOCAL','CARRERA PRIMERA OPCIÓN','CARRERA SEGUNDA OPCIÓN','MODALIDAD DE ADMISIÓN','MODALIDAD DE ESTUDIOS','PUNTAJE OBTENIDO','ESTADO DE INGRESO','OPCIÓN DE INGRESO','CARRERA DE INGRESO','PAÍS DE PROCEDENCIA','DEPARTAMENTO DE PROCEDENCIA','PROVINCIA DE PROCEDENCIA','DISTRITO DE PROCEDENCIA','COLEGIO DONDE TERMINÓ EL 5° GRADO DE SECUNADARIA','GESTIÓN DEL COLEGIO','DIRECCIÓN DEL POSTULANTE','CORREO ELECTRÓNICO','TELÉFONO','OBSERVACIONES'));

                $cont=5;
                $cont2=5;

                $postulantes = DB::table('postulantes')
        ->join('personas', 'personas.id', '=', 'postulantes.persona_id')
        ->join('semestres', 'semestres.id', '=', 'postulantes.semestre_id')
        ->join('modalidadadmisions', 'modalidadadmisions.id', '=', 'postulantes.modalidadadmision_id')
        ->join('escuelas as escuela1', 'escuela1.id', '=', 'postulantes.escuela_id')
        ->leftjoin('escuelas as escuela2', 'escuela2.id', '=', 'postulantes.escuela_id2')
        ->leftjoin('escuelas as escuelaing', 'escuelaing.id', '=', 'postulantes.opcioningreso')
        ->where('postulantes.borrado','0')
        ->where('postulantes.tipo',$tipo)
        ->where('semestres.id',$semestre->id)
        ->where(function($query) use ($buscar){
           $query->where('personas.nombres','like','%'.$buscar.'%');
           $query->orWhere('personas.apellidopat','like','%'.$buscar.'%');
           $query->orWhere('personas.apellidomat','like','%'.$buscar.'%');
           $query->orWhere('personas.doc','like','%'.$buscar.'%');
           $query->orWhere('postulantes.codigo','like','%'.$buscar.'%');
           })
        ->orderBy('personas.apellidopat')
        ->orderBy('personas.apellidomat')
        ->orderBy('personas.nombres')
        ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono','postulantes.id','postulantes.codigo','postulantes.semestre_id','postulantes.escuela_id','postulantes.colegio','postulantes.modalidadadmision_id','postulantes.modalidadestudios','postulantes.puntaje','postulantes.estado','postulantes.opcioningreso','postulantes.persona_id','postulantes.observaciones','postulantes.tipo','postulantes.email','postulantes.escuela_id2','postulantes.tipogestioncolegio','postulantes.opcioningreso','semestres.nombre as semestre','modalidadadmisions.id as idmodadmi','modalidadadmisions.nombre as modalidadadmision','escuela1.nombre as escuela1',DB::Raw("IFNULL( `escuela2`.`nombre` , 'No hubo 2° Opción' ) as escuela2"),DB::Raw("IFNULL( `escuelaing`.`nombre` , 'No Ingresó' ) as escuelaing"),'postulantes.grado','postulantes.nombreGrado','postulantes.universidadCulminoPregrado')
        ->get();

        foreach ($postulantes as $key => $dato) {
            $rango='A'.strval((intval($cont)+intval($key))).':AF'.strval((intval($cont)+intval($key)));
            $sheet->setBorder($rango, 'thin');



 

           array_push($data, array($key+1,
           tipoDoc($dato->tipodoc),
           $dato->doc,
           $dato->codigo,
           $dato->apellidopat,
           $dato->apellidomat,
           $dato->nombres,
           genero(strval($dato->genero)),
           pasFechaVista($dato->fechanac),
           estadoCivil($dato->estadocivil,$dato->genero),
           esDiscpacitado($dato->esdiscapacitado),
           $dato->discapacidad,
           $semestre->nombre,
           'Ciudad Universitaria',
           $dato->escuela1,
           $dato->escuela2,
           $dato->modalidadadmision,
           modalidadEstudios($dato->modalidadestudios),
           $dato->puntaje,
           estadoIngreso($dato->estado),
           $dato->escuelaing,
           $dato->escuelaing,
           $dato->pais,
           $dato->departamento,
           $dato->provincia,
           $dato->distrito,
           $dato->colegio,
           gestionColegio($dato->tipogestioncolegio),
           $dato->direccion,
           $dato->email,
           $dato->telefono,
           $dato->observaciones
        
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
        $semestre_id=$request->semestre_id;

        $semestre=Semestre::find($semestre_id);

        Excel::create('Postulantes de Postgrado del '.$semestre->nombre, function($excel) use($buscar,$tipo,$semestre)  {
            $excel->sheet('Base de Datos de Postulantes', function($sheet) use($buscar,$tipo,$semestre){

                $sheet->setAutoSize(true);
                /* $sheet->mergeCells('B1:D1');
                $sheet->mergeCells('B2:H2'); */

                $sheet->mergeCells('A3:AA3');
                $sheet->cells('A3:AA3',function($cells)
                {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
                $sheet->setBorder('A3:AA3', 'thin');
                $sheet->cells('A3:AA3', function($cells)
                {
                    $cells->setBackground('#0C73E8');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontSize(15);

                    #Borders
                });
                
                $sheet->cells('A4:AA4', function($cells)
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
                'F'=>'20',
                'G'=>'30',
                'H'=>'15',
                'I'=>'20',
                'J'=>'15',
                'K'=>'20',
                'L'=>'30',
                'M'=>'30',
                'N'=>'50',
                'O'=>'40',
                'P'=>'40',
                'Q'=>'30',
                'R'=>'25',
                'S'=>'19',
                'T'=>'20',
                'U'=>'40',
                'V'=>'40',
                'W'=>'25',
                'X'=>'45',
                'Y'=>'35',
                'Z'=>'20',
                'AA'=>'65',
                )
                );

                $sheet->setHeight(array
                (
                '3'=>'24'
                )
                );

                $titulo='BASE DE DATOS ALUMNOS POSTULANTES DEL NIVEL POSTGRADO - SEMESTRE '.$semestre->nombre;

                array_push($data, array(''));
                array_push($data, array(''));
                array_push($data, array($titulo));

                $sheet->setBorder('A4:AA4', 'thin');
                array_push($data, array('N°','TIPO DE DOCUMENTO', 'NÚMERO DE DOCUMENTO', 'CÓDIGO DE POSTULANTE', 'APELLIDO PATERNO', 'APELLIDO MATERNO','NOMBRES','GÉNERO','FECHA DE NACIMIENTO','ESTADO CIVIL','SUFRE DISCAPACIDAD','DISCAPACIDAD QUE PADECE','PERIODO DE POSTULACIÓN','GRADO','DENOMINACIÓN DEL GRADO','MODALIDAD DE ADMISIÓN','MODALIDAD DE ESTUDIOS','PUNTAJE OBTENIDO','ESTADO DE INGRESO','PAÍS DE PROCEDENCIA','DEPARTAMENTO DE PROCEDENCIA','PROVINCIA DE PROCEDENCIA','DISTRITO DE PROCEDENCIA','UNIVERSIDAD DONDE CULMINÓ SUS ESTUDIOS','CORREO ELECTRÓNICO','TELÉFONO','OBSERVACIONES'));

                $cont=5;
                $cont2=5;

                $postulantes = DB::table('postulantes')
                ->join('personas', 'personas.id', '=', 'postulantes.persona_id')
                ->join('semestres', 'semestres.id', '=', 'postulantes.semestre_id')
                ->join('modalidadadmisions', 'modalidadadmisions.id', '=', 'postulantes.modalidadadmision_id')
        
                ->where('postulantes.borrado','0')
                ->where('postulantes.tipo',$tipo)
                ->where('semestres.id',$semestre->id)
                ->where(function($query) use ($buscar){
                   $query->where('personas.nombres','like','%'.$buscar.'%');
                   $query->orWhere('personas.apellidopat','like','%'.$buscar.'%');
                   $query->orWhere('personas.apellidomat','like','%'.$buscar.'%');
                   $query->orWhere('personas.doc','like','%'.$buscar.'%');
                   $query->orWhere('postulantes.codigo','like','%'.$buscar.'%');
                   })
                ->orderBy('personas.apellidopat')
                ->orderBy('personas.apellidomat')
                ->orderBy('personas.nombres')
                ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono','postulantes.id','postulantes.codigo','postulantes.semestre_id','postulantes.escuela_id','postulantes.colegio','postulantes.modalidadadmision_id','postulantes.modalidadestudios','postulantes.puntaje','postulantes.estado','postulantes.opcioningreso','postulantes.persona_id','postulantes.observaciones','postulantes.tipo','postulantes.email','postulantes.escuela_id2','postulantes.tipogestioncolegio','postulantes.opcioningreso','semestres.nombre as semestre','modalidadadmisions.id as idmodadmi','modalidadadmisions.nombre as modalidadadmision','postulantes.grado','postulantes.nombreGrado','postulantes.universidadCulminoPregrado')
                ->get();

        foreach ($postulantes as $key => $dato) {
            $rango='A'.strval((intval($cont)+intval($key))).':AA'.strval((intval($cont)+intval($key)));
            $sheet->setBorder($rango, 'thin');

 

           array_push($data, array($key+1,
           tipoDoc($dato->tipodoc),
           $dato->doc,
           $dato->codigo,
           $dato->apellidopat,
           $dato->apellidomat,
           $dato->nombres,
           genero(strval($dato->genero)),
           pasFechaVista($dato->fechanac),
           estadoCivil($dato->estadocivil,$dato->genero),
           esDiscpacitado($dato->esdiscapacitado),
           $dato->discapacidad,
           $semestre->nombre,
           grado($dato->grado),
           $dato->nombreGrado,
           $dato->modalidadadmision,
           modalidadEstudios($dato->modalidadestudios),
           $dato->puntaje,
           estadoIngreso($dato->estado),
           $dato->pais,
           $dato->departamento,
           $dato->provincia,
           $dato->distrito,
           $dato->universidadCulminoPregrado,
           $dato->email,
           $dato->telefono,
           $dato->observaciones
        
        ));
            
            $cont2++;
        }



                $sheet->fromArray($data, null, 'A1', false, false);
            
            });
            })->download('xlsx');  
   

        return response()->json(["buscar"=>$buscar,'tipo'=>$tipo]);
    }



    public function importarArchivo(Request $request)
    {
        ini_set('memory_limit','256M');

        ini_set('upload_max_filesize','128M');

        $archivo="";
        $file = $request->archivo;
        $segureFile=0;

       // $nombreArchivo="";

        $result='1';
        $msj='';
        $selector='';
        $errorColumna='';
        $errorFila='';

        if($request->hasFile('archivo')){



           /* $nombreArchivo=$request->nombreArchivo;*/

            $aux2='postulantePregrado'.date('d-m-Y').'-'.date('H-i-s');
            $input2  = array('archivo' => $file) ;
            $reglas2 = array('archivo' => 'required|file:1,51200');
            $validatorF = Validator::make($input2, $reglas2);

          /*  $inputNA  = array('archivonombre' => $nombreArchivo);
            $reglasNA = array('archivonombre' => 'required');
            $validatorNA = Validator::make($inputNA, $reglasNA);*/

          

            if ($validatorF->fails())
            {

            $segureFile=1;
            $msj="El archivo adjunto ingresado tiene un tamaño no válido superior a los 5 MB, ingrese otro archivo o limpie el formulario";
            $result='0';
            $selector='archivo';
            }
          /*  elseif($validatorNA->fails()){
                $segureFile=1;
                $msj="Si va a registrar un archivo adjunto, debe de ingresar un nombre válido con el que se verá en el sistema";
                $result='0';
                $selector='txtArchivoAdjunto';
            }*/
            else
            {
                $nombre2=$file->getClientOriginalName();
                $extension2=$file->getClientOriginalExtension();
                $nuevoNombre2=$aux2.".".$extension2;
                //$subir2=Storage::disk('revistas')->put($nuevoNombre2, \File::get($file));
                $subir2=Storage::disk('infoFile')->put($nuevoNombre2, \File::get($file));

               

                if($extension2=="xls" || $extension2=="xlsx"  || $extension2=="XLS" || $extension2=="XLSX" )
                {

                if($subir2){
                    $archivo=$nuevoNombre2;
                }
                else{
                    $msj="Error al subir el archivo adjunto, intentelo nuevamente luego";
                    $segureFile=1;
                    $result='0';
                    $selector='archivo';
                }
                }
                else {
                    $segureFile=1;
                    $msj="El archivo adjunto ingresado tiene una extensión no válida, ingrese otro archivo o limpie el formulario";
                    $result='0';
                    $selector='archivo';
                }
            }

        }

        if($segureFile==1){
            Storage::disk('infoFile')->delete($archivo);

            
        }
        else
        {

             $variablePrueba = "hola"; //si quieres meter una variable exterma al recorrido del excel

             $fecha=date("Y-m-d");

            $errorFila="";
            $errorColumna="";
            $detError="";
            $error=0;
            $msj="";
    
            $semestres=Semestre::where('activo','1')->where('borrado','0')->get();
            $escuelas=Escuela::where('activo','1')->where('borrado','0')->get();
            $modalidadAdmisions=Modalidadadmision::where('activo','1')->where('borrado','0')->get();


                 Excel::load(public_path().'/archivosExcel/'.$archivo, function ($reader) use (&$errorFila,  &$errorColumna,  &$detError, &$error, $archivo, &$msj, $semestres, $escuelas, $modalidadAdmisions, &$result, &$selector) { 

                    //$reader->first(); // Leer datos de la primera hoja

                   $resultado=$reader->skipRows(4)->first();


                   $error=0;

                   foreach ($resultado as $key => $row) {

                    $bandera01=false;

                    foreach ($semestres as $key3 => $dato) {
                        if(intval($row->c_sem)==$dato->id)
                        {
                            $bandera01=true;
                            break;
                        }
                    }

                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna SEMESTRE DE POSTULACIÓN";
                        $detError="El Identificador de Semestre no corresponde a ninguno ingresado en la base de datos. Corrija la Columna B, Fila ".($key+6);
                        $error=1;
                        break 1;

                    }

                    $bandera01=false;
                    foreach ($escuelas as $key4 => $dato) {
                        if(intval($row->c_carr1)==$dato->id)
                        {
                            $bandera01=true;
                            break;
                        }
                    }

                    if($bandera01==false){
        
                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna CARRERA PRIMERA OPCIÓN";
                        $detError="El Identificador de Carrera Primera Opción no corresponde a ninguna Escuela Profesional registrada en la base de datos. Corrija la Columna C, Fila ".($key+6);
                        $error=1;
                        break 1;

                    }

                    $bandera01=false;
                    if(intval($row->c_segop)==0 || intval($row->c_segop)==1){
                        $bandera01=true;
                        }
                        if($bandera01==false){
    
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna HUBO SEGUNDA OPCIÓN";
                            $detError="El código de Hubo Segunda Opción solo debe de llevar valores de 0 para NO o 1 para SI. Corrija la Columna D, Fila ".($key+6);
                            $error=1;
                            break 1;
    
                        }




                    if(intval($row->c_segop)==1){ 
                    $bandera01=false;
                    foreach ($escuelas as $key5 => $dato) {
                        if(intval($row->c_carr2)==$dato->id)
                        {
                            $bandera01=true;
                            break;
                        }
                    }

                }
                    

                    if($bandera01==false){
        
                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna CARRERA SEGUNDA OPCIÓN";
                        $detError="El Identificador de Carrera Segunda Opción no corresponde a ninguna Escuela Profesional registrada en la base de datos. De no haber habido segunda Opción, deje en blanco o con valor de 0 la Columna Hubo Segunda Opcion. Corrija la Columna E, Fila ".($key+6);
                        $error=1;
                        break 1;

                    }


                    $bandera01=false;
                    foreach ($modalidadAdmisions as $key6 => $dato) {
                        if(intval($row->c_modadmi)==$dato->id)
                        {
                            $bandera01=true;
                            break;
                        }
                    }

                    if($bandera01==false){
        
                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna MODALIDAD DE ADMISIÓN";
                        $detError="El Identificador de Modalidad de Admisión no corresponde a ninguna Modalidad de Admisión registrada en la base de datos. Corrija la Columna F, Fila ".($key+6);
                        $error=1;
                        break 1;

                    }


                    $bandera01=false;
                    if(intval($row->c_modestu)==1 || intval($row->c_modestu)==2 || intval($row->c_modestu)==3){
                        $bandera01=true;
                        }
                        if($bandera01==false){
    
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna MODALIDAD DE ESTUDIOS";
                            $detError="El código de Modalidad de Estudios Ingresada no corresponde a los valores posibles de ser consignados. Ingrese 1 para Presencial, ó 2 para Semipresencial ó 3 para Virtual. Corrija la Columna G, Fila ".($key+6);
                            $error=1;
                            break 1;
    
                        }

                        $bandera01=false;
                    if(intval($row->c_estado)==1 || intval($row->c_estado)==0){
                        $bandera01=true;
                        }
                        if($bandera01==false){
    
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna ESTADO DE INGRESO";
                            $detError="El código del Estado de Ingreso no corresponde a los valores posibles de ser consignados. Solo debe de llevar valores de 0 para No Ingresó o 1 para Si Ingresó. Corrija la Columna H, Fila ".($key+6);
                            $error=1;
                            break 1;
    
                        }


                        if(intval($row->c_estado)==1){
                        $bandera01=false;
                        if(intval($row->c_opcion)==intval($row->c_carr1) || intval($row->c_opcion)==intval($row->c_carr2)){
                            $bandera01=true;
                            }
                            if($bandera01==false){
        
                                $errorFila="Error en la Fila ".($key+6);
                                $errorColumna="Error en la Columna OPCIÓN DE INGRESO";
                                $detError="El código de la Opción no corresponde a los valores posibles de ser consignados. Debe consignar el código de la Primera o Segunda Opción a la que postuló según lo indicó en la columna C o E. Corrija la Columna I, Fila ".($key+6);
                                $error=1;
                                break 1;
        
                            }
                        }


                        $bandera01=false;
                        if(intval($row->c_tipodoc)==1 || intval($row->c_tipodoc)==2 || intval($row->c_tipodoc)==3 || intval($row->c_tipodoc)==4 || intval($row->c_tipodoc)==5){
                            $bandera01=true;
                            }
                            if($bandera01==false){
        
                                $errorFila="Error en la Fila ".($key+6);
                                $errorColumna="Error en la Columna TIPO DE DOCUMENTO";
                                $detError="El código del Tipo de Documento no corresponde a los valores posibles de ser consignados (1: DNI, 2: RUC, 3: Carnet de Extranjería, 4: Pasaporte, 5: Partida de Nacimiento). Corrija la Columna J, Fila ".($key+6);
                                $error=1;
                                break 1;
        
                            }

                        $bandera01=false;
                        if(strlen(trim($row->c_numdoc))>=8){
                            $bandera01=true;
                            }
                            if($bandera01==false){
        
                                $errorFila="Error en la Fila ".($key+6);
                                $errorColumna="Error en la Columna NÚMERO DE DOCUMENTO";
                                $detError="El Número de Documento de Indentidad ingresado se encuentran en blanco o no cuenta con un formato correcto. Corrija la Columna K, Fila ".($key+6);
                                $error=1;
                                break 1;
        
                            }


                        $bandera01=false;
                        if(strlen(trim($row->c_codpos))>0){
                            $bandera01=true;
                            }
                            if($bandera01==false){
        
                                $errorFila="Error en la Fila ".($key+6);
                                $errorColumna="Error en la Columna CÓDIGO DE POSTULANTE";
                                $detError="El código ingresado se encuentran en blanco. Corrija la Columna L, Fila ".($key+6);
                                $error=1;
                                break 1;
        
                            }


                        $bandera01=false;
                        if(strlen(trim($row->c_apepat))>0){
                            $bandera01=true;
                            }
                            if($bandera01==false){
        
                                $errorFila="Error en la Fila ".($key+6);
                                $errorColumna="Error en la Columna APELLIDO PATERNO";
                                $detError="El Apellido ingresado se encuentran en blanco. Corrija la Columna M, Fila ".($key+6);
                                $error=1;
                                break 1;
        
                            }


                        $bandera01=false;
                        if(strlen(trim($row->c_noms))>0){
                            $bandera01=true;
                            }
                            if($bandera01==false){
        
                                $errorFila="Error en la Fila ".($key+6);
                                $errorColumna="Error en la Columna NOMBRES";
                                $detError="Los Nombres ingresados se encuentran en blanco. Corrija la columna O, Fila ".($key+6);
                                $error=1;
                                break 1;
        
                            }

                        $bandera01=false;
                        if((trim($row->c_genero)=="M") || (trim($row->c_genero)=="F") || (trim($row->c_genero)=="m") || (trim($row->c_genero)=="f")){
                            $bandera01=true;
                            }
                            if($bandera01==false){
        
                                $errorFila="Error en la Fila ".($key+6);
                                $errorColumna="Error en la Columna GÉNERO";
                                $detError="Consideró un dato no identificado, indique M para másculino ó F para femenino, sin espacios en blanco. Corrija la Columna P, Fila ".($key+6);
                                $error=1;
                                break 1;
        
                            }

                            
                        if(strlen(trim($row->c_fechanac))==10){

                        //$dateTime = new DateTime::createFromFormat('d/m/Y',$row->c_fechanac);   //pasar a datetime

                        if(checkdate(intval(substr($row->c_fechanac, -7,2)), intval(substr($row->c_fechanac, -10,2)), intval(substr($row->c_fechanac, -4)))){
                            $var=pasFechaBD($row->c_fechanac);
                            $dateTime = DateTime::createFromFormat('Y-m-d', $var);  //pasar a datetime
                            $fechanac=$dateTime->format('Y-m-d');
                            $bandera01=false;
                            if($fechanac != null){
                                $bandera01=true;
                                }
                                if($bandera01==false){
            
                                    $errorFila="Error en la Fila ".($key+6);
                                    $errorColumna="Error en la Columna FECHA DE NACIMIENTO";
                                    $detError="EL dato ingresado se encuentran en blanco o no tiene un formato correcto dd/mm/aaaa. Corrija la Columna Q, Fila ".($key+6);
                                    $error=1;
                                    break 1;
            
                                }
                            }
                            else{
                                $errorFila="Error en la Fila ".($key+6);
                                $errorColumna="Error en la Columna FECHA DE NACIMIENTO";
                                $detError="EL dato ingresado se encuentran en blanco o no tiene un formato correcto dd/mm/aaaa. Corrija la Columna Q, Fila ".($key+6);
                                $error=1;
                                break 1;
                            }

                        }
                        else{
                            if($row->c_fechanac != null && strlen($row->c_fechanac->format('Y-m-d')) != null){
                                $bandera01=true;
                            }
                            else{
                                $bandera01=false;
                                $errorFila="Error en la Fila ".($key+6);
                                $errorColumna="Error en la Columna FECHA DE NACIMIENTO";
                                $detError="EL dato ingresado se encuentran en blanco o no tiene un formato correcto dd/mm/aaaa. Corrija la Columna Q, Fila ".($key+6);
                                $error=1;
                                break 1;
                            }
                        }


                        $bandera01=false;
                    if(intval($row->c_estadociv)==1 || intval($row->c_estadociv)==2 || intval($row->c_estadociv)==3 || intval($row->c_estadociv)==4){
                        $bandera01=true;
                        }
                        if($bandera01==false){
    
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna ESTADO CIVIL";
                            $detError="El código del Estado CIvil no corresponde a los valores posibles de ser consignados (1: Soltero (a), 2: Casado (a), 3: Viudo (a), ó 4: Divorsiado (a)). Corrija la Columna R, Fila ".($key+6);
                            $error=1;
                            break 1;
    
                        }



                        $bandera01=false;
                    if(intval($row->c_esdisca)==1 || intval($row->c_esdisca)==0){
                        $bandera01=true;
                        }
                        if($bandera01==false){
    
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna SUFRE DISCAPACIDAD";
                            $detError="El código de Condición de Discapacidad no corresponde a los valores posibles de ser consignados. Consigne 1 para SI o 0 para NO. Corrija la Columna S, Fila ".($key+6);
                            $error=1;
                            break 1;
    
                        }


                
                    if( intval($row->c_esdisca)==1){
                    $bandera01=false;
                    if(strlen(trim($row->c_disca))>0){
                        $bandera01=true;
                        }
                        if($bandera01==false){
    
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna DISCAPACIDAD QUE PADECE";
                            $detError="Si ha ingresado que el Alumno es Discapacitado, ingrese la Discapacidad que padece, no puede dejar el registro en blanco. Corrija la Columna T, Fila ".($key+6);
                            $error=1;
                            break 1;
    
                        }

                    }

                
                        $bandera01=true;
                        if(floatval($row->c_puntaje)<0){
                            $bandera01=false;
                            }
                            if($bandera01==false){
        
                                $errorFila="Error en la Fila ".($key+6);
                                $errorColumna="Error en la Columna PUNTAJE OBTENIDO";
                                $detError="Ha consignado un valor no válido, ingrese un valor mayor o igual a cero. Corrija la Columna U, Fila ".($key+6);
                                $error=1;
                                break 1;
        
                            }


                        $bandera01=false;
                        if(strlen(trim($row->c_pais))>0){
                        $bandera01=true;
                        }
                        if($bandera01==false){
    
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna PAÍS DE PROCEDENCIA";
                            $detError="El País de Procedencia ingresado se encuentran en blanco. Corrija la Columna V, Fila ".($key+6);
                            $error=1;
                            break 1;
    
                        }


                        $bandera01=false;
                        if(strlen(trim($row->c_depar))>0){
                        $bandera01=true;
                        }
                        if($bandera01==false){
    
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna DEPARTAMENTO DE PROCEDENCIA";
                            $detError="El Departamento de Procedencia ingresado se encuentran en blanco. Corrija la Columna W, Fila ".($key+6);
                            $error=1;
                            break 1;
    
                        }



                        $bandera01=false;
                        if(strlen(trim($row->c_prov))>0){
                        $bandera01=true;
                        }
                        if($bandera01==false){
    
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna PROVINCIA DE PROCEDENCIA";
                            $detError="La Provincia de Procedencia ingresado se encuentran en blanco. Corrija la Columna X, Fila ".($key+6);
                            $error=1;
                            break 1;
    
                        }



                        $bandera01=false;
                        if(strlen(trim($row->c_dist))>0){
                        $bandera01=true;
                        }
                        if($bandera01==false){
    
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna DISTRITO DE PROCEDENCIA";
                            $detError="El Distrito de Procedencia ingresado se encuentran en blanco. Corrija la Columna Y, Fila ".($key+6);
                            $error=1;
                            break 1;
    
                        }



                        $bandera01=false;
                        if(strlen(trim($row->c_termino5))>0){
                        $bandera01=true;
                        }
                        if($bandera01==false){
    
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna COLEGIO DONDE TERMINÓ EL 5° GRADO DE SECUNADARIA";
                            $detError="El Valor ingresado se encuentran en blanco. Corrija la Columna Z, Fila ".($key+6);
                            $error=1;
                            break 1;
    
                        }



                        $bandera01=false;
                    if(intval($row->c_gestcolegio)==1 || intval($row->c_gestcolegio)==2){
                        $bandera01=true;
                        }
                        if($bandera01==false){
    
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna GESTIÓN DEL COLEGIO";
                            $detError="El código de Tipo de Gestión del Colegio no corresponde a los valores posibles de ser consignados. Indique 1 para Estatal ó 2 para Particular. Corrija la Columna AA, Fila ".($key+6);
                            $error=1;
                            break 1;
    
                        }


                        $bandera01=false;
                        if(strlen(trim($row->c_direc))>0){
                        $bandera01=true;
                        }
                        if($bandera01==false){
    
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna DIRECCIÓN DEL POSTULANTE";
                            $detError="El Valor ingresado se encuentran en blanco. Corrija la Columna AB, Fila ".($key+6);
                            $error=1;
                            break 1;
    
                        }


                        $bandera01=false;
                        if(strlen(trim($row->c_email))>0 && is_valid_email(trim($row->c_email))){
                        $bandera01=true;
                        }
                        if($bandera01==false){
    
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna CORREO ELECTRÓNICO";
                            $detError="El Valor ingresado se encuentran en blanco, o cuenta con un formato incorrecto. Corrija la Coumna AC, Fila ".($key+6);
                            $error=1;
                            break 1;
    
                        }


                    }

                    if($error==1){
                    Storage::disk('infoFile')->delete($archivo);
                    $msj=$detError.' Por lo Que no se realizó la Importación de Datos.';
                    $result='0';
                    }
                    else{

                    $msj="Datos Importados Exitosamente";
                    
                    foreach ($resultado as $key => $row) {

                        $persona_id="0";
                        $idPostulante="0";

                        $persona=Persona::where('doc',(trim($row->c_numdoc)))->where('tipodoc',intval($row->c_tipodoc))->get();

                        foreach ($persona as $key => $dato) {
                            $persona_id=$dato->id;
                        }

                        $newGenero="M";
                        if(trim($row->c_genero)=="M" || trim($row->c_genero)=="m" )
                        {
                            $newGenero="M";
                        }elseif(trim($row->c_genero)=="F" || trim($row->c_genero)=="f")
                        {
                            $newGenero="F";
                        }

                        $discapacidad="";
                        if(intval($row->c_esdisca)==0)
                        {
                            $discapacidad="";
                        }else{
                            $discapacidad=trim($row->c_disca);
                        }

                        $escuela_id2 = 0;
                        if(intval($row->c_segop)==0)
                        {
                        $escuela_id2 = 0;
                        }
                        else{
                            $escuela_id2 = intval($row->c_carr2);
                        }

                        $opcionIngreso = 0;
                        if(intval($row->c_estado)==0)
                        {
                            $opcionIngreso = 0;
                        }
                        else{
                            $opcionIngreso = intval($row->c_opcion);
                        }

                        $grado=0;
                        $nombreGrado="";
                        $universidadCulminoPregrado="";

                    
                        /*$dateTime = new DateTime(pasFechaBD($row->c_fechanac));   //pasar a datetime
                        $fechanac=$dateTime->format('Y-m-d');*/
                        $fechanac= null;
                        if(strlen(trim($row->c_fechanac))==10){

                            $fechanac=pasFechaBD($row->c_fechanac);
                        }
                        else{
                            $fechanac=$row->c_fechanac->format('Y-m-d');
                        }


                        if(intval($persona_id)!=0)
                        {
                            $editPersona =Persona::find($persona_id);
                            $editPersona->tipodoc=intval($row->c_tipodoc);
                            $editPersona->doc=trim($row->c_numdoc);
                            $editPersona->nombres=trim($row->c_noms);
                            $editPersona->apellidopat=trim($row->c_apepat);
                            $editPersona->apellidomat=trim($row->c_apemat);
                            $editPersona->genero=$newGenero;
                            $editPersona->estadocivil=intval($row->c_estadociv);
                            $editPersona->fechanac=$fechanac;
                            $editPersona->esdiscapacitado=intval($row->c_esdisca);
                            $editPersona->discapacidad=$discapacidad;
                            $editPersona->pais=trim($row->c_pais);
                            $editPersona->departamento=trim($row->c_depar);
                            $editPersona->provincia=trim($row->c_prov);
                            $editPersona->distrito=trim($row->c_dist);
                            $editPersona->direccion=trim($row->c_direc);
                            $editPersona->email=trim($row->c_email);
                            $editPersona->telefono=trim($row->c_telf);
                
                            $editPersona->save();
                        }
                        else{
                            $newPersona = new Persona();
                            $newPersona->tipodoc=intval($row->c_tipodoc);
                            $newPersona->doc=trim($row->c_numdoc);
                            $newPersona->nombres=trim($row->c_noms);
                            $newPersona->apellidopat=trim($row->c_apepat);
                            $newPersona->apellidomat=trim($row->c_apemat);
                            $newPersona->genero=$newGenero;
                            $newPersona->estadocivil=intval($row->c_estadociv);
                            $newPersona->fechanac=$fechanac;
                            $newPersona->esdiscapacitado=intval($row->c_esdisca);
                            $newPersona->discapacidad=$discapacidad;
                            $newPersona->pais=trim($row->c_pais);
                            $newPersona->departamento=trim($row->c_depar);
                            $newPersona->provincia=trim($row->c_prov);
                            $newPersona->distrito=trim($row->c_dist);
                            $newPersona->direccion=trim($row->c_direc);
                            $newPersona->email=trim($row->c_email);
                            $newPersona->telefono=trim($row->c_telf);
                            $newPersona->activo='1';
                            $newPersona->borrado='0';
                
                            $newPersona->save();
                
                            $persona_id=$newPersona->id;
                        }

                        $postulantes=Postulante::where('persona_id',$persona_id)->where('semestre_id',intval($row->c_sem))->where('tipo','1')->get();
                        $idPostulante=0;

                        foreach ($postulantes as $key => $dato) {
                            $idPostulante=$dato->id;
                        }
                
                        if(intval($idPostulante)==0)
                        {

                        $newPostulante = new Postulante();
                        $newPostulante->codigo=trim($row->c_codpos);
                        $newPostulante->semestre_id=intval($row->c_sem);
                        $newPostulante->escuela_id=intval($row->c_carr1);
                        $newPostulante->colegio=trim($row->c_termino5);
                        $newPostulante->modalidadadmision_id=intval($row->c_modadmi);
                        $newPostulante->modalidadestudios=intval($row->c_modestu);
                        $newPostulante->puntaje=floatval($row->c_puntaje);
                        $newPostulante->estado=intval($row->c_estado);
                        $newPostulante->opcioningreso=$opcionIngreso;
                        $newPostulante->persona_id=$persona_id;
                        $newPostulante->observaciones=trim($row->c_obs);
                        $newPostulante->tipo='1';
                        $newPostulante->email=trim($row->c_email);
                        $newPostulante->escuela_id2=$escuela_id2;
                        $newPostulante->tipogestioncolegio=intval($row->c_gestcolegio);
                
                        $newPostulante->activo='1';
                        $newPostulante->borrado='0';
                
                        $newPostulante->save();
                        } 
                        else
                        {

                            $editPostulante =Postulante::find($idPostulante);
                            $editPostulante->codigo=trim($row->c_codpos);
                            $editPostulante->semestre_id=intval($row->c_sem);
                            $editPostulante->escuela_id=intval($row->c_carr1);
                            $editPostulante->colegio=trim($row->c_termino5);
                            $editPostulante->modalidadadmision_id=intval($row->c_modadmi);
                            $editPostulante->modalidadestudios=intval($row->c_modestu);
                            $editPostulante->puntaje=floatval($row->c_puntaje);
                            $editPostulante->estado=intval($row->c_estado);
                            $editPostulante->opcioningreso=$opcionIngreso;
                            $editPostulante->persona_id=$persona_id;
                            $editPostulante->observaciones=trim($row->c_obs);

                            $editPostulante->email=trim($row->c_email);
                            $editPostulante->escuela_id2=$escuela_id2;
                            $editPostulante->tipogestioncolegio=intval($row->c_gestcolegio);


                            $editPostulante->save();

                        }               
  
                    }

                }
                   

            })->get(); 
        
    }

        $errtitulo = $errorColumna.' '.$errorFila;
        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector, 'errtitulo'=>$errtitulo]);
   
    }



























    public function importarArchivo2(Request $request)
    {
        ini_set('memory_limit','256M');

        ini_set('upload_max_filesize','128M');

        $archivo="";
        $file = $request->archivo;
        $segureFile=0;

       // $nombreArchivo="";

        $result='1';
        $msj='';
        $selector='';
        $errorColumna='';
        $errorFila='';

        if($request->hasFile('archivo')){



           /* $nombreArchivo=$request->nombreArchivo;*/

            $aux2='postulantePostgrado'.date('d-m-Y').'-'.date('H-i-s');
            $input2  = array('archivo' => $file) ;
            $reglas2 = array('archivo' => 'required|file:1,51200');
            $validatorF = Validator::make($input2, $reglas2);

          /*  $inputNA  = array('archivonombre' => $nombreArchivo);
            $reglasNA = array('archivonombre' => 'required');
            $validatorNA = Validator::make($inputNA, $reglasNA);*/

          

            if ($validatorF->fails())
            {

            $segureFile=1;
            $msj="El archivo adjunto ingresado tiene un tamaño no válido superior a los 5 MB, ingrese otro archivo o limpie el formulario";
            $result='0';
            $selector='archivo';
            }
          /*  elseif($validatorNA->fails()){
                $segureFile=1;
                $msj="Si va a registrar un archivo adjunto, debe de ingresar un nombre válido con el que se verá en el sistema";
                $result='0';
                $selector='txtArchivoAdjunto';
            }*/
            else
            {
                $nombre2=$file->getClientOriginalName();
                $extension2=$file->getClientOriginalExtension();
                $nuevoNombre2=$aux2.".".$extension2;
                //$subir2=Storage::disk('revistas')->put($nuevoNombre2, \File::get($file));
                $subir2=Storage::disk('infoFile')->put($nuevoNombre2, \File::get($file));

               

                if($extension2=="xls" || $extension2=="xlsx"  || $extension2=="XLS" || $extension2=="XLSX" )
                {

                if($subir2){
                    $archivo=$nuevoNombre2;
                }
                else{
                    $msj="Error al subir el archivo adjunto, intentelo nuevamente luego";
                    $segureFile=1;
                    $result='0';
                    $selector='archivo';
                }
                }
                else {
                    $segureFile=1;
                    $msj="El archivo adjunto ingresado tiene una extensión no válida, ingrese otro archivo o limpie el formulario";
                    $result='0';
                    $selector='archivo';
                }
            }

        }

        if($segureFile==1){
            Storage::disk('infoFile')->delete($archivo);

            
        }
        else
        {

             $variablePrueba = "hola"; //si quieres meter una variable exterma al recorrido del excel

             $fecha=date("Y-m-d");

            $errorFila="";
            $errorColumna="";
            $detError="";
            $error=0;
            $msj="";
    
            $semestres=Semestre::where('activo','1')->where('borrado','0')->get();
            $modalidadAdmisions=Modalidadadmision::where('activo','1')->where('borrado','0')->get();


                 Excel::load(public_path().'/archivosExcel/'.$archivo, function ($reader) use (&$errorFila,  &$errorColumna,  &$detError, &$error, $archivo, &$msj, $semestres, $modalidadAdmisions, &$result, &$selector) { 

                    //$reader->first(); // Leer datos de la primera hoja

                   $resultado=$reader->skipRows(4)->first();


                   $error=0;

                   foreach ($resultado as $key => $row) {


                    // SEMESTRE DE POSTULACIÓN validando c_sem
                    $bandera01=false;
                    foreach ($semestres as $key3 => $dato) {
                        if(intval($row->c_sem)==$dato->id)
                        {
                            $bandera01=true;
                            break;
                        }
                    }
                    if($bandera01==false){

                        $errorFila=$key." Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna SEMESTRE DE POSTULACIÓN";
                        $detError="El Identificador de Semestre no corresponde a ninguno ingresado en la base de datos. Corrija la Columna B, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // GRADO A POSTULAR validando c_grado_pos

                    $bandera01=false;
                    if((trim($row->c_grado_pos)=="M") || (trim($row->c_grado_pos)=="D") || (trim($row->c_grado_pos)=="m") || (trim($row->c_grado_pos)=="d")){
                        $bandera01=true;
                        }
                        if($bandera01==false){
    
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna GRADO A POSTULAR";
                            $detError="Consideró un dato no identificado, indique M para Maestría ó D para Doctorado, sin espacios en blanco. Corrija la Columna C, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }


                    // DENOMINACIÓN DE GRADO Y MENSIÓN validando c_nombre_grado

                    $bandera01=false;
                    if(strlen(trim($row->c_nombre_grado))>0){
                        $bandera01=true;
                        }
                        if($bandera01==false){
    
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna DENOMINACIÓN DE GRADO Y MENSIÓN";
                            $detError="La Denominación del Grado y Mensión se encuentra en blanco, Ingrese el valor correspondiente. Corrija la Columna D, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }


                    // MODALIDAD DE ADMISIÓN validando c_modadmi

                    $bandera01=false;
                    foreach ($modalidadAdmisions as $key6 => $dato) {
                        if(intval($row->c_modadmi)==$dato->id)
                        {
                            $bandera01=true;
                            break;
                        }
                    }
                    if($bandera01==false){
        
                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna MODALIDAD DE ADMISIÓN";
                        $detError="El Identificador de Modalidad de Admisión no corresponde a ninguna Modalidad de Admisión registrada en la base de datos. Corrija la Columna E, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // MODALIDAD DE ESTUDIOS validando c_modestu

                    $bandera01=false;
                    if(intval($row->c_modestu)==1 || intval($row->c_modestu)==2 || intval($row->c_modestu)==3){
                        $bandera01=true;
                        }
                        if($bandera01==false){
    
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna MODALIDAD DE ESTUDIOS";
                            $detError="El código de Modalidad de Estudios Ingresada no corresponde a los valores posibles de ser consignados. Ingrese 1 para Presencial, ó 2 para Semipresencial ó 3 para Virtual. Corrija la Columna F, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }


                    // ESTADO DE INGRESO validando c_estado

                    $bandera01=false;
                    if(intval($row->c_estado)==1 || intval($row->c_estado)==0){
                        $bandera01=true;
                        }
                        if($bandera01==false){
    
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna ESTADO DE INGRESO";
                            $detError="El código del Estado de Ingreso no corresponde a los valores posibles de ser consignados. Solo debe de llevar valores de 0 para No Ingresó o 1 para Si Ingresó. Corrija la Columna G, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }


                    // TIPO DE DOCUMENTO validando c_tipodoc

                    $bandera01=false;
                    if(intval($row->c_tipodoc)==1 || intval($row->c_tipodoc)==2 || intval($row->c_tipodoc)==3 || intval($row->c_tipodoc)==4 || intval($row->c_tipodoc)==5){
                        $bandera01=true;
                        }
                        if($bandera01==false){
    
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna TIPO DE DOCUMENTO";
                            $detError="El código del Tipo de Documento no corresponde a los valores posibles de ser consignados (1: DNI, 2: RUC, 3: Carnet de Extranjería, 4: Pasaporte, 5: Partida de Nacimiento). Corrija la Columna H, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }

                    
                    // NÚMERO DE DOCUMENTO validando c_numdoc

                    $bandera01=false;
                    if(strlen(trim($row->c_numdoc))>=8){
                        $bandera01=true;
                        }
                        if($bandera01==false){
    
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna NÚMERO DE DOCUMENTO";
                            $detError="El Número de Documento de Indentidad ingresado se encuentran en blanco o no cuenta con un formato correcto. Corrija la Columna I, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }


                    // CÓDIGO DE POSTULANTE validando c_codpos

                    $bandera01=false;
                    if(strlen(trim($row->c_codpos))>0){
                        $bandera01=true;
                        }
                        if($bandera01==false){
    
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna CÓDIGO DE POSTULANTE";
                            $detError="El código ingresado se encuentran en blanco. Corrija la Columna J, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }

                    
                    // APELLIDO PATERNO validando c_apepat 

                    $bandera01=false;
                    if(strlen(trim($row->c_apepat))>0){
                        $bandera01=true;
                        }
                        if($bandera01==false){
    
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna APELLIDO PATERNO";
                            $detError="El Apellido ingresado se encuentran en blanco. Corrija la Columna K, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }


                    // NOMBRES validando c_noms 

                    $bandera01=false;
                    if(strlen(trim($row->c_noms))>0){
                        $bandera01=true;
                        }
                        if($bandera01==false){
    
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna NOMBRES";
                            $detError="Los Nombres ingresados se encuentran en blanco. Corrija la columna M, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }


                    // GÉNERO validando c_genero 

                    $bandera01=false;
                    if((trim($row->c_genero)=="M") || (trim($row->c_genero)=="F") || (trim($row->c_genero)=="m") || (trim($row->c_genero)=="f")){
                        $bandera01=true;
                        }
                        if($bandera01==false){
    
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna GÉNERO";
                            $detError="Consideró un dato no identificado, indique M para másculino ó F para femenino, sin espacios en blanco. Corrija la Columna N, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }

                    
                    // FECHA DE NACIMIENTO validando c_fechanac 

                    if(strlen(trim($row->c_fechanac))==10){

                    //$dateTime = new DateTime::createFromFormat('d/m/Y',$row->c_fechanac);   //pasar a datetime

                    if(checkdate(intval(substr($row->c_fechanac, -7,2)), intval(substr($row->c_fechanac, -10,2)), intval(substr($row->c_fechanac, -4)))){
                        $var=pasFechaBD($row->c_fechanac);
                        $dateTime = DateTime::createFromFormat('Y-m-d', $var);  //pasar a datetime
                        $fechanac=$dateTime->format('Y-m-d');
                        $bandera01=false;
                        if($fechanac != null){
                            $bandera01=true;
                            }
                            if($bandera01==false){
        
                                $errorFila="Error en la Fila ".($key+6);
                                $errorColumna="Error en la Columna FECHA DE NACIMIENTO";
                                $detError="EL dato ingresado se encuentran en blanco o no tiene un formato correcto dd/mm/aaaa. Corrija la Columna O, Fila ".($key+6);
                                $error=1;
                                break 1;
        
                            }
                        }
                        else{
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna FECHA DE NACIMIENTO";
                            $detError="EL dato ingresado se encuentran en blanco o no tiene un formato correcto dd/mm/aaaa. Corrija la Columna O, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }

                    }
                    else{
                        if($row->c_fechanac != null && strlen($row->c_fechanac->format('Y-m-d')) != null){
                            $bandera01=true;
                        }
                        else{
                            $bandera01=false;
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna FECHA DE NACIMIENTO";
                            $detError="EL dato ingresado se encuentran en blanco o no tiene un formato correcto dd/mm/aaaa. Corrija la Columna O, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }
                    }


                    // ESTADO CIVIL validando c_estadociv 

                    $bandera01=false;
                    if(intval($row->c_estadociv)==1 || intval($row->c_estadociv)==2 || intval($row->c_estadociv)==3 || intval($row->c_estadociv)==4){
                        $bandera01=true;
                        }
                        if($bandera01==false){
    
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna ESTADO CIVIL";
                            $detError="El código del Estado CIvil no corresponde a los valores posibles de ser consignados (1: Soltero (a), 2: Casado (a), 3: Viudo (a), ó 4: Divorsiado (a)). Corrija la Columna P, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }


                    // SUFRE DISCAPACIDAD validando c_esdisca 

                    $bandera01=false;
                    if(intval($row->c_esdisca)==1 || intval($row->c_esdisca)==0){
                        $bandera01=true;
                        }
                        if($bandera01==false){
    
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna SUFRE DISCAPACIDAD";
                            $detError="El código de Condición de Discapacidad no corresponde a los valores posibles de ser consignados. Consigne 1 para SI o 0 para NO. Corrija la Columna Q, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }


                    // DISCAPACIDAD QUE PADECE validando c_disca 
                
                    if( intval($row->c_esdisca)==1){
                    $bandera01=false;
                    if(strlen(trim($row->c_disca))>0){
                        $bandera01=true;
                        }
                        if($bandera01==false){
    
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna DISCAPACIDAD QUE PADECE";
                            $detError="Si ha ingresado que el Alumno es Discapacitado, ingrese la Discapacidad que padece, no puede dejar el registro en blanco. Corrija la Columna R, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }
                    }

                
                    // PUNTAJE OBTENIDO validando c_puntaje 

                    $bandera01=true;
                    if(floatval($row->c_puntaje)<0){
                        $bandera01=false;
                        }
                        if($bandera01==false){
    
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna PUNTAJE OBTENIDO";
                            $detError="Ha consignado un valor no válido, ingrese un valor mayor o igual a cero. Corrija la Columna S, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }


                    // PAÍS DE PROCEDENCIA validando c_pais 

                    $bandera01=false;
                    if(strlen(trim($row->c_pais))>0){
                    $bandera01=true;
                    }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna PAÍS DE PROCEDENCIA";
                        $detError="El País de Procedencia ingresado se encuentran en blanco. Corrija la Columna T, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // DEPARTAMENTO DE PROCEDENCIA validando c_depar

                    $bandera01=false;
                    if(strlen(trim($row->c_depar))>0){
                    $bandera01=true;
                    }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna DEPARTAMENTO DE PROCEDENCIA";
                        $detError="El Departamento de Procedencia ingresado se encuentran en blanco. Corrija la Columna U, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // PROVINCIA DE PROCEDENCIA validando c_prov

                    $bandera01=false;
                    if(strlen(trim($row->c_prov))>0){
                    $bandera01=true;
                    }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna PROVINCIA DE PROCEDENCIA";
                        $detError="La Provincia de Procedencia ingresado se encuentran en blanco. Corrija la Columna V, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // DISTRITO DE PROCEDENCIA validando c_dist

                    $bandera01=false;
                    if(strlen(trim($row->c_dist))>0){
                    $bandera01=true;
                    }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna DISTRITO DE PROCEDENCIA";
                        $detError="El Distrito de Procedencia ingresado se encuentran en blanco. Corrija la Columna W, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // UNIVERSIDAD DONDE CULMINÓ SUS ESTUDIOS validando c_termino_carr

                    $bandera01=false;
                    if(strlen(trim($row->c_termino_carr))>0){
                    $bandera01=true;
                    }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna UNIVERSIDAD DONDE CULMINÓ SUS ESTUDIOS";
                        $detError="El Valor ingresado se encuentran en blanco. Corrija la Columna X, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // DIRECCIÓN DEL POSTULANTE validando c_direc

                    $bandera01=false;
                    if(strlen(trim($row->c_direc))>0){
                    $bandera01=true;
                    }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna DIRECCIÓN DEL POSTULANTE";
                        $detError="El Valor ingresado se encuentran en blanco. Corrija la Columna Y, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // CORREO ELECTRÓNICO validando c_email

                    $bandera01=false;
                    if(strlen(trim($row->c_email))>0 && is_valid_email(trim($row->c_email))){
                    $bandera01=true;
                    }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna CORREO ELECTRÓNICO";
                        $detError="El Valor ingresado se encuentran en blanco, o cuenta con un formato incorrecto. Corrija la Coumna Z, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    }

                    if($error==1){
                    Storage::disk('infoFile')->delete($archivo);
                    $msj=$detError.' Por lo Que no se realizó la Importación de Datos.';
                    $result='0';
                    }
                    else{

                    $msj="Datos Importados Exitosamente";
                    
                    foreach ($resultado as $key => $row) {

                        $persona_id="0";
                        $idPostulante="0";

                        $persona=Persona::where('doc',(trim($row->c_numdoc)))->where('tipodoc',intval($row->c_tipodoc))->get();

                        foreach ($persona as $key => $dato) {
                            $persona_id=$dato->id;
                        }

                        $newGenero="M";
                        if(trim($row->c_genero)=="M" || trim($row->c_genero)=="m" )
                        {
                            $newGenero="M";
                        }elseif(trim($row->c_genero)=="F" || trim($row->c_genero)=="f")
                        {
                            $newGenero="F";
                        }

                        $discapacidad="";
                        if(intval($row->c_esdisca)==0)
                        {
                            $discapacidad="";
                        }else{
                            $discapacidad=trim($row->c_disca);
                        }

                        $gradoPostular=3;
                        if(trim($row->c_grado_pos)=="M" || trim($row->c_grado_pos)=="m" )
                        {
                            $gradoPostular=3;
                        }elseif(trim($row->c_grado_pos)=="D" || trim($row->c_grado_pos)=="d")
                        {
                            $gradoPostular=4;
                        }

                        $fechanac= null;
                        if(strlen(trim($row->c_fechanac))==10){

                            $fechanac=pasFechaBD($row->c_fechanac);
                        }
                        else{
                            $fechanac=$row->c_fechanac->format('Y-m-d');
                        }


                        if(intval($persona_id)!=0)
                        {
                            $editPersona =Persona::find($persona_id);
                            $editPersona->tipodoc=intval($row->c_tipodoc);
                            $editPersona->doc=trim($row->c_numdoc);
                            $editPersona->nombres=trim($row->c_noms);
                            $editPersona->apellidopat=trim($row->c_apepat);
                            $editPersona->apellidomat=trim($row->c_apemat);
                            $editPersona->genero=$newGenero;
                            $editPersona->estadocivil=intval($row->c_estadociv);
                            $editPersona->fechanac=$fechanac;
                            $editPersona->esdiscapacitado=intval($row->c_esdisca);
                            $editPersona->discapacidad=$discapacidad;
                            $editPersona->pais=trim($row->c_pais);
                            $editPersona->departamento=trim($row->c_depar);
                            $editPersona->provincia=trim($row->c_prov);
                            $editPersona->distrito=trim($row->c_dist);
                            $editPersona->direccion=trim($row->c_direc);
                            $editPersona->email=trim($row->c_email);
                            $editPersona->telefono=trim($row->c_telf);
                
                            $editPersona->save();
                        }
                        else{
                            $newPersona = new Persona();
                            $newPersona->tipodoc=intval($row->c_tipodoc);
                            $newPersona->doc=trim($row->c_numdoc);
                            $newPersona->nombres=trim($row->c_noms);
                            $newPersona->apellidopat=trim($row->c_apepat);
                            $newPersona->apellidomat=trim($row->c_apemat);
                            $newPersona->genero=$newGenero;
                            $newPersona->estadocivil=intval($row->c_estadociv);
                            $newPersona->fechanac=$fechanac;
                            $newPersona->esdiscapacitado=intval($row->c_esdisca);
                            $newPersona->discapacidad=$discapacidad;
                            $newPersona->pais=trim($row->c_pais);
                            $newPersona->departamento=trim($row->c_depar);
                            $newPersona->provincia=trim($row->c_prov);
                            $newPersona->distrito=trim($row->c_dist);
                            $newPersona->direccion=trim($row->c_direc);
                            $newPersona->email=trim($row->c_email);
                            $newPersona->telefono=trim($row->c_telf);
                            $newPersona->activo='1';
                            $newPersona->borrado='0';
                
                            $newPersona->save();
                
                            $persona_id=$newPersona->id;
                        }

                        $postulantes=Postulante::where('persona_id',$persona_id)->where('semestre_id',intval($row->c_sem))->where('tipo','2')->where('grado',$gradoPostular)->get();
                        $idPostulante=0;

                        foreach ($postulantes as $key => $dato) {
                            $idPostulante=$dato->id;
                        }
                
                        if(intval($idPostulante)==0)
                        {

                        $newPostulante = new Postulante();
                        $newPostulante->codigo=trim($row->c_codpos);
                        $newPostulante->semestre_id=intval($row->c_sem);
                        $newPostulante->modalidadadmision_id=intval($row->c_modadmi);
                        $newPostulante->modalidadestudios=intval($row->c_modestu);
                        $newPostulante->puntaje=floatval($row->c_puntaje);
                        $newPostulante->estado=intval($row->c_estado);
                        $newPostulante->persona_id=$persona_id;
                        $newPostulante->observaciones=trim($row->c_obs);
                        $newPostulante->tipo='2';
                        $newPostulante->grado=$gradoPostular;
                        $newPostulante->nombreGrado=trim($row->c_nombre_grado);
                        $newPostulante->universidadCulminoPregrado=trim($row->c_termino_carr);
                        $newPostulante->email=trim($row->c_email);
                
                        $newPostulante->activo='1';
                        $newPostulante->borrado='0';
                
                        $newPostulante->save();
                        } 
                        else
                        {

                            $editPostulante =Postulante::find($idPostulante);
                            $editPostulante->codigo=trim($row->c_codpos);
                            $editPostulante->semestre_id=intval($row->c_sem);
                            $editPostulante->modalidadadmision_id=intval($row->c_modadmi);
                            $editPostulante->modalidadestudios=intval($row->c_modestu);
                            $editPostulante->puntaje=floatval($row->c_puntaje);
                            $editPostulante->estado=intval($row->c_estado);
                            $editPostulante->persona_id=$persona_id;
                            $editPostulante->observaciones=trim($row->c_obs);
                            $editPostulante->tipo='2';
                            $editPostulante->grado=$gradoPostular;
                            $editPostulante->nombreGrado=trim($row->c_nombre_grado);
                            $editPostulante->universidadCulminoPregrado=trim($row->c_termino_carr);
                            $editPostulante->email=trim($row->c_email);


                            $editPostulante->save();

                        }               
  
                    }

                }
                   

            })->get(); 
        
    }

        $errtitulo = $errorColumna.' '.$errorFila;
        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector, 'errtitulo'=>$errtitulo]);
   
    }


}
