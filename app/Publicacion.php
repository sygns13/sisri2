<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{
    protected $table = 'publicaciones';
    protected $fillable = ['nombre','detalles','fecha','activo','borrado','investigacion_id'];
	protected $guarded = ['id'];
}
