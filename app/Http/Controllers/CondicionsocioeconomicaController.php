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
use App\Condicionsocioeconomica;
use App\Persona;
use App\Tipouser;
use App\User;

use Excel;
set_time_limit(600);

use App\Submodulo;
use App\Permisomodulo;
use App\Permisossubmodulo;

class CondicionsocioeconomicaController extends Controller
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

            $submodulo=Submodulo::find(40);
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


            $modulo="condicioneconomicaestudiante";
            return view('condicioneconomicaestudiante.index',compact('tipouser','modulo','escuelas','semestres','semestresel','contse','semestreNombre','submodulo','activoModulo','permisoModulos','permisoSubModulos'));
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
        
     $alumnos = DB::table('condicionsocioeconomica')
     ->join('personas', 'personas.id', '=', 'condicionsocioeconomica.persona_id')
     ->join('semestres', 'semestres.id', '=', 'condicionsocioeconomica.semestre_id')

     ->where('condicionsocioeconomica.borrado','0')
     ->where('semestres.id',$semestre_id)
     ->where(function($query) use ($buscar){
        $query->where('personas.nombres','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidopat','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidomat','like','%'.$buscar.'%');
        $query->orWhere('personas.doc','like','%'.$buscar.'%');
        $query->orWhere('condicionsocioeconomica.codigo','like','%'.$buscar.'%');
        })
     ->orderBy('personas.apellidopat')
     ->orderBy('personas.apellidomat')
     ->orderBy('personas.nombres')

     ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono',
     
     'condicionsocioeconomica.id', 'condicionsocioeconomica.codigo','condicionsocioeconomica.numhermanos','condicionsocioeconomica.numhermanosunasam', 'condicionsocioeconomica.puestopadre', 'condicionsocioeconomica.puestomadre','condicionsocioeconomica.ingresomensualfamiliar','condicionsocioeconomica.condicionviivienda', 'condicionsocioeconomica.tieneseguro', 'condicionsocioeconomica.nombreseguro','condicionsocioeconomica.estalaborando', 'condicionsocioeconomica.semestre_id','semestres.nombre as semestre','condicionsocioeconomica.persona_id')
     ->paginate(50);



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
       
        $semestre_id=$request->semestre_id;
        $persona_id=$request->persona_id;

        $codigo=$request->codigo;
        $numhermanos=$request->numhermanos;
        $numhermanosunasam=$request->numhermanosunasam;
        $puestopadre=$request->puestopadre;
        $puestomadre=$request->puestomadre;
        $ingresomensualfamiliar=$request->ingresomensualfamiliar;
        $condicionviivienda=$request->condicionviivienda;
        $tieneseguro=$request->tieneseguro;
        $nombreseguro=$request->nombreseguro;
        $estalaborando=$request->estalaborando;


        if(intval($tieneseguro)==0)
        {
            $nombreseguro="";
        }




        $result='1';
        $msj='';
        $selector='';


        $regla0=DB::table('condicionsocioeconomica')
        ->join('personas', 'personas.id', '=', 'condicionsocioeconomica.persona_id')
        ->where('personas.tipodoc',$tipodoc)
        ->where('personas.doc',$doc)
        ->where('condicionsocioeconomica.semestre_id',$semestre_id)->count();

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


        $input15  = array('codigo' => $codigo);
        $reglas15 = array('codigo' => 'required');

        $input16  = array('semestre_id' => $semestre_id);
        $reglas16 = array('semestre_id' => 'required');

        $input17  = array('numhermanos' => $numhermanos);
        $reglas17 = array('numhermanos' => 'required');

        $input18  = array('numhermanosunasam' => $numhermanosunasam);
        $reglas18 = array('numhermanosunasam' => 'required');

        $input19  = array('puestopadre' => $puestopadre);
        $reglas19 = array('puestopadre' => 'required');

        $input20 = array('puestomadre' => $puestomadre);
        $reglas20= array('puestomadre' => 'required');

        $input21 = array('ingresomensualfamiliar' => $ingresomensualfamiliar);
        $reglas21= array('ingresomensualfamiliar' => 'required');

        $input22 = array('condicionviivienda' => $condicionviivienda);
        $reglas22= array('condicionviivienda' => 'required');

        $input23 = array('tieneseguro' => $tieneseguro);
        $reglas23= array('tieneseguro' => 'required');

        $input24 = array('nombreseguro' => $nombreseguro);
        $reglas24= array('nombreseguro' => 'required');

        $input25 = array('estalaborando' => $estalaborando);
        $reglas25= array('estalaborando' => 'required');

      

        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);
        $validator5 = Validator::make($input5, $reglas5);
       /* $validator6 = Validator::make($input6, $reglas6);
        $validator7 = Validator::make($input7, $reglas7);
        $validator8 = Validator::make($input8, $reglas8);
        $validator9 = Validator::make($input9, $reglas9);
        $validator10 = Validator::make($input10, $reglas10);
        $validator11 = Validator::make($input11, $reglas11);
        $validator12 = Validator::make($input12, $reglas12);
        $validator13 = Validator::make($input13, $reglas13);
        $validator14 = Validator::make($input14, $reglas14);*/
        $validator15 = Validator::make($input15, $reglas15);
        $validator16 = Validator::make($input16, $reglas16);
        $validator17 = Validator::make($input17, $reglas17);
        $validator18 = Validator::make($input18, $reglas18);
        $validator19 = Validator::make($input19, $reglas19);
        $validator20 = Validator::make($input20, $reglas20);
        $validator21 = Validator::make($input21, $reglas21);
        $validator22 = Validator::make($input22, $reglas22);
        $validator23 = Validator::make($input23, $reglas23);
        $validator24 = Validator::make($input24, $reglas24);
        $validator25 = Validator::make($input25, $reglas25);



        if($regla0>0){
            $result='0';
            $msj='Ya se encuentra registrada la condicion económica del alumo con el Tipo y Documento de Identidad ingresado, del semestre seleccionado';
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
       /* elseif ($validator6->fails()) {
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
        }*/
        elseif ($validator15->fails()) {
            $result='0';
            $msj='Ingrese el Código Universitario del alumno';
            $selector='txtcodigo';
        }
        elseif ($validator16->fails()) {
            $result='0';
            $msj='Seleccione un semestre válido';
            $selector='cbusemestre';
        }
        elseif ($validator17->fails() || intval($numhermanos) < 0) {
            $result='0';
            $msj='Ingrese el número de hermanos del alumno o complete una cantidad mayor o igual a cero';
            $selector='txtnumhermanos';
        }
        elseif ($validator18->fails() || intval($numhermanosunasam) < 0) {
            $result='0';
            $msj='Ingrese el número de hermanos del alumno estudiando en la UNASAM o complete una cantidad mayor o igual a cero';
            $selector='txtnumhermanosunasam';
        }
        elseif (intval($numhermanos) < intval($numhermanosunasam)) {
            $result='0';
            $msj='El nùmero de Hermanos estudiantes en la UNASAM no puede ser mayor al número de hermanos totales';
            $selector='txtnumhermanosunasam';
        }
        elseif ($validator19->fails()) {
            $result='0';
            $msj='Ingrese el puesto laboral que desempeña el padre o apoderado';
            $selector='txtpuestopadre';
        }
        elseif ($validator20->fails()) {
            $result='0';
            $msj='Ingrese el puesto laboral que desempeña la madre o apoderado';
            $selector='txtpuestomadre';
        }
        elseif ($validator21->fails() || floatval($ingresomensualfamiliar) < 0) {
            $result='0';
            $msj='Ingrese el ingreso económico de la familia o una cantidad mayor o igual a cero';
            $selector='txtingresomensualfamiliar';
        }
        elseif ($validator22->fails()) {
            $result='0';
            $msj='Ingrese la condición de la vivienda del alumno: Familiar, Propia, Alquilada, etc';
            $selector='txtcondicionviivienda';
        }
        elseif ($validator23->fails()) {
            $result='0';
            $msj='Ingrese si el estudiante cuenta con seguro de salud';
            $selector='cbutieneseguro';
        }
        elseif ($validator24->fails() && intval($tieneseguro) == 1) {
            $result='0';
            $msj='Si indicó que el estudiante tiene seguro, por favor ingrese el nombre del seguro';
            $selector='txtnombreseguro';
        }
        elseif ($validator25->fails()) {
            $result='0';
            $msj='Ingrese si el alumno está laborando actualmente';
            $selector='cbuestalaborando';
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
           
            $editPersona->save();
        }
        else{
            $newPersona = new Persona();
            $newPersona->tipodoc=$tipodoc;
            $newPersona->doc=$doc;
            $newPersona->nombres=$nombres;
            $newPersona->apellidopat=$apellidopat;
            $newPersona->apellidomat=$apellidomat;
            $newPersona->activo='1';
            $newPersona->borrado='0';

            $newPersona->save();

            $persona_id=$newPersona->id;
        }

            $newCondicionEconomicaEstudiante = new Condicionsocioeconomica();
            $newCondicionEconomicaEstudiante->persona_id=$persona_id;
            $newCondicionEconomicaEstudiante->codigo=$codigo;
            $newCondicionEconomicaEstudiante->numhermanos=intval($numhermanos);
            $newCondicionEconomicaEstudiante->numhermanosunasam=intval($numhermanosunasam);
            $newCondicionEconomicaEstudiante->puestopadre=$puestopadre;
            $newCondicionEconomicaEstudiante->puestomadre=$puestomadre;
            $newCondicionEconomicaEstudiante->ingresomensualfamiliar=floatval($ingresomensualfamiliar);
            $newCondicionEconomicaEstudiante->condicionviivienda=$condicionviivienda;
            $newCondicionEconomicaEstudiante->tieneseguro=$tieneseguro;
            $newCondicionEconomicaEstudiante->nombreseguro=$nombreseguro;
            $newCondicionEconomicaEstudiante->estalaborando=$estalaborando;
            $newCondicionEconomicaEstudiante->semestre_id=$semestre_id;
            $newCondicionEconomicaEstudiante->activo='1';
            $newCondicionEconomicaEstudiante->borrado='0';

            $newCondicionEconomicaEstudiante->save();


            $msj='Condición Económica del Estudiante registrada con éxito';
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
        $tipodoc=$request->tipodoc;
        $doc=$request->doc;
        $nombres=$request->nombres;
        $apellidopat=$request->apellidopat;
        $apellidomat=$request->apellidomat;
       
        $semestre_id=$request->semestre_id;
        $persona_id=$request->persona_id;

        $codigo=$request->codigo;
        $numhermanos=$request->numhermanos;
        $numhermanosunasam=$request->numhermanosunasam;
        $puestopadre=$request->puestopadre;
        $puestomadre=$request->puestomadre;
        $ingresomensualfamiliar=$request->ingresomensualfamiliar;
        $condicionviivienda=$request->condicionviivienda;
        $tieneseguro=$request->tieneseguro;
        $nombreseguro=$request->nombreseguro;
        $estalaborando=$request->estalaborando;


        if(intval($tieneseguro)==0)
        {
            $nombreseguro="";
        }




        $result='1';
        $msj='';
        $selector='';


        $regla0=DB::table('condicionsocioeconomica')
        ->join('personas', 'personas.id', '=', 'condicionsocioeconomica.persona_id')
        ->where('personas.tipodoc',$tipodoc)
        ->where('personas.doc',$doc)
        ->where('condicionsocioeconomica.id','<>',$id)
        ->where('condicionsocioeconomica.semestre_id',$semestre_id)->count();

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


        $input15  = array('codigo' => $codigo);
        $reglas15 = array('codigo' => 'required');

        $input16  = array('semestre_id' => $semestre_id);
        $reglas16 = array('semestre_id' => 'required');

        $input17  = array('numhermanos' => $numhermanos);
        $reglas17 = array('numhermanos' => 'required');

        $input18  = array('numhermanosunasam' => $numhermanosunasam);
        $reglas18 = array('numhermanosunasam' => 'required');

        $input19  = array('puestopadre' => $puestopadre);
        $reglas19 = array('puestopadre' => 'required');

        $input20 = array('puestomadre' => $puestomadre);
        $reglas20= array('puestomadre' => 'required');

        $input21 = array('ingresomensualfamiliar' => $ingresomensualfamiliar);
        $reglas21= array('ingresomensualfamiliar' => 'required');

        $input22 = array('condicionviivienda' => $condicionviivienda);
        $reglas22= array('condicionviivienda' => 'required');

        $input23 = array('tieneseguro' => $tieneseguro);
        $reglas23= array('tieneseguro' => 'required');

        $input24 = array('nombreseguro' => $nombreseguro);
        $reglas24= array('nombreseguro' => 'required');

        $input25 = array('estalaborando' => $estalaborando);
        $reglas25= array('estalaborando' => 'required');

      

        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);
        $validator5 = Validator::make($input5, $reglas5);
       /* $validator6 = Validator::make($input6, $reglas6);
        $validator7 = Validator::make($input7, $reglas7);
        $validator8 = Validator::make($input8, $reglas8);
        $validator9 = Validator::make($input9, $reglas9);
        $validator10 = Validator::make($input10, $reglas10);
        $validator11 = Validator::make($input11, $reglas11);
        $validator12 = Validator::make($input12, $reglas12);
        $validator13 = Validator::make($input13, $reglas13);
        $validator14 = Validator::make($input14, $reglas14);*/
        $validator15 = Validator::make($input15, $reglas15);
        $validator16 = Validator::make($input16, $reglas16);
        $validator17 = Validator::make($input17, $reglas17);
        $validator18 = Validator::make($input18, $reglas18);
        $validator19 = Validator::make($input19, $reglas19);
        $validator20 = Validator::make($input20, $reglas20);
        $validator21 = Validator::make($input21, $reglas21);
        $validator22 = Validator::make($input22, $reglas22);
        $validator23 = Validator::make($input23, $reglas23);
        $validator24 = Validator::make($input24, $reglas24);
        $validator25 = Validator::make($input25, $reglas25);



        if($regla0>0){
            $result='0';
            $msj='Ya se encuentra registrada la condicion económica del alumo con el Tipo y Documento de Identidad ingresado, del semestre seleccionado';
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
       /* elseif ($validator6->fails()) {
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
        }*/
        elseif ($validator15->fails()) {
            $result='0';
            $msj='Ingrese el Código Universitario del alumno';
            $selector='txtcodigoE';
        }
        elseif ($validator16->fails()) {
            $result='0';
            $msj='Seleccione un semestre válido';
            $selector='cbusemestre';
        }
        elseif ($validator17->fails() || intval($numhermanos) < 0) {
            $result='0';
            $msj='Ingrese el número de hermanos del alumno o complete una cantidad mayor o igual a cero';
            $selector='txtnumhermanosE';
        }
        elseif ($validator18->fails() || intval($numhermanosunasam) < 0) {
            $result='0';
            $msj='Ingrese el número de hermanos del alumno estudiando en la UNASAM o complete una cantidad mayor o igual a cero';
            $selector='txtnumhermanosunasamE';
        }
        elseif (intval($numhermanos) < intval($numhermanosunasam)) {
            $result='0';
            $msj='El nùmero de Hermanos estudiantes en la UNASAM no puede ser mayor al número de hermanos totales';
            $selector='txtnumhermanosunasamE';
        }
        elseif ($validator19->fails()) {
            $result='0';
            $msj='Ingrese el puesto laboral que desempeña el padre o apoderado';
            $selector='txtpuestopadreE';
        }
        elseif ($validator20->fails()) {
            $result='0';
            $msj='Ingrese el puesto laboral que desempeña la madre o apoderado';
            $selector='txtpuestomadreE';
        }
        elseif ($validator21->fails() || floatval($ingresomensualfamiliar) < 0) {
            $result='0';
            $msj='Ingrese el ingreso económico de la familia o una cantidad mayor o igual a cero';
            $selector='txtingresomensualfamiliarE';
        }
        elseif ($validator22->fails()) {
            $result='0';
            $msj='Ingrese la condición de la vivienda del alumno: Familiar, Propia, Alquilada, etc';
            $selector='txtcondicionviiviendaE';
        }
        elseif ($validator23->fails()) {
            $result='0';
            $msj='Ingrese si el estudiante cuenta con seguro de salud';
            $selector='cbutieneseguroE';
        }
        elseif ($validator24->fails() && intval($tieneseguro) == 1) {
            $result='0';
            $msj='Si indicó que el estudiante tiene seguro, por favor ingrese el nombre del seguro';
            $selector='txtnombreseguroE';
        }
        elseif ($validator25->fails()) {
            $result='0';
            $msj='Ingrese si el alumno está laborando actualmente';
            $selector='cbuestalaborandoE';
        }

    
        else{


            $editPersona =Persona::find($persona_id);
            $editPersona->tipodoc=$tipodoc;
            $editPersona->doc=$doc;
            $editPersona->nombres=$nombres;
            $editPersona->apellidopat=$apellidopat;
            $editPersona->apellidomat=$apellidomat;

            $editPersona->save();
     

            $editAlumno =Condicionsocioeconomica::find($id);
            $editAlumno->persona_id=$persona_id;
            $editAlumno->codigo=$codigo;
            $editAlumno->numhermanos=intval($numhermanos);
            $editAlumno->numhermanosunasam=intval($numhermanosunasam);
            $editAlumno->puestopadre=$puestopadre;
            $editAlumno->puestomadre=$puestomadre;
            $editAlumno->ingresomensualfamiliar=floatval($ingresomensualfamiliar);
            $editAlumno->condicionviivienda=$condicionviivienda;
            $editAlumno->tieneseguro=$tieneseguro;
            $editAlumno->nombreseguro=$nombreseguro;
            $editAlumno->estalaborando=$estalaborando;
            
            $editAlumno->semestre_id=$semestre_id;
            $editAlumno->save();


            $msj='Condición Económica del Estudiante modificado con éxito';
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

   
        
        $borrar = Condicionsocioeconomica::destroy($id);
        //$task->delete();


        $msj='Condición Económica del Estudiante eliminado exitosamente';
   

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }

    public function descargarExcel(Request $request)
    { 

        $buscar=$request->busca;
        $tipo=$request->tipo;
        $semestre_id=$request->semestre_id;

        $semestre=Semestre::find($semestre_id);


        Excel::create('Condición Económica de Estudiantes - '.$semestre->nombre, function($excel) use($buscar,$tipo,$semestre)  {
            $excel->sheet('BD Condicion Economica', function($sheet) use($buscar,$tipo,$semestre){

                $sheet->setAutoSize(true);

                $sheet->mergeCells('A3:P3');
                $sheet->cells('A3:P3',function($cells)
                {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
                $sheet->setBorder('A3:P3', 'thin');
                $sheet->cells('A3:P3', function($cells)
                {
                    $cells->setBackground('#0C73E8');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontSize(15);

                    #Borders
                });
                
                $sheet->cells('A4:P4', function($cells)
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
                'D'=>'35',
                'E'=>'35',
                'F'=>'45',
                'G'=>'25',
                'H'=>'35',
                'I'=>'35',
                'J'=>'45',
                'K'=>'45',
                'L'=>'45',
                'M'=>'35',
                'N'=>'45',
                'O'=>'40',
                'P'=>'35',
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
                array_push($data, array('N°','TIPO DE DOCUMENTO', 'NÚMERO DE DOCUMENTO', 'APELLIDO PATERNO', 'APELLIDO MATERNO','NOMBRES','CÓDIGO UNIVERSITARIO','NRO DE HERMANOS(AS)','NRO DE HERMANOS(AS) QUE ESTUDIAN EN LA UNASAM','PUESTO LABORAL QUE DESEMPEÑA EL PADRE U APODERADO','PUESTO LABORAL QUE DESEMPEÑA LA MADRE U APODERADO','INGRESO ECONÓMICO MENSUAL FAMILIAR','CONDICIÓN DE VIVIENDA','¿EL ESTUDIANTE CUENTA CON SEGURO DE SALUD?','NOMBRE DEL SEGURO','EL ESTUDIANTE LABORA ACTUALMENTE'));

                $cont=5;
                $cont2=5;

                $alumnos = DB::table('condicionsocioeconomica')
                ->join('personas', 'personas.id', '=', 'condicionsocioeconomica.persona_id')
                ->join('semestres', 'semestres.id', '=', 'condicionsocioeconomica.semestre_id')
           
                ->where('condicionsocioeconomica.borrado','0')
                ->where('semestres.id',$semestre->id)
                ->where(function($query) use ($buscar){
                   $query->where('personas.nombres','like','%'.$buscar.'%');
                   $query->orWhere('personas.apellidopat','like','%'.$buscar.'%');
                   $query->orWhere('personas.apellidomat','like','%'.$buscar.'%');
                   $query->orWhere('personas.doc','like','%'.$buscar.'%');
                   $query->orWhere('condicionsocioeconomica.codigo','like','%'.$buscar.'%');
                   })
                ->orderBy('personas.apellidopat')
                ->orderBy('personas.apellidomat')
                ->orderBy('personas.nombres')
           
                ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono',
                'condicionsocioeconomica.id', 'condicionsocioeconomica.codigo','condicionsocioeconomica.numhermanos','condicionsocioeconomica.numhermanosunasam', 'condicionsocioeconomica.puestopadre', 'condicionsocioeconomica.puestomadre','condicionsocioeconomica.ingresomensualfamiliar','condicionsocioeconomica.condicionviivienda', 'condicionsocioeconomica.tieneseguro', 'condicionsocioeconomica.nombreseguro','condicionsocioeconomica.estalaborando', 'condicionsocioeconomica.semestre_id','semestres.nombre as semestre','condicionsocioeconomica.persona_id')
                ->get();

        foreach ($alumnos as $key => $dato) {
            $rango='A'.strval((intval($cont)+intval($key))).':P'.strval((intval($cont)+intval($key)));
            $sheet->setBorder($rango, 'thin');

           array_push($data, array($key+1,
           tipoDoc($dato->tipodoc),
           $dato->doc,
           $dato->apellidopat,
           $dato->apellidomat,
           $dato->nombres,
           $dato->codigo,
           $dato->numhermanos,
           $dato->numhermanosunasam,
           $dato->puestopadre,
           $dato->puestomadre,
           strval(number_format($dato->ingresomensualfamiliar,2)),
           $dato->condicionviivienda,
           SiUnoNoCero($dato->tieneseguro),
           $dato->nombreseguro,
           SiUnoNoCero($dato->estalaborando),
        
        ));
            
            $cont2++;
        }

                $sheet->fromArray($data, null, 'A1', false, false);
            
            });
            })->download('xlsx');  
   

        return response()->json(["buscar"=>$buscar,'tipo'=>$tipo]);
    }
}
