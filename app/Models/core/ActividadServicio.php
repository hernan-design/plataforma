<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActividadServicio extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.actividad_servicio';

	protected $primaryKey = 'codigo_actividad_servicio';

	public $timestamps = false;
}
