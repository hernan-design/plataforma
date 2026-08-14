<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Cache, Log;

class SectorInteres extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.sector_interes';

   	protected $primaryKey = 'codigo_sector_interes';

    public static function getClass($class) {
        switch ($class) :
            case 'sections': return 1;
            case 'children': return 2;
            default: return 'Not class identified';
		endswitch;
    } 

    public static function getInterests()
    {
        $cache = sprintf('_%s_%s', 'reasons_interests_ciiu', RegistroSesion::getInstitution());
		if (Cache::has($cache)) {
			return Cache::get($cache);
        }

        return Cache::rememberForever($cache, function() {
            $query = SectorInteres::query();
            $query->select('sector_interes.codigo_sector_interes', 'sector_interes.nombre_sector_interes');
            $query->where('sector_interes.clase_sector_interes', self::getClass('children'));
            $query->join('core.sector_interes_institucion', function($join) {
                $join->on('sector_interes_institucion.codigo_sector_interes', '=', 'sector_interes.codigo_sector_interes')
                 ->where('sector_interes_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
                 ->where('sector_interes_institucion.codigo_estado', '=', Estado::getState('active'));
            });
            // $query->orderby('sector_interes.codigo_sector_interes', 'asc');
            $query->orderby('sector_interes.nombre_sector_interes', 'asc');
            $results = $query->get();
                
            if(!$results || $results->count() == 0){
                $query = SectorInteres::query();
                $query->select('sector_interes.codigo_sector_interes', 'sector_interes.nombre_sector_interes');
                $query->where('sector_interes.clase_sector_interes', self::getClass('children'));
                // $query->orderby('sector_interes.codigo_sector_interes', 'asc');
                $query->orderby('sector_interes.nombre_sector_interes', 'asc');
                $results = $query->get(); 
            }
    
            return $results;
        });
    }

	public static function getSectorByActivity($activity_code)
	{
        return SectorInteres::select('sector_economico.nombre_sector_economico')
            ->join('core.sector_economico','sector_interes.codigo_sector_economico','=','sector_economico.codigo_sector_economico')
            ->where('sector_interes.codigo_sector_interes', '=', $activity_code)
            ->first();
    }
}
