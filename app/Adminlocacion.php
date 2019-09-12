<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adminlocacion extends Model
{
    protected $table = 'adminlocacions';
    protected $fillable = ['persona_id','local_id','tipoDependencia','dependencia','facultad','escuela','cargo','descripcionCargo','grado','descripcionGrado','lugarGrado','paisGrado','estitulado','descripcionTitulo','condicionLaboral','regimenLaboral','fechaIngreso','fechaInicioContrato','fechaFinContrato','observaciones','activo','borrado','estado'];
	protected $guarded = ['id'];
}
