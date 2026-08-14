<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use TuProyecto, Auth, Log, DB, Lang, SendEmail;

use App\{Estado, Evento,
	RegistroSesion, RolUsuario,
	Usuario, UsuarioEvento,
	UsuarioInstitucion,};

class UsuarioEventoController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function index(Request $request)
	{
		if($request->ajax()){
			return response()->json( UsuarioEvento::usuariosEventoList( $request->all() ) );
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		if($request->ajax()){
			list($codigo_evento) = TuProyecto::decryptSrcParams($request->codigo_evento);
			if(!$codigo_evento || !is_numeric($codigo_evento)) {
				abort(403);
			}

			$userInstitution = UsuarioInstitucion::where('codigo_institucion', RegistroSesion::getInstitution())
				->where('codigo_usuario', Auth::user()->codigo_usuario)->first();
			if(!$userInstitution instanceof UsuarioInstitucion){
				abort(404);
			}

			$event = Evento::find($codigo_evento);
			if(!$event instanceof Evento){
				abort(404);
			}

			$user = Usuario::getDataUser(Auth::user()->nickname_usuario);
			if(!$user instanceof Usuario) {
				abort(404);
			}

			//Consulta slug de la institución actual almacenado en cookies.
			$slug_institution = RegistroSesion::getInstitutionSlug();

			//Consulta codigo_institucion de la institución actual almacenado en cookies.
			$id_institution = RegistroSesion::getInstitution();

			switch ($slug_institution) {
				case 'compensar':

					//Valida si el usuario cuenta con el rol vinculado (39).
					$has_rol_associated = RolUsuario::getRoleAssociated($user->codigo_usuario, $id_institution);

					if ($has_rol_associated) {
						//Registra al usuario (persona) en el evento.
						$response = $this->participateEvent($event, $codigo_evento, $request, $user, $userInstitution);
						return response()->json($response);
					} else {
						//Notifica al usuario que no cuenta con rol vinculado.
						$response = new \stdClass();
						$response->message = "¡Para acceder a este servicio, debes estar activo en nuestro programa de emprendimiento.
							Para mayor información escríbenos a fomentoempresarial@compensar.com!";
						$response->check = false;
						return response()->json($response);
					}

				break;

				default:
					//Registra al usuario (persona) en el evento.
					$response = $this->participateEvent($event, $codigo_evento, $request, $user, $userInstitution);
					return response()->json($response);
				break;
			}
		}
		abort(404);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  Request  $request
	 * @param  int  $id
	 * @return Response
	 */
	public function show(Request $request, $id)
	{
		if($request->ajax()){
			$userEvent = UsuarioEvento::find($id);
			if(!$userEvent instanceof UsuarioEvento){
				abort(404);
			}

			$userEvent->register = true;
			return response()->json( $userEvent );
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  Request  $request
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $userEvent = UsuarioEvento::findOrFail($id);

		$event = Evento::find($userEvent->codigo_evento);
		if(!$event instanceof Evento) {
			abort(404);
		}

		$userEvent->delete();

		activity()
			->performedOn($userEvent)
			->withProperties([
				'attributes' => [
					'title' => $event->nombre_evento,
					'user' => Auth::user()->nombre_usuario,
					'user_id' => Auth::user()->codigo_usuario
				] ])
			->log('activitylog.event.unsuscribe');

		return response()->json(['success' => true]);
	}
	/**
	 * Guarda el registro del usuario (persona) que desea participar en un evento, posterior envia email del registro.
	 *
	 * @access public
	 * @param mixed $event, $codigo_evento, $request, $user, $userInstitution
	 * @return object $response
	 */
	public function participateEvent($event, int $codigo_evento, $request, $user, $userInstitution)
	{
		$userEvent = new UsuarioEvento;

		DB::beginTransaction();

		try {
			$userEvent->codigo_evento = $codigo_evento;
			$userEvent->codigo_estado = Estado::getState('active');
			$userEvent->codigo_usuario_institucion = $userInstitution->codigo_usuario_institucion;
			$userEvent->fecha_usuario_evento =  date('Y-m-d H:m:s');
			$userEvent->save();

			activity()
				->performedOn($userEvent)
				->withProperties([
					'attributes' => [
						'title' => $event->nombre_evento,
						'user' => Auth::user()->nombre_usuario,
						'user_id' => Auth::user()->codigo_usuario
					] ])
				->log('activitylog.event.inscription');

			$response = $userEvent;
			$response->codigo_evento = $request->codigo_evento;
			$response->nickname_usuario = $user->nickname_usuario;
			$response->imagen_usuario = $user->imagen_usuario;
			$response->nombre_usuario = $user->nombre_usuario;
			$response->nombre_nivel_educacion = $user->nombre_nivel_educacion;
			$response->success = true;
			$response->message = '¡Te has registrado correctamente!';
			$response->register = true;
			$response->check = true;

			// Queue::push('App\UsuarioEvento@notification', [
			// 	'codigo_evento' => $event->codigo_evento ,
			// 	'codigo_usuario' => $user->codigo_usuario ]);

			$horaInicio = date_create($event->hora_inicio_evento);
			$horaInicio = date_format($horaInicio, "H:i A");
			$horaFin = date_create($event->hora_fin_evento);
			$horaFin = date_format($horaFin, "H:i A");

			if (isset($event->url_meet_evento)) {
				$url_meet = $event->url_meet_evento;
			} elseif (isset($event->others_urls_meeting)) {
				$url_meet = $event->others_urls_meeting;
			} else {
				$url_meet = null;
			}

			$data = array();
			$data['_inst'] = RegistroSesion::getInstitution();
			$data['_subject'] = Lang::get('event.mail.participate.subject');
			$data['_template'] = 'emails.event.notification';
			$data['_to'] = $user->correo_electronico;
			$data['_to_name'] = $user->nombre_usuario;
			$data['_event_name'] = $event->nombre_evento;
			$data['_event_date'] = $event->fecha_evento;
			$data['_event_place'] = $event->lugar_evento;
			$data['_event_hour'] = "$horaInicio - $horaFin";
			$data['_url_meet'] = $url_meet;
			$data['_url_action'] = route('calendario.evento.show', ['evento' => $event->url_evento]);
			SendEmail::notification($data);

			DB::commit();
			return $response;

		}catch(\Exception $e){
			DB::rollback();
			Log::error(sprintf('%s:%s', 'UsuarioEventoController store', $e->getMessage()));
			return response()->json(['success' => false, 'errors' => Lang::get('app.exception')]);
		}
	}
}
