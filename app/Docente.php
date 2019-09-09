<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    protected $table = 'docentes';
    protected $fillable = ['personalacademico','cargogeneral','descripcioncargo','maximogrado','descmaximogrado','universidadgrado','lugarmaximogrado','paismaximogrado','otrogrado','estadootrogrado','univotrogrado','lugarotrogrado','paisotrogrado','titulo','descripciontitulo','condicion','categoria','regimen','investigador','pregrado','postgrado','esdestacado','fechaingreso','modalidadingreso','observaciones','activo','borrado','persona_id','horaslectivas','horasnolectivas','horasinvestigacion','horasdedicacion','escuela_id','facultad_id','dependencia','semestre_id','email'];
	protected $guarded = ['id'];
}
