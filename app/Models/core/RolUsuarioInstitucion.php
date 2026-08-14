<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

class RolUsuarioInstitucion extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.rol_usuario_institucion';

	public $timestamps = false;

	public $incrementing = false;

	public static function addRolUsuarioInstitucion($usuario_institucion, $rol_comunidad)
	{
		$rolUserInstitution = new RolUsuarioInstitucion();
		$rolUserInstitution->codigo_usuario_institucion = $usuario_institucion;
		$rolUserInstitution->codigo_rol_comunidad = $rol_comunidad;
		$rolUserInstitution->codigo_estado = Estado::getState('active');
		$rolUserInstitution->save();
	}

	public static function updateRolUsuarioInstitucion($usuario_institucion, $rol_comunidad, $estado)
	{
		$rolUser = RolUsuarioInstitucion::where('codigo_usuario_institucion', '=', $usuario_institucion)->where('codigo_rol_comunidad', '=', $rol_comunidad)->first();
		if($rolUser instanceof RolUsuarioInstitucion) {
			RolUsuarioInstitucion::where('codigo_usuario_institucion', '=', $usuario_institucion)->where('codigo_rol_comunidad', '=', $rol_comunidad)->update(['codigo_estado' => Estado::getState($estado)]);
		}else{
			$rolUser = new RolUsuarioInstitucion();
			$rolUser->codigo_usuario_institucion = $usuario_institucion;
			$rolUser->codigo_rol_comunidad = $rol_comunidad;
			$rolUser->codigo_estado = Estado::getState($estado);
			$rolUser->save();
		}
	}
}
