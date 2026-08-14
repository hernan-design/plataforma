<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

use DB, Auth, Validator, URL, Lang, Log;

use TuProyecto, SendEmail;

class Muro extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.muro';

	protected $primaryKey = 'codigo_muro';

	public $timestamps = false;

	protected $fillable = ['metadatos_muro', 'texto_muro', 'codigo_modulo', 'codigo_recurso_modulo', 'codigo_canal'];

    public static function getVisibility($visibility)
    {
    	switch ($visibility) :
		    case 'private': return 0;
		    case 'public': return 1;
			default: return 'Not visibility identified';
		endswitch;
    }

	public function isValid($data)
	{
		$rules = array(
			'codigo_modulo' => 'required'
		);

		$validator = Validator::make($data, $rules);
		if ($validator->passes()) {
			return true;
		}
		$this->errors = $validator->errors();
		return false;
	}

	public function isValidUpdate($data)
	{
		$rules = array(
			'texto_muro' => 'required'
		);

		$validator = Validator::make($data, $rules);
		if ($validator->passes()) {
			return true;
		}
		$this->errors = $validator->errors();
		return false;
	}

	public static function store($data)
	{
		try
		{
			// Wall
			$muro = new self;
			if (!$muro->isValid($data)) {
				throw new \Exception($muro->errors);
			}
			$muro->fill($data);
			$muro->texto_muro = trim($muro->texto_muro);
			$muro->visibilidad_muro = self::getVisibility('public');
			$muro->codigo_estado = Estado::getState('active');
			$muro->codigo_usuario = Auth::user()->codigo_usuario;
			$muro->fecha_muro = date('Y-m-d');
			$muro->hora_muro = date('H:i:s');
			$muro->save();

 			// Wall institution
   			$wallInstitution = new MuroInstitucion;
   			$wallInstitution->codigo_muro = $muro->codigo_muro;
   			$wallInstitution->codigo_institucion = RegistroSesion::getInstitution();
			$wallInstitution->codigo_estado = Estado::getState('active');
   			$wallInstitution->save();

			// Return
			return $muro;
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
	}

	/**
	 * Search posts wall.
	 * @param {array} $filters
	 */
   	public static function search(array $filters = [])
   	{
        $query = Muro::query();
		$query->select('muro.*', 'usuario.*', DB::raw("COALESCE(usuario.imagen_usuario, '') as imagen_usuario"), 'muro.codigo_usuario as owner', 'usuariom.nickname_usuario as nickname_reference', 'nombre_ciudad', 'nombre_pais', 'nombre_especialidad', 'nombre_nivel_educacion',
			DB::raw("usuario.nombre_usuario as nombre_usuario"), DB::raw("usuariom.nombre_usuario as nombre_reference"),
			DB::raw("COALESCE(muro.codigo_recurso_modulo, muro.codigo_muro) as codigo_recurso_modulo"),
			DB::raw("COALESCE(evento.nombre_evento, foro.titulo_foro, blog.nombre_contenido, curso.nombre_curso, '') as titulo_muro"),
			DB::raw("COALESCE(evento.descripcion_evento, foro.descripcion_foro, blog.resumen_contenido, curso.descripcion_curso, '') as texto_contenido_muro"),
			DB::raw("COALESCE(evento.fecha_evento, foro.fecha_apertura_foro, blog.fecha_contenido, curso.fecha_apertura_curso) as fecha_contenido_muro"),
			DB::raw("COALESCE(evento.hora_inicio_evento, foro.hora_apertura_foro, blog.hora_contenido) as hora_contenido_muro"),
			DB::raw("COALESCE(evento.url_evento, foro.url_foro, blog.url_contenido, curso.url_curso, '') as url_contenido_muro"),
			DB::raw("COALESCE(blog.imagen_contenido, curso.imagen_curso, '') as imagen_contenido"),
			DB::raw("COALESCE(tipo_contenido.url_tipo_contenido, categoria_foro.url_categoria_foro, categoria_curso.url_categoria_curso) as url_tipo_contenido"),
			DB::raw("COALESCE(tipo_contenido.nombre_tipo_contenido, categoria_foro.nombre_categoria_foro, tipo_evento.nombre_tipo_evento, categoria_curso.nombre_categoria_curso) as nombre_tipo_contenido"),
			DB::raw("COALESCE(tipo_contenido.codigo_tipo_contenido, categoria_foro.codigo_categoria_foro, tipo_evento.codigo_tipo_evento, categoria_curso.codigo_categoria_curso) as codigo_tipo_contenido"),
			DB::raw("COALESCE(tipo_curso.url_tipo_curso) as url_clase_contenido"),
			DB::raw("
				(CASE WHEN foro.codigo_foro IS NOT NULL
					THEN
					(
						SELECT STRING_AGG(texto_tag::text, ',') FROM core.tag JOIN core.tag_foro ON tag.codigo_tag = tag_foro.codigo_tag
						WHERE foro.codigo_foro = tag_foro.codigo_foro
					)
					ELSE null
				END ) AS tags_contenido"),
			DB::raw("
				(CASE
					WHEN blog.codigo_contenido IS NOT NULL THEN contenido_institucion.contador_comentario
					WHEN evento.codigo_evento IS NOT NULL THEN evento_institucion.contador_comentario
					WHEN foro.codigo_foro IS NOT NULL THEN foro_institucion.contador_comentario
					WHEN curso.codigo_curso IS NOT NULL THEN curso_institucion.contador_comentario
					ELSE muro_institucion.contador_comentario
				END ) AS contador_comentario"),
			DB::raw("
				(CASE
					WHEN blog.codigo_contenido IS NOT NULL THEN contenido_institucion.contador_like
					WHEN evento.codigo_evento IS NOT NULL THEN evento_institucion.contador_like
					WHEN foro.codigo_foro IS NOT NULL THEN foro_institucion.contador_like
					WHEN curso.codigo_curso IS NOT NULL THEN curso_institucion.contador_like
					ELSE muro_institucion.contador_like
				END) AS contador_like
			")
		);
		$query->join('seguridad.usuario as usuario', 'muro.codigo_usuario', '=', 'usuario.codigo_usuario');

		// Validate privacy wall institucion
		$query->join('core.muro_institucion', function($join) {
        	$join->on('muro.codigo_muro', '=', 'muro_institucion.codigo_muro')
    			->where('muro_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('muro_institucion.codigo_estado', '=', Estado::getState('active'));
      	});

		$query->leftjoin('core.ciudad', 'usuario.codigo_ciudad', '=', 'ciudad.codigo_ciudad');
		$query->leftjoin('core.pais', 'ciudad.codigo_pais', '=', 'pais.codigo_pais');

		$query->leftjoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');
		$query->leftjoin('core.especialidad', 'persona.codigo_especialidad', '=', 'especialidad.codigo_especialidad');
		$query->leftjoin('core.nivel_educacion', 'persona.codigo_nivel_educacion', '=', 'nivel_educacion.codigo_nivel_educacion');

		// User wall
		$query->leftjoin('seguridad.usuario as usuariom', function($join) {
    		$join->on('muro.codigo_recurso_modulo', '=', 'usuariom.codigo_usuario')
    			->where('muro.codigo_modulo', '=', Modulo::getModule('users'));
		});
		// Event wall
		$query->leftjoin('core.evento as evento', function($join) {
			$join->on('muro.codigo_recurso_modulo', '=', 'evento.codigo_evento')
				->where('muro.codigo_modulo', '=', Modulo::getModule('calendar'));
		});
		$query->leftjoin('core.evento_institucion', function ($join) {
			$join->on('evento.codigo_evento', '=', 'evento_institucion.codigo_evento')
				->on('evento_institucion.codigo_institucion', '=', 'muro_institucion.codigo_institucion');
		});
		$query->leftjoin('core.tipo_evento_calendario', 'evento_institucion.codigo_tipo_evento_calendario', '=', 'tipo_evento_calendario.codigo_tipo_evento_calendario');
		$query->leftjoin('core.tipo_evento', 'tipo_evento_calendario.codigo_tipo_evento', '=', 'tipo_evento.codigo_tipo_evento');
		// Forum wall
		$query->leftjoin('core.foro as foro', function($join) {
			$join->on('muro.codigo_recurso_modulo', '=', 'foro.codigo_foro')
				->where('muro.codigo_modulo', '=', Modulo::getModule('forum'));
		});
		$query->leftjoin('core.foro_institucion', function ($join) {
			$join->on('foro.codigo_foro', '=', 'foro_institucion.codigo_foro')
				->on('foro_institucion.codigo_institucion', '=', 'muro_institucion.codigo_institucion');
		});
		$query->leftjoin('core.categoria_foro as categoria_foro', 'foro.codigo_categoria_foro', '=', 'categoria_foro.codigo_categoria_foro');
		// Blog wall
		$query->leftjoin('core.contenido as blog', function($join) {
			$join->on('muro.codigo_recurso_modulo', '=', 'blog.codigo_contenido')
				->where('muro.codigo_modulo', '=', Modulo::getModule('blog'));
		});
		$query->leftjoin('core.contenido_institucion', function($join) {
			$join->on('blog.codigo_contenido', '=', 'contenido_institucion.codigo_contenido')
				->on('contenido_institucion.codigo_institucion', '=', 'muro_institucion.codigo_institucion');
		});
		$query->leftjoin('param.tipo_contenido_insti', function($join) {
           $join->on('contenido_institucion.codigo_tipo_cont_institucion', '=', 'tipo_contenido_insti.codigo_tipo_cont_institucion')
               ->on('tipo_contenido_insti.codigo_institucion', '=', 'contenido_institucion.codigo_institucion');
		});
		$query->leftjoin('core.tipo_contenido', 'tipo_contenido_insti.codigo_tipo_contenido', '=', 'tipo_contenido.codigo_tipo_contenido');
		// Course wall
		$query->leftjoin('aprende.curso as curso', function ($join) {
			$join->on('muro.codigo_recurso_modulo', '=', 'curso.codigo_curso')
				->where('muro.codigo_modulo', '=', Modulo::getModule('learn'));
		});
		$query->leftjoin('aprende.curso_institucion', function ($join) {
			$join->on('curso.codigo_curso', '=', 'curso_institucion.codigo_curso')
				->on('curso_institucion.codigo_institucion', '=', 'muro_institucion.codigo_institucion');
		});
		$query->leftjoin('aprende.categoria_curso', function ($join) {
			$join->on('curso.codigo_categoria_curso', '=', 'categoria_curso.codigo_categoria_curso');
		});
		$query->leftjoin('aprende.tipo_curso', 'curso.tipo_curso', '=', 'tipo_curso.codigo_tipo_curso');

		// Dynamic Filters
     	// Get posts wall (all, institution, friends, important, user). Default option 'all'
		if (isset($filters['wall']) && !empty($filters['wall'])) {
			switch ($filters['wall']) {
				case 'user':
					// Decrypt src-params
					if(isset($filters['srcparams-user']) && !empty($filters['srcparams-user'])){
						list($codigo_usuario) = TuProyecto::decryptSrcParams($filters['srcparams-user']);
						if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
							abort(403);
						}
						$query->whereRaw('(muro.codigo_usuario = '.$codigo_usuario.' OR ((muro.codigo_modulo = '.Modulo::getModule('users').'  AND muro.codigo_recurso_modulo = '.$codigo_usuario.')))');
					}
					abort(403);
			    break;
			}
        }

        // filter by content
        if (isset($filters['filter_content']) && !empty($filters['filter_content'])) {
        	$query->whereIn('muro.codigo_modulo', explode(',', $filters['filter_content']));
        }

        // Get filter posts wall
		if (isset($filters['filter']) && !empty($filters['filter'])) {
         	$query->where('muro.texto_muro', 'ilike', '%'.$filters['filter'].'%');
		}

		// Filter channel
		if (isset($filters['url_canal']) && !empty($filters['url_canal'])) {
			$query->join('core.canal', 'muro.codigo_canal', '=', 'canal.codigo_canal');
			$query->where('canal.codigo_institucion', RegistroSesion::getInstitution());
			$query->where('canal.url_canal', $filters['url_canal']);
		}else{
			$query->whereNull('muro.codigo_canal');
		}

		$query->where('muro.visibilidad_muro', Muro::getVisibility('public'));
		$query->where('muro.codigo_estado', Estado::getState('active'));

		// Get total posts
   		$total_entries = $query->count();

   		$query->orderBy('muro.fecha_muro','desc');
   		$query->orderBy('muro.hora_muro','desc');

   		// Get posts
   		$posts = $query->skip($filters['offset'])->take($filters['limit'])->get();

		$data = array();
		if(count($posts) > 0) {
			foreach ($posts as $post) {
				$data[] = Muro::buildPosts($post);
			}
   		}

   		$response = new \stdClass();
		$response->total_entries = $total_entries;
		$response->items = $data;
   		return $response;
   	}

   	public static function getPosts($codigo_muro)
   	{
   		$query = Muro::query();
        $query->select('muro.*', 'usuario.*', DB::raw("COALESCE(usuario.imagen_usuario, '') as imagen_usuario"), 'muro.codigo_usuario as owner', 'usuariom.nickname_usuario as nickname_reference', 'nombre_ciudad', 'nombre_pais', 'nombre_especialidad', 'nombre_nivel_educacion',
			DB::raw("usuario.nombre_usuario as nombre_usuario"), DB::raw("usuariom.nombre_usuario as nombre_reference"),
			DB::raw("COALESCE(muro.codigo_recurso_modulo, muro.codigo_muro) as codigo_recurso_modulo"),
			DB::raw("COALESCE(evento.nombre_evento, foro.titulo_foro, blog.nombre_contenido, curso.nombre_curso, '') as titulo_muro"),
			DB::raw("COALESCE(evento.descripcion_evento, foro.descripcion_foro, blog.resumen_contenido, curso.descripcion_curso, '') as texto_contenido_muro"),
			DB::raw("COALESCE(evento.fecha_evento, foro.fecha_apertura_foro, blog.fecha_contenido, curso.fecha_apertura_curso) as fecha_contenido_muro"),
			DB::raw("COALESCE(evento.hora_inicio_evento, foro.hora_apertura_foro, blog.hora_contenido) as hora_contenido_muro"),
			DB::raw("COALESCE(evento.url_evento, foro.url_foro, blog.url_contenido, curso.url_curso, '') as url_contenido_muro"),
			DB::raw("COALESCE(blog.imagen_contenido, curso.imagen_curso, '') as imagen_contenido"),
			DB::raw("COALESCE(tipo_contenido.url_tipo_contenido, categoria_foro.url_categoria_foro, categoria_curso.url_categoria_curso) as url_tipo_contenido"),
			DB::raw("COALESCE(tipo_contenido.nombre_tipo_contenido, categoria_foro.nombre_categoria_foro, tipo_evento.nombre_tipo_evento, categoria_curso.nombre_categoria_curso) as nombre_tipo_contenido"),
			DB::raw("COALESCE(tipo_contenido.codigo_tipo_contenido, categoria_foro.codigo_categoria_foro, tipo_evento.codigo_tipo_evento, categoria_curso.codigo_categoria_curso) as codigo_tipo_contenido"),
			DB::raw("COALESCE(tipo_curso.url_tipo_curso) as url_clase_contenido"),
			DB::raw("
				(CASE WHEN foro.codigo_foro IS NOT NULL
					THEN
					(
						SELECT STRING_AGG(texto_tag::text, ',') FROM core.tag JOIN core.tag_foro ON tag.codigo_tag = tag_foro.codigo_tag
						WHERE foro.codigo_foro = tag_foro.codigo_foro
					)
					ELSE null
				END ) AS tags_contenido"),
			DB::raw("
				(CASE
					WHEN blog.codigo_contenido IS NOT NULL THEN contenido_institucion.contador_comentario
					WHEN evento.codigo_evento IS NOT NULL THEN evento_institucion.contador_comentario
					WHEN foro.codigo_foro IS NOT NULL THEN foro_institucion.contador_comentario
					WHEN curso.codigo_curso IS NOT NULL THEN curso_institucion.contador_comentario
					ELSE muro_institucion.contador_comentario
				END ) AS contador_comentario"),
			DB::raw("
				(CASE
					WHEN blog.codigo_contenido IS NOT NULL THEN contenido_institucion.contador_like
					WHEN evento.codigo_evento IS NOT NULL THEN evento_institucion.contador_like
					WHEN foro.codigo_foro IS NOT NULL THEN foro_institucion.contador_like
					WHEN curso.codigo_curso IS NOT NULL THEN curso_institucion.contador_like
					ELSE muro_institucion.contador_like
				END) AS contador_like
			")
		);
		$query->join('seguridad.usuario', 'muro.codigo_usuario', '=', 'usuario.codigo_usuario');

		// Validate privacy wall institucion
		$query->join('core.muro_institucion', function($join) {
        	$join->on('muro.codigo_muro', '=', 'muro_institucion.codigo_muro')
    			->where('muro_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('muro_institucion.codigo_estado', '=', Estado::getState('active'));
      	});

		$query->leftjoin('core.ciudad', 'usuario.codigo_ciudad', '=', 'ciudad.codigo_ciudad');
		$query->leftjoin('core.pais', 'ciudad.codigo_pais', '=', 'pais.codigo_pais');

		$query->leftjoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');
		$query->leftjoin('core.especialidad', 'persona.codigo_especialidad', '=', 'especialidad.codigo_especialidad');
		$query->leftjoin('core.nivel_educacion', 'persona.codigo_nivel_educacion', '=', 'nivel_educacion.codigo_nivel_educacion');

		// User wall
		$query->leftjoin('seguridad.usuario as usuariom', function($join) {
    		$join->on('muro.codigo_recurso_modulo', '=', 'usuariom.codigo_usuario');
    		$join->where('muro.codigo_modulo', '=', Modulo::getModule('users'));
		});
		// Event wall
		$query->leftjoin('core.evento as evento', function($join) {
			$join->on('muro.codigo_recurso_modulo', '=', 'evento.codigo_evento')
				->where('muro.codigo_modulo', '=', Modulo::getModule('calendar'));
		});
		$query->leftjoin('core.evento_institucion', function ($join) {
			$join->on('evento.codigo_evento', '=', 'evento_institucion.codigo_evento')
				->on('evento_institucion.codigo_institucion', '=', 'muro_institucion.codigo_institucion');
		});
		$query->leftjoin('core.tipo_evento_calendario', 'evento_institucion.codigo_tipo_evento_calendario', '=', 'tipo_evento_calendario.codigo_tipo_evento_calendario');
		$query->leftjoin('core.tipo_evento', 'tipo_evento_calendario.codigo_tipo_evento', '=', 'tipo_evento.codigo_tipo_evento');
		// Forum wall
		$query->leftjoin('core.foro as foro', function($join) {
			$join->on('muro.codigo_recurso_modulo', '=', 'foro.codigo_foro')
				->where('muro.codigo_modulo', '=', Modulo::getModule('forum'));
		});
		$query->leftjoin('core.foro_institucion', function ($join) {
			$join->on('foro.codigo_foro', '=', 'foro_institucion.codigo_foro')
				->on('foro_institucion.codigo_institucion', '=', 'muro_institucion.codigo_institucion');
		});
		$query->leftjoin('core.categoria_foro as categoria_foro', 'foro.codigo_categoria_foro', '=', 'categoria_foro.codigo_categoria_foro');
		// Blog wall
		$query->leftjoin('core.contenido as blog', function($join) {
			$join->on('muro.codigo_recurso_modulo', '=', 'blog.codigo_contenido')
				->where('muro.codigo_modulo', '=', Modulo::getModule('blog'));
		});
		$query->leftjoin('core.contenido_institucion', function($join) {
			$join->on('blog.codigo_contenido', '=', 'contenido_institucion.codigo_contenido')
				->on('contenido_institucion.codigo_institucion', '=', 'muro_institucion.codigo_institucion');
		});
		$query->leftjoin('param.tipo_contenido_insti', function($join) {
           $join->on('contenido_institucion.codigo_tipo_cont_institucion', '=', 'tipo_contenido_insti.codigo_tipo_cont_institucion')
               ->on('tipo_contenido_insti.codigo_institucion', '=', 'contenido_institucion.codigo_institucion');
		});
		$query->leftjoin('core.tipo_contenido', 'tipo_contenido_insti.codigo_tipo_contenido', '=', 'tipo_contenido.codigo_tipo_contenido');
		// Course wall
		$query->leftjoin('aprende.curso as curso', function ($join) {
			$join->on('muro.codigo_recurso_modulo', '=', 'curso.codigo_curso')
				->where('muro.codigo_modulo', '=', Modulo::getModule('learn'));
		});
		$query->leftjoin('aprende.curso_institucion', function ($join) {
			$join->on('curso.codigo_curso', '=', 'curso_institucion.codigo_curso')
				->on('curso_institucion.codigo_institucion', '=', 'muro_institucion.codigo_institucion');
		});
		$query->leftjoin('aprende.categoria_curso', function ($join) {
			$join->on('curso.codigo_categoria_curso', '=', 'categoria_curso.codigo_categoria_curso');
		});
		$query->leftjoin('aprende.tipo_curso', 'curso.tipo_curso', '=', 'tipo_curso.codigo_tipo_curso');

		$query->where('muro.codigo_muro', $codigo_muro);
		return $query->first();
   	}

   	/**
	 * Build post.
	 */
   	public static function buildPosts($post)
   	{
		$object = new \stdClass();
		$object->cod = $post->codigo_muro;
		$object->codigo_muro = $post->codigo_muro;
		$object->codigo_modulo = $post->codigo_modulo;
		$object->codigo_recurso_modulo = TuProyecto::encryptSrcParams([$post->codigo_recurso_modulo]);
		$object->texto_muro = $post->texto_muro;
		$object->metadatos_muro = $post->metadatos_muro;
		$object->time_ago = TuProyecto::timeAgo($post->fecha_muro, $post->hora_muro);

		$object->titulo_muro = $post->titulo_muro;
		$object->texto_contenido_muro = $post->texto_contenido_muro;
		$object->fecha_contenido_muro = $post->fecha_contenido_muro;
		$object->hora_contenido_muro = $post->hora_contenido_muro;
		$object->url_contenido_muro = $post->url_contenido_muro;
		$object->imagen_contenido = $post->imagen_contenido;
		$object->url_tipo_contenido = $post->url_tipo_contenido;
		$object->nombre_tipo_contenido = $post->nombre_tipo_contenido;
		$object->codigo_tipo_contenido = $post->codigo_tipo_contenido;
		$object->tags_contenido = $post->tags_contenido;
		$object->url_clase_contenido = $post->url_clase_contenido;

		$object->puntos_usuario = $post->contador_gamification;
		$object->medallas_usuario = 0;
		$object->ranking_usuario = $post->posicion_gamification;
		$object->imagen_usuario = $post->imagen_usuario;
		$object->nombre_usuario = $post->nombre_usuario;
		$object->nickname_usuario = $post->nickname_usuario;
		$object->nombre_ciudad = $post->nombre_ciudad;
		$object->nombre_pais = $post->nombre_pais;
		$object->profesion_usuario = $post->profesion_usuario;
		$object->nombre_especialidad = $post->nombre_especialidad;
		$object->nombre_nivel_educacion = $post->nombre_nivel_educacion;

		$object->nombre_reference = $post->nombre_reference;
		$object->nickname_reference = $post->nickname_reference;
		$object->codigo_usuario = $post->codigo_usuario;

		$object->contador_comentario = $post->contador_comentario;
		$object->contador_like = $post->contador_like;

		$object->url_profile = $post->usuario->getProfileUrl();

		// Secure srcparams
		$resource_cod = $post->codigo_recurso_modulo;
		$resource = Recurso::getResource('muro.gestion');
		switch($post->codigo_modulo) {
			case Modulo::getModule('blog'): $resource = Recurso::getResource('blog.gestion');
				break;
			case Modulo::getModule('forum'): $resource = Recurso::getResource('foro.gestion');
				break;
			case Modulo::getModule('wall'): $resource = Recurso::getResource('muro.gestion');
				break;
			case Modulo::getModule('calendar'): $resource = Recurso::getResource('eventos.gestion');
				break;
			case Modulo::getModule('learn'): $resource = Recurso::getResource('aprende.gestion');
				break;
		}
		$object->srcparams = TuProyecto::encryptSrcParams([$resource_cod, $resource]);

		if ($object->codigo_usuario !== Auth::id() && Auth::user()->ability('admin,super-admin', 'login-admin')) {
			$object->isAuthorizedToDelete = true;
		}

		return $object;
   	}

   	/**
	 * Job Queue notification mail.
	 */
   	public function notification($job, $parameters)
   	{
   		try
   		{
			$wall = Muro::find($parameters['codigo_muro']);
			if(!$wall instanceof Muro) {
				throw new Exception("Muro not found");
			}

			if($wall->codigo_modulo === Modulo::getModule('users')) {
				// Mail notification
				$data = [];
				$data['_template'] = 'emails.wall.individual';
				$data['_inst'] = $parameters['codigo_institucion'];

				$user = Usuario::find($wall->codigo_recurso_modulo);
				if(!$user instanceof Usuario) {
					throw new Exception("Usuario not found");
				}

				$data['_url_user_action'] = $wall->usuario->getProfileUrl();

				$data['_subject'] = Lang::get('wall.mail.individual.subject', array('user' => $wall->usuario->nombre_usuario));
				$data['_to'] = $user->correo_electronico;
				$data['_to_name'] = $user->nombre_usuario;

				$data['comment'] = $wall->texto_muro;
				$data['url_wall'] = URL::route('usuario.nickname', array('nickname' => $user->nickname_usuario), false);
				SendEmail::notification($data);
			}

			// Delete Job
			$job->delete();

		}catch(\Exception $e){
			Log::error(sprintf('%s:%s', 'Muro notification', $e->getMessage()));
        }
	}

   	/**
	 * Get comments wall.
	 */
  	public function getComments()
   	{
   		$comments = $this->comentarios()
   			->join('core.comentario', 'comentario_muro.codigo_comentario', '=', 'comentario.codigo_comentario')
			->join('seguridad.usuario', 'comentario.codigo_usuario', '=', 'usuario.codigo_usuario')
			->join('core.usuario_institucion', function($join) {
	       		$join->on('usuario.codigo_usuario', '=', 'usuario_institucion.codigo_usuario')
					->where('usuario_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
					->where('usuario_institucion.codigo_estado', '=', Estado::getState('active'));
	      	})
   			->where('core.comentario_muro.codigo_estado', Estado::getState('active'))
   			->orderBy('comentario.fecha_comentario','asc')
   			->orderBy('comentario.hora_comentario','asc')
   			->get();
		$data = array();
		if(count($comments) > 0) {
			foreach ($comments as $comment) {
				$data[] = ComentarioMuro::buildComment($comment);
			}
		}
		return $data;
   	}

   	/**
	 * Defining Relations
	*/

	public function usuario()
    {
        return $this->hasOne('App\Usuario','codigo_usuario','codigo_usuario');
    }

   	public function comentarios()
    {
        return $this->hasMany('App\ComentarioMuro','codigo_muro','codigo_muro');
    }

}
