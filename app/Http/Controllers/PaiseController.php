<?php

namespace App\Http\Controllers;

use App\Paise;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaiseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paises=Paise::where('activo','1')->where('borrado','0')->orderBy('nombre')->get();

        $paise_id=1;//Perú

        return [
            'paises'=>$paises,
            'paise_id'=>$paise_id
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
     * @param  \App\Paise  $paise
     * @return \Illuminate\Http\Response
     */
    public function show(Paise $paise)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Paise  $paise
     * @return \Illuminate\Http\Response
     */
    public function edit(Paise $paise)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Paise  $paise
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Paise $paise)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Paise  $paise
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paise $paise)
    {
        //
    }
}
