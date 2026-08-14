<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Cache, DB, Input;

use App\Estado;

class ItemEvaluacionEmprendimiento extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.item_evaluacion_emprendimiento';

	protected $primaryKey = 'codigo_item_evaluacion';

	public $timestamps = false;

}
