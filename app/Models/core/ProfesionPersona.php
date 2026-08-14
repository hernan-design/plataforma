<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfesionPersona extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.profesion_persona';

   	protected $primaryKey = 'codigo_profesion_persona';
}
