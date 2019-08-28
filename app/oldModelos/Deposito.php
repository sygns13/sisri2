<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deposito extends Model
{
    protected $table = 'depositos';
    protected $fillable = ['opecodigo','banco_id','recibo_id'];
	protected $guarded = ['id'];
}
