<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

class ForoInstitucion extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.foro_institucion';

	public $timestamps = false;

	public $incrementing = false;
}
