<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Postulante extends Model
{
    protected $table = 'postulantes';
    protected $fillable = ['codigo','semestre_id','escuela_id','colegio','modalidadadmision_id','modalidadestudios','puntaje','estado','opcion','persona_id','observaciones','activo','borrado','tipo','grado','nombreGrado','pais','provincia','distrito','universidadCulminoPregrado','email'];
	protected $guarded = ['id'];
}
