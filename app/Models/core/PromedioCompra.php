<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromedioCompra extends Model
{
    	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.promedio_compra';

	public $timestamps = false;

	public $incrementing = false;
}
