<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use TuProyecto;

use DB, Request, View, Response, Input, Lang, Log, Auth, URL, SendEmail, App;

use App\MentorEmprendimiento, App\Estado, App\Usuario, App\Proyecto;

class MentorEmprendimientoController extends Controller {

    /**
     * Instantiate a new MentorEmprendimientoController instance.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['confirm']]);
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if (Request::ajax()) {
	    	// Decrypt src-params
			list($codigo_proyecto) = TuProyecto::decryptSrcParams(Input::get('codigo_proyecto'));
			if(!$codigo_proyecto || !is_numeric($codigo_proyecto)) {
				App::abort(403);
			}
			return Response::json(MentorEmprendimiento::getMentoringStartup($codigo_proyecto));
		}
		App::abort(404);
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
				App::abort(403);
			}

			// Decrypt src-params
			list($codigo_proyecto) = TuProyecto::decryptSrcParams(Input::get('codigo_proyecto'));
			if(!$codigo_proyecto || !is_numeric($codigo_proyecto)) {
				App::abort(403);
			}

			$user = Usuario::find($codigo_usuario);
			if(!$user instanceof Usuario) {
				App::abort(404);
			}

			$project = Proyecto::find($codigo_proyecto);
			if(!$project instanceof Proyecto) {
				App::abort(404);
			}

			$data = Input::all();
			$mentorEntrepreneur = new MentorEmprendimiento;
			if ($mentorEntrepreneur->isValid($data)) {
				DB::beginTransaction();
	        	try {

					$mentorEntrepreneur->codigo_usuario = $user->codigo_usuario;
					$mentorEntrepreneur->codigo_proyecto = $project->codigo_proyecto;
					$mentorEntrepreneur->codigo_estado = Estado::getState('confirm');
					$mentorEntrepreneur->fecha_mentor_emprendimiento = date('Y-m-d');
	   			    $mentorEntrepreneur->hora_mentor_emprendimiento = date('H:i:s');
					$mentorEntrepreneur->save();

					$userProject = Usuario::find($project->codigo_usuario);
			        if(!$userProject instanceof Usuario) {
			            App::abort(404);
			        }

			        // Mail notification
			        $data = [];
			        $data['_subject'] = Lang::get('mentoring.request.project.subject');
			        $data['_template'] = 'emails.mentoring.requestproject';

			        // Data Template
			        $data['_name_user_action'] = $userProject->nombre_usuario;
			        $data['_url_user_action'] = URL::route('usuario.nickname',['nickname' =>$userProject->nickname_usuario], false);
			        $data['_to'] = $user->correo_electronico;
			        $data['_to_name'] = $user->nombre_usuario;
			        $data['_message_request'] = Input::get('descripcion_solicitud_mentoria');
			        $data['_url_project'] = URL::route('proyecto.proyecto',['proyecto' =>$project->url_proyecto], false);
			        $data['_name_project'] = $project->nombre_proyecto;
			        $data['_url_confirm'] = URL::route('proyecto.mentoremprendimiento.confirmar',['u' => $user->codigo_usuario,'p' => $project->codigo_proyecto], false);

			        SendEmail::notification($data);

					// Commit Transaction
					DB::commit();
					return Response::json(['success' => true, 'codigo_estado' => $mentorEntrepreneur->codigo_estado, 'codigo_usuario' => $mentorEntrepreneur->codigo_usuario]);
				}catch(\Exception $e){
				    DB::rollback();
					Log::error($e->getMessage());
					return Response::json(['success' => false, 'errors' => Lang::get('app.exception')]);
				}
			}
			return Response::json(['success' => false, 'errors' => $mentorEntrepreneur->errors]);
		}
		App::abort(404);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
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
		//
	}


	public function confirm()
	{
		$user = Usuario::find(Input::get('u'));
		if(!$user instanceof Usuario) {
			App::abort(404);
		}

		$project = Proyecto::find(Input::get('p'));
		if(!$project instanceof Proyecto) {
			App::abort(404);
		}
		$mentorEntrepreneur = MentorEmprendimiento::getMentorEntrepreneur($user->codigo_usuario, $project->codigo_proyecto );
		if(!$mentorEntrepreneur instanceof MentorEmprendimiento) {
			App::abort(404);
		}

		DB::beginTransaction();
		try {
			MentorEmprendimiento::where('codigo_usuario', $user->codigo_usuario)->where('codigo_proyecto', $project->codigo_proyecto)
					->update(['codigo_estado' => Estado::getState('active')]);

	        $userProject = Usuario::find($project->codigo_usuario);
	        if(!$userProject instanceof Usuario) {
	            App::abort(404);
	        }
	        // Mail notification
	        $dataEntrepreneur = [];
	        $dataEntrepreneur['_subject'] = Lang::get('mentoring.request.entrepreneur.project.subject');
	        $dataEntrepreneur['_template'] = 'emails.mentoring.requestprojectconfirm';

	        // Data Template
	        $dataEntrepreneur['_name_user_action'] = $user->nombre_usuario;
	        $dataEntrepreneur['_url_user_action'] = URL::route('usuario.nickname',['nickname' =>$user->nickname_usuario], false);
	        $dataEntrepreneur['_to'] = $userProject->correo_electronico;
	        $dataEntrepreneur['_to_name'] = $userProject->nombre_usuario;
	        $dataEntrepreneur['_url_project'] = URL::route('proyecto.proyecto',['proyecto' =>$project->url_proyecto], false);
	        $dataEntrepreneur['_name_project'] = $project->nombre_proyecto;
	        $dataEntrepreneur['_url_user_action_owner'] = URL::route('mentoria.{rol?}.sesiones.index',['rol' => 'emprendedor'], false);

			SendEmail::notification($dataEntrepreneur);

			// Commit Transaction
			DB::commit();

			// Data for template confirm
			$datamentor = [];
			$datamentor['_message'] = Lang::get('mentoring.request.project.message.confirm',['project' => $project->nombre_proyecto]);
			$datamentor['_message_action'] = Lang::get('mentoring.request.project.message.confirm.view');
			$datamentor['_message_action_button'] = Lang::get('mentoring.request.project.button.schedule');
			$datamentor['_url_action'] = URL::route('usuario.nickname.tab',['nickname' => $user->nickname_usuario, 'tab'=>'calendario']);

			Auth::loginUsingId($user->codigo_usuario);
			return View::make('core/successconfirm', $datamentor);
		}catch(\Exception $e){
		    DB::rollback();
			Log::error($e->getMessage());
			return Response::json(array('success' => false, 'errors' => Lang::get('app.exception')));
		}
	}
}
