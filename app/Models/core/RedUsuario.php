<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Events\Notification;
use App\Models\mongodb\Notificacion as MDBNotificacion;
//use Chatkit\Chatkit;
use App\Models;


use TuProyecto, DB, Auth, Lang, URL, SendEmail, Log;

class RedUsuario extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.red_usuario';

	public $incrementing = false;

	public $timestamps = false;

	/**
	 * SQL used to validate the state of friendship between two users.
	 *
	 * @var string
	 */
	public static $raw_friendship = '(CASE
			WHEN (COALESCE(invitation.codigo_estado, 0) = 8 and COALESCE(answer.codigo_estado, 0) = 8) THEN \'friend\'
			WHEN (COALESCE(invitation.codigo_estado, 0) = 8 and (answer.codigo_estado is null or COALESCE(answer.codigo_estado, 0) = 13)) THEN \'waiting_answer\'
			WHEN ((COALESCE(invitation.codigo_estado, 0) = 13 or invitation.codigo_estado is null) and COALESCE(answer.codigo_estado, 0) = 8) THEN \'pending_confirm\'
			WHEN ( (invitation.codigo_estado is null or COALESCE(invitation.codigo_estado, 0) = 13) and (answer.codigo_estado is null or COALESCE(answer.codigo_estado, 0) = 13) or (COALESCE(invitation.codigo_estado, 0) = 13 or COALESCE(answer.codigo_estado, 0) = 13) ) THEN \'invitation\'
		END)';

	public static function getNetworkUsers(array $filters = [], Usuario $user)
   	{
		$networkUsers = [];
		$query = Usuario::query();
		$query->select( DB::raw("(CASE usuario.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '') ELSE nombre_usuario END) as nombre_usuario"),  'imagen_usuario', 'nickname_usuario', 'profesion_usuario', 'nombre_ciudad', 'nombre_pais', 'rol_usuario_institucion', DB::raw('COALESCE(invitation.codigo_usuario, answer.seg_codigo_usuario) as codigo_usuario'),
			DB::raw('COALESCE(invitation.seg_codigo_usuario, answer.codigo_usuario) as seg_codigo_usuario'),
			(Auth::check() ? DB::raw(sprintf('%s %s', RedUsuario::$raw_friendship, 'as state_friendship')) : DB::raw('\'\' as state_friendship'))
		);

		// City / Country
		$query->leftjoin('core.ciudad', 'usuario.codigo_ciudad', '=', 'ciudad.codigo_ciudad');
		$query->leftjoin('core.pais', 'ciudad.codigo_pais', '=', 'pais.codigo_pais');

		$query->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');

        // User institution
		$query->join('core.usuario_institucion', function($join){
			$join->on('usuario_institucion.codigo_usuario', '=', 'usuario.codigo_usuario')
				->where('usuario_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('usuario_institucion.codigo_estado', '=', Estado::getState('active'));
        });

        // State friendship
        $query->leftjoin('core.red_usuario as invitation', function($join)  use($user) {
			$join->on('usuario.codigo_usuario', '=', 'invitation.seg_codigo_usuario')
				->where('invitation.codigo_usuario', '=', $user->codigo_usuario)
				->where('invitation.codigo_institucion', '=', RegistroSesion::getInstitution());
        });

        $query->leftjoin('core.red_usuario as answer', function($join)  use($user) {
			$join->on('usuario.codigo_usuario', '=', 'answer.codigo_usuario')
				->where('answer.seg_codigo_usuario', '=', $user->codigo_usuario)
				->where('answer.codigo_institucion', '=', RegistroSesion::getInstitution());
        });

		$query->where('usuario.codigo_usuario', '!=', $user->codigo_usuario);

		$friendship = isset($filters['friendship']) && !empty($filters['friendship']) ? $filters['friendship'] : 'friend';
		if ($friendship) {
			switch ($friendship) {

		        case 'friend':
		        	$query->whereRaw(sprintf('%s = \'friend\'', RedUsuario::$raw_friendship));
		        break;

		        case 'request_friendship':
			        $query->where(function ($query) {
               			$query->whereRaw(sprintf('%s = \'pending_confirm\'', RedUsuario::$raw_friendship ))
			        		->orwhereRaw(sprintf('%s = \'waiting_answer\'', RedUsuario::$raw_friendship ));
          			 });
			    break;
			}
		}

		// Filters
		if(isset($filters['city']) && !empty($filters['city'])) {
	 		$query->where('usuario.codigo_ciudad', $filters['city']);
 		}

 		if(isset($filters['rol']) && !empty($filters['rol'])) {
 			$query->whereRaw("trim(usuario_institucion.rol_usuario_institucion) != ''");
			$query->whereNotNull('usuario_institucion.rol_usuario_institucion');
			$query->whereRaw("rol_to_array(usuario_institucion.rol_usuario_institucion)::integer[] @> ARRAY['".$filters['rol']."']::integer[] = true");
	    }

	    if(isset($filters['username']) && !empty($filters['username'])) {
			$query->whereRaw("nombre_usuario ilike '%".$filters['username']."%'");
 		}

		// Get count posts
		$total_entries = $query->count();

		// Orders
		$query->orderByRaw('COALESCE(answer.codigo_usuario, invitation.codigo_usuario, 0) desc');
		$query->orderBy('usuario.nombre_usuario', 'asc');

		// Get posts
		$data = $query->skip($filters['offset'])->take($filters['limit'])->get();

		if(count($data) > 0) {
			foreach ($data as $userNetwork) {
				$networkUsers[] = RedUsuario::buildUserNetwork($userNetwork);
			}
		}

		$response = new \stdClass();
		$response->total_entries = $total_entries;
		$response->items = $networkUsers;
   		return $response;
   	}

	 /**
	 * Build UserNetwork.
	 */
   	public static function buildUserNetwork($userNetwork)
   	{
		$object = new \stdClass();
		$object->seg_codigo_usuario = TuProyecto::encryptSrcParams([$userNetwork->seg_codigo_usuario]);
		$object->nombre_usuario = $userNetwork->nombre_usuario;
		$object->imagen_usuario = $userNetwork->imagen_usuario;
		$object->nickname_usuario = $userNetwork->nickname_usuario;
		$object->profesion_usuario = $userNetwork->profesion_usuario;
		$object->nombre_ciudad = $userNetwork->nombre_ciudad;
		$object->nombre_pais = $userNetwork->nombre_pais;

		$object->rol_usuario_institucion = $userNetwork->rol_usuario_institucion;
		$object->state_friendship = $userNetwork->state_friendship;

		$object->owner = in_array(Auth::user()->codigo_usuario, [$userNetwork->codigo_usuario]) ? true : false;
		return $object;
   	}

   	public static function invitationFriendship($user)
   	{
		// Verify User Network
		$userNetwork = RedUsuario::where('seg_codigo_usuario', $user->codigo_usuario)->where('codigo_usuario', Auth::user()->codigo_usuario)->where('codigo_institucion', RegistroSesion::getInstitution())->first();
		if ($userNetwork instanceof RedUsuario ) {
			RedUsuario::where('seg_codigo_usuario', $userNetwork->seg_codigo_usuario)->where('codigo_usuario', Auth::user()->codigo_usuario)->where('codigo_institucion', RegistroSesion::getInstitution())
			->update(['codigo_estado' => Estado::getState('active')]);
		}else{
			$userNetwork = new RedUsuario;
			$userNetwork->seg_codigo_usuario = $user->codigo_usuario;
			$userNetwork->codigo_usuario = Auth::user()->codigo_usuario;
			$userNetwork->codigo_institucion = RegistroSesion::getInstitution();
			$userNetwork->codigo_estado = Estado::getState('active');
			$userNetwork->fecha_red_usuario = date('Y-m-d');
   			$userNetwork->hora_red_usuario = date('H:i:s');
   			$userNetwork->save();
		}

		// Mail notification
	    $data = [];
	    $data['_subject'] = Lang::get('user.mail.network.user.subject', ['user' => Auth::user()->nombre_usuario]);
	    $data['_template'] = 'emails.user.confirmusernetwork';
	    $data['confirm'] = Lang::get('user.mail.network.user.confirm');

	    $data['_url_user_action'] = Auth::user()->getProfileUrl();
	    $data['_name_user_action'] = Auth::user()->nombre_usuario;
	    $data['_image_user_action'] = Auth::user()->imagen_usuario;
	    $data['_nickname_user_action'] = Auth::user()->nickname();
	    $data['_profession_user_action'] = Auth::user()->profesion_usuario;

	    $data['_to'] = $user->correo_electronico;

    	$data['_url_confirm'] = URL::route('usuario.redusuario.confirmar',['seg' => TuProyecto::encryptSrcParams([$user->codigo_usuario]),'u' => TuProyecto::encryptSrcParams([Auth::user()->codigo_usuario])], false);
    	$data['_to_name'] = $user->nombre_usuario;

	   	SendEmail::notification($data);

	   	// Broadcasting event
		event(new Notification([
			'title' => trans('user.notification.title'),
			'content' => trans('user.notification.content', ['user' => Auth::user()->getName()]),
			'receivedBy' => $user->codigo_usuario,
			'type' => MDBNotificacion::getType('friendship')
		]));
   	}

   	public static function confirmFriendship($seg_usuario, $codigo_usuario)
   	{
   		$seg_user = Usuario::find($seg_usuario->codigo_usuario);
        if(!$seg_user instanceof Usuario) {
			abort(403);
		}

		$user = Usuario::find($codigo_usuario);
        if(!$user instanceof Usuario) {
			abort(403);
		}

		$invitation_user = RedUsuario::where('seg_codigo_usuario', $user->codigo_usuario)->where('codigo_usuario', $seg_user->codigo_usuario)->where('codigo_institucion', RegistroSesion::getInstitution())->first();
		if($invitation_user instanceof RedUsuario) {

			$answer_user = RedUsuario::where('codigo_usuario', $user->codigo_usuario)->where('seg_codigo_usuario', $seg_user->codigo_usuario)->where('codigo_institucion', RegistroSesion::getInstitution())->first();
			if($answer_user instanceof RedUsuario) {
				DB::statement("UPDATE core.red_usuario SET codigo_estado = ".Estado::getState('active')."
					WHERE 	( (codigo_usuario = {$user->codigo_usuario} AND seg_codigo_usuario = {$seg_user->codigo_usuario}) OR
							(codigo_usuario = {$seg_user->codigo_usuario} AND seg_codigo_usuario = {$user->codigo_usuario}) )
					AND codigo_institucion = ".RegistroSesion::getInstitution());
			}else{

				$answer_user = new RedUsuario;
				$answer_user->seg_codigo_usuario = $seg_user->codigo_usuario;
				$answer_user->codigo_usuario = $user->codigo_usuario;
				$answer_user->codigo_institucion = RegistroSesion::getInstitution();
				$answer_user->codigo_estado = Estado::getState('active');
				$answer_user->fecha_red_usuario = date('Y-m-d');
				$answer_user->hora_red_usuario = date('H:i:s');
				$answer_user->save();

				DB::statement("UPDATE core.red_usuario SET codigo_estado = ".Estado::getState('active')."
					WHERE codigo_usuario = {$seg_user->codigo_usuario} AND seg_codigo_usuario = {$user->codigo_usuario} AND codigo_institucion = ".RegistroSesion::getInstitution());
			}
		}
   	}

   	public static function cancelFriendship($user){
   		// Set removed network
		DB::statement("UPDATE core.red_usuario SET codigo_estado = ".Estado::getState('removed')."
			WHERE ( (codigo_usuario = ".Auth::user()->codigo_usuario." AND seg_codigo_usuario = {$user->codigo_usuario}) OR
				  (codigo_usuario = {$user->codigo_usuario} AND seg_codigo_usuario = ".Auth::user()->codigo_usuario.") )
			AND codigo_institucion = ".RegistroSesion::getInstitution());
	   }
	
	// public static function createUserChatRoom($user){
	// 	$chatkit = new Chatkit([
	// 		'instance_locator' => 'v1:us1:d1919572-61d4-4c8d-b5ff-dae39be99939',
	// 		'key' => '2bdfe82f-38c7-42cb-878c-69c985434cfa:TUudOpF2yuw16mmmLm9bYW3b/+gm3IyyWeKLMlUiN+Q='
	// 	  ]);

	// 	  return $chatkit;
	// }	
	
}
