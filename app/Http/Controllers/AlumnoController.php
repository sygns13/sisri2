<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Escuela;
use App\Modalidadadmision;
use App\Semestre;
use Validator;
use Auth;
use DB;

use App\Alumno;
use App\Persona;
use App\Tipouser;
use App\User;

use App\Exports\PlantillaPostulanteExport;
use Maatwebsite\Excel\Facades\Excel;

class AlumnoController extends Controller
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


            $modulo="alumnospregrado";
            return view('alumnospregrado.index',compact('tipouser','modulo','escuelas','semestres','semestresel','contse','semestreNombre'));
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


            $modulo="alumnospregradoegresados";
            return view('alumnospregradoegresados.index',compact('tipouser','modulo','escuelas','semestres','semestresel','contse','semestreNombre'));
        }
        else
        {
            return redirect('home');           
        }
    }



    public function index3()
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


            $modulo="alumnospostgrado";
            return view('alumnospostgrado.index',compact('tipouser','modulo','escuelas','semestres','semestresel','contse','semestreNombre'));
        }
        else
        {
            return redirect('home');           
        }
    }


    public function index4()
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


            $modulo="alumnosegresadospostgrado";
            return view('alumnosegresadospostgrado.index',compact('tipouser','modulo','escuelas','semestres','semestresel','contse','semestreNombre'));
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

     $alumnos ="";

     if($tipo==1 || $tipo==2)
     {    
     $alumnos = DB::table('alumnos')
     ->join('personas', 'personas.id', '=', 'alumnos.persona_id')
     ->join('semestres as semestre', 'semestre.id', '=', 'alumnos.semestre_id')
     ->join('escuelas', 'escuelas.id', '=', 'alumnos.escuela_id')
     ->join('facultads', 'facultads.id', '=', 'escuelas.facultad_id')
     ->join('semestres as semestreingreso', 'semestreingreso.id', '=', 'alumnos.primerPeriodoMatricula')

     ->where('alumnos.borrado','0')
     ->where('alumnos.tipo',$tipo)
     ->where('semestre.id',$semestre_id)
     ->where(function($query) use ($buscar){
        $query->where('personas.nombres','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidopat','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidomat','like','%'.$buscar.'%');
        $query->orWhere('personas.doc','like','%'.$buscar.'%');
        $query->orWhere('alumnos.codigo','like','%'.$buscar.'%');
        })
     ->orderBy('personas.apellidopat')
     ->orderBy('personas.apellidomat')
     ->orderBy('personas.nombres')

     ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono','alumnos.id',
     
     'alumnos.periodoMatricula','alumnos.escuela_id','alumnos.escalaPago','alumnos.promedioPonderado','alumnos.promedioSemestre','alumnos.periodoIngreso','alumnos.primerPeriodoMatricula','alumnos.alumnoRiesgo','alumnos.numCursosRiesgo','alumnos.observaciones','alumnos.persona_id','alumnos.estado','alumnos.descestado','alumnos.codigo','alumnos.tituladoOtraCarrera','alumnos.egresadoOtraCarrera','alumnos.otraCarrera','alumnos.tipo','alumnos.grado','alumnos.nombreGrado','alumnos.escalaPagodesc','alumnos.semestre_id','semestre.nombre as semestre','escuelas.id as idescuela','escuelas.nombre as escuela','facultads.id as idfacultad','facultads.nombre as facultad','semestreingreso.id as idSemestreIngreso','semestreingreso.nombre as semestreingreso','alumnos.movinacional','alumnos.moviinternacional','alumnos.ismovnacional','alumnos.ismovinternacional','alumnos.otrotitulo')
     ->paginate(50);

    }

    elseif($tipo==3 || $tipo==4)
     {    
     $alumnos = DB::table('alumnos')
     ->join('personas', 'personas.id', '=', 'alumnos.persona_id')
     ->join('semestres as semestre', 'semestre.id', '=', 'alumnos.semestre_id')


     ->where('alumnos.borrado','0')
     ->where('alumnos.tipo',$tipo)
     ->where('semestre.id',$semestre_id)
     ->where(function($query) use ($buscar){
        $query->where('personas.nombres','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidopat','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidomat','like','%'.$buscar.'%');
        $query->orWhere('personas.doc','like','%'.$buscar.'%');
        $query->orWhere('alumnos.codigo','like','%'.$buscar.'%');
        })
     ->orderBy('personas.apellidopat')
     ->orderBy('personas.apellidomat')
     ->orderBy('personas.nombres')

     ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono','alumnos.id',
     
     'alumnos.periodoMatricula','alumnos.escuela_id','alumnos.escalaPago','alumnos.promedioPonderado','alumnos.promedioSemestre','alumnos.periodoIngreso','alumnos.primerPeriodoMatricula','alumnos.alumnoRiesgo','alumnos.numCursosRiesgo','alumnos.observaciones','alumnos.persona_id','alumnos.estado','alumnos.descestado','alumnos.codigo','alumnos.tituladoOtraCarrera','alumnos.egresadoOtraCarrera','alumnos.otraCarrera','alumnos.tipo','alumnos.grado','alumnos.nombreGrado','alumnos.escalaPagodesc','alumnos.semestre_id','semestre.nombre as semestre','alumnos.movinacional','alumnos.moviinternacional','alumnos.ismovnacional','alumnos.ismovinternacional','alumnos.otrotitulo')
     ->paginate(50);

    }


     return [
        'pagination'=>[
            'total'=> $alumnos->total(),
            'current_page'=> $alumnos->currentPage(),
            'per_page'=> $alumnos->perPage(),
            'last_page'=> $alumnos->lastPage(),
            'from'=> $alumnos->firstItem(),
            'to'=> $alumnos->lastItem(),
        ],
        'alumnos'=>$alumnos
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
     * Ingrese la Descripción de la Escala de Pago del Alumno a newly created resource in storage.
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

        $periodoMatricula=$request->periodoMatricula;
        $escuela_id=$request->escuela_id;
        $escalaPago=$request->escalaPago;
        $promedioPonderado=$request->promedioPonderado;
        $promedioSemestre=$request->promedioSemestre;
        $periodoIngreso=$request->periodoIngreso;
        $primerPeriodoMatricula=$request->primerPeriodoMatricula;
        $alumnoRiesgo=$request->alumnoRiesgo;
        $numCursosRiesgo=$request->numCursosRiesgo;
        $observaciones=$request->observaciones;
        $persona_id=$request->persona_id;
        $estado=$request->estado;
        $descestado=$request->descestado;
        $codigo=$request->codigo;
        $tituladoOtraCarrera=$request->tituladoOtraCarrera;
        $egresadoOtraCarrera=$request->egresadoOtraCarrera;
        $otraCarrera=$request->otraCarrera;
        $tipo=$request->tipo;
        $grado=$request->grado;
        $nombreGrado=$request->nombreGrado;
        $escalaPagodesc=$request->escalaPagodesc;
        $semestre_id=$request->semestre_id;
        $movinacional=$request->movinacional;
        $moviinternacional=$request->moviinternacional;
        $ismovnacional=$request->ismovnacional;
        $ismovinternacional=$request->ismovinternacional;
        $otrotitulo=$request->otrotitulo;

       


        if(intval($esdiscapacitado)==0)
        {
            $discapacidad="";
        }

        if(intval($alumnoRiesgo)==0)
        {
            $numCursosRiesgo=0;
        }

        if(intval($egresadoOtraCarrera)==0)
        {
            $otraCarrera="";
        }

        if(intval($tituladoOtraCarrera)==0)
        {
            $otrotitulo="";
        }

        if(intval($grado)==0)
        {
            $nombreGrado="";
        }

        if(intval($escalaPago)==0)
        {
            $escalaPagodesc="";
        }

        if(intval($ismovnacional)==0)
        {
            $movinacional="";
        }

        if(intval($ismovinternacional)==0)
        {
            $moviinternacional="";
        }



        $result='1';
        $msj='';
        $selector='';


        $regla0=DB::table('alumnos')
        ->join('personas', 'personas.id', '=', 'alumnos.persona_id')
        ->where('personas.tipodoc',$tipodoc)
        ->where('personas.doc',$doc)
        ->where('alumnos.semestre_id',$semestre_id)
        ->where('alumnos.tipo',$tipo)->count();

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

        $input18  = array('promedioPonderado' => $promedioPonderado);
        $reglas18 = array('promedioPonderado' => 'required');

        $input19  = array('promedioSemestre' => $promedioSemestre);
        $reglas19 = array('promedioSemestre' => 'required');

        $input20  = array('primerPeriodoMatricula' => $primerPeriodoMatricula);
        $reglas20 = array('primerPeriodoMatricula' => 'required');

        $input21  = array('periodoIngreso' => $periodoIngreso);
        $reglas21 = array('periodoIngreso' => 'required');

     



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


        if($regla0>0){
            $result='0';
            $msj='Ya se encuentra registrado un Alumno Matriculado de Pregrado con el Tipo y Documento de Identidad ingresado, del semestre seleccionado';
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
            $msj='Complete el Documento de Identidad del alumno';
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
            $msj='Ingrese los nombres del alumno';
            $selector='txtnombres';
        }
        elseif ($validator4->fails()) {
            $result='0';
            $msj='Ingrese el apellido paterno del alumno';
            $selector='txtapepat';
        }
        elseif ($validator5->fails()) {
            $result='0';
            $msj='Ingrese el apellido materno del alumno';
            $selector='txtapemat';
        }
        elseif ($validator6->fails()) {
            $result='0';
            $msj='Seleccione el Género del alumno';
            $selector='cbugenero';
        }
        elseif ($validator7->fails()) {
            $result='0';
            $msj='Seleccione el Estado Civil del alumno';
            $selector='cbuestadocivil';
        }
        elseif ($validator8->fails()) {
            $result='0';
            $msj='Ingrese la Fecha de Nacimiento del alumno';
            $selector='txtfechanac';
        }
        elseif ($validator9->fails()) {
            $result='0';
            $msj='Seleccione si el alumno es Discapacitado';
            $selector='cbugenero';
        }
        elseif (intval($esdiscapacitado)==1 && strlen($discapacidad)==0) {
            $result='0';
            $msj='Si ha indicado que el alumno es discapacitado, ingrese la discapacidad que padece';
            $selector='txtdiscapacidad';
        }

        elseif ($validator10->fails()) {
            $result='0';
            $msj='Ingrese el País de procedencia del alumno';
            $selector='txtpais';
        }
        elseif ($validator11->fails()) {
            $result='0';
            $msj='Ingrese el Departamento de procedencia del alumno';
            $selector='txtdep';
        }
        elseif ($validator12->fails()) {
            $result='0';
            $msj='Ingrese la Provincia de procedencia del alumno';
            $selector='txtprov';
        }
        elseif ($validator13->fails()) {
            $result='0';
            $msj='Ingrese el Distrito de procedencia del alumno';
            $selector='txtdist';
        }
        elseif ($validator14->fails()) {
            $result='0';
            $msj='Ingrese la Dirección del alumno';
            $selector='txtDir';
        }
        elseif ($validator15->fails()) {
            $result='0';
            $msj='Ingrese el Código del alumno';
            $selector='txtcodigo';
        }
        elseif ($validator16->fails()) {
            $result='0';
            $msj='Seleccione el Semestre de Postulación del alumno';
            $selector='cbusemestre';
        }
        elseif ($validator17->fails() || intval($escuela_id)==0 && ($tipo==1 || $tipo==2)) {
            $result='0';
            $msj='Seleccione la Escuela Profesional del alumno '.$tipo;
            $selector='cbucarrera';
        }
        elseif ($validator18->fails()) {
            $result='0';
            $msj='Ingrese el Promedio Ponderado del alumno';
            $selector='txtpromedioponderado';
        }
        elseif ($validator19->fails()) {
            $result='0';
            $msj='Ingrese el Promedio del Semestre del alumno';
            $selector='txtpromediosemestre';
        }
        elseif (($validator21->fails() || intval($periodoIngreso)==0) && ($tipo==1 || $tipo==2)) {
            $result='0';
            $msj='Seleccione el Semestre de Ingreso del Alumno';
            $selector='cbusemestreingreso';
        }


        elseif (($validator20->fails() || intval($primerPeriodoMatricula)==0) && ($tipo==1 || $tipo==2)) {
            $result='0';
            $msj='Seleccione el Primer Semestre de Matrícula del Alumno';
            $selector='cbuprimersemestre';
        }

        elseif (intval($escalaPago)!=0 && strlen($escalaPagodesc)==0) {
            $result='0';
            $msj='Ingrese la Descripción de la Escala de Pago del Alumno';
            $selector='txtEsclaPago';
        }
        elseif (intval($ismovnacional)!=0 && strlen($movinacional)==0 && ($tipo==1 || $tipo==2)) {
            $result='0';
            $msj='Ingrese la Descripción de la Movilidad Nacional Efectuada por el Alumno';
            $selector='txtmovinac';
        }
        elseif (intval($ismovinternacional)!=0 && strlen($moviinternacional)==0 && ($tipo==1 || $tipo==2)) {
            $result='0';
            $msj='Ingrese la Descripción de la Movilidad Internacional Efectuada por el Alumno';
            $selector='txtmovinternacional';
        }

        elseif (intval($tipo)==2 && intval($egresadoOtraCarrera)!=0 && strlen($otraCarrera)==0) {
            $result='0';
            $msj='Ingrese la Descripción de la Otra Carrera Profesional';
            $selector='txtotracarrera';
        }

        elseif (intval($tipo)==2 && intval($tituladoOtraCarrera)!=0 && strlen($otrotitulo)==0) {
            $result='0';
            $msj='Ingrese la Descripción del Título de la  Carrera Profesional '.$nombreGrado.' '.intval($otrotitulo);
            $selector='txttitulootracarrera';
        }


        elseif (strlen($nombreGrado)==0 && ($tipo==3 || $tipo==4)) {
            $result='0';
            $msj='Ingrese la Descripción del Grado y Mensión que Estudia el Alumno';
            $selector='nombreGrado';
        }

      
        else{



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

        if($tipo==1 || $tipo==2)
        {
            $newAlumno = new Alumno();
        $newAlumno->periodoMatricula=$periodoMatricula;
        $newAlumno->escuela_id=$escuela_id;
        $newAlumno->escalaPago=$escalaPago;
        $newAlumno->promedioPonderado=$promedioPonderado;
        $newAlumno->promedioSemestre=$promedioSemestre;
        $newAlumno->periodoIngreso=$periodoIngreso;
        $newAlumno->primerPeriodoMatricula=$primerPeriodoMatricula;
        $newAlumno->alumnoRiesgo=$alumnoRiesgo;
        $newAlumno->numCursosRiesgo=$numCursosRiesgo;
        $newAlumno->observaciones=$observaciones;
        $newAlumno->persona_id=$persona_id;
        $newAlumno->estado=$estado;
        $newAlumno->descestado=$descestado;
        $newAlumno->codigo=$codigo;
        $newAlumno->tituladoOtraCarrera=$tituladoOtraCarrera;
        $newAlumno->egresadoOtraCarrera=$egresadoOtraCarrera;
        $newAlumno->otraCarrera=$otraCarrera;
        $newAlumno->email=$email;
        $newAlumno->grado=$grado;
        $newAlumno->nombreGrado=$nombreGrado;
        $newAlumno->escalaPagodesc=$escalaPagodesc;
        $newAlumno->semestre_id=$semestre_id;
        $newAlumno->movinacional=$movinacional;
        $newAlumno->moviinternacional=$moviinternacional;
        $newAlumno->ismovnacional=$ismovnacional;
        $newAlumno->ismovinternacional=$ismovinternacional;
        $newAlumno->otrotitulo=$otrotitulo;
        $newAlumno->tipo=$tipo;
        $newAlumno->activo='1';
        $newAlumno->borrado='0';

        $newAlumno->save();

        }

        if($tipo==3 || $tipo==4)
        {
            $newAlumno = new Alumno();
        $newAlumno->periodoMatricula=$periodoMatricula;

        $newAlumno->escalaPago=$escalaPago;
        $newAlumno->promedioPonderado=$promedioPonderado;
        $newAlumno->promedioSemestre=$promedioSemestre;
        $newAlumno->periodoIngreso=$periodoIngreso;
        $newAlumno->primerPeriodoMatricula=$primerPeriodoMatricula;
        $newAlumno->alumnoRiesgo=$alumnoRiesgo;
        $newAlumno->numCursosRiesgo=$numCursosRiesgo;
        $newAlumno->observaciones=$observaciones;
        $newAlumno->persona_id=$persona_id;
        $newAlumno->estado=$estado;
        $newAlumno->descestado=$descestado;
        $newAlumno->codigo=$codigo;
        $newAlumno->tituladoOtraCarrera=$tituladoOtraCarrera;
        $newAlumno->egresadoOtraCarrera=$egresadoOtraCarrera;
        $newAlumno->otraCarrera=$otraCarrera;
        $newAlumno->email=$email;
        $newAlumno->grado=$grado;
        $newAlumno->nombreGrado=$nombreGrado;
        $newAlumno->escalaPagodesc=$escalaPagodesc;
        $newAlumno->semestre_id=$semestre_id;
        $newAlumno->movinacional=$movinacional;
        $newAlumno->moviinternacional=$moviinternacional;
        $newAlumno->ismovnacional=$ismovnacional;
        $newAlumno->ismovinternacional=$ismovinternacional;
        $newAlumno->otrotitulo=$otrotitulo;
        $newAlumno->tipo=$tipo;
        $newAlumno->activo='1';
        $newAlumno->borrado='0';

        $newAlumno->save();

        }
        

           

            $msj='Nuevo Alumno registrado con éxito';
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

        $periodoMatricula=$request->periodoMatricula;
        $escuela_id=$request->escuela_id;
        $escalaPago=$request->escalaPago;
        $promedioPonderado=$request->promedioPonderado;
        $promedioSemestre=$request->promedioSemestre;
        $periodoIngreso=$request->periodoIngreso;
        $primerPeriodoMatricula=$request->primerPeriodoMatricula;
        $alumnoRiesgo=$request->alumnoRiesgo;
        $numCursosRiesgo=$request->numCursosRiesgo;
        $observaciones=$request->observaciones;
        $persona_id=$request->persona_id;
        $estado=$request->estado;
        $descestado=$request->descestado;
        $codigo=$request->codigo;
        $tituladoOtraCarrera=$request->tituladoOtraCarrera;
        $egresadoOtraCarrera=$request->egresadoOtraCarrera;
        $otraCarrera=$request->otraCarrera;
        $tipo=$request->tipo;
        $grado=$request->grado;
        $nombreGrado=$request->nombreGrado;
        $escalaPagodesc=$request->escalaPagodesc;
        $semestre_id=$request->semestre_id;
        $movinacional=$request->movinacional;
        $moviinternacional=$request->moviinternacional;
        $ismovnacional=$request->ismovnacional;
        $ismovinternacional=$request->ismovinternacional;
        $otrotitulo=$request->otrotitulo;


        if(intval($esdiscapacitado)==0)
        {
            $discapacidad="";
        }

        if(intval($alumnoRiesgo)==0)
        {
            $numCursosRiesgo=0;
        }

        if(intval($egresadoOtraCarrera)==0)
        {
            $otraCarrera="";
        }

        if(intval($tituladoOtraCarrera)==0)
        {
            $otrotitulo="";
        }

        if(intval($grado)==0)
        {
            $nombreGrado="";
        }

        if(intval($escalaPago)==0)
        {
            $escalaPagodesc="";
        }

        if(intval($ismovnacional)==0)
        {
            $movinacional="";
        }

        if(intval($ismovinternacional)==0)
        {
            $moviinternacional="";
        }



        $result='1';
        $msj='';
        $selector='';


        $regla0=DB::table('alumnos')
        ->join('personas', 'personas.id', '=', 'alumnos.persona_id')
        ->where('personas.tipodoc',$tipodoc)
        ->where('alumnos.id','<>',$id)
        ->where('personas.doc',$doc)
        ->where('alumnos.semestre_id',$semestre_id)
        ->where('alumnos.tipo',$tipo)->count();

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

        $input18  = array('promedioPonderado' => $promedioPonderado);
        $reglas18 = array('promedioPonderado' => 'required');

        $input19  = array('promedioSemestre' => $promedioSemestre);
        $reglas19 = array('promedioSemestre' => 'required');

        $input20  = array('primerPeriodoMatricula' => $primerPeriodoMatricula);
        $reglas20 = array('primerPeriodoMatricula' => 'required');

     
        $input21  = array('periodoIngreso' => $periodoIngreso);
        $reglas21 = array('periodoIngreso' => 'required');


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


        if($regla0>0){
            $result='0';
            $msj='Ya se encuentra registrado un Alumno Matriculado de Pregrado con el Tipo y Documento de Identidad ingresado, del semestre seleccionado';
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
            $msj='Complete el Documento de Identidad del alumno';
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
            $msj='Ingrese los nombres del alumno';
            $selector='txtnombresE';
        }
        elseif ($validator4->fails()) {
            $result='0';
            $msj='Ingrese el apellido paterno del alumno';
            $selector='txtapepatE';
        }
        elseif ($validator5->fails()) {
            $result='0';
            $msj='Ingrese el apellido materno del alumno';
            $selector='txtapematE';
        }
        elseif ($validator6->fails()) {
            $result='0';
            $msj='Seleccione el Género del alumno';
            $selector='cbugeneroE';
        }
        elseif ($validator7->fails()) {
            $result='0';
            $msj='Seleccione el Estado Civil del alumno';
            $selector='cbuestadocivilE';
        }
        elseif ($validator8->fails()) {
            $result='0';
            $msj='Ingrese la Fecha de Nacimiento del alumno';
            $selector='txtfechanacE';
        }
        elseif ($validator9->fails()) {
            $result='0';
            $msj='Seleccione si el alumno es Discapacitado';
            $selector='cbugeneroE';
        }
        elseif (intval($esdiscapacitado)==1 && strlen($discapacidad)==0) {
            $result='0';
            $msj='Si ha indicado que el alumno es discapacitado, ingrese la discapacidad que padece';
            $selector='txtdiscapacidadE';
        }

        elseif ($validator10->fails()) {
            $result='0';
            $msj='Ingrese el País de procedencia del alumno';
            $selector='txtpaisE';
        }
        elseif ($validator11->fails()) {
            $result='0';
            $msj='Ingrese el Departamento de procedencia del alumno';
            $selector='txtdepE';
        }
        elseif ($validator12->fails()) {
            $result='0';
            $msj='Ingrese la Provincia de procedencia del alumno';
            $selector='txtprovE';
        }
        elseif ($validator13->fails()) {
            $result='0';
            $msj='Ingrese el Distrito de procedencia del alumno';
            $selector='txtdistE';
        }
        elseif ($validator14->fails()) {
            $result='0';
            $msj='Ingrese la Dirección del alumno';
            $selector='txtDirE';
        }
        elseif ($validator15->fails()) {
            $result='0';
            $msj='Ingrese el Código del alumno';
            $selector='txtcodigoE';
        }
        elseif ($validator16->fails()) {
            $result='0';
            $msj='Seleccione el Semestre de Postulación del alumno';
            $selector='cbusemestreE';
        }
        elseif (($validator17->fails() || intval($escuela_id)==0) && ($tipo==1 || $tipo==2)) {
            $result='0';
            $msj='Seleccione la Escuela Profesional del alumno';
            $selector='cbucarreraE';
        }
        elseif ($validator18->fails()) {
            $result='0';
            $msj='Ingrese el Promedio Ponderado del alumno';
            $selector='txtpromedioponderadoE';
        }
        elseif ($validator19->fails()) {
            $result='0';
            $msj='Ingrese el Promedio del Semestre del alumno';
            $selector='txtpromediosemestreE';
        }

        elseif (($validator21->fails() || intval($periodoIngreso)==0) && ($tipo==1 || $tipo==2)) {
            $result='0';
            $msj='Seleccione el Semestre de Ingreso del Alumno';
            $selector='cbusemestreingresoE';
        }


        elseif (($validator20->fails() || intval($primerPeriodoMatricula)==0)&& ($tipo==1 || $tipo==2)) {
            $result='0';
            $msj='Seleccione el Primer Semestre de Matrícula del Alumno';
            $selector='cbuprimersemestreE';
        }

        elseif (intval($escalaPago)!=0 && strlen($escalaPagodesc)==0) {
            $result='0';
            $msj='Ingrese la Descripción de la Escala de Pago del Alumno';
            $selector='txtEsclaPagoE';
        }
        elseif (intval($ismovnacional)!=0 && strlen($movinacional)==0 && ($tipo==1 || $tipo==2)) {
            $result='0';
            $msj='Ingrese la Descripción de la Movilidad Nacional Efectuada por el Alumno';
            $selector='txtmovinacE';
        }
        elseif (intval($ismovinternacional)!=0 && strlen($moviinternacional)==0 && ($tipo==1 || $tipo==2)) {
            $result='0';
            $msj='Ingrese la Descripción de la Movilidad Internacional Efectuada por el Alumno';
            $selector='txtmovinternacionalE';
        }

        elseif (intval($tipo)==2 && intval($egresadoOtraCarrera)!=0 && strlen($otraCarrera)==0) {
            $result='0';
            $msj='Ingrese la Descripción de la Otra Carrera Profesional';
            $selector='txtotracarreraE';
        }

        elseif (intval($tipo)==2 && intval($tituladoOtraCarrera)!=0 && strlen($otrotitulo)==0) {
            $result='0';
            $msj='Ingrese la Descripción del Título de la  Carrera Profesional '.$otrotitulo.' '.intval($tituladoOtraCarrera);
            $selector='txttitulootracarreraE';
        }

        elseif (strlen($nombreGrado)==0 && ($tipo==3 || $tipo==4)) {
            $result='0';
            $msj='Ingrese la Descripción del Grado y Mensión que Estudia el Alumno';
            $selector='nombreGrado';
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

            if($tipo==1 || $tipo==2)
            {
                $newAlumno = Alumno::find($id);
        $newAlumno->periodoMatricula=$periodoMatricula;
        $newAlumno->escuela_id=$escuela_id;
        $newAlumno->escalaPago=$escalaPago;
        $newAlumno->promedioPonderado=$promedioPonderado;
        $newAlumno->promedioSemestre=$promedioSemestre;
        $newAlumno->periodoIngreso=$periodoIngreso;
        $newAlumno->primerPeriodoMatricula=$primerPeriodoMatricula;
        $newAlumno->alumnoRiesgo=$alumnoRiesgo;
        $newAlumno->numCursosRiesgo=$numCursosRiesgo;
        $newAlumno->observaciones=$observaciones;
        $newAlumno->persona_id=$persona_id;
        $newAlumno->estado=$estado;
        $newAlumno->descestado=$descestado;
        $newAlumno->codigo=$codigo;
        $newAlumno->tituladoOtraCarrera=$tituladoOtraCarrera;
        $newAlumno->egresadoOtraCarrera=$egresadoOtraCarrera;
        $newAlumno->otraCarrera=$otraCarrera;
        $newAlumno->email=$email;
        $newAlumno->grado=$grado;
        $newAlumno->nombreGrado=$nombreGrado;
        $newAlumno->escalaPagodesc=$escalaPagodesc;
        $newAlumno->semestre_id=$semestre_id;
        $newAlumno->movinacional=$movinacional;
        $newAlumno->moviinternacional=$moviinternacional;
        $newAlumno->ismovnacional=$ismovnacional;
        $newAlumno->ismovinternacional=$ismovinternacional;
        $newAlumno->otrotitulo=$otrotitulo;
            }


            if($tipo==3 || $tipo==4)
            {
                $newAlumno = Alumno::find($id);
        $newAlumno->periodoMatricula=$periodoMatricula;

        $newAlumno->escalaPago=$escalaPago;
        $newAlumno->promedioPonderado=$promedioPonderado;
        $newAlumno->promedioSemestre=$promedioSemestre;
        $newAlumno->periodoIngreso=$periodoIngreso;
        $newAlumno->primerPeriodoMatricula=$primerPeriodoMatricula;
        $newAlumno->alumnoRiesgo=$alumnoRiesgo;
        $newAlumno->numCursosRiesgo=$numCursosRiesgo;
        $newAlumno->observaciones=$observaciones;
        $newAlumno->persona_id=$persona_id;
        $newAlumno->estado=$estado;
        $newAlumno->descestado=$descestado;
        $newAlumno->codigo=$codigo;
        $newAlumno->tituladoOtraCarrera=$tituladoOtraCarrera;
        $newAlumno->egresadoOtraCarrera=$egresadoOtraCarrera;
        $newAlumno->otraCarrera=$otraCarrera;
        $newAlumno->email=$email;
        $newAlumno->grado=$grado;
        $newAlumno->nombreGrado=$nombreGrado;
        $newAlumno->escalaPagodesc=$escalaPagodesc;
        $newAlumno->semestre_id=$semestre_id;
        $newAlumno->movinacional=$movinacional;
        $newAlumno->moviinternacional=$moviinternacional;
        $newAlumno->ismovnacional=$ismovnacional;
        $newAlumno->ismovinternacional=$ismovinternacional;
        $newAlumno->otrotitulo=$otrotitulo;
            }
        


        $newAlumno->save();

           

            $msj='Alumno modificado con éxito';
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

   
        
        $borrar = Alumno::destroy($id);
        //$task->delete();


        $msj='Alumno Seleccionado eliminado exitosamente';
   

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
