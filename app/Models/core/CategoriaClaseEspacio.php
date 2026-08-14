<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

use Cache;

class CategoriaClaseEspacio extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.categoria_clase_espacio';

	protected $primaryKey = 'codigo_categoria_clase_espacio';

	public $timestamps = false;

	public static function getCategoryClassSpace($category)
	{
		$cache = sprintf('_%s_%s', '_get_category_class_space', $category);
		if (Cache::has($cache)) {
			return Cache::get($cache);
		}

		return Cache::rememberForever($cache, function() use ($category) {
			$query = CategoriaClaseEspacio::query();
			$query->where('codigo_clase_emprendimiento', $category);
			$query->orderby('nombre_categoria_clase_espacio', 'asc');
			return $query->get();
		});
	}
}
