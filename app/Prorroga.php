<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prorroga extends Model
{
    protected $table = 'prorrogas';
    protected $fillable = ['titulo','descripcion','programacion_id','numero','fechainicio','fechafin','dias','activo','borrado','estado','motivo','motivoatencion','user_id_solicita','nombre_user','user_id_atiende'];
	protected $guarded = ['id'];
}
