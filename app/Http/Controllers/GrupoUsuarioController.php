<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Request, Response, Redirect, Auth, Input, DB, Log, Lang, URL;

use TuProyecto, SendEmail;

use App\GrupoUsuario, App\Usuario, App\Estado, App\RolUsuarioGrupo, App\Entidad;

class GrupoUsuarioController extends Controller {

    /**
     * Instantiate a new GrupoUsuarioController instance.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'confirmar']]);
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Request::ajax()){
			if(Input::get('list')){
				return Response::json(GrupoUsuario::getWorkTeam( Request::all() ));
			}
			return Response::json(GrupoUsuario::getUsersTeamGroup( Request::all() ));
		}
		abort(404);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if (Request::ajax()) {
			// Decrypt src-params
	        list($codigo_usuario) = TuProyecto::decryptSrcParams(Input::get('codigo_usuario'));
	        if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
	            abort(403);
	        }

			// Valid user
			$user = Usuario::find($codigo_usuario);
			if(!$user instanceof Usuario) {
				abort(403);
			}

			$entity = Entidad::where('codigo_usuario', '=', $user->codigo_usuario)->first();
			if(!$entity instanceof Entidad) {
				abort(403);
			}

			$data = Input::all();
			$grupousuario = new GrupoUsuario;
			if ($grupousuario->isValid($data)) {
	        	try {

	        		$rol = RolUsuarioGrupo::getRolUserGroup(Input::get('codigo_rol_usuario_grupo_insti'));
	        		if(!$rol instanceof RolUsuarioGrupo) {
						abort(403);
					}
	        		// Mail notification
				    $data = [];
				    $data['_subject'] = Lang::get('project.mail.group.project.subject', ['entity' => $user->nombre_usuario]);
				    $data['_template'] = 'emails.project.notificationgroup';

				    // Data Template
				    $data['nombre_usuario'] = $user->nombre_usuario;
				    $data['url_nickname'] = URL::route('proyecto.proyecto', ['proyecto' => $user->nickname_usuario], false);
				    $data['confirm'] = Lang::get('project.mail.group.project.confirm');
			        $data['invitation'] = Input::has('mensaje_invitacion') ? Input::get('mensaje_invitacion'): '';

				    $data['_to'] = Input::get('email');

				    $data['rol'] = $rol->nombre_rol_usuario_grupo;

					$datauser = Usuario::where('correo_electronico', '=', Input::get('email'))->first();
			        if(!$datauser instanceof Usuario) {
			        	$data['_url_confirm'] = URL::route('usuario.equipo.confirmar',['m' => TuProyecto::encryptSrcParams([Input::get('email')]),'u' => TuProyecto::encryptSrcParams([$entity->codigo_usuario]),'n' => Input::get('nombre_usuario'),'a' => Input::get('primer_apellido_persona'), 'r' => Input::get('codigo_rol_usuario_grupo_insti')], false);
			        	$data['_to_name'] = Input::get('nombre_usuario').' '.Input::get('primer_apellido_persona') ;
			        }else{
						$data['_url_confirm'] = URL::route('usuario.equipo.confirmar',['m' => TuProyecto::encryptSrcParams([Input::get('email')]),'u' => TuProyecto::encryptSrcParams([$entity->codigo_usuario]), 'r' => Input::get('codigo_rol_usuario_grupo_insti')], false);
			        	$data['_to_name'] = $datauser->nombre_usuario;
			        }

				   	SendEmail::notification($data);
					// Commit Transaction
					return Response::json(array('success' => true, 'requestPost' => true, 'message' => Lang::get('project.group.success', ['user' => $data['_to_name'], 'mail' => $data['_to']])));
				}catch(\Exception $e){
					Log::error($e->getMessage());
					return Response::json(array('success' => false, 'requestPost' => true, 'errors' => Lang::get('app.exception')));
				}
			}
			return Response::json(['success' => false, 'errors' => $grupousuario->errors]);
		}
    	abort(404);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		if(Request::ajax()){
			return Response::json( GrupoUsuario::buildUserWorkTeam(GrupoUsuario::getUserWorkTeam($id)) );
		}
		abort(404);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if (Request::ajax()) {

			// Decrypt src-params
	        list($codigo_usuario) = TuProyecto::decryptSrcParams(Input::get('codigo_usuario'));
	        if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
	            abort(403);
	        }
			$groupUser = GrupoUsuario::where('codigo_usuario', '=', $codigo_usuario)->where('seg_codigo_usuario', '=', Input::get('seg_codigo_usuario'))->first();

			if(!$groupUser instanceof GrupoUsuario) {
				abort(404);
			}
			$user = Usuario::find($groupUser->codigo_usuario);
			if(!$user instanceof Usuario) {
				abort(404);
			}
			if(in_array(Auth::user()->codigo_usuario, $user->getAllowedUsers()))
			{
				DB::beginTransaction();
				try {
					// Set removed state
					GrupoUsuario::where('codigo_usuario', '=', $groupUser->codigo_usuario)->where('seg_codigo_usuario', '=', $groupUser->seg_codigo_usuario)
						->update(array('codigo_estado' => Estado::getState('removed')));

					DB::commit();
					return Response::json(array('success' => true));
				}catch(\Exception $e){
					DB::rollback();
					Log::error($e->getMessage());
					return Response::json(array('success' => false, 'errors' => Lang::get('app.exception')));
				}
			}
			abort(403);
		}
    	abort(404);
	}

	/**
	 * Confirm invitation to project team.
	 *
	 * @return Response
	 */
	public function confirmar()
	{
		// Decrypt src-params
		list($correo_electronico) = TuProyecto::decryptSrcParams(Input::get('m'));
		if(!$correo_electronico || !is_string($correo_electronico)) {
			abort(403);
		}

		list($codigo_usuario) = TuProyecto::decryptSrcParams(Input::get('u'));
		if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
			abort(403);
		}

        // User entity
		$user = Usuario::find($codigo_usuario);
		if(!$user instanceof Usuario) {
			abort(403);
		}

        // Entity user
		$entity = Entidad::where('codigo_usuario', '=', $user->codigo_usuario)->first();
		if(!$entity instanceof Entidad) {
			abort(403);
		}

		DB::beginTransaction();
		try{
			$userJoin = Usuario::where('correo_electronico', '=', $correo_electronico)->first();
	        if(!$userJoin instanceof Usuario) {
            	// Add guest user
            	$data = [];
            	$data['nombre_usuario'] = Input::get('n');
            	$data['primer_apellido_persona'] = Input::get('a');
            	$data['correo_electronico'] = $correo_electronico;
            	$userJoin = Usuario::store($data);

	        	// Notification
            	// Usuario::newGuestUser($userJoin);

            }

			$member = GrupoUsuario::where('seg_codigo_usuario', $userJoin->codigo_usuario)->where('codigo_usuario', $user->codigo_usuario)->first();
            if($member instanceof GrupoUsuario) {
                if($member->codigo_estado != Estado::getState('active')) {
                    GrupoUsuario::where('seg_codigo_usuario', $userJoin->codigo_usuario)->where('codigo_usuario', $user->codigo_usuario)
                    ->update(['codigo_estado' => Estado::getState('active')]);
                }
            }else{
                $member = new GrupoUsuario;
                $member->seg_codigo_usuario = $userJoin->codigo_usuario;
                $member->codigo_usuario = $user->codigo_usuario;
                $member->codigo_estado = Estado::getState('active');
                $member->codigo_rol_usuario_grupo_insti = Input::get('r');
				$member->fecha_hora_grupo_usuario = date('Y-m-d H:m:s');
                $member->save();
            }

			DB::commit();
        	Auth::loginUsingId($member->seg_codigo_usuario);
			return Redirect::route('proyecto.proyecto', $user->nickname_usuario);

		}catch(\Exception $e){
			DB::rollback();
    		Log::error(sprintf('%s:%s', 'GrupoUsuarioController:confirmar', $e->getMessage()));
    		abort(500);
		}
	}
}
