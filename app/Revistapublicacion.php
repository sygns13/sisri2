<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Revistapublicacion extends Model
{
    protected $table = 'revistaspublicacions';
    protected $fillable = ['tipoPublicacion','titulo','descripcion','escuela_id','fechaPublicado','indexada','lugarIndexada','numero','rutadoc','archivonombre'];
	protected $guarded = ['id'];
}
