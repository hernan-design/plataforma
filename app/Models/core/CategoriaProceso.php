<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cache, DB, Log;

class CategoriaProceso extends Model
{

    protected $table = 'core.categoria_proceso';

    protected $primaryKey = 'codigo_categoria_proceso';

	public $timestamps = false;


	public static function getCategoriesProcess()
	{
		$cache = sprintf('_%s_%s', 'category_program', RegistroSesion::getInstitution());
		if (Cache::has($cache)) {
			return Cache::get($cache);
		}
        
		return Cache::rememberForever($cache, function() {
			$query = CategoriaProceso::query();
			$query->select('categoria_proceso.codigo_categoria_proceso as key', 'categoria_proceso.nombre_categoria_proceso as value');
			$query->join('core.categoria_proceso_insti', function($leftJoin) {
				$leftJoin->on('categoria_proceso_insti.codigo_categoria_proceso', '=', 'categoria_proceso.codigo_categoria_proceso')
					->where('categoria_proceso_insti.codigo_estado','=',Estado::getState('active'))
					->where('categoria_proceso_insti.codigo_institucion','=',RegistroSesion::getInstitution());
			});

			$query->orderby('url_categoria_proceso','asc');
			$return = $query->get();
			Log::debug(['debug'=>$return]);
			return $return;
		});
	}

	public static function getCategories() {
        $cache = sprintf('_%s_%s', 'categories_list', RegistroSesion::getInstitution());
		if (Cache::has($cache)) {
			return Cache::get($cache);
        }
                
		return Cache::rememberForever($cache, function() {
			$query = CategoriaProceso::query();
			$query->select( 'categoria_proceso.nombre_categoria_proceso', 'categoria_proceso.codigo_categoria_proceso');
			$query->join('core.categoria_proceso_insti', 'categoria_proceso_insti.codigo_categoria_proceso', '=', 'categoria_proceso.codigo_categoria_proceso');
			$query->where('categoria_proceso_insti.codigo_institucion', '=', RegistroSesion::getInstitution());
			$query->where('categoria_proceso_insti.codigo_estado', '=', Estado::getState('active'));
			return $query->pluck('categoria_proceso.nombre_categoria_proceso', 'categoria_proceso.codigo_categoria_proceso')->toArray();
		});
	}
}
