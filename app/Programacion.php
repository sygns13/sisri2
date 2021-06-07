<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Programacion extends Model
{
    protected $table = 'programacions';
    protected $fillable = ['titulo','descripcion','submodulo_id','fechaini','fechafin','user_id','activo','borrado'];
	protected $guarded = ['id'];
}
