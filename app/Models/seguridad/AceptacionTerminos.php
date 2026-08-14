<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

class AceptacionTerminos extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'seguridad.aceptacion_terminos';

	public $incrementing = false;

	public $timestamps = false;
}
