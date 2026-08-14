<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use TuProyecto, Auth, DB, Log, SendEmail, Lang;

use App\RedUsuario;

class UsuarioEvento extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.usuario_evento';

   	protected $primaryKey = 'codigo_usuario_evento';

	public $timestamps = false;

	public static function usuariosEventoList(array $filters = [])
	{
		$usersEvents = [];
		$query = UsuarioEvento::query();
		$query->select('codigo_usuario_evento', 'imagen_usuario', 'nivel_educacion_usuario.nombre_nivel_educacion', 'fecha_usuario_evento', 'nickname_usuario', 'usuario.codigo_usuario',
			DB::raw("initcap(usuario.nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '')) as nombre_usuario"),
			(Auth::check() ? DB::raw(sprintf('%s %s', RedUsuario::$raw_friendship, 'as state_friendship')) : DB::raw('\'\' as state_friendship'))
		);
		$query->join('core.usuario_institucion', 'usuario_evento.codigo_usuario_institucion', '=', 'usuario_institucion.codigo_usuario_institucion');
		$query->join('seguridad.usuario', 'usuario_institucion.codigo_usuario', '=', 'usuario.codigo_usuario');

		// State friendship
        if(Auth::check()) {
	        $query->leftjoin('core.red_usuario as invitation', function($join) {
				$join->on('usuario.codigo_usuario', '=', 'invitation.seg_codigo_usuario')
					->where('invitation.codigo_usuario', '=', Auth::user()->codigo_usuario)
					->where('invitation.codigo_institucion', '=', RegistroSesion::getInstitution());
	        });

	        $query->leftjoin('core.red_usuario as answer', function($join) {
				$join->on('usuario.codigo_usuario', '=', 'answer.codigo_usuario')
					->where('answer.seg_codigo_usuario', '=', Auth::user()->codigo_usuario)
					->where('answer.codigo_institucion', '=', RegistroSesion::getInstitution());
	        });
        }

		$query->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');
		$query->leftJoin('core.nivel_educacion_usuario', 'persona.codigo_persona', '=', 'nivel_educacion_usuario.codigo_persona');
		$query->leftJoin('core.nivel_educacion', function($join){
			$join->on('nivel_educacion_usuario.codigo_nivel_educacion', '=', 'nivel_educacion.codigo_nivel_educacion')
				->where('nivel_educacion_usuario.codigo_estado', '=', Estado::getState('active'));
		});

		if(isset($filters['codigo_evento']) && !empty($filters['codigo_evento'])){
			list($codigo_evento) = TuProyecto::decryptSrcParams($filters['codigo_evento']);
			if(!$codigo_evento || !is_numeric($codigo_evento)) {
				abort(403);
			}
			$query->where('codigo_evento', $codigo_evento);
		}

		// Get posts
		$total_entries = $query->count();

		$query->orderBy('fecha_usuario_evento', 'desc');
		$query->skip($filters['offset'])->take($filters['limit']);
		$data = $query->get();

		foreach ($data as $value) {
			$usersEvents[] = self::buildEventoUsuario($value);
		}

		$response = new \stdClass();
		$response->total_entries = $total_entries;
		$response->items = $usersEvents;
		return $response;
	}

		/**
	* Job Queue notification mail.
	*/
	public function notification($job, $data)
    {

	    $event = Evento::find($data['codigo_evento']);
	    if(!$event instanceof Evento) {
	      throw new \Exception("Event not found");
		}

	    $usuario = Usuario::find($data['codigo_usuario']);
	    if(!$usuario instanceof Usuario) {
	      throw new \Exception("Usuario not found");
		}


	    // Mail notification
	    $data = array();
		$data['_inst'] = RegistroSesion::getInstitution();
		$data['_subject'] = Lang::get('event.mail.participate.subject');
		$data['_template'] = 'emails.event.notification';
	    $data['_to'] = $usuario->correo_electronico;
		$data['_to_name'] = $usuario->nombre_usuario;
		$data['_event_name'] = $event->nombre_evento;
		$data['_url_action'] = route('calendario.evento.show', ['evento' => $event->url_evento]);
		SendEmail::notification($data);
	    // Delete Job
	    $job->delete();
  	}

	public static function buildEventoUsuario($usuario)
	{
		$object = new \stdClass();
		$object->nombre_usuario = $usuario->nombre_usuario;
		$object->imagen_usuario = $usuario->imagen_usuario;
		$object->state_friendship = $usuario->state_friendship;
		$object->nickname_usuario = $usuario->nickname_usuario;
		$object->fecha_usuario_evento = $usuario->fecha_usuario_evento;
		$object->codigo_usuario_evento = $usuario->codigo_usuario_evento;
		$object->nombre_nivel_educacion = $usuario->nombre_nivel_educacion;
		$object->srcparams = TuProyecto::encryptSrcParams([$usuario->codigo_usuario]);

		return $object;
	}
}
