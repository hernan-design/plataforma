<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models, App\Rol, App\Evento, App\Encuesta;

use TuProyecto;

use DB, Input, Auth, Log, Artisan, Config, Validator, Lang, URL, SendEmail;

class Mentoria extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'aprende.mentoria';

	protected $primaryKey = 'codigo_mentoria';

	public $timestamps = false;

	public function isValid($data)
    {
        $rules = array(
            'descripcion_mentoria' => 'required|string|words:1,200',
            'objetivos_mentoria' => 'required'
        );

     	$validator = Validator::make($data, $rules);
        if ($validator->passes()) {
     		return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getMentorings()
   	{
   		$sessions = array();
		$query = Mentoria::query();
		$query->select('mentoria.codigo_mentoria', 'evento.codigo_estado','mentoria.seg_codigo_usuario', 'mentoria.codigo_usuario', 'descripcion_mentoria', 'fecha_mentoria', 'hora_mentoria',
			'calificacion_mentoria','evento.codigo_evento', 'estado.nombre_estado', 'estado.codigo_estado','evento.fecha_evento','evento.fecha_fin_evento', 'evento.hora_inicio_evento','evento.hora_fin_evento','evaluacion_mentoria.codigo_evaluacion_mentoria', 'evaluacion_tarea.codigo_evaluacion_tarea',
			// Entrepreneur data
			DB::raw("emprendedor.codigo_usuario as emprendedor"),
			DB::raw("(CASE emprendedor.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN emprendedor.nombre_usuario || ' ' || COALESCE(pemprendedor.primer_apellido_persona, '') || ' ' || COALESCE(pemprendedor.segundo_apellido_persona, '') ELSE emprendedor.nombre_usuario END) as nombre_usuario_emprendedor"),

			DB::raw("COALESCE(emprendedor.imagen_usuario, '".Config::get('tuproyecto.avatar_image')."') as imagen_usuario_emprendedor"),
			DB::raw("emprendedor.nickname_usuario as nickname_usuario_emprendedor"),
			// Mentor data
			DB::raw("mentor.codigo_usuario as mentor"),
			DB::raw("(CASE mentor.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN mentor.nombre_usuario || ' ' || COALESCE(pmentor.primer_apellido_persona, '') || ' ' || COALESCE(pmentor.segundo_apellido_persona, '') ELSE mentor.nombre_usuario END) as nombre_usuario_mentor"),

			DB::raw("COALESCE(mentor.imagen_usuario, '".Config::get('tuproyecto.avatar_image')."') as imagen_usuario_mentor"),
			DB::raw("mentor.nickname_usuario as nickname_usuario_mentor"));

		$query->join('core.evento', 'mentoria.codigo_evento', '=', 'evento.codigo_evento');
		$query->join('core.estado', 'evento.codigo_estado', '=', 'estado.codigo_estado');

		// Users mentoring
		$query->join('seguridad.usuario as mentor', 'mentoria.seg_codigo_usuario', '=', 'mentor.codigo_usuario');
		$query->leftJoin('core.persona as pmentor', 'mentor.codigo_usuario', '=', 'pmentor.codigo_usuario');
		$query->leftJoin('core.usuario_institucion as imentor', function($join) {
            $join->on('mentor.codigo_usuario', '=', 'imentor.codigo_usuario')
             ->where('imentor.codigo_institucion', '=', RegistroSesion::getInstitution());
		   });

		$query->join('seguridad.usuario as emprendedor', 'mentoria.codigo_usuario', '=', 'emprendedor.codigo_usuario');
		$query->leftJoin('core.persona as pemprendedor', 'emprendedor.codigo_usuario', '=', 'pemprendedor.codigo_usuario');
		$query->leftJoin('core.usuario_institucion as iemprendedor', function($join) {
            $join->on('emprendedor.codigo_usuario', '=', 'iemprendedor.codigo_usuario')
             ->where('iemprendedor.codigo_institucion', '=', RegistroSesion::getInstitution());
		   });

		// Evaluation
		$query->leftJoin('aprende.evaluacion_mentoria', 'mentoria.codigo_mentoria', '=', 'evaluacion_mentoria.codigo_mentoria');
		$query->leftJoin('aprende.evaluacion_tarea', 'mentoria.codigo_mentoria', '=', 'evaluacion_tarea.codigo_mentoria');

		// Filter institution
		$query->join('aprende.mentoria_institucion', function($join) {
       		$join->on('mentoria.codigo_mentoria', '=', 'mentoria_institucion.codigo_mentoria')
				->where('mentoria_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('mentoria_institucion.codigo_estado', '=', Estado::getState('active'));
      	});

		// Filters
		switch (Input::get('rol')) {
			case 'mentor':
				$query->where('mentoria.seg_codigo_usuario', Auth::user()->codigo_usuario);
				break;
			default:
				$query->where('mentoria.codigo_usuario', Auth::user()->codigo_usuario);
				break;
		}

		// Get total posts
		$total_entries = $query->get()->count();

   		$query->orderBy('evento.fecha_evento','desc');
   		$query->orderBy('evento.hora_inicio_evento','desc');

		// Get posts
		$data = $query->skip(Input::get('offset'))->take(Input::get('limit'))->get();

		if(count($data) > 0) {
			foreach ($data as $session) {
				$sesion_mentoria = new \stdClass();
				$sesion_mentoria->codigo_mentoria = TuProyecto::encryptSrcParams([$session->codigo_mentoria]);
				$sesion_mentoria->descripcion_mentoria = $session->descripcion_mentoria;
				$sesion_mentoria->url_mentoria = sprintf("%s-%s", 'sesion', $session->codigo_mentoria);
				$sesion_mentoria->codigo_evento = $session->codigo_evento;
				$sesion_mentoria->estado_evento = $session->codigo_estado;
				$sesion_mentoria->codigo_usuario = $session->codigo_usuario;
				$sesion_mentoria->seg_codigo_usuario = $session->seg_codigo_usuario;
				$sesion_mentoria->nombre_estado = $session->nombre_estado;
				$sesion_mentoria->fecha_evento = $session->fecha_evento;
				$sesion_mentoria->fecha_fin_evento = $session->fecha_fin_evento;
				$sesion_mentoria->hora_inicio_evento = $session->hora_inicio_evento;
				$sesion_mentoria->hora_fin_evento = $session->hora_fin_evento;
				$sesion_mentoria->mentor = Auth::user()->codigo_usuario == $session->mentor ? true : false;
				$sesion_mentoria->emprendedor = Auth::user()->codigo_usuario == $session->emprendedor ? true : false;

				$sesion_mentoria->nombre_usuario_emprendedor = $session->nombre_usuario_emprendedor;
				$sesion_mentoria->imagen_usuario_emprendedor = $session->imagen_usuario_emprendedor;
				$sesion_mentoria->nickname_usuario_emprendedor = $session->nickname_usuario_emprendedor;

				$sesion_mentoria->nombre_usuario_mentor = $session->nombre_usuario_mentor;
				$sesion_mentoria->imagen_usuario_mentor = $session->imagen_usuario_mentor;
				$sesion_mentoria->nickname_usuario_mentor = $session->nickname_usuario_mentor;

				$sesion_mentoria->evaluacion = false;
				if( sprintf("%s %s", $session->fecha_fin_evento, $session->hora_fin_evento) <= date('Y-m-d H:i:s') && $session->codigo_estado == Estado::getState('confirmed') ){
					$sesion_mentoria->evaluacion = true;
				}

				$sesion_mentoria->codigo_evaluacion_mentoria = $session->codigo_evaluacion_mentoria;
				$sesion_mentoria->codigo_evaluacion_tarea = $session->codigo_evaluacion_tarea;

				$sessions[] = $sesion_mentoria;
			}
		}

		$response = new \stdClass();
		$response->total_entries = $total_entries;
		$response->items = $sessions;
   		return $response;
   	}

	public static function getMentoringEvent($event) {
		return Mentoria::select('mentoria.*','mi.codigo_institucion')->where('mentoria.codigo_evento', '=', $event)
		->join('aprende.mentoria_institucion as mi', 'mentoria.codigo_mentoria', '=', 'mi.codigo_mentoria')
		->whereNotIn('mentoria.codigo_estado', [Estado::getState('removed')])
		->orderBy('mentoria.codigo_evento','desc')->first();
    }

    public static function getMentoring($codigo_mentoria)
   	{
   		$query = Mentoria::query();
        $query->select('mentoria.codigo_mentoria', 'mentoria.seg_codigo_usuario', 'mentoria.codigo_usuario', 'descripcion_mentoria', 'fecha_mentoria', 'hora_mentoria', 'calificacion_mentoria','evento.codigo_evento', 'estado.codigo_estado', 'estado.nombre_estado', 'evento.fecha_evento', 'evento.fecha_fin_evento', 'evento.hora_inicio_evento', 'evento.hora_fin_evento', 'evaluacion_mentoria.codigo_evaluacion_mentoria', 'evaluacion_tarea.codigo_evaluacion_tarea',
        	// Entrepreneur data
			DB::raw("emprendedor.codigo_usuario as emprendedor"),
			DB::raw("(CASE emprendedor.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN emprendedor.nombre_usuario || ' ' || COALESCE(pemprendedor.primer_apellido_persona, '') || ' ' || COALESCE(pemprendedor.segundo_apellido_persona, '') ELSE emprendedor.nombre_usuario END) as nombre_usuario_emprendedor"),
			DB::raw("COALESCE(emprendedor.imagen_usuario, '".Config::get('tuproyecto.avatar_image')."') as imagen_usuario_emprendedor"),
			DB::raw("emprendedor.nickname_usuario as nickname_usuario_emprendedor"),
			// Mentor data
			DB::raw("mentor.codigo_usuario as mentor"),
			DB::raw("(CASE mentor.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN mentor.nombre_usuario || ' ' || COALESCE(pmentor.primer_apellido_persona, '') || ' ' || COALESCE(pmentor.segundo_apellido_persona, '') ELSE mentor.nombre_usuario END) as nombre_usuario_mentor"),

			DB::raw("COALESCE(mentor.imagen_usuario, '".Config::get('tuproyecto.avatar_image')."') as imagen_usuario_mentor"),
			DB::raw("mentor.nickname_usuario as nickname_usuario_mentor"));

		$query->join('core.evento', 'mentoria.codigo_evento', '=', 'evento.codigo_evento');
		$query->join('core.estado', 'evento.codigo_estado', '=', 'estado.codigo_estado');

		// Users mentoring
		$query->join('seguridad.usuario as mentor', 'mentoria.seg_codigo_usuario', '=', 'mentor.codigo_usuario');
		$query->leftJoin('core.persona as pmentor', 'mentor.codigo_usuario', '=', 'pmentor.codigo_usuario');
		$query->leftJoin('core.usuario_institucion as imentor', function($join) {
            $join->on('mentor.codigo_usuario', '=', 'imentor.codigo_usuario')
             ->where('imentor.codigo_institucion', '=', RegistroSesion::getInstitution());
		});

		$query->join('seguridad.usuario as emprendedor', 'mentoria.codigo_usuario', '=', 'emprendedor.codigo_usuario');
		$query->leftJoin('core.persona as pemprendedor', 'emprendedor.codigo_usuario', '=', 'pemprendedor.codigo_usuario');


		// Evaluation
		$query->leftJoin('aprende.evaluacion_mentoria', 'mentoria.codigo_mentoria', '=', 'evaluacion_mentoria.codigo_mentoria');
		$query->leftJoin('aprende.evaluacion_tarea', 'mentoria.codigo_mentoria', '=', 'evaluacion_tarea.codigo_mentoria');

		$query->where('mentoria.codigo_mentoria', $codigo_mentoria);
		return $query->first();
   	}

    /**
	 * Build Mentoring.
	*/
   	public static function buildMentoring($mentoring)
   	{

		$object = new \stdClass();
		$object->codigo_mentoria = TuProyecto::encryptSrcParams([$mentoring->codigo_mentoria]);
		$object->descripcion_mentoria = $mentoring->descripcion_mentoria;
		$object->fecha_evento = $mentoring->fecha_evento;
		$object->fecha_fin_evento = $mentoring->fecha_fin_evento;
		$object->hora_inicio_evento = $mentoring->hora_inicio_evento;
		$object->hora_fin_evento = $mentoring->hora_fin_evento;

		$object->nombre_usuario_emprendedor = $mentoring->nombre_usuario_emprendedor;
		$object->imagen_usuario_emprendedor = $mentoring->imagen_usuario_emprendedor;
		$object->nickname_usuario_emprendedor = $mentoring->nickname_usuario_emprendedor;

		$object->nombre_usuario_mentor = $mentoring->nombre_usuario_mentor;
		$object->imagen_usuario_mentor = $mentoring->imagen_usuario_mentor;
		$object->nickname_usuario_mentor = $mentoring->nickname_usuario_mentor;

		$object->url_mentoria = sprintf("%s-%s", 'sesion', $mentoring->codigo_mentoria);

		// Valid date available evaluation
		$object->evaluacion = false;
		if( sprintf("%s %s", $mentoring->fecha_fin_evento, $mentoring->hora_fin_evento) <= date('Y-m-d H:i:s') && $mentoring->codigo_estado == Estado::getState('confirmed') ){
			$object->evaluacion = true;
		}
		$object->codigo_evaluacion_mentoria = $mentoring->codigo_evaluacion_mentoria;
		$object->codigo_evaluacion_tarea = $mentoring->codigo_evaluacion_tarea;

		$dataobjectives = $mentoring->objetivos()->where('codigo_estado', Estado::getState('active'))->get();
		$objectives = [];
		if(count($dataobjectives) > 0) {
			foreach ($dataobjectives as $objective) {
				$objetivo = new \stdClass();
				$objetivo->descripcion_objetivo_mentoria = $objective->descripcion_objetivo_mentoria;
				$objectives[] = $objetivo;
			}
		}
		$object->objetivos = $objectives;

		$object->mentor = Auth::user()->codigo_usuario == $mentoring->mentor ? true : false;
		$object->emprendedor = Auth::user()->codigo_usuario == $mentoring->emprendedor ? true : false;

		return $object;
   	}

	/**
	* Job Queue notification mail.
	*/
  	public function notification($job, $data)
    {
	    $mentoring = Mentoria::find($data['codigo_mentoria']);
	    if(!$mentoring instanceof Mentoria) {
	      throw new \Exception("Mentoring not found");
	    }
	    $event = Evento::find($data['codigo_evento']);
	    if(!$event instanceof Evento) {
	      throw new \Exception("Event not found");
		}

		$url_survey = null;


		if(RegistroSesion::institution()->modelo_negocio_institucion){
			$encuestaInstitucion = EncuestaInstitucion::where('codigo_institucion', RegistroSesion::getInstitution())
			->where('codigo_lugar_aplicacion', LugarAplicacion::getPlace('projects'))
			->where('codigo_estado', Estado::getState('active'))
			->first();

			if($encuestaInstitucion  instanceof EncuestaInstitucion) {
				$survey = Encuesta::find($encuestaInstitucion->codigo_encuesta);
				if($survey instanceof Encuesta) {
					$url_survey = $survey->url_encuesta;
				}
			}
		}

	    // Mail notification User
	    $data = array();
	    $data['_subject'] = Lang::get('mentoring.mail.request.subject',['user' => $mentoring->usuario->nombre_usuario]);
	    $data['_template'] = 'emails.mentoring.request';

	    // Data Template
	    $dataobjectives = $mentoring->objetivos()->where('codigo_estado', Estado::getState('active'))->get();
		$objectives = [];
		if(count($dataobjectives) > 0) {
			foreach ($dataobjectives as $objective) {
				$objetivo = new \stdClass();
				$objetivo->descripcion_objetivo_mentoria = $objective->descripcion_objetivo_mentoria;
				$objectives[] = $objetivo;
			}
		}
	    $data['descripcion_mentoria'] = $mentoring->descripcion_mentoria;
	    $data['objetivos_mentoria'] = $objectives;
	    $data['_url_user_action'] = URL::route('usuario.nickname',['nickname' => $mentoring ->usuario->nickname_usuario], false);
	    $data['_name_user_action'] = $mentoring->usuario->nombre_usuario;
	    $data['_to'] = $event->usuario->correo_electronico;
	    $data['_to_name'] = $event->usuario->nombre_usuario;
	    $data['_url_user_action_owner'] = URL::route('usuario.nickname.tab',['nickname' => $event ->usuario->nickname_usuario, 'tab' => 'calendario'], false);
	    $data['date_start'] = sprintf("%s %s", TuProyecto::dateFormat($event->fecha_evento, $type="complete"), TuProyecto::timeFormat($event->hora_inicio_evento));
	    $data['date_end'] = sprintf("%s %s", TuProyecto::dateFormat($event->fecha_fin_evento, $type="complete"), TuProyecto::timeFormat($event->hora_fin_evento));
		$data['_url_survey'] = $url_survey;
		$data['_url_survey_action'] = sprintf('/encuesta/aplicar/%s/%s', $url_survey ,TuProyecto::encryptSrcParams([$mentoring->usuario->codigo_usuario]));
		$data['lugar_evento'] = $event->lugar_evento;
		SendEmail::notification($data);


	    // Delete Job
	    $job->delete();
  	}

    /**
	* Job Queue notification mail Confirm Evento.
	*/
  	public function notificationConfirm($job, $data)
    {
	    $mentoring = Mentoria::find($data['codigo_mentoria']);
	    if(!$mentoring instanceof Mentoria) {
	      throw new \Exception("Mentoring not found");
	    }
	    $event = Evento::find($data['codigo_evento']);
	    if(!$event instanceof Evento) {
	      throw new \Exception("Event not found");
		}
		$institucion = Institucion::find($data['codigo_institucion']);
	    if(!$event instanceof Evento) {
	      throw new \Exception("Event not found");
		}

		Artisan::call('googleapi:makementorconference', [
			'mentoringID' => $mentoring->codigo_mentoria,
			'sessionID' => $event->codigo_evento,
			'institution' => $institucion->codigo_institucion
		]);

	    // Delete Job
	    $job->delete();
  	}

  	/**
	* Job Queue notification mail Confirm Evento.
	*/
  	public function evaluationMentoring($job, $data)
    {

	    $mentoring = Mentoria::find($data['codigo_mentoria']);
	    if(!$mentoring instanceof Mentoria) {
	      throw new \Exception("Mentoring not found");
	    }
	    $event = Evento::find($mentoring->codigo_evento);
	    if(!$event instanceof Evento) {
	      throw new \Exception("Event not found");
	    }
	    // Mail notification
	    $data = [];
	    $data['_subject'] = Lang::get('mentoring.mail.evaluation.mentor.subject');
	    $data['_template'] = 'emails.mentoring.evaluation.pendingmentor';

	    // Data Template
	    $data['_name_user_action'] = $event->usuario->nombre_usuario;
	    $data['_url_user_action'] = URL::route('usuario.nickname',['nickname' => $event ->usuario->nickname_usuario], false);
	    $data['_to'] = $event->usuario->correo_electronico;
	    $data['_to_name'] = $event->usuario->nombre_usuario;
	    $data['_url_qualification'] = URL::route('mentoria.evaluacion.sesion.create',['m' => TuProyecto::encryptSrcParams([$mentoring->codigo_mentoria])], false);

	    SendEmail::notification($data);

	    // Delete Job
	    $job->delete();
	  }

	public static function getMentors(array $filter = null) {
		$mentorings = [];
		$query = Mentoria::query();
		$query->select(
			'mentoria.codigo_mentoria',
			'mentoria.duration_mentoring',
			'mentoria.objetivo_mentor', 'emprendedor.identificacion_usuario',
			'mentoria.descripcion_mentoria as descripcion',
			'mentoria.fecha_mentoria as fecha',
			'mentoria.hora_mentoria as hora',
			'mentoria.fase',
			'mentoria.recomendacion',
			'mentoria.seguimiento',
			'mentoria.asignacion_voucher',
			'mentoria.diagnostico',
			DB::raw('mentoria.codigo_estado as codigo_estado'),
			// Mentor data
			DB::raw('mentor.codigo_usuario as mentor'),
			DB::raw("(CASE mentor.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN mentor.nombre_usuario || ' ' || COALESCE(pmentor.primer_apellido_persona, '') || ' ' || COALESCE(pmentor.segundo_apellido_persona, '') ELSE mentor.nombre_usuario END) as nombre_usuario_mentor"),
			DB::raw("COALESCE(mentor.imagen_usuario, '".Config::get('tuproyecto.avatar_image')."') as imagen_usuario_mentor"),
			DB::raw("mentor.nickname_usuario as nickname_usuario_mentor"),
			DB::raw("mentor.nombre_usuario as short_name_mentor"),
			DB::raw("imentor.ultimo_ingreso_usuario as ultimo_ingreso_mentor"),

			// Entrepreneur data
			DB::raw('emprendedor.codigo_usuario as emprendedor'),
			DB::raw("(CASE emprendedor.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN emprendedor.nombre_usuario || ' ' || COALESCE(pemprendedor.primer_apellido_persona, '') || ' ' || COALESCE(pemprendedor.segundo_apellido_persona, '') ELSE emprendedor.nombre_usuario END) as nombre_usuario_emprendedor"),
			DB::raw("COALESCE(emprendedor.imagen_usuario, '".Config::get('tuproyecto.avatar_image')."') as imagen_usuario_emprendedor"),
			DB::raw("emprendedor.nickname_usuario as nickname_usuario_emprendedor"),
			DB::raw("emprendedor.nombre_usuario as short_name_emprendedor"),
			DB::raw("iemprendedor.ultimo_ingreso_usuario as ultimo_ingreso_emprendedor"),
			'eventoS.fecha_evento as fecha_evento',
			'eventoS.hora_inicio_evento as hora_inicio'
		);

		// Mentor data
		$query->join('seguridad.usuario as mentor', 'mentor.codigo_usuario', '=', 'mentoria.seg_codigo_usuario');
		$query->leftJoin('core.persona as pmentor', 'pmentor.codigo_usuario', '=', 'mentor.codigo_usuario');
		$query->leftJoin('core.usuario_institucion as imentor', function($join) {
            $join->on('mentor.codigo_usuario', '=', 'imentor.codigo_usuario')
             ->where('imentor.codigo_institucion', '=', RegistroSesion::getInstitution());
		   });

		// Entrepreneur data
		$query->join('seguridad.usuario as emprendedor', 'emprendedor.codigo_usuario', '=', 'mentoria.codigo_usuario');
		$query->leftJoin('core.persona as pemprendedor', 'pemprendedor.codigo_usuario', 'emprendedor.codigo_usuario');
		$query->leftJoin('core.usuario_institucion as iemprendedor', function($join) {
            $join->on('emprendedor.codigo_usuario', '=', 'iemprendedor.codigo_usuario')
             ->where('iemprendedor.codigo_institucion', '=', RegistroSesion::getInstitution());
		   });

		//hora evento o sesion
		$query->join('core.evento as eventoS', 'eventoS.codigo_evento', '=', 'mentoria.codigo_evento');

		$query->join('aprende.mentoria_institucion', function($join) {
			$join->on('mentoria_institucion.codigo_mentoria', '=', 'mentoria.codigo_mentoria')
				->where('mentoria_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->whereNotIn('mentoria_institucion.codigo_estado', [ Estado::getState('removed') ]);
		});

		$query->where(function($query){
			$query->where('mentor.codigo_usuario', '=', Auth::user()->codigo_usuario)
				->orWhere('emprendedor.codigo_usuario', '=', Auth::user()->codigo_usuario);
		});

		$query->whereNotIn('mentoria.codigo_estado', [ Estado::getState('removed') ]);

		if(isset($filter['codigo_asesoria']) && !empty($filter['codigo_asesoria']) ){
			$query->where('mentoria.codigo_asesoria', $filter['codigo_asesoria']);
		}

		//filter list sessions 
			if (isset($filter['state']) && $filter['state']) {
			$state = $filter['state'];
			$query->where('mentoria.codigo_estado', $state);
		}

		if (isset($filter['date_mentoring']) && $filter['date_mentoring']) {

			$query->where( 'mentoria.fecha_mentoria', '>=', $date = date('Y m d') );
		}
		
		$query->orderBy('codigo_mentoria', 'desc');
		// Get total posts
		$total_entries = $query->get()->count();
		$data = $query->get();

		if(count($data) > 0) {
			foreach ($data as $itemMentoring) {
				$mentorings[] = Mentoria::buildMentoringSession($itemMentoring);
			}
		}

		$response = new \stdClass();
		$response->total_entries = $total_entries;
		$response->items = $mentorings;
   		return $response;
	}

	  public static function getMentor($mentor)
	  {
		$mentorings = [];
		$query = Mentoria::query();
		$query->select(
			'mentoria.codigo_mentoria', 'emprendedor.identificacion_usuario', 'mentoria.descripcion_mentoria as descripcion', 'mentoria.fecha_mentoria as fecha', 'mentoria.hora_mentoria as hora',
			'mentoria_institucion.codigo_estado',
			// Mentor data
			DB::raw('mentor.codigo_usuario as mentor'),
			DB::raw("(CASE mentor.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN mentor.nombre_usuario || ' ' || COALESCE(pmentor.primer_apellido_persona, '') || ' ' || COALESCE(pmentor.segundo_apellido_persona, '') ELSE mentor.nombre_usuario END) as nombre_usuario_mentor"),
			DB::raw("COALESCE(mentor.imagen_usuario, '".Config::get('tuproyecto.avatar_image')."') as imagen_usuario_mentor"),
			DB::raw("mentor.nickname_usuario as nickname_usuario_mentor"),
			DB::raw("mentor.nombre_usuario as short_name_mentor"),

			// Entrepreneur data
			DB::raw('emprendedor.codigo_usuario as emprendedor'),
			DB::raw("(CASE emprendedor.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN emprendedor.nombre_usuario || ' ' || COALESCE(pemprendedor.primer_apellido_persona, '') || ' ' || COALESCE(pemprendedor.segundo_apellido_persona, '') ELSE emprendedor.nombre_usuario END) as nombre_usuario_emprendedor"),
			DB::raw("COALESCE(emprendedor.imagen_usuario, '".Config::get('tuproyecto.avatar_image')."') as imagen_usuario_emprendedor"),
			DB::raw("emprendedor.nickname_usuario as nickname_usuario_emprendedor"),
			DB::raw("emprendedor.nombre_usuario as short_name_emprendedor")
		);

		// Mentor data
		$query->join('seguridad.usuario as mentor', 'mentor.codigo_usuario', '=', 'mentoria.seg_codigo_usuario');
		$query->leftJoin('core.persona as pmentor', 'pmentor.codigo_usuario', '=', 'mentor.codigo_usuario');
		$query->leftJoin('core.usuario_institucion as imentor', function($join) {
            $join->on('mentor.codigo_usuario', '=', 'imentor.codigo_usuario')
             ->where('imentor.codigo_institucion', '=', RegistroSesion::getInstitution());
	   	});

		   // Entrepreneur data
		$query->join('seguridad.usuario as emprendedor', 'emprendedor.codigo_usuario', '=', 'mentoria.codigo_usuario');
		$query->leftJoin('core.persona as pemprendedor', 'pemprendedor.codigo_usuario', 'emprendedor.codigo_usuario');
		$query->leftJoin('core.usuario_institucion as iemprendedor', function($join) {
            $join->on('emprendedor.codigo_usuario', '=', 'iemprendedor.codigo_usuario')
             ->where('iemprendedor.codigo_institucion', '=', RegistroSesion::getInstitution());
	   	});
		$query->join('aprende.mentoria_institucion', function($join) {
			$join->on('mentoria_institucion.codigo_mentoria', '=', 'mentoria.codigo_mentoria')
				->where('mentoria_institucion.codigo_institucion', '=', RegistroSesion::getInstitution());
		});

		$query->where('mentoria.codigo_mentoria', '=', $mentor);

		// Get total posts
		$total_entries = $query->get()->count();
		$data = $query->first();

		if (isset($data) && !empty($data)) {
			$mentorings = Mentoria::buildMentorngSession($data);
			$mentorings->total_entries = $total_entries;
		} else {
			$mentorings['total_entries'] = $total_entries;
		}

		$response = new \stdClass();

		$response->items = $mentorings;

   		return $mentorings;
	  }

	  public static function getAttachedMentor($mentor) {

	  }

	  public static function buildMentorngSession($mentoring) {
		$object = new \stdClass();
		// Dates of session
		$object->description = $mentoring->descripcion;
		$object->date = $mentoring->fecha;
		$object->hour = $mentoring->hora;
		$object->estado = $mentoring->codigo_estado;
		$object->attached = [];

		// data entrepreneur
		$object->nombre_usuario_emprendedor = $mentoring->nombre_usuario_emprendedor;
		$object->identificacion_usuario = $mentoring->identificacion_usuario;
		$object->imagen_usuario_emprendedor = $mentoring->imagen_usuario_emprendedor;
		$object->nickname_usuario_emprendedor = $mentoring->nickname_usuario_emprendedor;
        $object->short_name_emprendedor = $mentoring->short_name_emprendedor;
        $object->ultimo_ingreso_emprendedor = $mentoring->ultimo_ingreso_emprendedor;
        $object->ultimo_ingreso_emprendedor_ago = $mentoring->ultimo_ingreso_emprendedor ? TuProyecto::timeAgo($mentoring->ultimo_ingreso_emprendedor) : '' ;
		$object->emprendedor = Auth::user()->codigo_usuario == $mentoring->emprendedor ? true : false;

		// data entrepreneurship
		$object->nombre_emprendimiento = $mentoring->nombre_emprendimiento;
		$object->descripcion_emprendimiento = $mentoring->descripcion_emprendimiento;
		$object->url_emprendimiento = $mentoring->url_emprendimiento;

		$object->nombre_usuario_mentor = $mentoring->nombre_usuario_mentor;
		$object->imagen_usuario_mentor = $mentoring->imagen_usuario_mentor;
		$object->nickname_usuario_mentor = $mentoring->nickname_usuario_mentor;
        $object->short_name_mentor = $mentoring->short_name_mentor;
        $object->ultimo_ingreso_mentor = $mentoring->ultimo_ingreso_mentor;
        $object->ultimo_ingreso_mentor_ago = $mentoring->ultimo_ingreso_mentor ? TuProyecto::timeAgo($mentoring->ultimo_ingreso_mentor) : '';
		$object->evaluation_mentor = $mentoring->evaluation_mentor;
		$object->mentor = Auth::user()->codigo_usuario == $mentoring->mentor ? true : false;

		// $object->url_profile = $mentoring->usuario->getProfileUrl();

		return $object;
	  }

	  public static function buildMentoringSession($mentoring) {
		$object = new \stdClass();

		// Dates of session
		// TuProyecto::encryptSrcParams([$mentoring->codigo_mentoria])
		$object->codigo_mentoria = TuProyecto::encryptSrcParams([$mentoring->codigo_mentoria]);
		$object->id_mentoria = $mentoring->codigo_mentoria;
		$object->description = $mentoring->descripcion;
		$object->date = $mentoring->fecha;
		$object->hour = $mentoring->hora;
		$object->estado = $mentoring->codigo_estado;
		$object->phase = $mentoring->fase ?: '';
		$object->recommends = $mentoring->recomendacion ?: '';
		$object->tracing = $mentoring->seguimiento ?: '';
		$object->assigvoucher = $mentoring->asignacion_voucher ? json_decode($mentoring->asignacion_voucher) : false;
		$object->diagnosis = $mentoring->diagnostico ?: '';
		//$object->duration_mentoring = $mentoring->duration_mentoring;

		//duración de mentoria
		if (isset($mentoring->duration_mentoring)) {
			$duration_mentoring = explode(",", $mentoring->duration_mentoring);
		//dd( $object->duration_mentoring_hour = $duration_mentoring[0] );
			$object->duration_mentoring_hour = trim($duration_mentoring[0]);
			$object->duration_mentoring_minutes = trim($duration_mentoring[1]);
		} else {
			$object->duration_mentoring_hour = null;
			$object->duration_mentoring_minutes = null;
		}

		//date event o session
		$object->fecha_evento = $mentoring->fecha_evento;
		$object->hora_inicio = $mentoring->hora_inicio;
 
		$object->can_finish_mentoring = date("Y-m-d") >= $mentoring->fecha_evento ? true: false;
 
		// data entrepreneur
		$object->nombre_usuario_emprendedor = $mentoring->nombre_usuario_emprendedor;
		$object->identificacion_usuario = $mentoring->identificacion_usuario;
		$object->imagen_usuario_emprendedor = $mentoring->imagen_usuario_emprendedor;
		$object->nickname_usuario_emprendedor = $mentoring->nickname_usuario_emprendedor;
        $object->short_name_emprendedor = $mentoring->short_name_emprendedor;
        $object->ultimo_ingreso_emprendedor = $mentoring->ultimo_ingreso_emprendedor;
        $object->ultimo_ingreso_emprendedor_ago = $mentoring->ultimo_ingreso_emprendedor ? TuProyecto::timeAgo($mentoring->ultimo_ingreso_emprendedor) : '' ;
		$object->emprendedor = Auth::user()->codigo_usuario == $mentoring->emprendedor ? true : false;

		// data entrepreneurship
		$object->nombre_emprendimiento = $mentoring->nombre_emprendimiento;
		$object->descripcion_emprendimiento = $mentoring->descripcion_emprendimiento;
		$object->url_emprendimiento = $mentoring->url_emprendimiento;

		$object->nombre_usuario_mentor = $mentoring->nombre_usuario_mentor;
		$object->imagen_usuario_mentor = $mentoring->imagen_usuario_mentor;
		$object->nickname_usuario_mentor = $mentoring->nickname_usuario_mentor;
        $object->short_name_mentor = $mentoring->short_name_mentor;
        $object->ultimo_ingreso_mentor = $mentoring->ultimo_ingreso_mentor;
        $object->ultimo_ingreso_mentor_ago = $mentoring->ultimo_ingreso_mentor ? TuProyecto::timeAgo($mentoring->ultimo_ingreso_mentor) : '';
		$object->evaluation_mentor = $mentoring->evaluation_mentor;
		$object->mentor = Auth::user()->codigo_usuario == $mentoring->mentor ? true : false;

		$dataobjectives = $mentoring->objetivos()->where('codigo_estado', Estado::getState('active'))->get();
		$objectives = [];
		if(count($dataobjectives) > 0) {
			foreach ($dataobjectives as $objective) {
				$objetivo = new \stdClass();
				$objetivo->codigo_objetivo_mentoria = $objective->codigo_objetivo_mentoria;
				$objetivo->descripcion_objetivo_mentoria = $objective->descripcion_objetivo_mentoria;
				$objectives[] = $objetivo;
			}
		}
		$object->objetivos = $objectives;
		$object->general_objetive = $mentoring->objetivo_mentor;

		// $object->url_profile = $mentoring->usuario->getProfileUrl();

		return $object;
	  }

    /**
	 * Defining Relations
	*/
	public function usuario()
    {
        return $this->hasOne('App\Usuario','codigo_usuario','codigo_usuario');
    }

	public function mentor()
    {
        return $this->hasOne('App\Usuario','codigo_usuario','seg_codigo_usuario');
	}

    public function estado()
    {
        return $this->hasOne('App\Estado','codigo_estado','codigo_estado');
    }

   	public function objetivos()
    {
        return $this->hasMany('App\ObjetivoMentoria', 'codigo_mentoria', 'codigo_mentoria');
    }
}
