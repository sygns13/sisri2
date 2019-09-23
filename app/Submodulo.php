<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Submodulo extends Model
{
    protected $table = 'submodulos';
    protected $fillable = ['submodulo  ' ,
    'activo' ,
    'borrado','modulo_id' ];
    
	protected $guarded = ['id'];
}
