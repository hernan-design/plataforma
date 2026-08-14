<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

use Cache, DateTime;

class TipoIdentificacion extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.tipo_identificacion';

	protected $primaryKey = 'codigo_tipo_identificacion';

	public $timestamps = false;

	public static function type($type)
	{
		switch ($type) {
			case 'ti': return 4; // Tarjeta de identidad
		    case 'rc': return 6; // Registro civil
			default: return 'Not type identification identified';
		}
	}

	public static function identificationType(array $filters = [])
	{
		$institution = Institucion::find(RegistroSesion::getInstitution());

		$query = TipoIdentificacion::query();
		$query->select('tipo_identificacion.codigo_tipo_identificacion as id', 'nombre_tipo_identificacion as text');
		$query->join('core.tipo_id_institucion', function($join){
			$join->on('tipo_identificacion.codigo_tipo_identificacion', '=', 'tipo_id_institucion.codigo_tipo_identificacion')
				->where('tipo_id_institucion.codigo_institucion', '=', RegistroSesion::getInstitution());
		});

		if($institution->validacion_edad_documento && isset($filters['data']) && !empty($filters['data'])){
			$from = new DateTime($filters['data']);
			$to   = new DateTime('today');
			$interval = $from->diff($to);

			if ($institution->codigo_institucion == Institucion::getInstitution('compensar') && $interval->format('%y') < '18') {
				return [["id"=> null,"text" => ""]];
			}

			if($interval->format('%y') < '18'){
				$query->whereIn('tipo_identificacion.codigo_tipo_identificacion', [self::type('ti'), self::type('rc')]);
			}
		}

		if(isset($filters['dataId']) && !empty($filters['dataId'])){
			$query->where('tipo_identificacion.codigo_tipo_identificacion' , $filters['dataId']);
		}elseif (RegistroSesion::getInstitution() == 61){ // 61 = rutan
			$query->where('tipo_identificacion.codigo_tipo_identificacion', '!=', 3); //3 = nit
		}

		if(isset($filters['dataId']) && !empty($filters['dataId'])){
			$query->where('tipo_identificacion.codigo_tipo_identificacion' , $filters['dataId']);
		}elseif (RegistroSesion::getInstitution() == 30) { //30 = compensar
			$query->where('tipo_identificacion.codigo_tipo_identificacion', '!=', 4); //4 = tarjeta de indetidad
		}

		if(isset($filters['dataId']) && !empty($filters['dataId'])){
			$query->where('tipo_identificacion.codigo_tipo_identificacion' , $filters['dataId']);
		}elseif (RegistroSesion::getInstitution() == 30) { //30 = compensar
			$query->where('tipo_identificacion.codigo_tipo_identificacion', '!=', 6); //6 = registro civil
		}

		if(isset($filters['q']) && !empty($filters['q'])){
			$query->whereRaw("nombre_tipo_identificacion ilike '%".trim($filters['q'])."%'");
		}

		$query->orderby('nombre_tipo_identificacion', 'asc');
		return $query->get();
	}

	public static function getIdentificationType()
	{
		$identification = [];
		$cache = sprintf('_%s_%s', '_get_identification_type_institution', RegistroSesion::getInstitution());
        if (Cache::has($cache)) {
            $identification = Cache::get($cache);
        }else{
	        $identification = Cache::rememberForever($cache, function() {
	            $query = TipoIdentificacion::query();
	            $query->select('tipo_id_institucion.codigo_tipo_identificacion', 'nombre_tipo_identificacion');
				$query->join('core.tipo_id_institucion', function($join){
					$join->on('tipo_identificacion.codigo_tipo_identificacion', '=', 'tipo_id_institucion.codigo_tipo_identificacion')
						->where('tipo_id_institucion.codigo_institucion', '=', RegistroSesion::getInstitution());
				});
	            $query->orderby('nombre_tipo_identificacion', 'asc');
	            return $query->get();
	        });
		}

		return $identification->pluck('nombre_tipo_identificacion', 'codigo_tipo_identificacion')->toArray();
	}
}
