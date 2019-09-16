<?php

namespace App\Http\Controllers;

use App\Proyecto;
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

use App\Persona;
use App\Tipouser;
use App\User;

use App\Exports\PlantillaPostulanteExport;
use Maatwebsite\Excel\Facades\Excel;

class ProyectoController extends Controller
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


            $modulo="proyectos";
            return view('proyectos.index',compact('tipouser','modulo','escuelas','semestres','semestresel','contse','semestreNombre'));
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

    
     $proyectos = DB::table('proyectos')
     ->join('personas', 'personas.id', '=', 'proyectos.persona_id')
     ->join('semestres as semestre', 'semestre.id', '=', 'proyectos.semestre_id')

     ->where('proyectos.borrado','0')
     ->where('semestre.id',$semestre_id)
     ->where(function($query) use ($buscar){
        $query->where('proyectos.nombre','like','%'.$buscar.'%');
        $query->orwhere('proyectos.descripcion','like','%'.$buscar.'%');
        $query->orwhere('personas.nombres','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidopat','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidomat','like','%'.$buscar.'%');
        $query->orWhere('personas.doc','like','%'.$buscar.'%');
        })

     ->orderBy('proyectos.fechainicio')
     ->orderBy('proyectos.fechafinal')
     ->orderBy('proyectos.id')

     ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono','proyectos.id',
     'proyectos.nombre','proyectos.descripcion','proyectos.fechainicio','proyectos.fechafinal','proyectos.lugar','proyectos.jefeproyecto','proyectos.fuentefinanciamiento','proyectos.cantidadbeneficiarios','proyectos.semestre_id','proyectos.tipo','proyectos.persona_id','proyectos.presupuesto','proyectos.observaciones','semestre.nombre as semestre')
     ->paginate(50);

   


     return [
        'pagination'=>[
            'total'=> $proyectos->total(),
            'current_page'=> $proyectos->currentPage(),
            'per_page'=> $proyectos->perPage(),
            'last_page'=> $proyectos->lastPage(),
            'from'=> $proyectos->firstItem(),
            'to'=> $proyectos->lastItem(),
        ],
        'proyectos'=>$proyectos
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

        $nombre=$request->nombre;
        $descripcion=$request->descripcion;
        $fechainicio=$request->fechainicio;
        $fechafinal=$request->fechafinal;
        $lugar=$request->lugar;
        $jefeproyecto=$request->jefeproyecto;
        $fuentefinanciamiento=$request->fuentefinanciamiento;
        $cantidadbeneficiarios=$request->cantidadbeneficiarios;
        $semestre_id=$request->semestre_id;
        $tipo=$request->tipo;
        $persona_id=$request->persona_id;
        $presupuesto=$request->presupuesto;
        $observaciones=$request->observaciones;
       
        if(intval($esdiscapacitado)==0)
        {
            $discapacidad="";
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

        $input15  = array('nombre' => $nombre);
        $reglas15 = array('nombre' => 'required');

        $input16  = array('descripcion' => $descripcion);
        $reglas16 = array('descripcion' => 'required');

        $input17  = array('fechainicio' => $fechainicio);
        $reglas17 = array('fechainicio' => 'required');

        $input18  = array('fechafinal' => $fechafinal);
        $reglas18 = array('fechafinal' => 'required');

        $input19  = array('lugar' => $lugar);
        $reglas19 = array('lugar' => 'required');

        $input20  = array('fuentefinanciamiento' => $fuentefinanciamiento);
        $reglas20 = array('fuentefinanciamiento' => 'required');

        $input21  = array('cantidadbeneficiarios' => $cantidadbeneficiarios);
        $reglas21 = array('cantidadbeneficiarios' => 'required');

        $input22  = array('presupuesto' => $presupuesto);
        $reglas22 = array('presupuesto' => 'required');

     



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


        if($validator1->fails()){
            $result='0';
            $msj='Seleccione un tipo de Documento Válido';
            $selector='cbutipodoc';
        }
        elseif ($validator2->fails())
        {
            $result='0';
            $msj='Complete el Documento de Identidad del Jefe de Proyecto o Campaña Itinerante';
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
            $msj='Ingrese los nombres del Jefe de Proyecto o Campaña Itinerante';
            $selector='txtnombres';
        }
        elseif ($validator4->fails()) {
            $result='0';
            $msj='Ingrese el apellido paterno del Jefe de Proyecto o Campaña Itinerante';
            $selector='txtapepat';
        }
        elseif ($validator5->fails()) {
            $result='0';
            $msj='Ingrese el apellido materno del Jefe de Proyecto o Campaña Itinerante';
            $selector='txtapemat';
        }
        elseif ($validator6->fails()) {
            $result='0';
            $msj='Seleccione el Género del Jefe de Proyecto o Campaña Itinerante';
            $selector='cbugenero';
        }
        elseif ($validator7->fails()) {
            $result='0';
            $msj='Seleccione el Estado Civil del Jefe de Proyecto o Campaña Itinerante';
            $selector='cbuestadocivil';
        }
        elseif ($validator8->fails()) {
            $result='0';
            $msj='Ingrese la Fecha de Nacimiento del Jefe de Proyecto o Campaña Itinerante';
            $selector='txtfechanac';
        }
        elseif ($validator9->fails()) {
            $result='0';
            $msj='Seleccione si el Jefe de Proyecto o Campaña Itinerante es Discapacitado';
            $selector='cbugenero';
        }
        elseif (intval($esdiscapacitado)==1 && strlen($discapacidad)==0) {
            $result='0';
            $msj='Si ha indicado que el Jefe de Proyecto o Campaña Itinerante es discapacitado, ingrese la discapacidad que padece';
            $selector='txtdiscapacidad';
        }

        elseif ($validator10->fails()) {
            $result='0';
            $msj='Ingrese el País de procedencia del Jefe de Proyecto o Campaña Itinerante';
            $selector='txtpais';
        }
        elseif ($validator11->fails()) {
            $result='0';
            $msj='Ingrese el Departamento de procedencia del Jefe de Proyecto o Campaña Itinerante';
            $selector='txtdep';
        }
        elseif ($validator12->fails()) {
            $result='0';
            $msj='Ingrese la Provincia de procedencia del Jefe de Proyecto o Campaña Itinerante';
            $selector='txtprov';
        }
        elseif ($validator13->fails()) {
            $result='0';
            $msj='Ingrese el Distrito de procedencia del Jefe de Proyecto o Campaña Itinerante';
            $selector='txtdist';
        }
        elseif ($validator14->fails()) {
            $result='0';
            $msj='Ingrese la Dirección del Jefe de Proyecto o Campaña Itinerante';
            $selector='txtDir';
        }
        elseif ($validator15->fails()) {
            $result='0';
            $msj='Ingrese el nombre del proyecto o campaña itinerante';
            $selector='txtnombre';
        }
        elseif ($validator16->fails()) {
            $result='0';
            $msj='Ingrese la descripción del proyecto o campaña itinerante';
            $selector='txtdescripcion';
        }
        elseif ($validator17->fails()) {
            $result='0';
            $msj='Ingrese la fecha de inicio del proyecto o campaña itinerante';
            $selector='txtfechainicio';
        }
        elseif ($validator18->fails()) {
            $result='0';
            $msj='Ingrese la fecha de culminación del proyecto o campaña itinerante';
            $selector='txtfechafinal';
        }
        elseif ($validator19->fails()) {
            $result='0';
            $msj='Ingrese el Lugar de ejecución del proyecto o campaña itinerante';
            $selector='txtlugar';
        }
        elseif ($validator20->fails()) {
            $result='0';
            $msj='Ingrese la fuente de funanciamiento del proyecto o campaña itinerante';
            $selector='txtfuentefinanciamiento';
        }


        elseif ($validator21->fails() ) {
            $result='0';
            $msj='Ingrese la cantidad de beneficiarios del proyecto o campaña itinerante';
            $selector='txtcantidadbeneficiarios';
        }

        elseif ($validator22->fails() ) {
            $result='0';
            $msj='Ingrese el presupuesto del proyecto o campaña itinerante';
            $selector='txtpresupuesto';
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

        $jefeproyecto=$nombres.' '.$apellidopat.' '.$apellidomat;

        $newProyecto = new Proyecto();
        $newProyecto->nombre=$nombre;
        $newProyecto->descripcion=$descripcion;
        $newProyecto->fechainicio=$fechainicio;
        $newProyecto->fechafinal=$fechafinal;
        $newProyecto->lugar=$lugar;
        $newProyecto->jefeproyecto=$jefeproyecto;
        $newProyecto->fuentefinanciamiento=$fuentefinanciamiento;
        $newProyecto->cantidadbeneficiarios=$cantidadbeneficiarios;
        $newProyecto->semestre_id=$semestre_id;
        $newProyecto->tipo=$tipo;
        $newProyecto->persona_id=$persona_id;
        $newProyecto->presupuesto=$presupuesto;
        $newProyecto->observaciones=$observaciones;

        $newProyecto->activo='1';
        $newProyecto->borrado='0';

        $newProyecto->save();

           

            $msj='Nuevo Proyecto o Campaña Itinerante registrada con éxito';
        }


        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function show(Proyecto $proyecto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function edit(Proyecto $proyecto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Proyecto  $proyecto
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

        $nombre=$request->nombre;
        $descripcion=$request->descripcion;
        $fechainicio=$request->fechainicio;
        $fechafinal=$request->fechafinal;
        $lugar=$request->lugar;
        $jefeproyecto=$request->jefeproyecto;
        $fuentefinanciamiento=$request->fuentefinanciamiento;
        $cantidadbeneficiarios=$request->cantidadbeneficiarios;
        $semestre_id=$request->semestre_id;
        $tipo=$request->tipo;
        $persona_id=$request->persona_id;
        $presupuesto=$request->presupuesto;
        $observaciones=$request->observaciones;
       
        if(intval($esdiscapacitado)==0)
        {
            $discapacidad="";
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

        $input15  = array('nombre' => $nombre);
        $reglas15 = array('nombre' => 'required');

        $input16  = array('descripcion' => $descripcion);
        $reglas16 = array('descripcion' => 'required');

        $input17  = array('fechainicio' => $fechainicio);
        $reglas17 = array('fechainicio' => 'required');

        $input18  = array('fechafinal' => $fechafinal);
        $reglas18 = array('fechafinal' => 'required');

        $input19  = array('lugar' => $lugar);
        $reglas19 = array('lugar' => 'required');

        $input20  = array('fuentefinanciamiento' => $fuentefinanciamiento);
        $reglas20 = array('fuentefinanciamiento' => 'required');

        $input21  = array('cantidadbeneficiarios' => $cantidadbeneficiarios);
        $reglas21 = array('cantidadbeneficiarios' => 'required');

        $input22  = array('presupuesto' => $presupuesto);
        $reglas22 = array('presupuesto' => 'required');

     



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


        if($validator1->fails()){
            $result='0';
            $msj='Seleccione un tipo de Documento Válido';
            $selector='cbutipodocE';
        }
        elseif ($validator2->fails())
        {
            $result='0';
            $msj='Complete el Documento de Identidad del Jefe de Proyecto o Campaña Itinerante';
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
            $msj='Ingrese los nombres del Jefe de Proyecto o Campaña Itinerante';
            $selector='txtnombresE';
        }
        elseif ($validator4->fails()) {
            $result='0';
            $msj='Ingrese el apellido paterno del Jefe de Proyecto o Campaña Itinerante';
            $selector='txtapepatE';
        }
        elseif ($validator5->fails()) {
            $result='0';
            $msj='Ingrese el apellido materno del Jefe de Proyecto o Campaña Itinerante';
            $selector='txtapematE';
        }
        elseif ($validator6->fails()) {
            $result='0';
            $msj='Seleccione el Género del Jefe de Proyecto o Campaña Itinerante';
            $selector='cbugeneroE';
        }
        elseif ($validator7->fails()) {
            $result='0';
            $msj='Seleccione el Estado Civil del Jefe de Proyecto o Campaña Itinerante';
            $selector='cbuestadocivilE';
        }
        elseif ($validator8->fails()) {
            $result='0';
            $msj='Ingrese la Fecha de Nacimiento del Jefe de Proyecto o Campaña Itinerante';
            $selector='txtfechanacE';
        }
        elseif ($validator9->fails()) {
            $result='0';
            $msj='Seleccione si el Jefe de Proyecto o Campaña Itinerante es Discapacitado';
            $selector='cbugeneroE';
        }
        elseif (intval($esdiscapacitado)==1 && strlen($discapacidad)==0) {
            $result='0';
            $msj='Si ha indicado que el Jefe de Proyecto o Campaña Itinerante es discapacitado, ingrese la discapacidad que padece';
            $selector='txtdiscapacidadE';
        }

        elseif ($validator10->fails()) {
            $result='0';
            $msj='Ingrese el País de procedencia del Jefe de Proyecto o Campaña Itinerante';
            $selector='txtpaisE';
        }
        elseif ($validator11->fails()) {
            $result='0';
            $msj='Ingrese el Departamento de procedencia del Jefe de Proyecto o Campaña Itinerante';
            $selector='txtdepE';
        }
        elseif ($validator12->fails()) {
            $result='0';
            $msj='Ingrese la Provincia de procedencia del Jefe de Proyecto o Campaña Itinerante';
            $selector='txtprovE';
        }
        elseif ($validator13->fails()) {
            $result='0';
            $msj='Ingrese el Distrito de procedencia del Jefe de Proyecto o Campaña Itinerante';
            $selector='txtdistE';
        }
        elseif ($validator14->fails()) {
            $result='0';
            $msj='Ingrese la Dirección del Jefe de Proyecto o Campaña Itinerante';
            $selector='txtDirE';
        }
        elseif ($validator15->fails()) {
            $result='0';
            $msj='Ingrese el nombre del proyecto o campaña itinerante';
            $selector='txtnombreE';
        }
        elseif ($validator16->fails()) {
            $result='0';
            $msj='Ingrese la descripción del proyecto o campaña itinerante';
            $selector='txtdescripcionE';
        }
        elseif ($validator17->fails()) {
            $result='0';
            $msj='Ingrese la fecha de inicio del proyecto o campaña itinerante';
            $selector='txtfechainicioE';
        }
        elseif ($validator18->fails()) {
            $result='0';
            $msj='Ingrese la fecha de culminación del proyecto o campaña itinerante';
            $selector='txtfechafinalE';
        }
        elseif ($validator19->fails()) {
            $result='0';
            $msj='Ingrese el Lugar de ejecución del proyecto o campaña itinerante';
            $selector='txtlugarE';
        }
        elseif ($validator20->fails()) {
            $result='0';
            $msj='Ingrese la fuente de funanciamiento del proyecto o campaña itinerante';
            $selector='txtfuentefinanciamientoE';
        }


        elseif ($validator21->fails() ) {
            $result='0';
            $msj='Ingrese la cantidad de beneficiarios del proyecto o campaña itinerante';
            $selector='txtcantidadbeneficiariosE';
        }

        elseif ($validator22->fails() ) {
            $result='0';
            $msj='Ingrese el presupuesto del proyecto o campaña itinerante';
            $selector='txtpresupuestoE';
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
       

            $jefeproyecto=$nombres.' '.$apellidopat.' '.$apellidomat;
         
        $newProyecto =Proyecto::find($id);
        $newProyecto->nombre=$nombre;
        $newProyecto->descripcion=$descripcion;
        $newProyecto->fechainicio=$fechainicio;
        $newProyecto->fechafinal=$fechafinal;
        $newProyecto->lugar=$lugar;
        $newProyecto->jefeproyecto=$jefeproyecto;
        $newProyecto->fuentefinanciamiento=$fuentefinanciamiento;
        $newProyecto->cantidadbeneficiarios=$cantidadbeneficiarios;
        $newProyecto->semestre_id=$semestre_id;
        $newProyecto->tipo=$tipo;
        $newProyecto->persona_id=$persona_id;
        $newProyecto->presupuesto=$presupuesto;
        $newProyecto->observaciones=$observaciones;

        $newProyecto->activo='1';
        $newProyecto->borrado='0';

        $newProyecto->save();

           

            $msj='Proyecto o Campaña Itinerante modificada con éxito';
        }


        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result='1';
        $msj='1';

   
        
        $borrar = Proyecto::destroy($id);
        //$task->delete();


        $msj='Proyecto o campaña itinerante Seleccionada eliminada exitosamente';
   

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
