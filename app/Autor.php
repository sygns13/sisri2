<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    protected $table = 'autors';
    protected $fillable = ['persona_id','cargo','activo','borrado','revistaspublicacion_id'];
	protected $guarded = ['id'];
}
