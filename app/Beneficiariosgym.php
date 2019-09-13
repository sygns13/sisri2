<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beneficiariosgym extends Model
{
    protected $table = 'beneficiariosgyms';
    protected $fillable = ['codigo',
    'escuela_id',
    'semestre_id',
    'activo',
    'borrado',
    'persona_id',
    'observaciones'];
    
	protected $guarded = ['id'];

}
