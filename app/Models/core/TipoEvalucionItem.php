<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoEvalucionItem extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.tipo_evaluacion_item';

   	protected $primaryKey = 'codigo_tipo_evaluacion_item';

   	public $timestamps = false;

}
