<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model {

	/**
	 * Tabla de permisos (antes definida por Zizaco\Entrust\EntrustPermission).
	 */
	protected $table = 'seguridad.permiso';

	/**
	 * Many-to-Many relations with role model.
	 */
	public function roles()
	{
		return $this->belongsToMany(Rol::class, config('entrust.permission_role_table'), 'permission_id', 'role_id');
	}
}
