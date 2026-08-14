<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

class VersionTerminos extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'param.version_terminos';

   	protected $primaryKey = 'codigo_version_terminos';

}
