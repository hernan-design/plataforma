<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

class MetaInstitucion extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'param.meta_institucion';

   	/**
	 * Defining Relations
	*/

	public function meta()
    {
        return $this->hasOne('App\Meta', 'codigo_meta', 'codigo_meta');
   	}
}
