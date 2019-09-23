<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.3/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Tipouser;
use App\User;
use Auth;

use App\Modulo;
use App\Submodulo;
use App\Permisomodulo;
use App\Permisossubmodulo;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {   
        $iduser=Auth::user()->id;
        $idtipouser=Auth::user()->tipouser_id;
        $tipouser=Tipouser::find($idtipouser);
        $modulo="inicioAdmin";

        $permisoModulos=Permisomodulo::where('user_id',Auth::user()->id)->get();
        $permisoSubModulos=Permisossubmodulo::where('user_id',Auth::user()->id)->get();

        return view('inicio.home',compact('tipouser','modulo','iduser','permisoModulos','permisoSubModulos'));
    }
}
