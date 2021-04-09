<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cursosriesgo extends Model
{
    protected $table = 'cursosriesgos';
    protected $fillable = ['nombre','activo','borrado','alumno_id'];
	protected $guarded = ['id'];
}
