<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

use Cache, DB;

class RolInstitucion extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.rol_institucion';

   	protected $primaryKey = 'codigo_rol_comunidad';

	public $timestamps = false;

	public static function getRole($role) {
    	switch ($role) :
		    case 'entrepreneur': return 1;
		    case 'investor': return 2;
		    case 'mentor': return 3;
			default: return 'Not role identified';
		endswitch;
    }
}
