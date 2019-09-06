<?php

namespace App\Http\Controllers;

use App\Docente;
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



class DocenteController extends Controller
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
            $facultads=Facultad::where('activo','1')->where('borrado','0')->get();

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


            $modulo="docentes";
            return view('docentes.index',compact('tipouser','modulo','escuelas','semestres','facultads','semestresel','contse','semestreNombre'));
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

     $docentes = DB::table('docentes')
     ->join('personas', 'personas.id', '=', 'docentes.persona_id')
     ->join('semestres', 'semestres.id', '=', 'docentes.semestre_id')
     ->leftjoin('facultads', 'facultads.id', '=', 'docentes.facultad_id')
     ->leftjoin('escuelas', 'escuelas.id', '=', 'docentes.escuela_id')
     ->where('docentes.borrado','0')
     ->where('semestres.id',$semestre_id)
     ->where(function($query) use ($buscar){
        $query->where('personas.nombres','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidopat','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidomat','like','%'.$buscar.'%');
        $query->orWhere('personas.doc','like','%'.$buscar.'%');
        $query->orWhere('facultads.nombre','like','%'.$buscar.'%');
        $query->orWhere('escuelas.nombre','like','%'.$buscar.'%');
        })
     ->orderBy('personas.apellidopat')
     ->orderBy('personas.apellidomat')
     ->orderBy('personas.nombres')
     ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono','docentes.id',
    'docentes.personalacademico','docentes.cargogeneral','docentes.descripcioncargo','docentes.maximogrado','docentes.descmaximogrado','docentes.universidadgrado','docentes.lugarmaximogrado','docentes.paismaximogrado','docentes.otrogrado','docentes.estadootrogrado','docentes.univotrogrado','docentes.lugarotrogrado','docentes.paisotrogrado','docentes.titulo','docentes.descripciontitulo','docentes.condicion','docentes.categoria','docentes.regimen','docentes.investigador','docentes.pregrado','docentes.postgrado','docentes.esdestacado','docentes.fechaingreso','docentes.modalidadingreso','docentes.observaciones','docentes.persona_id','docentes.horaslectivas','docentes.horasnolectivas','docentes.horasinvestigacion','docentes.horasdedicacion','docentes.escuela_id','docentes.facultad_id', 'docentes.dependencia','docentes.semestre_id','semestres.nombre as semestre',DB::Raw("IFNULL( `facultads`.`nombre` , '' ) as facultad"),DB::Raw("IFNULL( `escuelas`.`nombre` , '' ) as escuela"))->paginate(50);


     return [
        'pagination'=>[
            'total'=> $docentes->total(),
            'current_page'=> $docentes->currentPage(),
            'per_page'=> $docentes->perPage(),
            'last_page'=> $docentes->lastPage(),
            'from'=> $docentes->firstItem(),
            'to'=> $docentes->lastItem(),
        ],
        'docentes'=>$docentes
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Docente  $docente
     * @return \Illuminate\Http\Response
     */
    public function show(Docente $docente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Docente  $docente
     * @return \Illuminate\Http\Response
     */
    public function edit(Docente $docente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Docente  $docente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Docente $docente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Docente  $docente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Docente $docente)
    {
        //
    }
}
