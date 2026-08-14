<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

class RequisitoFase extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.requisito_fase';

	public $timestamps = false;

    public $incrementing = false;   
}
