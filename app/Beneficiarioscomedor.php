<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beneficiarioscomedor extends Model
{
    protected $table = 'beneficiarioscomedors';
    protected $fillable = ['codigo',
    'escuela_id',
    'semestre_id',
    'activo',
    'borrado',
    'persona_id',
    'observaciones'];
    
	protected $guarded = ['id'];
}
