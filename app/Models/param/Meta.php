<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

class Meta extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'param.meta';

   	protected $primaryKey = 'codigo_meta';
}
