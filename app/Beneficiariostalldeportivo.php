<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beneficiariostalldeportivo extends Model
{
    protected $table = 'beneficiariostalldeportivos';
    protected $fillable = ['codigo',
    'escuela_id',
    'semestre_id',
    'disciplina',
    'activo',
    'borrado',
    'persona_id',
    'observaciones'];
    
	protected $guarded = ['id'];
}
