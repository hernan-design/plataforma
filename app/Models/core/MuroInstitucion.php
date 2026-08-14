<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

class MuroInstitucion extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.muro_institucion';

	public $timestamps = false;

	public $incrementing = false;
}
