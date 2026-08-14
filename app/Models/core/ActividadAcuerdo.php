<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActividadAcuerdo extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.actividad_acuerdo';

	protected $primaryKey = 'codigo_actividad_acuerdo';

	public $timestamps = false;
}
