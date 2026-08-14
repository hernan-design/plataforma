<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

use TuProyecto;

use Input, App;

class NivelEducacionUsuario extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.nivel_educacion_usuario';

	protected $primaryKey = 'codigo_nivel_educacion_usuario';

	public $timestamps = false;

	
	public static function getLevels()
	{
		$levels = [];
		$query = NivelEducacionUsuario::query();
		$query->select('nivel_educacion.codigo_nivel_educacion', 'nivel_educacion.nombre_nivel_educacion', 'nivel_educacion_usuario.nombre_nivel_educacion as disciplina','codigo_nivel_educacion_usuario');
		$query->join('core.nivel_educacion', 'nivel_educacion_usuario.codigo_nivel_educacion', '=', 'nivel_educacion.codigo_nivel_educacion');
		$query->where('nivel_educacion_usuario.codigo_estado', '=', Estado::getState('active'));

		if(Input::has('codigo_persona')) {
			// Decrypt src-params
			list($codigo_persona) = TuProyecto::decryptSrcParams(Input::get('codigo_persona'));
			if(!$codigo_persona || !is_numeric($codigo_persona)) {
				App::abort(403);
			}
			$query->where('nivel_educacion_usuario.codigo_persona', '=', $codigo_persona);

	    	$query->orderBy('nombre_nivel_educacion','asc');
			$levels = $query->get();
		}
		return $levels;
	}

	/**
	* Defining Relations
	*/
	public function nivel()
    {
        return $this->hasOne('App\NivelEducacion','codigo_nivel_educacion','codigo_nivel_educacion');
    }
}
