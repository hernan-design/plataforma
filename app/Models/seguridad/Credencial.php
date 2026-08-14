<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

class Credencial extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'seguridad.credencial';

   	protected $primaryKey = 'codigo_credencial';

	public $timestamps = false;
}
