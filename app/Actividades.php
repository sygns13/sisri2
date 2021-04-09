<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actividades extends Model
{
    protected $table = 'actividades';
    protected $fillable = ['actividad','descripcion','oficinas','lugar','beneficiarios','organizadores','fecha','activo','borrado'];
	protected $guarded = ['id'];
}
