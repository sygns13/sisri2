<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Administrativo extends Model
{
    protected $table = 'administrativos';
    protected $fillable = ['persona_id','local_id','tipoDependencia','dependencia','facultad','escuela','cargo','descripcionCargo','grado','descripcionGrado','esTitulado','descripcionTitulo','lugarGrado','paisGrado','fechaIngreso','observaciones','activo','borrado','estado','condicion','fechaSalida'];
	protected $guarded = ['id'];
}
