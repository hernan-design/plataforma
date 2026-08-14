<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

class CheckListCumplimiento extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'aprende.check_list_cumplimiento';

	protected $primaryKey = 'codigo_cumplimiento_check';

	public $timestamps = false;	
}
