<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Graduado extends Model
{
    protected $table = 'graduados';
    protected $fillable = ['escuela_id','nombreGrado','programaEstudios','fechaEgreso','idioma','modalidadObtencion','numResolucion','fechaResol','numeroDiploma','autoridadRector','fechaEmision','observaciones','activo','borrado','persona_id','tipo','trabajoinvestigacion'];
	protected $guarded = ['id'];
}
