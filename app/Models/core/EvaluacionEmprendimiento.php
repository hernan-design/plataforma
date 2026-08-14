<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluacionEmprendimiento extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.evaluacion_emprendimiento';

	protected $primaryKey = 'codigo_evaluacion_emprendimiento';

	public $timestamps = false;
}
