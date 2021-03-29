<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamentoacademico extends Model
{
    protected $table = 'departamentoacademicos';
    protected $fillable = ['nombre','activo','borrado','facultad_id'];
	protected $guarded = ['id'];
}
