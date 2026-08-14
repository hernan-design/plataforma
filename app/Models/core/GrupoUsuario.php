<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

use TuProyecto;

use Validator, DB, Auth;

use App\Estado;

class GrupoUsuario extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.grupo_usuario';

	public $timestamps = false;

	public $incrementing = false;

   	public function isValid($data)
	{
		$rules = array(
			'nombre_usuario' => 'required|max:250',
			'primer_apellido_persona' => 'required|max:250',
			'email' => 'required|email',
			'codigo_usuario' => 'required'
		);

		$validator = Validator::make($data, $rules);
		if ($validator->passes()) {
			return true;
		}
		$this->errors = $validator->errors();
		return false;
	}

	public function isValidTeam($data)
	{
		$rules = array(
			'codigo_usuario' => 'required'
		);

		$validator = Validator::make($data, $rules);
		if ($validator->passes()) {
			return true;
		}
		$this->errors = $validator->errors();
		return false;
	}

	public static function getUsersTeamGroup(array $filters = [])
   	{
   		$users = [];
   		if(isset($filters['codigo_usuario']) && !empty($filters['codigo_usuario'])) {
			$query = GrupoUsuario::query();
			$query->select('grupo_usuario.codigo_usuario as owner','grupo_usuario.codigo_usuario as codigo_usuario','grupo_usuario.codigo_rol_usuario_grupo_insti','administracion_grupo_usuario','fecha_hora_grupo_usuario','imagen_usuario','nombre_usuario','nombre_rol_usuario_grupo',
			DB::raw("trim(initcap(ciudad.nombre_ciudad)) as nombre_ciudad"),
			DB::raw("COALESCE(initcap(ciudad.distrito_ciudad), '') as distrito_ciudad"), 'nombre_pais','nickname_usuario', 'grupo_usuario.seg_codigo_usuario');

			$query->join('core.entidad', 'grupo_usuario.codigo_usuario', '=', 'entidad.codigo_usuario');
			$query->join('seguridad.usuario', 'grupo_usuario.seg_codigo_usuario', '=', 'usuario.codigo_usuario');
			$query->leftjoin('core.rol_usuario_grupo_insti', 'grupo_usuario.codigo_rol_usuario_grupo_insti', '=', 'rol_usuario_grupo_insti.codigo_rol_usuario_grupo_insti');
			$query->leftjoin('core.rol_usuario_grupo', 'rol_usuario_grupo_insti.codigo_rol_usuario_grupo', '=', 'rol_usuario_grupo.codigo_rol_usuario_grupo');

			// City / Country
			$query->leftjoin('core.ciudad', 'usuario.codigo_ciudad', '=', 'ciudad.codigo_ciudad');
			$query->leftjoin('core.pais', 'ciudad.codigo_pais', '=', 'pais.codigo_pais');

			// Decrypt src-params
			list($codigo_usuario) = TuProyecto::decryptSrcParams($filters['codigo_usuario']);
			if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
				abort(403);
			}

			$query->where('grupo_usuario.codigo_usuario', $codigo_usuario);
			$query->where('grupo_usuario.codigo_estado', Estado::getState('active'));

			// Get count posts
			$total_entries = $query->count();

			// Get posts
			$data = $query->skip($filters['offset'])->take($filters['limit'])->get();

			if(count($data) > 0) {
				foreach ($data as $usersTeams) {
					$users[] = GrupoUsuario::buildUserTeam($usersTeams);
				}
			}

			$response = new \stdClass();
			$response->total_entries = $total_entries;
			$response->items = $users;
	   		return $response;
		}
		return $users;
   	}

	public static function getWorkTeam(array $filters = [])
   	{
   		$users = [];
   		if(isset($filters['codigo_usuario']) && !empty($filters['codigo_usuario'])) {

			// Decrypt src-params
			list($codigo_usuario) = TuProyecto::decryptSrcParams($filters['codigo_usuario']);
			if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
				abort(500);
			}

			$query = GrupoUsuario::query();
			$query->select('nombre_usuario as text', 'grupo_usuario.codigo_grupo_usuario as id');

			$query->join('core.entidad', 'grupo_usuario.codigo_usuario', '=', 'entidad.codigo_usuario');
			$query->join('seguridad.usuario', 'grupo_usuario.seg_codigo_usuario', '=', 'usuario.codigo_usuario');

			if(isset($filters['q']) && !empty($filters['q'])){
				$query->whereRaw("nombre_usuario ilike '%".trim($filters['q'])."%'");
			}

			$query->where('grupo_usuario.codigo_usuario', $codigo_usuario);
			$query->where('grupo_usuario.codigo_estado', Estado::getState('active'));

			$users = $query->get();
	   		return $users;
		}
		return $users;
   	}

	public static function getUserWorkTeam($codigo_grupo_usuario)
	{
		$query = GrupoUsuario::query();
		$query->select(DB::raw("(nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '')) as nombre_usuario"), 'nombre_rol_usuario_grupo', 'correo_electronico', 'grupo_usuario.seg_codigo_usuario', 'codigo_grupo_usuario');

		$query->join('core.entidad', 'grupo_usuario.codigo_usuario', '=', 'entidad.codigo_usuario');
		$query->join('seguridad.usuario', 'grupo_usuario.seg_codigo_usuario', '=', 'usuario.codigo_usuario');
		$query->leftjoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');
		$query->leftjoin('core.rol_usuario_grupo_insti', 'grupo_usuario.codigo_rol_usuario_grupo_insti', '=', 'rol_usuario_grupo_insti.codigo_rol_usuario_grupo_insti');
		$query->leftjoin('core.rol_usuario_grupo', 'rol_usuario_grupo_insti.codigo_rol_usuario_grupo', '=', 'rol_usuario_grupo.codigo_rol_usuario_grupo');

		$query->where('grupo_usuario.codigo_grupo_usuario', $codigo_grupo_usuario);
		$query->where('grupo_usuario.codigo_estado', Estado::getState('active'));

		$user = $query->first();
		return $user;
	}

	/**
	 * Build UserTeam.
	 */
   	public static function buildUserWorkTeam($userWorkTeam)
   	{
		$object = new \stdClass();
		$object->nombre_usuario_acuerdo = $userWorkTeam->nombre_usuario;
		$object->cargo_usuario_acuerdo = $userWorkTeam->nombre_rol_usuario_grupo;
		$object->correo_usuario_acuerdo = $userWorkTeam->correo_electronico;
		$object->codigo_grupo_usuario = $userWorkTeam->codigo_grupo_usuario;
		return $object;
	}

	/**
	 * Build UserTeam.
	 */
   	public static function buildUserTeam($userTeam)
   	{
		$object = new \stdClass();
		$object->nombre_usuario = $userTeam->nombre_usuario;
		$object->imagen_usuario = $userTeam->imagen_usuario;
		$object->nombre_rol_usuario_grupo = $userTeam->nombre_rol_usuario_grupo;
		$object->nombre_ciudad = $userTeam->nombre_ciudad;
		$object->distrito_ciudad = $userTeam->distrito_ciudad;
		$object->nombre_pais = $userTeam->nombre_pais;
		$object->nickname_usuario = $userTeam->nickname_usuario;
		$object->id = $userTeam->seg_codigo_usuario;
		$object->text = $userTeam->nombre_usuario;

		$object->codigo_usuario = TuProyecto::encryptSrcParams([$userTeam->codigo_usuario]);
		$object->seg_codigo_usuario = $userTeam->seg_codigo_usuario;

		$object->owner = (Auth::check() && in_array(Auth::user()->codigo_usuario, [$userTeam->owner])) ? true : false;
		return $object;
   	}


	public static function removeUserUser($user, $userTeam) {
        return GrupoUsuario::select('grupo_usuario.*')
            ->where('codigo_usuario', '=', $user)
            ->where('seg_codigo_usuario', '=', $userTeam)
            ->first();
    }

    public static function addJoinGroup($user)
   	{
		// Verify User Group
		$userGroup = GrupoUsuario::where('seg_codigo_usuario', Auth::user()->codigo_usuario)->where('codigo_usuario', $user->codigo_usuario)->first();
		if ($userGroup instanceof GrupoUsuario ) {
			GrupoUsuario::where('seg_codigo_usuario',Auth::user()->codigo_usuario)->where('codigo_usuario', $userGroup->codigo_usuario)
			->update(['codigo_estado' => Estado::getState('active')]);
		}else{
			$groupUser = new GrupoUsuario;
			$groupUser->seg_codigo_usuario = Auth::user()->codigo_usuario;
            $groupUser->codigo_usuario = Auth::user()->codigo_usuario;
            $groupUser->codigo_estado = Estado::getState('active');
			$groupUser->fecha_hora_grupo_usuario = date('Y-m-d H:m:s');
            $groupUser->save();
		}
   	}

   	public static function cancelJoinGroup($user){

   		// Set removed grupo user
		GrupoUsuario::where('seg_codigo_usuario', Auth::user()->codigo_usuario)->where('codigo_usuario', $user)
			->update(['codigo_estado' => Estado::getState('removed')]);
   	}

	public function user()
	{
		return $this->hasOne('App\Usuario', 'codigo_usuario', 'seg_codigo_usuario');
	}
}
