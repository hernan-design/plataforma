<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

class Beneficio extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'param.beneficio';

   	protected $primaryKey = 'codigo_beneficio';

   	public static function getAdvantage()
   	{
		$query = Beneficio::query();
		$query->select('imagen_beneficio', 'texto_beneficio');
		$query->where('codigo_estado', Estado::getState('active'));
		$query->where('codigo_institucion', '=', RegistroSesion::getInstitution());
		$query->orderBy('codigo_beneficio','asc');
		return $query->take(3)->get();
   	}
}
