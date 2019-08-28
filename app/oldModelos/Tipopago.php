<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipopago extends Model
{
    protected $table = 'tipopagos';
    protected $fillable = ['descripcion'];
	protected $guarded = ['id'];
}
