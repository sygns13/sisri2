<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rubro extends Model
{
    protected $table = 'rubros';
    protected $fillable = ['descripcion','code','estado','categoria_id','borrado'];
	protected $guarded = ['id'];
}
