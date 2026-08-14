<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

class AsesoriaInstitucion extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'aprende.asesoria_institucion';

	public $timestamps = false;

	public $incrementing = false;
}
