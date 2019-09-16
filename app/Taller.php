<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Taller extends Model
{
    protected $table = 'tallers';
    protected $fillable = ['nombre','descripcion','docentecargo','dnidocente','docente_id','activo','borrado','semestre_id'];
	protected $guarded = ['id'];
}
