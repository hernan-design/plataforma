<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

class TipoCredencial extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'seguridad.tipo_credencial';

   	protected $primaryKey = 'codigo_tipo_credencial';

	public static function getType($type) {
    	switch ($type) :
		    case 'twitter': return 1;
		    case 'facebook': return 2;
		    case 'linkedin': return 3;
			default: return 'Not type identified';
		endswitch;
    }
}
