<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RolUsuario extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'seguridad.rol_usuario';

	public $incrementing = false;

	public $timestamps = false;

	/**
	 * Verifica si el usuario (persona) cuenta con rol asociado (vinculado => 39).
	 *
	 * @Annotation los parametros corresponden al codigo_usuario, codigo_institucion, codigo_estado y id (rol).
	 * @access public
	 * @static
	 * @param int $id_user, $id_institution, $id_status, $id_role
	 * @return boolean
	 */
	public static function getRoleAssociated(int $id_user, int $id_institution, int $id_status = 8, int $id_role = 39)
	{
		$query = RolUsuario::where('user_id', $id_user);
		$query->where('codigo_institucion', $id_institution);
		$query->where('codigo_estado', $id_status);
		$query->where('role_id', $id_role);

		$role_user = $query->first();

		if(isset($role_user)) return true;
		else return false;
	}
}
