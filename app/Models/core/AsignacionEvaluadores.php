<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AsignacionEvaluadores extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.asignacion_evaluadores';

	protected $primaryKey = 'codigo_evaluador';

	public function user()
    {
        return $this->belongsTo('App\Usuario', 'codigo_usuario');
    }
}
