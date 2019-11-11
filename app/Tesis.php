<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tesis extends Model
{
    protected $table = 'tesis';
    protected $fillable = ['nombreProyecto','autor','fuenteFinanciamiento','autor2','activo','borrado','escuela_id'];
	protected $guarded = ['id'];
}
