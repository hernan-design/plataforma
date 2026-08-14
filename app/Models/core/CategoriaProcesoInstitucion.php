<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use TuProyecto;

use DB, Cache;

class CategoriaProcesoInstitucion extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.categoria_proceso_insti';

	public $timestamps = false;

	public $incrementing = false;


	public static function getCategoriesProcess()
    {
        $cache = sprintf('_%s_%s', 'categories_process', RegistroSesion::getInstitution());
        if (Cache::has($cache)) {
            return Cache::get($cache);    
        }

        return Cache::rememberForever($cache, function() {
            $query = CategoriaProcesoInstitucion::query();
            $query->select('categoria_proceso.codigo_categoria_proceso', 'nombre_categoria_proceso');
            $query->join('core.categoria_proceso', 'categoria_proceso_insti.codigo_categoria_proceso', '=', 'categoria_proceso.codigo_categoria_proceso');
            $query->where('categoria_proceso_insti.codigo_institucion', RegistroSesion::getInstitution());

            $query->orderby('nombre_categoria_proceso','asc');
        	return $query->get();
        });
    }
}
