<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Postulante extends Model
{
    protected $table = 'postulantes';
    protected $fillable = ['codigo','semestre_id','escuela_id','colegio','modalidadadmision_id','modalidadestudios','puntaje','estado','opcioningreso','persona_id','observaciones','activo','borrado','tipo','grado','nombreGrado','pais','provincia','distrito','universidadCulminoPregrado','email','escuela_id2','tipogestioncolegio','escuela_ingreso'];
	protected $guarded = ['id'];
}
