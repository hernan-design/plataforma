<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

class ClaseParametro extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'param.clase_parametro';

   	protected $primaryKey = 'codigo_clase_parametro';

	public static function getClass($class) {
    	switch ($class) :
		    case 'platform': return 1;
		    case 'landing': return 2;
			default: return 'Not class identified';
		endswitch;
    }
}
