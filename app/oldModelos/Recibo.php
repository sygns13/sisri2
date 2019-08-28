<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recibo extends Model
{
    protected $table = 'recibos';
    protected $fillable = ['efectivo','vuelto','extorno','secuencia','codigo','fecha','hora_pagada','persona_id','estado','user_id','fecha_usado','hora_usada','tipopago_id','year','borrado','total','fechaextorno','horaextorno','mes'];
	protected $guarded = ['id'];
}
