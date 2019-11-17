<?php

namespace App\Http\Controllers;

use App\Beneficiario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Programassalud;
use Validator;
use Auth;
use DB;

use App\Persona;
use App\Tipouser;
use App\User;

use Excel;
set_time_limit(600);

class BeneficiarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index1($idprogramassaluds)
    {
        if(accesoUser([1,2])){


            $idtipouser=Auth::user()->tipouser_id;
            $tipouser=Tipouser::find($idtipouser);

            $programassalud=Programassalud::find($idprogramassaluds);
            $modulo="beneficiarios";

            return view('beneficiarios.index',compact('tipouser','modulo','programassalud'));

            
        }
        else
        {
            return redirect('home');          
        }
    }


    public function index(Request $request)
    {   
     $buscar=$request->busca;
     $programasalud=$request->programasalud;

      
     $beneficiarios = DB::table('beneficiarios')
     ->join('personas', 'personas.id', '=', 'beneficiarios.persona_id')
     ->join('programassaluds', 'programassaluds.id', '=', 'beneficiarios.programassalud_id')

     ->where('programassaluds.id',$programasalud)
     ->where('beneficiarios.borrado','0')
     ->where(function($query) use ($buscar){
        $query->where('personas.nombres','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidopat','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidomat','like','%'.$buscar.'%');
        $query->orWhere('personas.doc','like','%'.$buscar.'%');
        })
     ->orderBy('personas.apellidopat')
     ->orderBy('personas.apellidomat')
     ->orderBy('personas.nombres')

     ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono','beneficiarios.id',
     'beneficiarios.tipo','beneficiarios.persona_id','beneficiarios.codigo','beneficiarios.programassalud_id','beneficiarios.observaciones','beneficiarios.fechaatencion')
     ->paginate(50);




     return [
        'pagination'=>[
            'total'=> $beneficiarios->total(),
            'current_page'=> $beneficiarios->currentPage(),
            'per_page'=> $beneficiarios->perPage(),
            'last_page'=> $beneficiarios->lastPage(),
            'from'=> $beneficiarios->firstItem(),
            'to'=> $beneficiarios->lastItem(),
        ],
        'beneficiarios'=>$beneficiarios
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

        $tipo=$request->tipo;
        $persona_id=$request->persona_id;
        $codigo=$request->codigo;
        $programassalud_id=$request->programassalud_id;
        $observaciones=$request->observaciones;
        $fechaatencion=$request->fechaatencion;
         

        $programas=Programassalud::find($programassalud_id);


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

  

        $input16  = array('fechaatencion' => $fechaatencion);
        $reglas16 = array('fechaatencion' => 'required');


  



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

        $validator16 = Validator::make($input16, $reglas16);




        if($validator1->fails()){
            $result='0';
            $msj='Seleccione un tipo de Documento Válido';
            $selector='cbutipodoc';
        }
        elseif ($validator2->fails())
        {
            $result='0';
            $msj='Complete el Documento de Identidad';
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
            $msj='Ingrese los nombres';
            $selector='txtnombres';
        }
        elseif ($validator4->fails()) {
            $result='0';
            $msj='Ingrese el apellido paterno';
            $selector='txtapepat';
        }
        elseif ($validator5->fails()) {
            $result='0';
            $msj='Ingrese el apellido materno';
            $selector='txtapemat';
        }
        elseif ($validator6->fails()) {
            $result='0';
            $msj='Seleccione el Género';
            $selector='cbugenero';
        }
        elseif ($validator7->fails()) {
            $result='0';
            $msj='Seleccione el Estado Civil';
            $selector='cbuestadocivil';
        }
        elseif ($validator8->fails()) {
            $result='0';
            $msj='Ingrese la Fecha de Nacimiento';
            $selector='txtfechanac';
        }
        elseif ($validator9->fails()) {
            $result='0';
            $msj='Seleccione si la persona es Discapacitada';
            $selector='cbugenero';
        }
        elseif (intval($esdiscapacitado)==1 && strlen($discapacidad)==0) {
            $result='0';
            $msj='Si ha indicado que es discapacitado, ingrese la discapacidad que padece';
            $selector='txtdiscapacidad';
        }

        elseif ($validator10->fails()) {
            $result='0';
            $msj='Ingrese el País de procedencia';
            $selector='txtpais';
        }
        elseif ($validator11->fails()) {
            $result='0';
            $msj='Ingrese el Departamento de procedencia';
            $selector='txtdep';
        }
        elseif ($validator12->fails()) {
            $result='0';
            $msj='Ingrese la Provincia de procedencia';
            $selector='txtprov';
        }
        elseif ($validator13->fails()) {
            $result='0';
            $msj='Ingrese el Distrito de procedencia';
            $selector='txtdist';
        }
        elseif ($validator14->fails()) {
            $result='0';
            $msj='Ingrese la Dirección';
            $selector='txtDir';
        }



        elseif ($validator16->fails()) {
            $result='0';
            $msj='Seleccione la Escuela Profesional';
            $selector='txtfechaatencion';
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

     
        $newBeneficiario = new Beneficiario();
        $newBeneficiario->tipo=$tipo;
        $newBeneficiario->persona_id=$persona_id;
        $newBeneficiario->codigo=$codigo;
        $newBeneficiario->programassalud_id=$programassalud_id;
        $newBeneficiario->observaciones=$observaciones;
        $newBeneficiario->fechaatencion=$fechaatencion;
        $newBeneficiario->activo='1';
        $newBeneficiario->borrado='0';

        $newBeneficiario->save();


           

            $msj='Registro de Beneficiario guardado con éxito';
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

        $tipo=$request->tipo;
        $persona_id=$request->persona_id;
        $codigo=$request->codigo;
        $programassalud_id=$request->programassalud_id;
        $observaciones=$request->observaciones;
        $fechaatencion=$request->fechaatencion;
         

        $programas=Programassalud::find($programassalud_id);


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

  

        $input16  = array('fechaatencion' => $fechaatencion);
        $reglas16 = array('fechaatencion' => 'required');


  



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

        $validator16 = Validator::make($input16, $reglas16);




        if($validator1->fails()){
            $result='0';
            $msj='Seleccione un tipo de Documento Válido';
            $selector='cbutipodoc';
        }
        elseif ($validator2->fails())
        {
            $result='0';
            $msj='Complete el Documento de Identidad';
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
            $msj='Ingrese los nombres';
            $selector='txtnombres';
        }
        elseif ($validator4->fails()) {
            $result='0';
            $msj='Ingrese el apellido paterno';
            $selector='txtapepat';
        }
        elseif ($validator5->fails()) {
            $result='0';
            $msj='Ingrese el apellido materno';
            $selector='txtapemat';
        }
        elseif ($validator6->fails()) {
            $result='0';
            $msj='Seleccione el Género';
            $selector='cbugenero';
        }
        elseif ($validator7->fails()) {
            $result='0';
            $msj='Seleccione el Estado Civil';
            $selector='cbuestadocivil';
        }
        elseif ($validator8->fails()) {
            $result='0';
            $msj='Ingrese la Fecha de Nacimiento';
            $selector='txtfechanac';
        }
        elseif ($validator9->fails()) {
            $result='0';
            $msj='Seleccione si la persona es Discapacitada';
            $selector='cbugenero';
        }
        elseif (intval($esdiscapacitado)==1 && strlen($discapacidad)==0) {
            $result='0';
            $msj='Si ha indicado que es discapacitado, ingrese la discapacidad que padece';
            $selector='txtdiscapacidad';
        }

        elseif ($validator10->fails()) {
            $result='0';
            $msj='Ingrese el País de procedencia';
            $selector='txtpais';
        }
        elseif ($validator11->fails()) {
            $result='0';
            $msj='Ingrese el Departamento de procedencia';
            $selector='txtdep';
        }
        elseif ($validator12->fails()) {
            $result='0';
            $msj='Ingrese la Provincia de procedencia';
            $selector='txtprov';
        }
        elseif ($validator13->fails()) {
            $result='0';
            $msj='Ingrese el Distrito de procedencia';
            $selector='txtdist';
        }
        elseif ($validator14->fails()) {
            $result='0';
            $msj='Ingrese la Dirección';
            $selector='txtDir';
        }



        elseif ($validator16->fails()) {
            $result='0';
            $msj='Seleccione la Escuela Profesional';
            $selector='txtfechaatencion';
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
       
     
        $newBeneficiario =Beneficiario::find($id);
        $newBeneficiario->tipo=$tipo;
        $newBeneficiario->persona_id=$persona_id;
        $newBeneficiario->codigo=$codigo;
        $newBeneficiario->programassalud_id=$programassalud_id;
        $newBeneficiario->observaciones=$observaciones;
        $newBeneficiario->fechaatencion=$fechaatencion;


        $newBeneficiario->save();


           

            $msj='Registro de Beneficiario modificado con éxito';
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

   
        
        $borrar = Beneficiario::destroy($id);
        //$task->delete();


        $msj='Registro de Beneficiario Seleccionado eliminado exitosamente';
   

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }

    public function descargarExcel(Request $request)
    {   
        $buscar=$request->busca;
        $programasalud=$request->programasalud;

        $programas=Programassalud::find($programasalud);

        if(intval($programas->tipo)==1){

        Excel::create('Beneficiarios del Programa de Salud - '.$programas->nombre, function($excel) use($buscar,$programas)  {
            $excel->sheet('BD Beneficiarios', function($sheet) use($buscar,$programas){

                $sheet->setAutoSize(true);
                /* $sheet->mergeCells('B1:D1');
                $sheet->mergeCells('B2:H2'); */

                $sheet->mergeCells('A3:O3');
                $sheet->cells('A3:O3',function($cells)
                {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
                $sheet->setBorder('A3:O3', 'thin');
                $sheet->cells('A3:O3', function($cells)
                {
                    $cells->setBackground('#0C73E8');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontSize(15);

                    #Borders
                });
                
                $sheet->cells('A4:O4', function($cells)
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
                'J'=>'20',
                'K'=>'35',
                'L'=>'45',
                'M'=>'45',
                'N'=>'20',
                'O'=>'65',
                )
                );

                $sheet->setHeight(array
                (
                '3'=>'24'
                )
                );

                $titulo='BASE DE DATOS DE BENEFICIARIOS DEL PROGRAMA DE SALUD '.$programas->nombre;

                array_push($data, array(''));
                array_push($data, array(''));
                array_push($data, array($titulo));

                $sheet->setBorder('A4:O4', 'thin');
                array_push($data, array('N°','TIPO DE DOCUMENTO', 'NÚMERO DE DOCUMENTO', 'APELLIDO PATERNO', 'APELLIDO MATERNO','NOMBRES','GÉNERO','FECHA DE NACIMIENTO','ESTADO CIVIL','SUFRE DISCAPACIDAD','DISCAPACIDAD QUE PADECE','PROGRAMA DE SALUD','TIPO DE BENEFICIARIO','FECHA DE ATENCIÓN','OBSERVACIONES'));

                $cont=5;
                $cont2=5;

                $beneficiarios = DB::table('beneficiarios')
                ->join('personas', 'personas.id', '=', 'beneficiarios.persona_id')
                ->join('programassaluds', 'programassaluds.id', '=', 'beneficiarios.programassalud_id')
           
                ->where('programassaluds.id',$programas->id)
                ->where('beneficiarios.borrado','0')
                ->where(function($query) use ($buscar){
                   $query->where('personas.nombres','like','%'.$buscar.'%');
                   $query->orWhere('personas.apellidopat','like','%'.$buscar.'%');
                   $query->orWhere('personas.apellidomat','like','%'.$buscar.'%');
                   $query->orWhere('personas.doc','like','%'.$buscar.'%');
                   })
                ->orderBy('personas.apellidopat')
                ->orderBy('personas.apellidomat')
                ->orderBy('personas.nombres')
           
                ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono','beneficiarios.id',
                'beneficiarios.tipo','beneficiarios.persona_id','beneficiarios.codigo','beneficiarios.programassalud_id','beneficiarios.observaciones','beneficiarios.fechaatencion')
                ->get();

        foreach ($beneficiarios as $key => $dato) {
            $rango='A'.strval((intval($cont)+intval($key))).':O'.strval((intval($cont)+intval($key)));
            $sheet->setBorder($rango, 'thin');

/*
$sheet->setBorder('A4:S4', 'thin');
                array_push($data, array('N°','TIPO DE DOCUMENTO', 'NÚMERO DE DOCUMENTO', 'APELLIDO PATERNO', 'APELLIDO MATERNO','NOMBRES','GÉNERO','FECHA DE NACIMIENTO','ESTADO CIVIL','SUFRE DISCAPACIDAD','DISCAPACIDAD QUE PADECE','PROGRAMA DE SALUD','TIPO DE BENEFICIARIO','CÓDIGO','FECHA DE ATENCIÓN','OBSERVACIONES'));
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
           $programas->nombre,
           tipoBeneficiario($dato->tipo),
           pasFechaVista($dato->fechaatencion),
           $dato->observaciones
        
        ));
            
            $cont2++;
        }



                $sheet->fromArray($data, null, 'A1', false, false);
            
            });
            })->download('xlsx');  
   
        }elseif(intval($programas->tipo)==2){

            Excel::create('Beneficiarios de la Campaña de Salud - '.$programas->nombre, function($excel) use($buscar,$programas)  {
                $excel->sheet('BD Beneficiarios', function($sheet) use($buscar,$programas){
    
                    $sheet->setAutoSize(true);
                    /* $sheet->mergeCells('B1:D1');
                    $sheet->mergeCells('B2:H2'); */
    
                    $sheet->mergeCells('A3:O3');
                    $sheet->cells('A3:O3',function($cells)
                    {
                        $cells->setAlignment('center');
                        $cells->setValignment('center');
                    });
                    $sheet->setBorder('A3:O3', 'thin');
                    $sheet->cells('A3:O3', function($cells)
                    {
                        $cells->setBackground('#0C73E8');
                        $cells->setFontColor('#FFFFFF');
                        $cells->setAlignment('center');
                        $cells->setValignment('center');
                        $cells->setFontSize(15);
    
                        #Borders
                    });
                    
                    $sheet->cells('A4:O4', function($cells)
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
                    'J'=>'20',
                    'K'=>'35',
                    'L'=>'45',
                    'M'=>'45',
                    'N'=>'20',
                    'O'=>'65',
                    )
                    );
    
                    $sheet->setHeight(array
                    (
                    '3'=>'24'
                    )
                    );
    
                    $titulo='BASE DE DATOS DE BENEFICIARIOS DE LA CAMPAÑA DE SALUD '.$programas->nombre;
    
                    array_push($data, array(''));
                    array_push($data, array(''));
                    array_push($data, array($titulo));
    
                    $sheet->setBorder('A4:O4', 'thin');
                    array_push($data, array('N°','TIPO DE DOCUMENTO', 'NÚMERO DE DOCUMENTO', 'APELLIDO PATERNO', 'APELLIDO MATERNO','NOMBRES','GÉNERO','FECHA DE NACIMIENTO','ESTADO CIVIL','SUFRE DISCAPACIDAD','DISCAPACIDAD QUE PADECE','CAMPAÑA DE SALUD','TIPO DE BENEFICIARIO','FECHA DE ATENCIÓN','OBSERVACIONES'));
    
                    $cont=5;
                    $cont2=5;
    
                    $beneficiarios = DB::table('beneficiarios')
                    ->join('personas', 'personas.id', '=', 'beneficiarios.persona_id')
                    ->join('programassaluds', 'programassaluds.id', '=', 'beneficiarios.programassalud_id')
               
                    ->where('programassaluds.id',$programas->id)
                    ->where('beneficiarios.borrado','0')
                    ->where(function($query) use ($buscar){
                       $query->where('personas.nombres','like','%'.$buscar.'%');
                       $query->orWhere('personas.apellidopat','like','%'.$buscar.'%');
                       $query->orWhere('personas.apellidomat','like','%'.$buscar.'%');
                       $query->orWhere('personas.doc','like','%'.$buscar.'%');
                       })
                    ->orderBy('personas.apellidopat')
                    ->orderBy('personas.apellidomat')
                    ->orderBy('personas.nombres')
               
                    ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono','beneficiarios.id',
                    'beneficiarios.tipo','beneficiarios.persona_id','beneficiarios.codigo','beneficiarios.programassalud_id','beneficiarios.observaciones','beneficiarios.fechaatencion')
                    ->get();
    
            foreach ($beneficiarios as $key => $dato) {
                $rango='A'.strval((intval($cont)+intval($key))).':O'.strval((intval($cont)+intval($key)));
                $sheet->setBorder($rango, 'thin');
    
    /*
    $sheet->setBorder('A4:S4', 'thin');
                    array_push($data, array('N°','TIPO DE DOCUMENTO', 'NÚMERO DE DOCUMENTO', 'APELLIDO PATERNO', 'APELLIDO MATERNO','NOMBRES','GÉNERO','FECHA DE NACIMIENTO','ESTADO CIVIL','SUFRE DISCAPACIDAD','DISCAPACIDAD QUE PADECE','PROGRAMA DE SALUD','TIPO DE BENEFICIARIO','CÓDIGO','FECHA DE ATENCIÓN','OBSERVACIONES'));
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
               $programas->nombre,
               tipoBeneficiario($dato->tipo),
               pasFechaVista($dato->fechaatencion),
               $dato->observaciones
            
            ));
                
                $cont2++;
            }
    
    
    
                    $sheet->fromArray($data, null, 'A1', false, false);
                
                });
                })->download('xlsx');
        }

        

        return response()->json(["buscar"=>$buscar,'programasalud'=>$programasalud]);
    }
}
