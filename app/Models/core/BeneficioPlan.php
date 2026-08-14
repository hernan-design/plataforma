<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Cache;

use App\Estado, App\RegistroSesion;

class BeneficioPlan extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.beneficio_plan';

   	protected $primaryKey = 'codigo_beneficio_plan';

    public static function getAdvantages()
    {
		$cache = sprintf('_%s_%s', 'plans_advantages', RegistroSesion::getInstitution());
		if (Cache::has($cache)) {
			return Cache::get($cache);
		}

		return Cache::rememberForever($cache, function() {
			$query = self::query();
			$query->where('codigo_institucion', RegistroSesion::getInstitution());
			$query->where('codigo_estado', Estado::getState('active'));
			$query->orderby('codigo_beneficio_plan', 'asc');
			return $query->get();
		});
    }
}
