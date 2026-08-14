<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

use Cache;

class CategoriaCurso extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'aprende.categoria_curso';

	protected $primaryKey = 'codigo_categoria_curso';

	public $timestamps = false;

	public static function getCategory($category)
   	{
		return CategoriaCurso::whereRaw("trim(lower(url_categoria_curso)) = trim(lower('$category'))")->first();
   	}

    public static function getCategoriesCourse()
    {
        $cache = sprintf('_%s_%s', 'categories_course', RegistroSesion::getInstitution());
		if (Cache::has($cache)) {
			return Cache::get($cache);
		}

        return Cache::rememberForever($cache, function() {
            $query = CategoriaCurso::query();
            $query->orderby('url_categoria_curso','asc');
            return $query->get(); 
        });
    }
}
