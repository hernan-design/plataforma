<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

use Cache;

class RolUsuarioGrupo extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.rol_usuario_grupo';

   	protected $primaryKey = 'codigo_rol_usuario_grupo';

	public $timestamps = false;

	public static function getGroupUserRol($data)
	{
		switch ($data) {
			case 'teamWork': return 9;
			default: return 'Not type group user rol identified';
		}
	}

    public static function getUserGroupRol()
    {

        $cache = sprintf('_%s_%s', 'rol_user_group_list', RegistroSesion::getInstitution());
        if (Cache::has($cache)) {
            return Cache::get($cache);
        }

        return Cache::rememberForever($cache, function() {
            $query = RolUsuarioGrupo::query();
            $query->select('codigo_rol_usuario_grupo_insti as key', 'nombre_rol_usuario_grupo as value');
			$query->join('core.rol_usuario_grupo_insti', 'rol_usuario_grupo.codigo_rol_usuario_grupo', '=', 'rol_usuario_grupo_insti.codigo_rol_usuario_grupo');
            $query->where('rol_usuario_grupo_insti.codigo_estado', Estado::getState('active'));
            $query->where('rol_usuario_grupo_insti.codigo_institucion', RegistroSesion::getInstitution());
            $query->orderby('nombre_rol_usuario_grupo','asc');
            return $query->get();
        });

    }

    public static function getRolUserGroup($rolUser)
    {
		$query = RolUsuarioGrupo::query();
		$query->select('rol_usuario_grupo.codigo_rol_usuario_grupo', 'nombre_rol_usuario_grupo');
		$query->join('core.rol_usuario_grupo_insti', 'rol_usuario_grupo.codigo_rol_usuario_grupo', '=', 'rol_usuario_grupo_insti.codigo_rol_usuario_grupo');
		$query->where('rol_usuario_grupo_insti.codigo_rol_usuario_grupo_insti', $rolUser);
		$query->where('rol_usuario_grupo_insti.codigo_estado', Estado::getState('active'));
		return $query->first();

    }
}
