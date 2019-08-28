<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Escuela extends Model
{
    protected $table = 'escuelas';
    protected $fillable = ['nombre','activo','borrado','facultad_id'];
	protected $guarded = ['id'];
}
