<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Datosfacultad extends Model
{
    protected $table = 'datosfacultads';
    protected $fillable = ['nombre','descripcion','cantidad','subnombre','descripcion2','cantidad2','activo','borrado','tipodato_id','facultad_id','semestre_id'];
	protected $guarded = ['id'];
}
