<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

use TuProyecto;

use Input, App;

class RazonRegistroUsuario extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.razon_registro_usuario';

	public $incrementing = false;

	public $timestamps = false;

	public static function getReasons()
	{
		$reasons = [];
		$query = RazonRegistroUsuario::query();
		$query->select('razon_registro.codigo_razon_registro', 'razon_registro.nombre_razon_registro');
		$query->join('core.razon_registro', 'razon_registro_usuario.codigo_razon_registro', '=', 'razon_registro.codigo_razon_registro');
		$query->where('razon_registro_usuario.codigo_estado', '=', Estado::getState('active'));

		if(Input::has('codigo_usuario')) {
			// Decrypt src-params
			list($codigo_usuario) = TuProyecto::decryptSrcParams(Input::get('codigo_usuario'));
			if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
				App::abort(403);
			}
			$query->where('razon_registro_usuario.codigo_usuario', '=', $codigo_usuario);

	    	$query->orderBy('nombre_razon_registro','asc');
			$reasons = $query->get();
		}
		return $reasons;
	}

	/**
	* Defining Relations
	*/
	public function razonregistro()
    {
        return $this->hasOne('App\RazonRegistro','codigo_razon_registro','codigo_razon_registro');
    }
}
