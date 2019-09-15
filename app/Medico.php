<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    protected $table = 'medicos';
    protected $fillable = ['persona_id','especialidad','fechaingreso','fechainiciocontrato','fechafincontrato','activo','borrado','acargo','programassalud_id','observaciones','tipo'];
	protected $guarded = ['id'];
}
