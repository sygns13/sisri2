<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beneficiario extends Model
{
    protected $table = 'beneficiarios';
    protected $fillable = ['tipo','persona_id','codigo','programassalud_id','observaciones','activo','borrado','fechaatencion'];
	protected $guarded = ['id'];
}
