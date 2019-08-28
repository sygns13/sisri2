<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semestre extends Model
{
    protected $table = 'semestres';
    protected $fillable = ['nombre','fechainicio','fechafin','estado','activo','borrado','user_id'];
	protected $guarded = ['id'];
}
