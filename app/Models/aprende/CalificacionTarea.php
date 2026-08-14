<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

class CalificacionTarea extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'aprende.calificacion_tarea';

	protected $primaryKey = 'codigo_calificacion_tarea';

	public $timestamps = false;

}