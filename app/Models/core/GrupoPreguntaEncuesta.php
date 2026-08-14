<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoPreguntaEncuesta extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.grupo_pregunta_encuesta';

	public $timestamps = false;

	public $incrementing = false;
}
