<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

use TuProyecto;

use DB, Auth, Validator, Lang, URL, SendEmail, Log;

class RespuestaForo extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.respuesta_foro';

   	protected $primaryKey = 'codigo_respuesta_foro';

  	public $timestamps = false;

   	protected $fillable = array('codigo_foro', 'texto_respuesta_foro');

   	public function isValid($data)
    {
        $rules = array(
            'codigo_foro' => 'required|regex:[^[0-9]*$]|numeric',
            'texto_respuesta_foro' => 'required'
      	);

     	$validator = Validator::make($data, $rules);
        if ($validator->passes()) {
     		return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

   	/**
	 * Forum most commented posts.
	 */
   	public static function getRecentComments()
   	{
		$recentComments = [];
   		$comments = RespuestaForo::select('respuesta_foro.*', 'foro.codigo_foro', 'foro.titulo_foro', 'foro.url_foro', 'categoria_foro.codigo_categoria_foro', 'categoria_foro.url_categoria_foro')
   			->join('core.foro', 'core.respuesta_foro.codigo_foro', '=', 'core.foro.codigo_foro')
   			->join('core.categoria_foro', 'core.foro.codigo_categoria_foro', '=', 'core.categoria_foro.codigo_categoria_foro')
   			->join('seguridad.usuario', 'core.respuesta_foro.codigo_usuario', '=', 'usuario.codigo_usuario')

       		// Forum institution
			->join('core.foro_institucion', function($join) {
       			$join->on('foro.codigo_foro', '=', 'foro_institucion.codigo_foro')
					->where('foro_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
					->where('foro_institucion.codigo_estado', '=', Estado::getState('active'));
      		})

			// Private forum group
			->whereRaw('
				(CASE
					WHEN foro_grupo = true THEN '.(Auth::check() ? Auth::user()->codigo_usuario : 0).' IN (SELECT DISTINCT(usuario_grupo.codigo_usuario) FROM core.usuario_grupo
						INNER JOIN core.grupo_foro ON usuario_grupo.codigo_grupo = grupo_foro.codigo_grupo AND grupo_foro.codigo_foro = foro.codigo_foro
						WHERE usuario_grupo.codigo_estado = '.Estado::getState('active').')
					ELSE TRUE
				END)'
			)

   			->orderBy('respuesta_foro.fecha_respuesta_foro','desc')
   			->orderBy('respuesta_foro.hora_respuesta_foro','desc')
   			->take(4)->get();
		foreach ($comments as $comment) {
			$forum = new \stdClass();
			$forum->titulo_foro = $comment->titulo_foro;
			$forum->url_foro = $comment->url_foro;
			$forum->nickname_usuario = $comment->nickname_usuario;
			$forum->nickname = $comment->usuario->nickname();
			$forum->date_time = TuProyecto::postsDateFormat($comment->fecha_respuesta_foro, $comment->hora_respuesta_foro);
			$forum->url_categoria_foro = $comment->url_categoria_foro;
			$recentComments[] = $forum;
		}
		return $recentComments;
   	}

   	public static function getTopCollaborators()
   	{
		return Usuario::join('param.institucion', 'usuario.codigo_institucion', '=', 'institucion.codigo_institucion')
			->select(DB::raw('ROW_NUMBER() OVER(ORDER BY contador_comentario_foro desc) as item'), 'usuario.codigo_usuario', 'imagen_usuario', 'contador_comentario_foro',
				'nickname_usuario',DB::raw("(CASE usuario.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '') ELSE nombre_usuario END) as nombre_usuario"), 'sigla_institucion')
			->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario')
   			->orderBy('contador_comentario_foro','desc')
			->take(5)->get();
   	}

   	public static function getCommentForum($forum)
   	{
   		$query = RespuestaForo::query();
		$query->select( DB::raw("(CASE usuario.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '') ELSE nombre_usuario END) as nombre_usuario"), 'respuesta_foro.*');
		$query->join('seguridad.usuario', 'respuesta_foro.codigo_usuario', '=', 'usuario.codigo_usuario');
		$query->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');
		$query->where('respuesta_foro.codigo_respuesta_foro', '=', $forum);
		return $query->first();
   	}

   	/**
	 * Forum comments.
	 */
   	public static function buildComment($comment)
   	{

   		$object = new \stdClass();
		$object->codigo_foro = $comment->codigo_foro;
		$object->codigo_respuesta_foro = $comment->codigo_respuesta_foro;
		$object->texto_respuesta_foro = $comment->texto_respuesta_foro;
		$object->fecha_respuesta_foro = TuProyecto::postsDateFormat($comment->fecha_respuesta_foro, $comment->hora_respuesta_foro);
		$object->nombre_usuario = $comment->nombre_usuario;
		$object->imagen_usuario = $comment->usuario->imagen_usuario;
		$object->ciudad_usuario = '';
		if($comment->usuario->codigo_ciudad) {
			$object->ciudad_usuario = $comment->usuario->ciudad->cityFormat();
		}
		$object->comentarios_usuario = $comment->usuario->contador_comentario_foro;
		$object->nickname_usuario = $comment->usuario->nickname_usuario;
		$object->nickname = $comment->usuario->nickname();
		$object->contador_like = $comment->contador_like;

		$object->url_profile = $comment->usuario->getProfileUrl();

		// Secure srcparams
		$object->srcparams = TuProyecto::encryptSrcParams([$comment->codigo_respuesta_foro, Recurso::getResource('foro.comentario')]);
		return $object;
   	}

   	/**
	 * Job Queue notification mail.
	 */
   	public function notification($job, $parameters)
   	{
   		try
   		{
			$answer = RespuestaForo::find($parameters['codigo_respuesta_foro']);
			if(!$answer instanceof RespuestaForo) {
				throw new \Exception("RespuestaForo not found");
			}

			$forum = Foro::find($answer->codigo_foro);
			if(!$forum instanceof Foro) {
				throw new \Exception("Foro not found");
			}

			$participants = Foro::select(DB::raw('DISTINCT(respuesta_foro.codigo_usuario) as codigo_usuario'), 'nombre_usuario', 'usuario_institucion.codigo_institucion', 'correo_electronico')
				->join('core.respuesta_foro', 'foro.codigo_foro', '=', 'respuesta_foro.codigo_foro')
	   			->join('seguridad.usuario', 'seguridad.usuario.codigo_usuario', '=', 'respuesta_foro.codigo_usuario')
	   			->join('core.usuario_institucion', function($join) use($parameters) {
		       		$join->on('usuario.codigo_usuario', '=', 'usuario_institucion.codigo_usuario')
						->where('usuario_institucion.codigo_institucion', '=', $parameters['codigo_institucion'])
						->where('usuario_institucion.codigo_estado', '=', Estado::getState('active'));
		      	})
	   			->join('core.foro_institucion', function($join) use($parameters) {
	       			$join->on('foro.codigo_foro', '=', 'foro_institucion.codigo_foro')
						->where('foro_institucion.codigo_institucion', '=', $parameters['codigo_institucion'])
						->where('foro_institucion.codigo_estado', '=', Estado::getState('active'));
		      	})
	   			->whereNotIn('respuesta_foro.codigo_usuario', [$answer->codigo_usuario, $forum->codigo_usuario])
	   			->where('foro.codigo_foro', $answer->codigo_foro)
				->get();

			// Mail notification
			$data = [];
			$data['_subject'] = Lang::get('forum.mail.subject');
			$data['_template'] = 'emails.forum.notification';
			$data['_inst'] = $parameters['codigo_institucion'];

			// Data Template
			$data['owner'] = false;
			$data['titulo_foro'] = $forum->titulo_foro;
			$data['url_foro'] = URL::route('foro.categoria.tema', ['category' => $forum->categoria->url_categoria_foro, 'theme' => $forum->url_foro], false);
			$data['_url_user_action'] = $answer->usuario->getProfileUrl();
			$data['_name_user_action'] = $answer->usuario->nombre_usuario;

			foreach ($participants as $partaker) {
				$data['_to'] = $partaker->correo_electronico;
				$data['_to_name'] = $partaker->nombre_usuario;
				// Send Mail Notification
				SendEmail::notification($data);
			}

			if($answer->codigo_usuario != $forum->codigo_usuario) {
				// Send Mail Owner Forum
				$data['owner'] = true;
				$data['_to'] = $forum->usuario->correo_electronico;
				$data['_to_name'] = $forum->usuario->nombre_usuario;
				SendEmail::notification($data);
			}

		}catch(\Exception $e) {
			Log::error(sprintf('%s:%s', 'RespuestaForo notification', $e->getMessage()));

        } finally {
        	// Delete Job
			$job->delete();
		}
	}

   	/**
	 * Defining Relations
	*/
	public function usuario()
    {
        return $this->hasOne('App\Usuario','codigo_usuario','codigo_usuario');
    }

  	public function foro()
    {
        return $this->belongsTo('App\Foro','codigo_foro','codigo_foro');
    }

}
