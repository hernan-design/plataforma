<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'param.landingpage';

    public static function getPage($category, $slug) {
        $query = LandingPage::query();
		$query->join('param.categoria_landingpage', 'landingpage.codigo_categoria_lp', '=', 'categoria_landingpage.codigo_categoria_lp');
		$query->where('codigo_institucion', RegistroSesion::getInstitution());
        $query->whereRaw("trim(lower(url_landingpage)) ilike trim(lower('%".$slug."%'))");
        $query->whereRaw("trim(lower(url_categoria_lp)) ilike trim(lower('%".$category."%'))");
		$query->where('codigo_estado', Estado::getState('active'));
		return $query->first();
    }
}