<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalle_proceso extends Model
{
    protected $table = 'detalle_procesos';
    protected $fillable = ['fecha','hora','accion','user_id','detalle_recibo_id'];
	protected $guarded = ['id'];
}

