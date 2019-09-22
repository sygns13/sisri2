<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Investigacion extends Model
{
    protected $table = 'investigacions';
    protected $fillable = ['titulo','descripcion','resolucionAprobacion','presupuestoAsignado','presupuestoEjecutado','horas','fechaInicio','fechaTermino','clasificacion','rutadocumento','estado','activo','borrado','avance','descripcionAvance','escuela_id','lineainvestigacion','financiamiento','patentado','observaciones','archivonombre'];
	protected $guarded = ['id'];
}
