<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entidad extends Model
{
    protected $table = 'entidads';
    protected $fillable = ['descripcion','code','estado','activo','borrado','local_id'];
	protected $guarded = ['id'];
}
