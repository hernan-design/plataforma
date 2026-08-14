<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

class Calendario extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.calendario';

   	protected $primaryKey = 'codigo_calendario';

}
