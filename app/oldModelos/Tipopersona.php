<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipopersona extends Model
{
    protected $table = 'tipopersonas';
    protected $fillable = ['tipo'];
	protected $guarded = ['id'];
}
