<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipodato extends Model
{
    protected $table = 'tipodatos';
    protected $fillable = ['titulo','descripcion','tipo','activo','borrado'];
	protected $guarded = ['id'];
}
