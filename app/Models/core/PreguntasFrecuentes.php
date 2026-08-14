<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreguntasFrecuentes extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.preguntas_frecuentes';

   	protected $primaryKey = 'codigo_preguntas_frecuentes';
}
