<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Eventocultural extends Model
{
    protected $table = 'eventoculturals';
    protected $fillable = ['nombre','descripcion','lugarpresentacion','fechainicio','fechafinal','semestre_id','entidad','observaciones'];
	protected $guarded = ['id'];
}
