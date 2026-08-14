<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

class Metrica extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'param.metrica';

   	protected $primaryKey = 'codigo_metrica';
}
