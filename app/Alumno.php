<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = 'alumnos';
    protected $fillable = ['periodoMatricula',
    'escuela_id',
    'escalaPago',
    'promedioPonderado',
    'promedioSemestre',
    'periodoIngreso',
    'primerPeriodoMatricula',
    'alumnoRiesgo',
    'numCursosRiesgo',
    'observaciones',
    'activo',
    'borrado',
    'created_at',
    'updated_at',
    'persona_id',
    'estado',
    'descestado',
    'codigo',
    'tituladoOtraCarrera',
    'egresadoOtraCarrera',
    'otraCarrera',
    'email',
    'tipo',
    'grado',
    'nombreGrado',
    'escalaPagodesc',
    'semestre_id',
    'movinacional',
    'moviinternacional',
    'ismovnacional',
    'ismovinternacional', 'otrotitulo'];
    
	protected $guarded = ['id'];
}
