<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Investigador extends Model
{
    protected $table = 'investigadors';
    protected $fillable = ['persona_id','escuela_id','facultad_id','observaciones','clasificacion','activo','borrado'];
	protected $guarded = ['id'];
}
