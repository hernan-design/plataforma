<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

class CanalRegistro extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'param.canal_registro';

   	protected $primaryKey = 'codigo_canal_registro';

 	public static function getChanels()
    {
		$query = CanalRegistro::query();
		$query->where('codigo_institucion', '=', RegistroSesion::getInstitution());
		$query->orderBy('nombre_canal_registro', 'asc');
		return $query->pluck('nombre_canal_registro', 'codigo_canal_registro')->toArray();
    }
}
