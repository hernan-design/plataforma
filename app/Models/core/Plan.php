<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Cache;

use App\Estado, App\RegistroSesion;

class Plan extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.plan';

   	protected $primaryKey = 'codigo_plan';

    public static function getPlans()
    {
		$cache = sprintf('_%s_%s', 'plans_pricing', RegistroSesion::getInstitution());
		if (Cache::has($cache)) {
			return Cache::get($cache);
		}

		return Cache::rememberForever($cache, function() {
			$query = self::query();
			$query->where('codigo_institucion', RegistroSesion::getInstitution());
			$query->where('codigo_estado', Estado::getState('active'));
			$query->orderby('plan_sugerido', 'desc');
			return $query->get();
		});
    }

    public function items()
    {
        return $this->hasMany('App\ItemPlan', 'codigo_plan', 'codigo_plan');
    }
}
