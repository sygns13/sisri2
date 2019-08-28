<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';
    protected $fillable = ['tipodoc','doc','nombres','apellidopat','apellidomat','genero','estadocivil','fechanac','esdiscapacitado','discapacidad','pais','departamento','provincia','distrito','direccion','activo','borrado','email','telefono'];
	protected $guarded = ['id'];
}
