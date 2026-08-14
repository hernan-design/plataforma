<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

class GrupoForo extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.grupo_foro';

	public $timestamps = false;

    public $incrementing = false;

    public static function getGroupsPost($post_code)
   	{   		
		$query = GrupoForo::query();
		$query->select('usuario_grupo.codigo_usuario','usuario_grupo.codigo_rol');
		$query->join('core.grupo', 'grupo.codigo_grupo', '=', 'grupo_foro.codigo_grupo');
		$query->join('core.usuario_grupo', 'usuario_grupo.codigo_grupo', '=', 'grupo.codigo_grupo');
		$query->where('usuario_grupo.codigo_estado', Estado::getState('active'));
		return $query->get();
		
   	}
}
