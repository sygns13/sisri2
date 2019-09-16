<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Talleresparticipante extends Model
{
    protected $table = 'talleresparticipantes';
    protected $fillable = ['nombre','fecha','participantes','activo','borrado','eventocultural_id','observaciones'];
	protected $guarded = ['id'];
}
