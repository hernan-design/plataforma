<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use TuProyecto;

use Input, Auth, Lang, URL, DB, Request, Cache, Log;

class SectorEconomicoPersona extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.sector_economico_persona';

	public $incrementing = false;

	public $timestamps = false;

	public static function getEconomicSector(array $filters = [])
	{
		$economicSector = [];
		$query = SectorEconomicoPersona::query();
		$query->select('sector_economico.codigo_sector_economico', 'sector_economico.nombre_sector_economico');
		$query->join('core.sector_economico', 'sector_economico_persona.codigo_sector_economico', '=', 'sector_economico.codigo_sector_economico');
		$query->where('sector_economico_persona.codigo_estado', '=', Estado::getState('active'));

		if(isset($filters['codigo_persona']) && !empty($filters['codigo_persona'])) {

			// Decrypt src-params
			list($codigo_persona) = TuProyecto::decryptSrcParams($filters['codigo_persona']);
			if(!$codigo_persona || !is_numeric($codigo_persona)) {
				abort(403);
			}
			$query->where('sector_economico_persona.codigo_persona', '=', $codigo_persona);

	    	$query->orderBy('nombre_sector_economico','asc');
			$economicSector = $query->get();
		}
		return $economicSector;
	}

}
