<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RespuestaEvalCompra extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.respuesta_eval_compra';

   	protected $primaryKey = 'codigo_respuesta_eval_compra';

   	public $timestamps = false;
}
