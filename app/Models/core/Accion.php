<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

class Accion extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.accion';

   	protected $primaryKey = 'codigo_accion';

   	public static function getAction($action)
   	{
		return Accion::where('key_accion', '=', $action)->first();
   	}
}
