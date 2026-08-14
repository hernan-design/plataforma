<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Cache, DB, Input, Log;

class SectorEconomico extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.sector_economico';

   	protected $primaryKey = 'codigo_sector_economico';

    public static function getSectors()
    {
        if (Cache::has('_economic_sectors')) {
            return Cache::get('_economic_sectors');
        }

        return Cache::rememberForever('_economic_sectors', function() {
            $query = SectorEconomico::query();
            $query->orderby('nombre_sector_economico', 'asc');
            return $query->get();
        });
    }

    public static function getEconomicSectorsList()
    {
        if (Cache::has('_get_economic_sectors')) {
            return Cache::get('_get_economic_sectors');    
        }

        return Cache::rememberForever('_get_economic_sectors', function() {
            $query = SectorEconomico::query();
            $query->select('codigo_sector_economico', 'nombre_sector_economico');
            $query->orderby('nombre_sector_economico', 'asc');            
            return $query->pluck('nombre_sector_economico', 'codigo_sector_economico')->toArray();  
        });
    }

    /**
	 * @return array list of stages for selector list
	 */
	public static function getSectorSelectorList(array $filters = []){
		$query = SectorEconomico::query();
		$query->select('sector_economico.codigo_sector_economico as id', 'nombre_sector_economico as text');
        
		if(Input::has('id') ){
			$query->where("sector_economico.codigo_sector_economico", "=", Input::get('id'));
		}

		if(Input::has('q')) {
			$query->whereRaw("nombre_sector_economico ilike '%".Input::get('q')."%'");
		}

		if(Input::has('dataId')) {
			$query->where("sector_economico.codigo_sector_economico", "=",Input::get('dataId'));
		}


		$query->orderby('nombre_sector_economico','asc');
		$data = $query->limit( 50 )->get();
		$data = $query->get();

		return $data;
	}
}
