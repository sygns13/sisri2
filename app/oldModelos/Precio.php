<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Precio extends Model
{
    protected $table = 'precios';
    protected $fillable = ['descripcion','codigo','estado','monto','rubro_id','entidad_id','borrado'];
	protected $guarded = ['id'];
}
