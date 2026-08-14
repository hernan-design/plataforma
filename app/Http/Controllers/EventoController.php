<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use TuProyecto;
use DB, Auth, Log, Lang, App;

use App\Evento, App\Estado, App\TipoEventoCalendario, App\TemaPrincipalEvento, App\TipoEvento, App\EventoInstitucion, App\AsesoriaInstitucion, App\RegistroSesion, App\Muro, App\Modulo, App\Canal, App\ContenidoCanal, App\Usuario;

class EventoController extends Controller {

	/**
     * Instantiate a new EventoController instance.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware('intended', ['only' => ['index', 'show']]);
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function index(Request $request)
	{
        $data = $request->all();

		if($request->ajax()){
			return response()->json(Evento::getEvents($data));
		}
		return view('public/calendar/main');
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
	 * @param  Request  $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		//dd('en store', $request->get('fecha_inicio'), $request->get('fecha_fin') );
		if ($request->ajax()) {
			$data = $request->all();
			$typeEvenCalendar = TipoEventoCalendario::getCalendarInstitution($request->codigo_tipo_evento);
			if(!$typeEvenCalendar instanceof TipoEventoCalendario) {
				$message = "EL tipo de evento no es válido";
				Log::error(sprintf('%s:%s', 'EventoController store',$message));
				return response()->json(['success' => false, 'errors' => $message]);
			}

			$event = new Evento;
			if ($event->isValid($data)) {
				DB::beginTransaction();
	        	try {
	        		$event->fill($data);
					$event->codigo_calendario = $typeEvenCalendar->codigo_calendario;
					$event->codigo_usuario = Auth::user()->codigo_usuario;
					$event->codigo_estado = Estado::getState('active');
					$event->privacidad_evento = false;
					$event->codigo_tema_principal_evento = $request->has('codigo_tema_principal_evento') ? (int) $request->codigo_tema_principal_evento : null;
					$event->url_evento = slugtp($event->nombre_evento, 'core.evento', 'url_evento');

		   			// Date start event
					if($request->has('fecha_inicio') && !empty($request->fecha_inicio)) {
						list($date, $time) = explode(' ', $request->fecha_inicio);
						$event->fecha_evento = $date;
						$event->hora_inicio_evento = $time;
					}

		   			// Date end event
					if($request->has('fecha_fin') && !empty($request->fecha_fin)) {
						list($date, $time) = explode(' ', $request->fecha_fin);
						$event->fecha_fin_evento = $date;
						$event->hora_fin_evento = $time;
					}



					$event->asistencia_evento = false;
					$event->save();


					$eventInstitution = new EventoInstitucion;
					$eventInstitution->codigo_evento = $event->codigo_evento;
					$eventInstitution->codigo_tipo_evento_calendario = $typeEvenCalendar->codigo_tipo_evento_calendario;
					$eventInstitution->codigo_institucion = RegistroSesion::getInstitution();
					$eventInstitution->codigo_estado = Estado::getState('active');
					// dd('datos ',$eventInstitution, $event);
					$eventInstitution->save();

					//creacon de mentoria
					if ($request->has('codigo_asesoria') && $request->codigo_asesoria != 0) {
						Evento::createMentoring($event);
					}

		   			// Channel
		   			$channel = null;
		   			if($request->has('url_canal') && !empty($request->url_canal)) {
		   				$channel = Canal::where('url_canal', $request->url_canal)->where('canal.codigo_institucion', RegistroSesion::getInstitution())->first();
		   				if(!$channel instanceof Canal) {
		   					throw new \Exception("No existe el canal ".$request->url_canal);
		   				}

		   				$cchannel = new ContenidoCanal;
		   				$cchannel->codigo_canal = $channel->codigo_canal;
		   				$cchannel->codigo_estado = Estado::getState('active');
		   				$cchannel->codigo_modulo = Modulo::getModule('calendar');
		   				$cchannel->codigo_recurso_modulo = $event->codigo_evento;
		   				$cchannel->save();
		   			}

					// Prepare response
					$response = new \stdClass();
					switch ($request->has('action')) {
						case 'wall':
							// Prepare data wall
							$data = [];
							$data['codigo_canal'] = $channel instanceof Canal ?  $channel->codigo_canal : null;
							$data['codigo_modulo'] = Modulo::getModule('calendar');
							$data['codigo_recurso_modulo'] = $event->codigo_evento;
							$data['texto_muro'] = sprintf('%s <a href="%s">Ver más</a>', $event->nombre_evento, route('calendario.evento.show', ['evento' => $event->url_evento]));

							$muro = Muro::store($data);
							if( !$muro instanceof Muro ) {
								throw new \Exception("Error creando post muro");
							}
							$response = Muro::buildPosts(Muro::getPosts($muro->codigo_muro));
						break;

						default:
							$response->codigo_evento = TuProyecto::encryptSrcParams([$event->codigo_evento]);
							$response->id = $event->codigo_evento;
							$response->start = $event->fecha_evento.'T'.$event->hora_inicio_evento;
							$response->end = $event->fecha_fin_evento.'T'.$event->hora_fin_evento;
							$response->className = 'available';
							$response->owner = true;
							$response->success = true;
						break;
					}
					// confirmacion de mentoría
					if ($request->has('codigo_asesoria') && $request->codigo_asesoria != 0) {
						$eventMen = Evento::find($event->codigo_evento);
						Evento::confirmMentoring($eventMen);
					}

					// Commit Transaction
					DB::commit();
					return response()->json($response);
				}catch(\Exception $e){
				    DB::rollback();
					Log::error(sprintf('%s:%s', 'EventoController store', $e->getMessage()));
					return response()->json(['success' => false, 'errors' => Lang::get('app.exception')]);
				}
			}
			return response()->json(array('success' => false, 'errors' => $event->errors));
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
        // Filters
		switch ($request->has('type')) {
			case 'encrypt':

				// Decrypt src-params
				list($codigo_evento) = TuProyecto::decryptSrcParams($id);
				if(!$codigo_evento || !is_numeric($codigo_evento)) {
					abort(403);
		 		}
		 		$event = Evento::getEvent($codigo_evento);
		        break;
		    default:
				$event = Evento::getUrlEvent($id);
				break;
		}

		if(!$event instanceof Evento) {
			if ($request->ajax()) {
				Log::error(sprintf('%s:%s', 'EventoController@show', 'Evento no encontrado' ));
				return response()->json(array('success' => false, 'errors' => Lang::get('app.exception')));
			}
            abort(404);
		}

		$eventDetail = Evento::buildEvent($event);
		if ($request->ajax()) {
			return response()->json($eventDetail);
		}

		$data['event'] = $eventDetail;
		return view('public/calendar/main', $data);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  Request  $request
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(Request $request, $id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  Request  $request
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		if ($request->ajax()) {
			// Decrypt src-params
			list($codigo_evento) = TuProyecto::decryptSrcParams($id);
			if(!$codigo_evento || !is_numeric($codigo_evento)) {
				abort(403);
			}

			$data = $request->all();

			$event = Evento::find($codigo_evento);
			if(!$event instanceof Evento) {
				abort(404);
			}

			$user = Usuario::find($event->codigo_usuario);
			if(!$user instanceof Usuario){
				abort(404);
			}

			$message = '';
			DB::beginTransaction();
			try {
				// Channel
	   			$channel = null;
	   			if($request->has('url_canal') && !empty($request->url_canal)) {
	   				$channel = Canal::where('url_canal', $request->url_canal)->where('canal.codigo_institucion', RegistroSesion::getInstitution())->first();
	   				if(!$channel instanceof Canal) {
	   					throw new \Exception("No existe el canal ".$request->url_canal);
	   				}

	   				$cchannel = ContenidoCanal::where('codigo_modulo', Modulo::getModule('calendar'))->where('codigo_recurso_modulo', $event->codigo_evento)->first();
	   				if(!$cchannel instanceof ContenidoCanal) {
		   				$cchannel->codigo_estado = Estado::getState('inactive');
	   					// throw new \Exception("No se puede asociar el canal con el contenido");
	   				}else {
		   				$cchannel->codigo_canal = $channel->codigo_canal;
		   				$cchannel->codigo_estado = Estado::getState('active');
	   				}
	   				$cchannel->save();
	   			}

				switch ( $request->has('action') && !empty($request->action) ? $request->action : '' ) {
					case 'schedule-mentoring':
						$message = Evento::scheduleMentoring($event);
						break;
					case 'confirm-mentoring':
						$message = Evento::confirmMentoring($event);
						break;
					case 'edit-event':
						$event->fill($data);
						// Date start event
						if($request->has('fecha_evento') && !empty($request->fecha_evento)) {
							list($date, $time) = explode(' ', $request->fecha_evento);
				   			$event->fecha_evento = $date;
							$event->hora_inicio_evento = $time;
						}

			   			// Date end event
						if($request->has('fecha_fin_evento') && !empty($request->fecha_fin_evento)) {
							list($date, $time) = explode(' ', $request->fecha_fin_evento);
				   			$event->fecha_fin_evento = $date;
							$event->hora_fin_evento = $time;
						}
						$event->save();

						$event->nombre_usuario = $user->nombre_usuario;
						$event->imagen_usuario = $user->imagen_usuario;
						$event->nickname_usuario = $user->nickname_usuario;
						$event->codigo_usuario = $user->codigo_usuario;

						$response = Evento::buildEvent($event);
						$response->success = true;
						$response->message = 'Datos editados correctamente';

						// Commit Transaction
						DB::commit();
						return response()->json($response);
						break;
					case 'wall':
						// get reference to wall entry
						$muro = Muro::find($request->codigo_muro);
						if(!$muro instanceof Muro) {
							throw new \Exception("Error actualizando post muro");
						}

						// update the event
						$message = Evento::updateEvent($event);

						// Prepare data wall
						$muro->codigo_canal = $channel instanceof Canal ?  $channel->codigo_canal : null;
						$muro->texto_muro = sprintf('%s <a href="%s">Ver más</a>', $event->nombre_evento, route('calendario.evento.show', ['evento' => $event->url_evento]));
						$muro->save();

						$response = Muro::buildPosts(Muro::getPosts($muro->codigo_muro));
						$response->success = true;

						// Commit Transaction
						DB::commit();
						return response()->json($response);
						break;
					default:
						$message = Evento::updateEvent($event);

						// Prepare response
						$response = new \stdClass();
						$response->id = $event->codigo_evento;
						$response->start = $event->fecha_evento.'T'.$event->hora_inicio_evento;
						$response->end = $event->fecha_fin_evento.'T'.$event->hora_fin_evento;
						$response->className = 'available';
						$response->success = true;

						// Commit Transaction
						DB::commit();
						return response()->json($response);
				}

				// Commit Transaction
				DB::commit();
				return response()->json(['success' => true, 'message' => $message]);
			}catch(\Exception $e){
			    DB::rollback();
				Log::error(sprintf('%s:%s', 'EventoController:update', $e->getMessage()));
				return response()->json(['success' => false, 'errors' => Lang::get('app.exception')]);
			}
		}
		abort(404);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  Request  $request
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Request $request, $id)
	{
		if ($request->ajax()) {
			// Decrypt src-params
			list($codigo_evento) = TuProyecto::decryptSrcParams($id);
			if(!$codigo_evento || !is_numeric($codigo_evento)) {
				abort(403);
			}
			$event = Evento::find($codigo_evento);
			if(!$event instanceof Evento) {
				abort(404);
			}
			// Validate user update event
			if(Auth::user()->codigo_usuario == $event->codigo_usuario) {
				DB::beginTransaction();
				try {
					// Set removed state
					Evento::where('codigo_evento', '=', $event->codigo_evento)
						->update(['codigo_estado' => Estado::getState('removed')]);

					// Update event institution
					EventoInstitucion::where('codigo_evento', $event->codigo_evento)->where('codigo_institucion', RegistroSesion::getInstitution())
						->update(['codigo_estado' => Estado::getState('removed')]);

					DB::commit();
					return response()->json(array('success' => true));
				}catch(\Exception $e){
					DB::rollback();
					Log::error($e->getMessage());
					return response()->json(array('success' => false, 'errors' => Lang::get('app.exception')));
				}
			}
			abort(403);
		}
    	abort(404);
	}

	 /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function temaseventolist(Request $request)
    {
        if($request->ajax()){
			$data = [];

				$query = TemaPrincipalEvento::query();
				$query->select('tema_principal_evento.codigo_tema_principal_evento as id', DB::raw("trim(COALESCE(initcap(nombre_tema_principal_evento), '')) as text"));
				$query->join('core.tema_principal_institucion', function($join) {
					$join->on('tema_principal_evento.codigo_tema_principal_evento', '=', 'tema_principal_institucion.codigo_tema_principal_evento')
					->where('tema_principal_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
					->where('tema_principal_institucion.codigo_estado', '=', Estado::getState('active'));
				});
				if($request->has('id') ){
					$query->where("tema_principal_evento.codigo_tema_principal_evento", "=", $request->id);
				}

				if($request->has('q')) {
					$query->where( function($query) use($request) {
						$query->whereRaw("tema_principal_evento.nombre_tema_principal_evento ilike '%".$request->q."%'");
					});
				}

				if($request->has('dataId') &&  is_numeric($request->dataId) && (int) $request->dataId > 0 ) {
					$query->where("tema_principal_evento.codigo_tema_principal_evento", "=",(int) $request->dataId);
				}

                $query->orderby('tema_principal_evento.nombre_tema_principal_evento','asc');

				$data = $query->limit( 1000 )->get();
				$data = $query->get();
				// dd($data);

            return response()->json($data);
		}

		abort('404');
    }
}
