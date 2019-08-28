<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Culquidato extends Model
{
    protected $table = 'culqidatos';
    protected $fillable = ['montototal','comision','montoparcial','recibo_id'];
	protected $guarded = ['id'];
}
