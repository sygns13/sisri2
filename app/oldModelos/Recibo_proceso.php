<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recibo_proceso extends Model
{
    protected $table = 'recibo_procesos';
    protected $fillable = ['fecha','hora','accion','user_id','recibo_id'];
	protected $guarded = ['id'];
}
