<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalleinvestigacion extends Model
{
    protected $table = 'detalleinvestigacions';
    protected $fillable = ['investigacion_id','cargo','tipoAutor','activo','borrado','investigador_id'];
	protected $guarded = ['id'];
}

