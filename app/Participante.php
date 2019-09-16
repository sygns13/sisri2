<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participante extends Model
{
    protected $table = 'participantes';
    protected $fillable = ['persona_id  ' ,
    'escuela_id' ,
    'activo' ,
    'borrado' ];
    
	protected $guarded = ['id'];
}
