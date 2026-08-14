<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

class EventoInstitucion extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.evento_institucion';

	public $timestamps = false;

	public $incrementing = false;
}
