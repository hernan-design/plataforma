<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

class OrientacionEncuesta extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.orientacion_encuesta';

   	protected $primaryKey = 'codigo_orientacion_encuesta';

	public $timestamps = false;

    public static function getOrientation($orientation)
    {
    	switch ($orientation) :
		    case 'projects': return 1;
		    case 'users': return 2;
		    case 'teams': return 3;
			default: return 'Not orientation identified';
		endswitch;
    }
}
