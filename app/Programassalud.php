<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Programassalud extends Model
{
    protected $table = 'programassaluds';
    protected $fillable = ['nombre','descripcion','cantidadAtenciones','fechaini','fechafin','activo','borrado','tipo','lugar'];
	protected $guarded = ['id'];
}
