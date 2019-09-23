<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permisomodulo extends Model
{
    protected $table = 'permisomodulos';
    protected $fillable = ['activo  ' ,
    'borrado' ,
    'modulo_id','user_id','tipo' ];
    
	protected $guarded = ['id'];
}
