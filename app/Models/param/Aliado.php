<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

class Aliado extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'param.aliado';

   	protected $primaryKey = 'codigo_aliado';

   	public static function getPartners()
   	{
		$query = Aliado::query();
		$query->select('nombre_aliado', 'logo_aliado', 'url_aliado');
		$query->where('codigo_estado', Estado::getState('active'));
		$query->where('codigo_institucion', '=', RegistroSesion::getInstitution());
		$query->orderBy('codigo_aliado','asc');
		return $query->get();
   	}
}
