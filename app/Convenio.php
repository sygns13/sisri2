<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Convenio extends Model
{
    protected $table = 'convenios';
    protected $fillable = ['nombre','descripcion','institucion','resolucion','objetivo','obligaciones','fechainicio','fechafinal','estado','activo','borrado','tipo'];
	protected $guarded = ['id'];
}
