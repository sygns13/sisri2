<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    protected $table = 'modulos';
    protected $fillable = ['modulo  ' ,
    'activo' ,
    'borrado' ];
    
	protected $guarded = ['id'];
}