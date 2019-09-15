<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pasantia extends Model
{
    protected $table = 'pasantias';
    protected $fillable = ['persona_id' ,
    'escuela_id' ,
    'modalidads' ,
    'concepto' ,
    'pais' ,
    'institucion' ,
    'fechainicio' ,
    'fechafinal' ,
    'monto' ,
    'resolucions' ,
    'activo' ,
    'borrado' ,
    'tipo' ,
    'dependencia' ,
    'observaciones','facultad_id'];
    
	protected $guarded = ['id'];
}
