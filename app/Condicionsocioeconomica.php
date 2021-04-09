<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Condicionsocioeconomica extends Model
{
    protected $table = 'condicionsocioeconomica';
    protected $fillable = ['persona_id','codigo','numhermanos','numhermanosunasam','puestopadre','puestomadre','ingresomensualfamiliar','condicionviivienda','tieneseguro','nombreseguro','estalaborando', 'semestre_id','activo','borrado'];
	protected $guarded = ['id'];
}
