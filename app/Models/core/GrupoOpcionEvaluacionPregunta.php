<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoOpcionEvaluacionPregunta extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.grup_opc_eval_pregunta';

   	protected $primaryKey = 'codigo_grup_opc_eval_pregunta';

   	public $timestamps = false;
}
