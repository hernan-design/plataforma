<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use TuProyecto;

use App;

class SectorInteresProyecto extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.sector_interes_proyecto';

	public $incrementing = false;

	public $timestamps = false;


	public static function getInterests(array $filters = [])
	{
		$reasons = [];
		$query = SectorInteresProyecto::query();
		$query->select('sector_interes.codigo_sector_interes', 'sector_interes.nombre_sector_interes');
		$query->join('core.sector_interes', 'sector_interes_proyecto.codigo_sector_interes', '=', 'sector_interes.codigo_sector_interes');
		$query->where('sector_interes_proyecto.codigo_estado', '=', Estado::getState('active'));

		if(isset($filters['codigo_proyecto']) && !empty($filters['codigo_proyecto'])) {
			// Decrypt src-params
			list($codigo_proyecto) = TuProyecto::decryptSrcParams($filters['codigo_proyecto']);
			if(!$codigo_proyecto || !is_numeric($codigo_proyecto)) {
				App::abort(403);
			}
			$query->where('sector_interes_proyecto.codigo_proyecto', '=', $codigo_proyecto);

	    	$query->orderBy('nombre_sector_interes','asc');
			$reasons = $query->get();
		}
		return $reasons;
	}
	/**
	* Defining Relations
	*/
	public function sectorinteres()
    {
        return $this->hasOne('App\SectorInteres','codigo_sector_interes','codigo_sector_interes');
    }
}
