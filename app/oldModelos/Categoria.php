<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';
    protected $fillable = ['descripcion','code','activo','borrado'];
	protected $guarded = ['id'];
}
