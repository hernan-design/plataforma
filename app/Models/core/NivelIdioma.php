<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Cache;

class NivelIdioma extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.nivel_idioma';

	protected $primaryKey = 'codigo_nivel_idioma';

    public $timestamps = false;
    
    public static function languageLevel()
    {
        $cache = sprintf('_%s', '_get_language_level');
		if (Cache::has($cache)) {
			return Cache::get($cache);
        }
        
        return Cache::rememberForever($cache, function() {
            $query = NivelIdioma::query();
            $query->select('codigo_nivel_idioma', 'nombre_nivel_idioma');
            $query->orderBy('nombre_nivel_idioma', 'asc');

            return $query->get();
        });
    }
}
