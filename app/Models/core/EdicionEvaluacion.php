<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Log;
class EdicionEvaluacion extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.edicion_evaluacion';

	protected $primaryKey = 'codigo_edicion_evaluacion';

	/**
	 * Consulta registros.
	 *
	 * @access public
	 * @static function
	 * @param object $evaluation
	 * @return object $data
	 */
	public static function getRegisters($evaluation)
	{
		$query = EdicionEvaluacion::query();
		$query->select('created_at', 'pdf_evaluacion');
		$query->where('codigo_fase', $evaluation->codigo_fase);
		$query->where('codigo_usuario', $evaluation->seg_codigo_usuario);
		$query->orderBy('created_at', 'desc');
		$data = $query->get();

		return $data;
	}

	/**
	 * Defining Relations
	*/
	public function usuario()
    {
        return $this->hasOne('App\Usuario','codigo_usuario','codigo_usuario');
    }

	public function mentor()
    {
        return $this->hasOne('App\Usuario','codigo_usuario','seg_codigo_usuario');
	}

	public function registroconvocatoria()
    {
        return $this->hasOne('App\RegistroConvocatoria','codigo_registro_convocatoria','codigo_registro_convocatoria');
	}

}
