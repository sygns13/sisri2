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



            $modulo="revistas";
            return view('revistas.index',compact('tipouser','modulo','escuelas'));
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
    'revistaspublicacions.tipoPublicacion','revistaspublicacions.titulo','revistaspublicacions.descripcion','revistaspublicacions.escuela_id','revistaspublicacions.fechaPublicado','revistaspublicacions.indexada','revistaspublicacions.lugarIndexada','revistaspublicacions.numero','revistaspublicacions.rutadoc',DB::Raw("IFNULL( `facultads`.`nombre` , '' ) as facultad"),DB::Raw("IFNULL( `escuelas`.`nombre` , '' ) as escuela"))->paginate(50); 

/* 
    $investigacions=Investigacion::paginate(50);
 */

 $revista=$revistas->items();

 $autores = array();


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
        $autores[]= $value;
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
        'autores'=>$autores
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
    public function update(Request $request, Revistapublicacion $revistapublicacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Revistapublicacion  $revistapublicacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Revistapublicacion $revistapublicacion)
    {
        //
    }
}
