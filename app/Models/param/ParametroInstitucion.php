<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

class ParametroInstitucion extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'param.parametro_institucion';

   	public static function getParametersLanding()
	{
		$query = ParametroInstitucion::query();
		$query->select('nombre_parametro', 'valor_parametro');
		$query->join('param.parametro', 'parametro_institucion.codigo_parametro', '=', 'parametro.codigo_parametro');
		$query->where('parametro.codigo_tipo_parametro', TipoParametro::getType('video'));
		$query->where('parametro_institucion.codigo_estado', Estado::getState('active'));
		$query->where('parametro_institucion.codigo_institucion', RegistroSesion::getInstitution());
		$query->where('parametro.codigo_clase_parametro', ClaseParametro::getClass('landing'));
		return $query->pluck('valor_parametro', 'nombre_parametro')->toArray();
	}

   	/**
	 * Defining Relations
	*/

	public function parametro()
    {
        return $this->hasOne('App\Parametro', 'codigo_parametro', 'codigo_parametro');
   	}
}
