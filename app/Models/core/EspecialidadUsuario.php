<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

use TuProyecto;

use Input, Auth,  DB, Cache, Log;

class EspecialidadUsuario extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.especialidad_usuario';

	public $incrementing = false;

	public $timestamps = false;

	public static function getSpecialties()
	{
		$specialties = [];
		$query = EspecialidadUsuario::query();
		$query->select('especialidad.codigo_especialidad',
			DB::raw('(CASE especialidad.codigo_especialidad WHEN '.Especialidad::getSpecialty("other").' THEN descripcion_especialidad ELSE nombre_especialidad END) as nombre_especialidad'));
		$query->join('core.especialidad', 'especialidad_usuario.codigo_especialidad', '=', 'especialidad.codigo_especialidad');
		$query->join('core.especialidad_institucion', function($join){
			$join->on('especialidad.codigo_especialidad', '=', 'especialidad_institucion.codigo_especialidad')
				->where('especialidad_institucion.codigo_institucion', '=', RegistroSesion::getInstitution());
		});
		$query->where('especialidad_usuario.codigo_estado', '=', Estado::getState('active'));

		if(Input::has('codigo_usuario')) {
			// Decrypt src-params
			list($codigo_usuario) = TuProyecto::decryptSrcParams(Input::get('codigo_usuario'));
			if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
				App::abort(403);
			}
			$query->where('especialidad_usuario.codigo_usuario', '=', $codigo_usuario);

	    	$query->orderBy('nombre_especialidad','asc');
			$specialties = $query->get();
		}
		return $specialties;
	}

	/**
	* Defining Relations
	*/
	public function especialidad()
    {
        return $this->hasOne('App\Especialidad','codigo_especialidad','codigo_especialidad');
    }
}
