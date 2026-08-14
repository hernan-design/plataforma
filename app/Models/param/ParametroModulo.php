<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

use DB;

class ParametroModulo extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'param.parametro_modulo';

  	public static function getParameter($parameter) {
    	switch ($parameter) :
		    case 'position': return 14;
			default: return 'Not parameter identified';
		endswitch;
    }

	public static function getParametersLanding()
	{
		$query = ParametroModulo::query();
		$query->select(DB::raw("lower(nombre_parametro || '_' || nombre_modulo) as nombre_parametro"), 'valor_parametro_modulo');
		$query->join('seguridad.modulo', 'parametro_modulo.codigo_modulo', '=', 'modulo.codigo_modulo');
		$query->join('param.parametro', 'parametro_modulo.codigo_parametro', '=', 'parametro.codigo_parametro');
		$query->where('parametro_modulo.codigo_estado', Estado::getState('active'));
		$query->where('parametro.codigo_tipo_parametro', '!=', TipoParametro::getType('color'));
		$query->where('parametro_modulo.codigo_institucion', RegistroSesion::getInstitution());
   		$query->orderBy('parametro_modulo.codigo_modulo','asc');
   		$query->orderBy('parametro_modulo.codigo_parametro','asc');
		return $query->pluck('valor_parametro_modulo', 'nombre_parametro')->toArray();
	}

   	/**
	 * Defining Relations
	*/

	public function parametro()
    {
        return $this->hasOne('Parametro', 'codigo_parametro', 'codigo_parametro');
   	}
}
