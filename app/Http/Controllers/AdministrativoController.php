<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Administrativo;
use App\Escuela;
use App\Facultad;
use App\Local;

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

class AdministrativoController extends Controller
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

            $facultads=Facultad::where('activo','1')->where('borrado','0')->orderBy('nombre')->get();
            $locals=Local::where('activo','1')->where('borrado','0')->orderBy('nombre')->get();

            $submodulo=Submodulo::find(21);
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


            $modulo="administrativos";
            return view('administrativos.index',compact('tipouser','modulo','escuelas','facultads','locals','submodulo','activoModulo','permisoModulos','permisoSubModulos'));
        }
        else
        {
            return redirect('home');           
        }
    }


    public function index(Request $request)
    {
        $buscar=$request->busca;
     
     $administrativos = DB::table('administrativos')
     ->join('personas', 'personas.id', '=', 'administrativos.persona_id')
     ->join('locals', 'locals.id', '=', 'administrativos.local_id')

     ->where('administrativos.borrado','0')
     ->where('administrativos.activo','1')

     ->where(function($query) use ($buscar){
        $query->where('personas.nombres','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidopat','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidomat','like','%'.$buscar.'%');
        $query->orWhere('personas.doc','like','%'.$buscar.'%');
        })

     ->orderBy('personas.apellidopat')
     ->orderBy('personas.apellidomat')
     ->orderBy('personas.nombres')

     ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono','administrativos.id', 'personas.correoinstitucional',
     
     'administrativos.persona_id','administrativos.local_id','administrativos.tipoDependencia','administrativos.dependencia','administrativos.facultad','administrativos.escuela','administrativos.cargo','administrativos.descripcionCargo','administrativos.grado','administrativos.descripcionGrado','administrativos.esTitulado','administrativos.descripcionTitulo','administrativos.lugarGrado','administrativos.paisGrado','administrativos.fechaIngreso','administrativos.observaciones','administrativos.estado','administrativos.condicion','administrativos.fechaSalida','administrativos.id','locals.id as idlocal','locals.nombre as local')
     ->paginate(50);

     return [
        'pagination'=>[
            'total'=> $administrativos->total(),
            'current_page'=> $administrativos->currentPage(),
            'per_page'=> $administrativos->perPage(),
            'last_page'=> $administrativos->lastPage(),
            'from'=> $administrativos->firstItem(),
            'to'=> $administrativos->lastItem(),
        ],
        'administrativos'=>$administrativos
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
        $correoinstitucional=$request->correoinstitucional;

        $persona_id=$request->persona_id;
        $local_id=$request->local_id;
        $tipoDependencia=$request->tipoDependencia;
        $dependencia=$request->dependencia;
        $facultad=$request->facultad;
        $escuela=$request->escuela;
        $cargo=$request->cargo;
        $descripcionCargo=$request->descripcionCargo;
        $grado=$request->grado;
        $descripcionGrado=$request->descripcionGrado;
        $esTitulado=$request->esTitulado;
        $descripcionTitulo=$request->descripcionTitulo;
        $lugarGrado=$request->lugarGrado;
        $paisGrado=$request->paisGrado;
        $fechaIngreso=$request->fechaIngreso;
        $observaciones=$request->observaciones;
        $estado=$request->estado;
        $condicion=$request->condicion;
        $fechaSalida=$request->fechaSalida;
     


        if(intval($esdiscapacitado)==0)
        {
            $discapacidad="";
        }

        if(intval($tipoDependencia)==9)
        {
            $dependencia=$facultad;
        } 
        elseif(intval($tipoDependencia)==10)
        {
            $dependencia=$escuela;
        }

        if($grado=="0")
        {
            $descripcionGrado="";
            $esTitulado="0";
            $descripcionTitulo="";
            $lugarGrado="";
            $paisGrado="";
        }
        elseif($lugarGrado=="Nacional")
        {
            $paisGrado="PERÚ";
        }

        if(intval($esTitulado)==0)
        {
            $descripcionTitulo="";
        }

        if(intval($estado)==1)
        {
            $fechaSalida=null;
        }



        $result='1';
        $msj='';
        $selector='';


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



        $input15  = array('local_id' => $local_id);
        $reglas15 = array('local_id' => 'required');

        $input16  = array('tipoDependencia' => $tipoDependencia);
        $reglas16 = array('tipoDependencia' => 'required');

        $input17  = array('dependencia' => $dependencia);
        $reglas17 = array('dependencia' => 'required');

        $input18  = array('descripcionCargo' => $descripcionCargo);
        $reglas18 = array('descripcionCargo' => 'required');

        $input19  = array('fechaIngreso' => $fechaIngreso);
        $reglas19 = array('fechaIngreso' => 'required');

        $input20  = array('fechaSalida' => $fechaSalida);
        $reglas20 = array('fechaSalida' => 'required');

        $input21  = array('correoinstitucional' => $correoinstitucional);
        $reglas21 = array('correoinstitucional' => 'required');

    


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




       if($validator1->fails()){
            $result='0';
            $msj='Seleccione un tipo de Documento Válido';
            $selector='cbutipodoc';
        }
        elseif ($validator2->fails())
        {
            $result='0';
            $msj='Complete el Documento de Identidad del Personal Administrativo';
            $selector='txtDNI';

        }
        elseif (strlen($doc)<8)
        {
            $result='0';
            $msj='Complete un N° de Documento de Identidad Válido, mínimo 08 dígitos';
            $selector='txtDNI';

        }
        elseif ($validator3->fails()) {
            $result='0';
            $msj='Ingrese los nombres del Personal Administrativo';
            $selector='txtnombres';
        }
        elseif ($validator4->fails()) {
            $result='0';
            $msj='Ingrese el apellido paterno del Personal Administrativo';
            $selector='txtapepat';
        }
        elseif ($validator5->fails()) {
            $result='0';
            $msj='Ingrese el apellido materno del Personal Administrativo';
            $selector='txtapemat';
        }
        elseif ($validator6->fails()) {
            $result='0';
            $msj='Seleccione el Género del Personal Administrativo';
            $selector='cbugenero';
        }
        elseif ($validator7->fails()) {
            $result='0';
            $msj='Seleccione el Estado Civil del Personal Administrativo';
            $selector='cbuestadocivil';
        }
        elseif ($validator8->fails()) {
            $result='0';
            $msj='Ingrese la Fecha de Nacimiento del Personal Administrativo';
            $selector='txtfechanac';
        }
        elseif ($validator9->fails()) {
            $result='0';
            $msj='Seleccione si el personal administrativo es Discapacitado';
            $selector='cbugenero';
        }
        elseif (intval($esdiscapacitado)==1 && strlen($discapacidad)==0) {
            $result='0';
            $msj='Si ha indicado que el personal administrativo es discapacitado, ingrese la discapacidad que padece';
            $selector='txtdiscapacidad';
        }

        elseif ($validator10->fails()) {
            $result='0';
            $msj='Ingrese el País de procedencia del Personal Administrativo';
            $selector='txtpais';
        }
        elseif ($validator11->fails()) {
            $result='0';
            $msj='Ingrese el Departamento de procedencia del Personal Administrativo';
            $selector='txtdep';
        }
        elseif ($validator12->fails()) {
            $result='0';
            $msj='Ingrese la Provincia de procedencia del Personal Administrativo';
            $selector='txtprov';
        }
        elseif ($validator13->fails()) {
            $result='0';
            $msj='Ingrese el Distrito de procedencia del Personal Administrativo';
            $selector='txtdist';
        }
        elseif ($validator14->fails()) {
            $result='0';
            $msj='Ingrese la Dirección del Personal Administrativo';
            $selector='txtDir';
        }
        elseif ($validator21->fails()) {
            $result='0';
            $msj='ingrese el correo institucional del Personal Administrativo';
            $selector='txtcorreoinstitucional';
        }
        elseif ($validator15->fails() || $local_id=="0") {
            $result='0';
            $msj='Seleccione un Local Válido';
            $selector='cbulocal';
        }
        elseif ($validator16->fails() || $tipoDependencia=="0") {
            $result='0';
            $msj='Seleccione un Tipo de Dependencia válida';
            $selector='cbutipodependencia';
        }
        elseif ($validator17->fails() && intval($tipoDependencia)<9) {
            $result='0';
            $msj='Ingrese el nombre de la Dependencia ';
            $selector='txtdependencia';
        }

        elseif (intval($tipoDependencia)==9 && $facultad=="0") {
            $result='0';
            $msj='Seleccione la Facultad donde labora el Personal Administrativo';
            $selector='cbufacultad';
        }

        elseif (intval($tipoDependencia)==10 && $escuela=="0") {
            $result='0';
            $msj='Seleccione la Escuela profesional donde labora el Personal Administrativo';
            $selector='cbucarrera';
        }

        elseif ($cargo=="0") {
            $result='0';
            $msj='Seleccione un cargo válido';
            $selector='cbucarrera';
        }

        elseif ($validator18->fails()) {
            $result='0';
            $msj='Ingrese el Nombre exacto del cargo';
            $selector='txtdesccargo';
        }

        elseif ($grado!="0" && strlen($descripcionGrado)==0) {
            $result='0';
            $msj='Ingrese la Descripción de su máximo grado alcanzado';
            $selector='txtdescGrado';
        }

        elseif (intval($esTitulado)==1 && strlen($descripcionTitulo)==0) {
            $result='0';
            $msj='Ingrese el nombre del título Universitario';
            $selector='txttitulouniv';
        }

        elseif ($grado!="0" && strlen($paisGrado)==0 && $lugarGrado=="Internacional") {
            $result='0';
            $msj='Ingrese el País donde consiguió su máximo grado académico';
            $selector='txtpaismaxgrado';
        }



        elseif ($validator19->fails()) {
            $result='0';
            $msj='Ingrese la fecha en que el trabajador ingresó a su cargo';
            $selector='txtfechaingreso';
        }

        elseif ($validator20->fails() && intval($estado)==0) {
            $result='0';
            $msj='Ingrese la fecha en que el trabajador finalizó su cargo laboral';
            $selector='txtfechasalida';
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
            $editPersona->correoinstitucional=$correoinstitucional;

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
            $newPersona->correoinstitucional=$correoinstitucional;
            $newPersona->activo='1';
            $newPersona->borrado='0';

            $newPersona->save();

            $persona_id=$newPersona->id;
        }

     
        $newAdministrativo = new Administrativo();
        $newAdministrativo->persona_id=$persona_id;
        $newAdministrativo->local_id=$local_id;
        $newAdministrativo->tipoDependencia=$tipoDependencia;
        $newAdministrativo->dependencia=$dependencia;
        $newAdministrativo->facultad=$facultad;
        $newAdministrativo->escuela=$escuela;
        $newAdministrativo->cargo=$cargo;
        $newAdministrativo->descripcionCargo=$descripcionCargo;
        $newAdministrativo->grado=$grado;
        $newAdministrativo->descripcionGrado=$descripcionGrado;
        $newAdministrativo->esTitulado=$esTitulado;
        $newAdministrativo->descripcionTitulo=$descripcionTitulo;
        $newAdministrativo->lugarGrado=$lugarGrado;
        $newAdministrativo->paisGrado=$paisGrado;
        $newAdministrativo->fechaIngreso=$fechaIngreso;
        $newAdministrativo->observaciones=$observaciones;
        $newAdministrativo->estado=$estado;
        $newAdministrativo->condicion=$condicion;
        $newAdministrativo->fechaSalida=$fechaSalida;

        $newAdministrativo->activo='1';
        $newAdministrativo->borrado='0';

        $newAdministrativo->save();


            $msj='Nuevo Personal Administrativo registrado con éxito';
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
        $correoinstitucional=$request->correoinstitucional;

        $persona_id=$request->persona_id;
        $local_id=$request->local_id;
        $tipoDependencia=$request->tipoDependencia;
        $dependencia=$request->dependencia;
        $facultad=$request->facultad;
        $escuela=$request->escuela;
        $cargo=$request->cargo;
        $descripcionCargo=$request->descripcionCargo;
        $grado=$request->grado;
        $descripcionGrado=$request->descripcionGrado;
        $esTitulado=$request->esTitulado;
        $descripcionTitulo=$request->descripcionTitulo;
        $lugarGrado=$request->lugarGrado;
        $paisGrado=$request->paisGrado;
        $fechaIngreso=$request->fechaIngreso;
        $observaciones=$request->observaciones;
        $estado=$request->estado;
        $condicion=$request->condicion;
        $fechaSalida=$request->fechaSalida;
     


        if(intval($esdiscapacitado)==0)
        {
            $discapacidad="";
        }

        if(intval($tipoDependencia)==9)
        {
            $dependencia=$facultad;
        } 
        elseif(intval($tipoDependencia)==10)
        {
            $dependencia=$escuela;
        }

        if($grado=="0")
        {
            $descripcionGrado="";
            $esTitulado="0";
            $descripcionTitulo="";
            $lugarGrado="";
            $paisGrado="";
        }
        elseif($lugarGrado=="Nacional")
        {
            $paisGrado="PERÚ";
        }

        if(intval($esTitulado)==0)
        {
            $descripcionTitulo="";
        }

        if(intval($estado)==1)
        {
            $fechaSalida=null;
        }



        $result='1';
        $msj='';
        $selector='';


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



        $input15  = array('local_id' => $local_id);
        $reglas15 = array('local_id' => 'required');

        $input16  = array('tipoDependencia' => $tipoDependencia);
        $reglas16 = array('tipoDependencia' => 'required');

        $input17  = array('dependencia' => $dependencia);
        $reglas17 = array('dependencia' => 'required');

        $input18  = array('descripcionCargo' => $descripcionCargo);
        $reglas18 = array('descripcionCargo' => 'required');

        $input19  = array('fechaIngreso' => $fechaIngreso);
        $reglas19 = array('fechaIngreso' => 'required');

        $input20  = array('fechaSalida' => $fechaSalida);
        $reglas20 = array('fechaSalida' => 'required');

        $input21  = array('correoinstitucional' => $correoinstitucional);
        $reglas21 = array('correoinstitucional' => 'required');

    


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




       if($validator1->fails()){
            $result='0';
            $msj='Seleccione un tipo de Documento Válido';
            $selector='cbutipodocE';
        }
        elseif ($validator2->fails())
        {
            $result='0';
            $msj='Complete el Documento de Identidad del Personal Administrativo';
            $selector='txtDNIE';

        }
        elseif (strlen($doc)<8)
        {
            $result='0';
            $msj='Complete un N° de Documento de Identidad Válido, mínimo 08 dígitos';
            $selector='txtDNIE';

        }
        elseif ($validator3->fails()) {
            $result='0';
            $msj='Ingrese los nombres del Personal Administrativo';
            $selector='txtnombresE';
        }
        elseif ($validator4->fails()) {
            $result='0';
            $msj='Ingrese el apellido paterno del Personal Administrativo';
            $selector='txtapepatE';
        }
        elseif ($validator5->fails()) {
            $result='0';
            $msj='Ingrese el apellido materno del Personal Administrativo';
            $selector='txtapematE';
        }
        elseif ($validator6->fails()) {
            $result='0';
            $msj='Seleccione el Género del Personal Administrativo';
            $selector='cbugeneroE';
        }
        elseif ($validator7->fails()) {
            $result='0';
            $msj='Seleccione el Estado Civil del Personal Administrativo';
            $selector='cbuestadocivilE';
        }
        elseif ($validator8->fails()) {
            $result='0';
            $msj='Ingrese la Fecha de Nacimiento del Personal Administrativo';
            $selector='txtfechanacE';
        }
        elseif ($validator9->fails()) {
            $result='0';
            $msj='Seleccione si el personal administrativo es Discapacitado';
            $selector='cbugeneroE';
        }
        elseif (intval($esdiscapacitado)==1 && strlen($discapacidad)==0) {
            $result='0';
            $msj='Si ha indicado que el personal administrativo es discapacitado, ingrese la discapacidad que padece';
            $selector='txtdiscapacidadE';
        }

        elseif ($validator10->fails()) {
            $result='0';
            $msj='Ingrese el País de procedencia del Personal Administrativo';
            $selector='txtpaisE';
        }
        elseif ($validator11->fails()) {
            $result='0';
            $msj='Ingrese el Departamento de procedencia del Personal Administrativo';
            $selector='txtdepE';
        }
        elseif ($validator12->fails()) {
            $result='0';
            $msj='Ingrese la Provincia de procedencia del Personal Administrativo';
            $selector='txtprovE';
        }
        elseif ($validator13->fails()) {
            $result='0';
            $msj='Ingrese el Distrito de procedencia del Personal Administrativo';
            $selector='txtdistE';
        }
        elseif ($validator14->fails()) {
            $result='0';
            $msj='Ingrese la Dirección del Personal Administrativo';
            $selector='txtDirE';
        }
        elseif ($validator21->fails()) {
            $result='0';
            $msj='ingrese el correo institucional del Personal Administrativo';
            $selector='txtcorreoinstitucionalE';
        }
        elseif ($validator15->fails() || $local_id=="0") {
            $result='0';
            $msj='Seleccione un Local Válido';
            $selector='cbulocalE';
        }
        elseif ($validator16->fails() || $tipoDependencia=="0") {
            $result='0';
            $msj='Seleccione un Tipo de Dependencia válida';
            $selector='cbutipodependenciaE';
        }
        elseif ($validator17->fails() && intval($tipoDependencia)<9) {
            $result='0';
            $msj='Ingrese el nombre de la Dependencia ';
            $selector='txtdependenciaE';
        }

        elseif (intval($tipoDependencia)==9 && $facultad=="0") {
            $result='0';
            $msj='Seleccione la Facultad donde labora el Personal Administrativo';
            $selector='cbufacultadE';
        }

        elseif (intval($tipoDependencia)==10 && $escuela=="0") {
            $result='0';
            $msj='Seleccione la Escuela profesional donde labora el Personal Administrativo';
            $selector='cbucarreraE';
        }

        elseif ($cargo=="0") {
            $result='0';
            $msj='Seleccione un cargo válido';
            $selector='cbucarreraE';
        }

        elseif ($validator18->fails()) {
            $result='0';
            $msj='Ingrese el Nombre exacto del cargo';
            $selector='txtdesccargoE';
        }

        elseif ($grado!="0" && strlen($descripcionGrado)==0) {
            $result='0';
            $msj='Ingrese la Descripción de su máximo grado alcanzado';
            $selector='txtdescGradoE';
        }

        elseif (intval($esTitulado)==1 && strlen($descripcionTitulo)==0) {
            $result='0';
            $msj='Ingrese el nombre del título Universitario';
            $selector='txttitulounivE';
        }

        elseif ($grado!="0" && strlen($paisGrado)==0 && $lugarGrado=="Internacional") {
            $result='0';
            $msj='Ingrese el País donde consiguió su máximo grado académico';
            $selector='txtpaismaxgradoE';
        }



        elseif ($validator19->fails()) {
            $result='0';
            $msj='Ingrese la fecha en que el trabajador ingresó a su cargo';
            $selector='txtfechaingresoE';
        }

        elseif ($validator20->fails() && intval($estado)==0) {
            $result='0';
            $msj='Ingrese la fecha en que el trabajador finalizó su cargo laboral';
            $selector='txtfechasalidaE';
        }
   

      else {

     
       
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
            $editPersona->correoinstitucional=$correoinstitucional;

            $editPersona->save();
     

     
            $newAdministrativo = Administrativo::find($id);
            $newAdministrativo->persona_id=$persona_id;
            $newAdministrativo->local_id=$local_id;
            $newAdministrativo->tipoDependencia=$tipoDependencia;
            $newAdministrativo->dependencia=$dependencia;
            $newAdministrativo->facultad=$facultad;
            $newAdministrativo->escuela=$escuela;
            $newAdministrativo->cargo=$cargo;
            $newAdministrativo->descripcionCargo=$descripcionCargo;
            $newAdministrativo->grado=$grado;
            $newAdministrativo->descripcionGrado=$descripcionGrado;
            $newAdministrativo->esTitulado=$esTitulado;
            $newAdministrativo->descripcionTitulo=$descripcionTitulo;
            $newAdministrativo->lugarGrado=$lugarGrado;
            $newAdministrativo->paisGrado=$paisGrado;
            $newAdministrativo->fechaIngreso=$fechaIngreso;
            $newAdministrativo->observaciones=$observaciones;
            $newAdministrativo->estado=$estado;
            $newAdministrativo->condicion=$condicion;
            $newAdministrativo->fechaSalida=$fechaSalida;


            $newAdministrativo->save();

            $msj='Personal Administrativo modificado con éxito';
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

   
        
        $borrar = Administrativo::destroy($id);
        //$task->delete();


        $msj='Personal Administrativo Seleccionado eliminado exitosamente';
   

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }

    public function descargarExcel(Request $request)
    {   
        $buscar=$request->busca;

     


        Excel::create('Personal Administrativo', function($excel) use($buscar)  {
            $excel->sheet('BD de Administrativos', function($sheet) use($buscar){

                $sheet->setAutoSize(true);
                /* $sheet->mergeCells('B1:D1');
                $sheet->mergeCells('B2:H2'); */

                $sheet->mergeCells('A3:AB3');
                $sheet->cells('A3:AB3',function($cells)
                {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
                $sheet->setBorder('A3:AB3', 'thin');
                $sheet->cells('A3:AB3', function($cells)
                {
                    $cells->setBackground('#0C73E8');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontSize(15);

                    #Borders
                });
                
                $sheet->cells('A4:AB4', function($cells)
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
                'F'=>'30',
                'G'=>'20',
                'H'=>'20',
                'I'=>'20',
                'J'=>'22',
                'K'=>'40',
                'L'=>'45',
                'M'=>'35',
                'N'=>'45',
                'O'=>'45',
                'P'=>'45',
                'Q'=>'20',
                'R'=>'35',
                'S'=>'45',
                'T'=>'22',
                'U'=>'45',
                'V'=>'35',
                'W'=>'30',
                'X'=>'25',
                'Y'=>'26',
                'Z'=>'33',
                'AA'=>'65', // Correo Institucional
                'AB'=>'65',
                )
                );

                $sheet->setHeight(array
                (
                '3'=>'24'
                )
                );

                $titulo='BASE DE DATOS PERSONAL ADMINSITRATIVO UNASAM';

                array_push($data, array(''));
                array_push($data, array(''));
                array_push($data, array($titulo));

                $sheet->setBorder('A4:AB4', 'thin');
                array_push($data, array('N°','TIPO DE DOCUMENTO', 'NÚMERO DE DOCUMENTO', 'APELLIDO PATERNO', 'APELLIDO MATERNO','NOMBRES','GÉNERO','FECHA DE NACIMIENTO','ESTADO CIVIL','SUFRE DISCAPACIDAD','DISCAPACIDAD QUE PADECE','LOCAL','TIPO DE DEPENDENCIA','DEPENDENCIA','CARGO','DESCRIPCIÓN DEL CARGO','CONDICIÓN LABORAL','MÁXIMO GRADO ACADÉMICO','DESCRIPCIÓN DEL MÁXIMO GRADO ACADÉMICO','TÍTULO UNIVERSITARIO','DESCRIPCIÓN DEL TÍTULO UNIVERSITARIO','LUGAR DEL MÁXIMO GRADO','PAÍS DEL MÁXIMO GRADO','ESTADO DE CONTRATO','FECHA DE INICIO DE LABORES','FECHA DE FINALIZACIÓN DE LABORES', 'CORREO INSTITUCIONAL', 'OBSERVACIONES'));

                $cont=5;
                $cont2=5;

                $administrativos = DB::table('administrativos')
     ->join('personas', 'personas.id', '=', 'administrativos.persona_id')
     ->join('locals', 'locals.id', '=', 'administrativos.local_id')

     ->where('administrativos.borrado','0')
     ->where('administrativos.activo','1')

     ->where(function($query) use ($buscar){
        $query->where('personas.nombres','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidopat','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidomat','like','%'.$buscar.'%');
        $query->orWhere('personas.doc','like','%'.$buscar.'%');
        })

     ->orderBy('personas.apellidopat')
     ->orderBy('personas.apellidomat')
     ->orderBy('personas.nombres')

     ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono','administrativos.id', 'personas.correoinstitucional', 
     'administrativos.persona_id','administrativos.local_id','administrativos.tipoDependencia','administrativos.dependencia','administrativos.facultad','administrativos.escuela','administrativos.cargo','administrativos.descripcionCargo','administrativos.grado','administrativos.descripcionGrado','administrativos.esTitulado','administrativos.descripcionTitulo','administrativos.lugarGrado','administrativos.paisGrado','administrativos.fechaIngreso','administrativos.observaciones','administrativos.estado','administrativos.condicion','administrativos.fechaSalida','administrativos.id','locals.id as idlocal','locals.nombre as local')
     ->get();

        foreach ($administrativos as $key => $dato) {
            $rango='A'.strval((intval($cont)+intval($key))).':AB'.strval((intval($cont)+intval($key)));
            $sheet->setBorder($rango, 'thin');
/*
 array_push($data, array('N°','TIPO DE DOCUMENTO', 'NÚMERO DE DOCUMENTO', 'APELLIDO PATERNO', 'APELLIDO MATERNO','NOMBRES','GÉNERO','FECHA DE NACIMIENTO','ESTADO CIVIL','SUFRE DISCAPACIDAD','DISCAPACIDAD QUE PADECE','LOCAL','TIPO DE DEPENDENCIA','DEPENDENCIA','CARGO','DESCRIPCIÓN DEL CARGO','CONDICIÓN LABORAL','MÁXIMO GRADO ACADÉMICO','DESCRIPCIÓN DEL MÁXIMO GRADO ACADÉMICO','TÍTULO UNIVERSITARIO','DESCRIPCIÓN DEL TÍTULO UNIVERSITARIO','LUGAR DEL MÁXIMO GRADO','PAÍS DEL MÁXIMO GRADO','ESTADO DE CONTRATO','FECHA DE INICIO DE LABORES','FECHA DE FINALIZACIÓN DE LABORES','OBSERVACIONES'));
 */

           array_push($data, array($key+1,
           tipoDoc($dato->tipodoc),
           $dato->doc,
           $dato->apellidopat,
           $dato->apellidomat,
           $dato->nombres,
           genero(strval($dato->genero)),
           pasFechaVista($dato->fechanac),
           estadoCivil($dato->estadocivil,$dato->genero),
           esDiscpacitado($dato->esdiscapacitado),
           $dato->discapacidad,
           $dato->local,
           tipoDependenciaAdmin($dato->tipoDependencia),
           $dato->dependencia,
           $dato->cargo,
           $dato->descripcionCargo,
           $dato->condicion,
           gradoAdmin($dato->grado),
           $dato->descripcionGrado,
           SiUnoNoCero($dato->esTitulado),
           $dato->descripcionTitulo,
           $dato->lugarGrado,
           $dato->paisGrado,
           estadoContrato($dato->estado),
           pasFechaVista($dato->fechaIngreso),
           pasFechaVista($dato->fechaSalida),
           $dato->correoinstitucional,
           $dato->observaciones
        
        ));
            
            $cont2++;
        }



                $sheet->fromArray($data, null, 'A1', false, false);
            
            });
            })->download('xlsx');  
   

        return response()->json(["buscar"=>$buscar,'tipo'=>$tipo]);
    }



























    public function importarArchivo1(Request $request)
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

            $aux2='administrativos'.date('d-m-Y').'-'.date('H-i-s');
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
    
            $locales=Local::where('activo','1')->where('borrado','0')->get();


                 Excel::load(public_path().'/archivosExcel/'.$archivo, function ($reader) use (&$errorFila,  &$errorColumna,  &$detError, &$error, $archivo, &$msj, $locales, &$result, &$selector) { 

                    //$reader->first(); // Leer datos de la primera hoja

                   $resultado=$reader->skipRows(4)->first();


                   $error=0;

                   

                   foreach ($resultado as $key => $row) {

                    
                    // Validando c_local

                    $bandera01=false;
                    foreach ($locales as $key3 => $dato) {
                        if(intval($row->c_local)==$dato->id)
                        {
                            $bandera01=true;
                            break;
                        }
                    }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna LOCAL";
                        $detError="El Identificador de Local no corresponde a ningún Local registrado en la base de datos. Corrija la Columna B, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_tipo_dependencia

                    $bandera01=false;
                    if(intval($row->c_tipo_dependencia)==1 || intval($row->c_tipo_dependencia)==2 || intval($row->c_tipo_dependencia)==3 || intval($row->c_tipo_dependencia)==4 
                    || intval($row->c_tipo_dependencia)==5  || intval($row->c_tipo_dependencia)==6  || intval($row->c_tipo_dependencia)==7  || intval($row->c_tipo_dependencia)==8
                    || intval($row->c_tipo_dependencia)==9  || intval($row->c_tipo_dependencia)==10){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna TIPO DE DEPENDENCIA";
                        $detError="El registro ingresado no corresponde a los valores posibles de ser consignado. Corrija la Columna C, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_dependencia

                    $bandera01=false;
                    if(strlen(trim($row->c_dependencia))>0){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna DEPENDENCIA";
                        $detError="El registro ingresado se encuentran en blanco. Corrija la Columna D, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_tipodoc

                    $bandera01=false;
                    if(intval($row->c_tipodoc)==1 || intval($row->c_tipodoc)==2 || intval($row->c_tipodoc)==3 || intval($row->c_tipodoc)==4 || intval($row->c_tipodoc)==5){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna TIPO DE DOCUMENTO";
                        $detError="El código del Tipo de Documento no corresponde a los valores posibles de ser consignados (1: DNI, 2: RUC, 3: Carnet de Extranjería, 4: Pasaporte, 5: Partida de Nacimiento). Corrija la Columna E, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_numdoc

                    $bandera01=false;
                    if(strlen(trim($row->c_numdoc))>=8){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna NÚMERO DE DOCUMENTO";
                        $detError="El Número de Documento de Indentidad ingresado se encuentran en blanco o no cuenta con un formato correcto. Corrija la Columna F, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_apepat

                    $bandera01=false;
                    if(strlen(trim($row->c_apepat))>0){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna APELLIDO PATERNO";
                        $detError="El Apellido ingresado se encuentran en blanco. Corrija la Columna G, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_noms

                    $bandera01=false;
                    if(strlen(trim($row->c_noms))>0){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna NOMBRES";
                        $detError="Los Nombres ingresados se encuentran en blanco. Corrija la columna I, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_genero

                    $bandera01=false;
                    if((trim($row->c_genero)=="M") || (trim($row->c_genero)=="F") || (trim($row->c_genero)=="m") || (trim($row->c_genero)=="f")){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna GÉNERO";
                        $detError="Consideró un dato no identificado, indique M para másculino ó F para femenino, sin espacios en blanco. Corrija la Columna J, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_fechanac

                    if(strlen(trim($row->c_fechanac))==10){

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
                                    $detError="EL dato ingresado se encuentran en blanco o no tiene un formato correcto dd/mm/aaaa. Corrija la Columna K, Fila ".($key+6);
                                    $error=1;
                                    break 1;
            
                                }
                        }
                        else{
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna FECHA DE NACIMIENTO";
                            $detError="EL dato ingresado se encuentran en blanco o no tiene un formato correcto dd/mm/aaaa. Corrija la Columna K, Fila ".($key+6);
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
                            $detError="EL dato ingresado se encuentran en blanco o no tiene un formato correcto dd/mm/aaaa. Corrija la Columna K, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }
                    }


                    // Validando c_estadociv

                    $bandera01=false;
                    if(intval($row->c_estadociv)==1 || intval($row->c_estadociv)==2 || intval($row->c_estadociv)==3 || intval($row->c_estadociv)==4){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna ESTADO CIVIL";
                        $detError="El código del Estado CIvil no corresponde a los valores posibles de ser consignados (1: Soltero (a), 2: Casado (a), 3: Viudo (a), ó 4: Divorsiado (a)). Corrija la Columna L, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_esdisca

                    $bandera01=false;
                    if(intval($row->c_esdisca)==1 || intval($row->c_esdisca)==0){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna SUFRE DISCAPACIDAD";
                        $detError="El código de Condición de Discapacidad no corresponde a los valores posibles de ser consignados. Consigne 1 para SI o 0 para NO. Corrija la Columna M, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_disca

                    //var_dump($row);

                    if( intval($row->c_esdisca)==1){
                        $bandera01=false;
                        if(strlen(trim($row->c_disca))>0){
                            $bandera01=true;
                            }
                        if($bandera01==false){

                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna DISCAPACIDAD QUE PADECE";
                            $detError="Si ha ingresado que el Alumno es Discapacitado, ingrese la Discapacidad que padece, no puede dejar el registro en blanco. Corrija la Columna N, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }
                    }



                    // Validando c_cargo

                    $bandera01=false;
                    if(intval($row->c_cargo)==15 || intval($row->c_cargo)==1 || intval($row->c_cargo)==2 || intval($row->c_cargo)==3 || intval($row->c_cargo)==4 ||
                    intval($row->c_cargo)==5 || intval($row->c_cargo)==6 || intval($row->c_cargo)==7 || intval($row->c_cargo)==8 || intval($row->c_cargo)==9 ||
                    intval($row->c_cargo)==10 || intval($row->c_cargo)==11 || intval($row->c_cargo)==12 || intval($row->c_cargo)==13 || intval($row->c_cargo)==14                    
                    ){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna CARGO";
                        $detError="El código del Cargo no corresponde a los valores posibles de ser consignados. Corrija la Columna O, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }



                    // Validando c_desc_cargo

                    $bandera01=false;
                    if(strlen(trim($row->c_desc_cargo))>0){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna DESCRIPCIÓN DEL CARGO";
                        $detError="El registro ingresado se encuentran en blanco. Corrija la Columna P, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_clase

                    $bandera01=false;
                    if(intval($row->c_clase)==1 || intval($row->c_clase)==2 || intval($row->c_clase)==3){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna CONDICIÓN LABORAL";
                        $detError="El código de Condición Laboral no corresponde a los valores posibles a ser consignados, no puede dejar el registro en blanco. Corrija la Columna Q, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_max_grado

                    $bandera01=false;
                    if(intval($row->c_max_grado)==0 || intval($row->c_max_grado)==1 || intval($row->c_max_grado)==2 || intval($row->c_max_grado)==3 || intval($row->c_max_grado)==4 ||
                    intval($row->c_max_grado)==5 || intval($row->c_max_grado)==6                
                    ){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna MAXIMO GRADO ACADÉMICO";
                        $detError="El valor ingresado no corresponde a ninguno de los valores posibles. Corrija la Columna R, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }



                    // Validando c_desc_max_grado

                    if(intval($row->c_max_grado)!=0){
                        $bandera01=false;
                        if(strlen(trim($row->c_desc_max_grado))>0){
                            $bandera01=true;
                            }
                        if($bandera01==false){

                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna DESCRIPCIÓN DEL MÁXIMO GRADO ACADÉMICO";
                            $detError="Si ha indicado que el Personal Administrativo cuenta con un grado académico. Debe de ingresar la descripción del máximo grado académico del Personal Administrativo. Corrija la Columna S, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }
                    }



                    // Validando c_tiene_titulo

                    $bandera01=false;
                    if(intval($row->c_tiene_titulo)==0 || intval($row->c_tiene_titulo)==1){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna ¿TIENE TÍTULO UNIVERSITARIO?";
                        $detError="El código de ¿Tiene Título Universitario? solo debe de llevar valores de 0 ó vacío para NO ó 1 para SI. Corrija la Columna T, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_titulo

                    if( intval($row->c_tiene_titulo)==1){
                        $bandera01=false;
                        if(strlen(trim($row->c_titulo))>0){
                            $bandera01=true;
                            }
                        if($bandera01==false){

                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna DESCRIPCIÓN DEL TÍTULO UNIVERSITARIO";
                            $detError="Si indicó que el Personal Administrativo tiene título Universitario: Debe de ingresar la descripción del título Universitario que posee. Corrija la Columna U, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }
                    }

                    
                     // Validando c_lugar_max_grado

                     if(intval($row->c_max_grado)!=0){
                        $bandera01=false;
                        if(intval($row->c_lugar_max_grado)==1 || intval($row->c_lugar_max_grado)==2){
                            $bandera01=true;
                            }
                        if($bandera01==false){

                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna LUGAR DEL MÁXIMO GRADO ACADÉMICO";
                            $detError="Si ha indicado que el Personal Administrativo cuenta con un grado académico. El código de Lugar del Máximo grado académico solo debe de llevar valores de 1: Nacional o 2:Internacional. Corrija la Columna V, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }
                    }



                    // Validando c_pais_max_grado
                    if(intval($row->c_max_grado)!=0){
                        if( intval($row->c_lugar_max_grado)==2){
                            $bandera01=false;
                            if(strlen(trim($row->c_pais_max_grado))>0){
                                $bandera01=true;
                                }
                            if($bandera01==false){

                                $errorFila="Error en la Fila ".($key+6);
                                $errorColumna="Error en la Columna PAÍS DONDE OBTUVO EL MÁXIMO GRADO ACADÉMICO";
                                $detError="Si ha indicado que el lugar donde obtuvo su máximo grado es internacional: Debe de ingresar la descripción del país donde el Personal Administrativo obtuvo su máximo grado académico. Corrija la Columna W, Fila ".($key+6);
                                $error=1;
                                break 1;
                            }
                        }
                    }



                    // Validando c_estado_contrato

                    $bandera01=false;
                    if(intval($row->c_estado_contrato)==0 || intval($row->c_estado_contrato)==1){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna ESTADO DE CONTRATO";
                        $detError="El código de Estado de Contrato solo debe de llevar valores de 0 ó vacío para Finalizado ó 1 para Activo. Corrija la Columna X, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }



                    // Validando c_fecha_ingreso

                    if(strlen(trim($row->c_fecha_ingreso))==10){

                        if(checkdate(intval(substr($row->c_fecha_ingreso, -7,2)), intval(substr($row->c_fecha_ingreso, -10,2)), intval(substr($row->c_fecha_ingreso, -4)))){
                            $var=pasFechaBD($row->c_fecha_ingreso);
                            $dateTime = DateTime::createFromFormat('Y-m-d', $var);  //pasar a datetime
                            $fechanac=$dateTime->format('Y-m-d');
                            $bandera01=false;
                            if($fechanac != null){
                                $bandera01=true;
                                }
                                if($bandera01==false){
            
                                    $errorFila="Error en la Fila ".($key+6);
                                    $errorColumna="Error en la Columna FECHA DE INGRESO AL CARGO";
                                    $detError="El dato ingresado se encuentran en blanco o no tiene un formato correcto. Corrija la Columna Y, Fila ".($key+6);
                                    $error=1;
                                    break 1;
            
                                }
                        }
                        else{
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna FECHA DE INGRESO AL CARGO";
                            $detError="El dato ingresado se encuentran en blanco o no tiene un formato correcto. Corrija la Columna Y, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }

                    }
                    else{
                        if($row->c_fecha_ingreso != null && strlen($row->c_fecha_ingreso->format('Y-m-d')) != null){
                            $bandera01=true;
                        }
                        else{
                            $bandera01=false;
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna FECHA DE INGRESO AL CARGO";
                            $detError="El dato ingresado se encuentran en blanco o no tiene un formato correcto. Corrija la Columna Y, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }
                    }



                    // Validando c_fecha_ingreso


                    if(intval($row->c_estado_contrato)==0){
                        
                        if(strlen(trim($row->c_fecha_salida))==10){

                            if(checkdate(intval(substr($row->c_fecha_salida, -7,2)), intval(substr($row->c_fecha_salida, -10,2)), intval(substr($row->c_fecha_salida, -4)))){
                                $var=pasFechaBD($row->c_fecha_salida);
                                $dateTime = DateTime::createFromFormat('Y-m-d', $var);  //pasar a datetime
                                $fechanac=$dateTime->format('Y-m-d');
                                $bandera01=false;
                                if($fechanac != null){
                                    $bandera01=true;
                                    }
                                    if($bandera01==false){
                
                                        $errorFila="Error en la Fila ".($key+6);
                                        $errorColumna="Error en la Columna FECHA DE SALIDA DEL CARGO";
                                        $detError="Si indicó que el estado de contrato es Finalizado debe de consignar un valor válido. El dato ingresado se encuentran en blanco o no tiene un formato correcto. Corrija la Columna Z, Fila ".($key+6);
                                        $error=1;
                                        break 1;
                
                                    }
                            }
                            else{
                                $errorFila="Error en la Fila ".($key+6);
                                $errorColumna="Error en la Columna FECHA DE SALIDA DEL CARGO";
                                $detError="Si indicó que el estado de contrato es Finalizado debe de consignar un valor válido. El dato ingresado se encuentran en blanco o no tiene un formato correcto. Corrija la Columna Z, Fila ".($key+6);
                                $error=1;
                                break 1;
                            }

                        }
                        else{
                            if($row->c_fecha_salida != null && strlen($row->c_fecha_salida->format('Y-m-d')) != null){
                                $bandera01=true;
                            }
                            else{
                                $bandera01=false;
                                $errorFila="Error en la Fila ".($key+6);
                                $errorColumna="Error en la Columna FECHA DE SALIDA DEL CARGO";
                                $detError="Si indicó que el estado de contrato es Finalizado debe de consignar un valor válido. El dato ingresado se encuentran en blanco o no tiene un formato correcto. Corrija la Columna Z, Fila ".($key+6);
                                $error=1;
                                break 1;
                            }
                        }
                    }


                    // Validando c_pais

                    $bandera01=false;
                    if(strlen(trim($row->c_pais))>0){
                    $bandera01=true;
                    }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna PAÍS DE PROCEDENCIA";
                        $detError="El País de Procedencia ingresado se encuentran en blanco. Corrija la Columna AA, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_depar

                    $bandera01=false;
                    if(strlen(trim($row->c_depar))>0){
                    $bandera01=true;
                    }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna DEPARTAMENTO DE PROCEDENCIA";
                        $detError="El Departamento de Procedencia ingresado se encuentran en blanco. Corrija la Columna AB, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_prov

                    $bandera01=false;
                    if(strlen(trim($row->c_prov))>0){
                    $bandera01=true;
                    }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna PROVINCIA DE PROCEDENCIA";
                        $detError="La Provincia de Procedencia ingresado se encuentran en blanco. Corrija la Columna AC, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_dist

                    $bandera01=false;
                    if(strlen(trim($row->c_dist))>0){
                    $bandera01=true;
                    }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna DISTRITO DE PROCEDENCIA";
                        $detError="El Distrito de Procedencia ingresado se encuentran en blanco. Corrija la Columna AD, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }



                    // Validando c_direc   

                    $bandera01=false;
                    if(strlen(trim($row->c_direc))>0){
                    $bandera01=true;
                    }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="DIRECCIÓN DEL PERSONAL ADMINISTRATIVO";
                        $detError="El Valor ingresado se encuentran en blanco. Corrija la Columna AE, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }



                    // Validando c_email 

                    $bandera01=false;
                    if(strlen(trim($row->c_email))>0 && is_valid_email(trim($row->c_email))){
                    $bandera01=true;
                    }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna CORREO ELECTRÓNICO PERSONAL";
                        $detError="El Valor ingresado se encuentran en blanco, o cuenta con un formato incorrecto. Corrija la Coumna AF, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_mail_insti

                    $bandera01=false;
                    if(strlen(trim($row->c_mail_insti))>0 && is_valid_email(trim($row->c_mail_insti))){
                    $bandera01=true;
                    }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna CORREO ELECTRÓNICO INSTITUCIONAL";
                        $detError="El Valor ingresado se encuentran en blanco, o cuenta con un formato incorrecto. Corrija la Coumna AG, Fila ".($key+6);
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
                        $idAdministrativo="0";

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

                        $fechanac= null;
                        if(strlen(trim($row->c_fechanac))==10){

                            $fechanac=pasFechaBD($row->c_fechanac);
                        }
                        else{
                            $fechanac=$row->c_fechanac->format('Y-m-d');
                        }


                        //Administrativo

                        $cargo = "Otro";
                        $clase = "";
                        $descMaximoGrado = "";
                        $lugarMaximoGrado = "";
                        $paisMaximoGrado = "";
                        $titulo = "";
                        $fechaIngreso = null;
                        $fechaSalida = null;

                        $facultad = "0";
                        $escuela = "0";

                        if(intval($row->c_tipo_dependencia) == 9){
                            $facultad = trim($row->c_dependencia);
                        } 
                        elseif(intval($row->c_tipo_dependencia) == 10){
                            $escuela = trim($row->c_dependencia);
                        } 

                        

                        switch (intval($row->c_cargo)) {
                            case 15:
                                $cargo = "Otro";
                                break;
                            case 1:
                                $cargo = "Rector";
                                break;
                            case 2:
                                $cargo = "Vicerrector Académico";
                                break;
                            case 3:
                                $cargo = "Vicerrector de Investigación";
                                break;
                            case 4:
                                $cargo = "Vicerrector Administrativo";
                                break;
                            case 5:
                                $cargo = "Decano";
                                break;
                            case 6:
                                $cargo = "Director de Escuela";
                                break;
                            case 7:
                                $cargo = "Director de Oficina";
                                break;
                            case 8:
                                $cargo = "Jefe de Oficina";
                                break;
                            case 9:
                                $cargo = "Jefe de Departamento Académico";
                                break;
                            case 10:
                                $cargo = "Coordinador";
                                break;
                            case 11:
                                $cargo = "Asesor";
                                break;
                            case 12:
                                $cargo = "Asistente Administrativo";
                                break;
                            case 13:
                                $cargo = "Especialista";
                                break;
                            case 14:
                                $cargo = "Analista";
                                break;
                        }


                        switch (intval($row->c_clase)) {

                            case 1:
                                $clase = "Nombrado";
                                break;
                            case 2:
                                $clase = "Contratado";
                                break;
                            case 3:
                                $clase = "CAS";
                                break;
                        }


                        if(intval($row->c_max_grado)!=0) {
                            
                            $descMaximoGrado = trim($row->c_desc_max_grado);

                            if(intval($row->c_lugar_max_grado)==1){
                                $lugarMaximoGrado = "Nacional";
                                $paisMaximoGrado = "PERÚ";
                            }elseif(intval($row->c_lugar_max_grado)==2){
                                $lugarMaximoGrado = "Internacional";
                                $paisMaximoGrado = trim($row->c_pais_max_grado);
                            }
                        }


                        if( intval($row->c_tiene_titulo)==1){
                            $titulo = trim($row->c_titulo);
                        }


                        if(strlen(trim($row->c_fecha_ingreso))==10){

                            $fechaIngreso=pasFechaBD($row->c_fecha_ingreso);
                        }
                        else{
                            $fechaIngreso=$row->c_fecha_ingreso->format('Y-m-d');
                        }


                        if( intval($row->c_estado_contrato)==0){
                            if(strlen(trim($row->c_fecha_salida))==10){

                                $fechaSalida=pasFechaBD($row->c_fecha_salida);
                            }
                            else{
                                $fechaSalida=$row->c_fecha_salida->format('Y-m-d');
                            }
                        }



                        if(intval($persona_id)!=0)
                        {
                            $editPersona =Persona::find($persona_id);

                            $editPersona->tipodoc = intval($row->c_tipodoc);
                            $editPersona->doc = trim($row->c_numdoc);
                            $editPersona->nombres = trim($row->c_noms);
                            $editPersona->apellidopat = trim($row->c_apepat);
                            $editPersona->apellidomat = trim($row->c_apemat);
                            $editPersona->genero = $newGenero;
                            $editPersona->estadocivil = intval($row->c_estadociv);
                            $editPersona->fechanac = $fechanac;
                            $editPersona->esdiscapacitado = intval($row->c_esdisca);
                            $editPersona->discapacidad = $discapacidad;
                            $editPersona->pais = trim($row->c_pais);
                            $editPersona->departamento = trim($row->c_depar);
                            $editPersona->provincia = trim($row->c_prov);
                            $editPersona->distrito = trim($row->c_dist);
                            $editPersona->direccion = trim($row->c_direc);
                            $editPersona->email = trim($row->c_email);
                            $editPersona->telefono = trim($row->c_telf);
                            $editPersona->correoinstitucional = trim($row->c_mail_insti);
                            $editPersona->identidadetnica = trim($row->c_identidad);
                
                            $editPersona->save();
                        }
                        else{
                            $newPersona = new Persona();
                            $newPersona->tipodoc = intval($row->c_tipodoc);
                            $newPersona->doc = trim($row->c_numdoc);
                            $newPersona->nombres = trim($row->c_noms);
                            $newPersona->apellidopat = trim($row->c_apepat);
                            $newPersona->apellidomat = trim($row->c_apemat);
                            $newPersona->genero = $newGenero;
                            $newPersona->estadocivil = intval($row->c_estadociv);
                            $newPersona->fechanac = $fechanac;
                            $newPersona->esdiscapacitado = intval($row->c_esdisca);
                            $newPersona->discapacidad = $discapacidad;
                            $newPersona->pais = trim($row->c_pais);
                            $newPersona->departamento = trim($row->c_depar);
                            $newPersona->provincia = trim($row->c_prov);
                            $newPersona->distrito = trim($row->c_dist);
                            $newPersona->direccion = trim($row->c_direc);
                            $newPersona->email = trim($row->c_email);
                            $newPersona->telefono = trim($row->c_telf);
                            $newPersona->correoinstitucional = trim($row->c_mail_insti);
                            $newPersona->identidadetnica = trim($row->c_identidad);
                            $newPersona->activo = '1';
                            $newPersona->borrado = '0';
                
                            $newPersona->save();
                
                            $persona_id=$newPersona->id;
                        }

                        $administrativos=Administrativo::where('persona_id',$persona_id)->where('fechaIngreso',$fechaIngreso)->get();
                        $idAdministrativo=0;

                        

                        

                        foreach ($administrativos as $key => $dato) {
                            $idAdministrativo=$dato->id;
                        }
                
                        if(intval($idAdministrativo)==0)
                        {

                            $newAdministrativo = new Administrativo();

                            $newAdministrativo->persona_id=$persona_id;
                            $newAdministrativo->local_id=intval($row->c_local);
                            $newAdministrativo->tipoDependencia=intval($row->c_tipo_dependencia);
                            $newAdministrativo->dependencia=trim($row->c_dependencia);
                            $newAdministrativo->facultad=$facultad;
                            $newAdministrativo->escuela=$escuela;
                            $newAdministrativo->cargo=$cargo;
                            $newAdministrativo->descripcionCargo=trim($row->c_desc_cargo);
                            $newAdministrativo->grado=intval($row->c_max_grado);
                            $newAdministrativo->descripcionGrado=$descMaximoGrado;
                            $newAdministrativo->esTitulado=intval($row->c_tiene_titulo);
                            $newAdministrativo->descripcionTitulo=$titulo;
                            $newAdministrativo->lugarGrado=$lugarMaximoGrado;
                            $newAdministrativo->paisGrado=$paisMaximoGrado;
                            $newAdministrativo->fechaIngreso=$fechaIngreso;
                            $newAdministrativo->observaciones=trim($row->c_obs);
                            $newAdministrativo->estado=intval($row->c_estado_contrato);
                            $newAdministrativo->condicion=$clase;
                            $newAdministrativo->fechaSalida=$fechaSalida;

                            $newAdministrativo->activo='1';
                            $newAdministrativo->borrado='0';

                            $newAdministrativo->save();
    
                        } 
                        else
                        {

                            $editAdministrativo = Administrativo::find($idAdministrativo);

                            $editAdministrativo->persona_id=$persona_id;
                            $editAdministrativo->local_id=intval($row->c_local);
                            $editAdministrativo->tipoDependencia=intval($row->c_tipo_dependencia);
                            $editAdministrativo->dependencia=trim($row->c_dependencia);
                            $editAdministrativo->facultad=$facultad;
                            $editAdministrativo->escuela=$escuela;
                            $editAdministrativo->cargo=$cargo;
                            $editAdministrativo->descripcionCargo=trim($row->c_desc_cargo);
                            $editAdministrativo->grado=intval($row->c_max_grado);
                            $editAdministrativo->descripcionGrado=$descMaximoGrado;
                            $editAdministrativo->esTitulado=intval($row->c_tiene_titulo);
                            $editAdministrativo->descripcionTitulo=$titulo;
                            $editAdministrativo->lugarGrado=$lugarMaximoGrado;
                            $editAdministrativo->paisGrado=$paisMaximoGrado;
                            $editAdministrativo->fechaIngreso=$fechaIngreso;
                            $editAdministrativo->observaciones=trim($row->c_obs);
                            $editAdministrativo->estado=intval($row->c_estado_contrato);
                            $editAdministrativo->condicion=$clase;
                            $editAdministrativo->fechaSalida=$fechaSalida;


                            $editAdministrativo->save();


                        }               
  
                    }

                }
                   

            })->get(); 
        
    }

        $errtitulo = $errorColumna.' '.$errorFila;
        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector, 'errtitulo'=>$errtitulo]);
   
    }

}
