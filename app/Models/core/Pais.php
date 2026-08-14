<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

class Pais extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.pais';

   	protected $primaryKey = 'codigo_pais';
}
