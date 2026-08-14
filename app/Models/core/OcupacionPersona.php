<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OcupacionPersona extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.ocupacion_persona';

   	protected $primaryKey = 'codigo_ocupacion_persona';

   	public $timestamps = false;
}
