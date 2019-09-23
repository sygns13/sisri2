<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permisossubmodulo extends Model
{
    protected $table = 'permisossubmodulos';
    protected $fillable = ['activo  ' ,
    'borrado' ,
    'user_id','submodulo_id' ];
    
	protected $guarded = ['id'];
}
