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
            return view('postulantes.index',compact('tipouser','modulo','escuelas','semestres','modalidadAdmision','semestresel','contse','semestreNombre'));
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


            $modulo="postulantespostgrado";
            return view('postulantespostgrado.index',compact('tipouser','modulo','escuelas','semestres','modalidadAdmision','semestresel','contse','semestreNombre'));
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


/*     public function imprimirExcel($var1)
    {
        //return Excel::download(new UsersExport, 'users.xlsx');
        return Excel::download(new PlantillaPostulanteExport, 'invoices.xlsx');
        //return "hola ".$var1;
    } */

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
}
