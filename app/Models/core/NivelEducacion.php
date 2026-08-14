<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

use Cache;

use App\Models\core\NivelEducacionInstitucion;

class NivelEducacion extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.nivel_educacion';

   	protected $primaryKey = 'codigo_nivel_educacion';

    public static function getLevels()
    {
            $getLevelEducation = NivelEducacionInstitucion::getLevelEducation();
            if ($getLevelEducation->count() > 0) {
                return $getLevelEducation;
            }
            $query = NivelEducacion::query();
            $query->select('codigo_nivel_educacion', 'nombre_nivel_educacion');
            $query->whereIn('codigo_nivel_educacion', [ 12, 13, 14, 8, 1, 15, 9, 2, 3, 4, 11, 6, 5, 10, 7 ]);
            $query->orderby('orden_nivel_educacion', 'asc');
            return $query->get();
    }
}
