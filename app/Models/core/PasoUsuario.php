<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

class PasoUsuario extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.paso_usuario';

	public $timestamps = false;

	public $incrementing = false;
}
