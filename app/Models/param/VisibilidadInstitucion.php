<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

use DB;

class VisibilidadInstitucion extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'param.visibilidad_instituci';

	public $incrementing = false;

	public $timestamps = false;

	public static function getInstitutionModules()
	{
		$query = VisibilidadInstitucion::query();
		$query->select('modulo.codigo_modulo', DB::raw('lower(nombre_modulo) as name'), DB::raw("COALESCE(valor_parametro_modulo, '100') as position"), 'bloque_texto_modulo');
		$query->join('seguridad.modulo', 'visibilidad_instituci.codigo_modulo', '=', 'modulo.codigo_modulo');
		$query->leftjoin('param.parametro_modulo', function($join) {
            	$join->on('param.parametro_modulo.codigo_modulo', '=', 'modulo.codigo_modulo')
            		->where('param.parametro_modulo.codigo_parametro', '=', ParametroModulo::getParameter('position'))
        			->where('param.parametro_modulo.codigo_institucion', '=', RegistroSesion::getInstitution())
					->where('param.parametro_modulo.codigo_estado', '=', Estado::getState('active'));
        	});
		$query->where('modulo.parametrizacion_modulo', true);
		$query->where('modulo.codigo_estado', Estado::getState('active'));
		$query->where('visibilidad_instituci.codigo_institucion', RegistroSesion::getInstitution());
		$query->where('visibilidad_instituci.codigo_estado', Estado::getState('active'));
		$query->where('visibilidad_instituci.valor_visibilidad_institucion', true);
   		$query->orderBy('position','asc');
		return $query->get();
	}
}
