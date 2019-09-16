<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    protected $table = 'proyectos';
    protected $fillable = ['nombre','descripcion','fechainicio','fechafinal','lugar','jefeproyecto','fuentefinanciamiento','cantidadbeneficiarios','semestre_id','activo','borrado','tipo','persona_id','presupuesto','observaciones'];
	protected $guarded = ['id'];
}
