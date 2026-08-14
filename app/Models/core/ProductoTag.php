<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

class ProductoTag extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.producto_tag';

	public $timestamps = false;

	public $incrementing = false;
}