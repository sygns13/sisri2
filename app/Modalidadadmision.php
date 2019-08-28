<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modalidadadmision extends Model
{
    protected $table = 'modalidadadmisions';
    protected $fillable = ['nombre','descripcion','activo','borrado'];
	protected $guarded = ['id'];
}
