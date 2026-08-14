<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

class AvanceTema extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'aprende.avance_tema';

	public $incrementing = false;

	public $timestamps = false;
}
