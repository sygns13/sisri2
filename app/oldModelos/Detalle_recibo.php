<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalle_recibo extends Model
{
    protected $table = 'detalle_recibos';
    protected $fillable = ['precio_id','recibo_id','cantidad','precioUnitario','precioTotal','fecha_pagada','hora_pagada','fecha_usado','hora_usado','estado','concepto'];
	protected $guarded = ['id'];
}
