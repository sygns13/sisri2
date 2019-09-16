<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presentacion extends Model
{
    protected $table = 'presentacions';
    protected $fillable = ['fecha','asistentes','detalle','activo','borrado','taller_id','observaciones'];
	protected $guarded = ['id'];
}
