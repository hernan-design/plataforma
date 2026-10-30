<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

use Validator, TuProyecto, DB, Input, Auth, URL;

class Discusion extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.discucion';

	protected $primaryKey = 'codigo_discucion';

	public $timestamps = false;

   	protected $fillable = ['texto_discucion'];

    public function isValid($data)
    {
        $rules = array(
            'texto_discucion' => 'required|string'
        );

     	$validator = Validator::make($data, $rules);
        if ($validator->passes()) {
     		return true;
        }
        $this->errors = $validator->errors();
        return false;
    }


   	public static function getDataDiscussion($discussion)
   	{
   		$query = Discusion::query();
		$query->select('discucion.codigo_discucion', 'discucion.texto_discucion', 'discucion.codigo_usuario', 'discucion.codigo_modulo', 'usuario.nickname_usuario', 'usuario.imagen_usuario', 'usuario.correo_electronico', DB::raw("(CASE usuario.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '') ELSE nombre_usuario END) as nombre_usuario"), 'discucion.contador_comentarios_discucion','discucion.contador_like', "codigo_contenido", "codigo_muro", "codigo_evento", "codigo_foro", "codigo_asesoria", "codigo_convocatoria", "codigo_producto", "codigo_curso", "discusion_usuario.codigo_usuario as user_entrepreneur",
			DB::raw('(CASE 	WHEN codigo_contenido IS NOT NULL THEN \'article\'
							WHEN codigo_muro IS NOT NULL THEN \'wall\'
							WHEN codigo_evento IS NOT NULL THEN \'event\'
							WHEN codigo_foro IS NOT NULL THEN \'forum\'
							WHEN codigo_asesoria IS NOT NULL THEN \'advice\'
							WHEN codigo_convocatoria IS NOT NULL THEN \'call\'
							WHEN discusion_usuario.codigo_usuario IS NOT NULL THEN \'user\'
							WHEN codigo_producto IS NOT NULL THEN \'product\'
							WHEN codigo_curso IS NOT NULL THEN \'course\'
					ELSE NULL END) as origin'),
			DB::raw('(CASE  WHEN discusion_contenido.fecha_discusion IS NOT NULL THEN discusion_contenido.fecha_discusion
							WHEN discusion_asesoria.fecha_discusion IS NOT NULL THEN discusion_asesoria.fecha_discusion
							WHEN discusion_convocatoria.fecha_discusion IS NOT NULL THEN discusion_convocatoria.fecha_discusion
							WHEN discusion_usuario.fecha_discusion IS NOT NULL THEN discusion_usuario.fecha_discusion
							WHEN discucion_producto.fecha_discusion IS NOT NULL THEN discucion_producto.fecha_discusion
							WHEN discucion_curso.fecha_discusion IS NOT NULL THEN discucion_curso.fecha_discusion
					ELSE discucion.fecha_discucion END) as fecha_discusion')
			);

		$query->leftJoin('core.discucion_muro', 'discucion.codigo_discucion', '=', 'discucion_muro.codigo_discucion');
		$query->leftJoin('core.discusion_evento', 'discucion.codigo_discucion', '=', 'discusion_evento.codigo_discucion');
		$query->leftJoin('core.discusion_foro', 'discucion.codigo_discucion', '=', 'discusion_foro.codigo_discucion');
		$query->leftJoin('core.discusion_contenido', 'discucion.codigo_discucion', '=', 'discusion_contenido.codigo_discucion');
		$query->leftJoin('core.discusion_asesoria', 'discucion.codigo_discucion', '=', 'discusion_asesoria.codigo_discucion');
		$query->leftJoin('core.discusion_convocatoria', 'discucion.codigo_discucion', '=', 'discusion_convocatoria.codigo_discucion');
		$query->leftJoin('core.discusion_usuario', 'discucion.codigo_discucion', '=', 'discusion_usuario.codigo_discucion');
		$query->leftJoin('core.discucion_producto', 'discucion.codigo_discucion', '=', 'discucion_producto.codigo_discucion');
		$query->leftJoin('aprende.discucion_curso', 'discucion.codigo_discucion', '=', 'discucion_curso.codigo_discucion');

		// User Discussion
		$query->join('seguridad.usuario', 'discucion.codigo_usuario', '=', 'usuario.codigo_usuario');
		$query->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');

		$query->join('param.discucion_institucion', function($join) {
       		$join->on('discucion.codigo_discucion', '=', 'discucion_institucion.codigo_discucion')
				->where('discucion_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('discucion_institucion.codigo_estado', '=', Estado::getState('active'));
      	});

		$query->where('discucion.codigo_discucion', '=', $discussion);
		$query->where('discucion.codigo_estado', '=', Estado::getState('active'));
		return $query->first();
   	}

	/**
	* Build Discussion.
	*/
   	public static function buildDiscussion($discussion)
   	{
		$object = new \stdClass();
		$object->id_discucion = $discussion->codigo_discucion;
		$object->codigo_discucion = TuProyecto::encryptSrcParams([$discussion->codigo_discucion]);
		$object->texto_discucion = $discussion->texto_discucion;
		$object->codigo_modulo = $discussion->codigo_modulo;

		$object->codigo_usuario = $discussion->codigo_usuario;
		$object->nombre_usuario = $discussion->nombre_usuario;
		$object->imagen_usuario = $discussion->imagen_usuario;
		$object->nickname_usuario = $discussion->nickname_usuario;
		$object->fecha_discusion = $discussion->fecha_discusion;

		$object->contador_comentarios_discucion = $discussion->contador_comentarios_discucion;
		$object->contador_like = $discussion->contador_like;
		$object->owner = Auth::user()->codigo_usuario == $discussion->codigo_usuario ? true : false;

		$object->url_profile = $discussion->usuario->getProfileUrl();
		$object->url_discusion = sprintf("%s-%s", 'discusion', $discussion->codigo_discucion);

		$dataOrigin = new \stdClass();
		switch ($discussion->origin) {
		    case 'advice':
		    	$advice = Asesoria::find($discussion->codigo_asesoria);
	   			$dataOrigin->nombre_origen = 'Mentoría';
	   			$dataOrigin->codigo_origen = $advice->codigo_asesoria;
	   			$dataOrigin->titulo_origen = '';
	   			$dataOrigin->texto_origen = $advice->descripcion_asesoria;
	   			$dataOrigin->usuario_origen = $advice->codigo_usuario;
	   			$dataOrigin->seg_usuario_origen = $advice->seg_codigo_usuario;
	   			$dataOrigin->url_origen = URL::route('mentoria.preguntas.show', ['preguntas' => sprintf("%s-%s", 'pregunta', $advice->codigo_asesoria)], false);
	   			$dataOrigin->imagen_origen = '';
	    	break;

		    case 'article':
			    $article = Contenido::select('contenido.*','url_contenido', 'url_tipo_contenido', 'correo_electronico', 'nombre_usuario', 'contenido_institucion.codigo_institucion as institucion')
	   			->where('contenido.codigo_contenido', $discussion->codigo_contenido )
				->join('core.contenido_institucion', function($join) {
	       			$join->on('contenido.codigo_contenido', '=', 'contenido_institucion.codigo_contenido')
						->where('contenido_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
						->where('contenido_institucion.codigo_estado', '=', Estado::getState('active'));
		      	})
		      	->join('param.tipo_contenido_insti', function($join) {
	            	$join->on('contenido_institucion.codigo_tipo_cont_institucion', '=', 'tipo_contenido_insti.codigo_tipo_cont_institucion')
		                ->where('tipo_contenido_insti.codigo_institucion', '=', RegistroSesion::getInstitution())
		                ->where('tipo_contenido_insti.codigo_estado', '=', Estado::getState('active'));
	        	})
	        	->join('core.tipo_contenido', 'tipo_contenido_insti.codigo_tipo_contenido', '=', 'tipo_contenido.codigo_tipo_contenido')
	        	->join('seguridad.usuario', 'contenido.codigo_usuario', '=', 'usuario.codigo_usuario')
				->first();

	   			$dataOrigin->nombre_origen = 'Artículo';
	   			$dataOrigin->codigo_origen = $article->codigo_contenido;
	   			$dataOrigin->titulo_origen = $article->nombre_contenido;
	   			$dataOrigin->texto_origen = $article->resumen_contenido;
	   			$dataOrigin->imagen_origen = $article->imagen_contenido;
	   			$dataOrigin->usuario_origen = $article->codigo_usuario;
	   			$dataOrigin->url_origen = URL::route('blog.categoria.articulo', ['category' => $article->url_tipo_contenido, 'article' => $article->url_contenido], false);
	    	break;

	    	case 'wall':
	    		$wall = Muro::find($discussion->codigo_muro);
	    		$dataOrigin->nombre_origen = 'Comunidades';
	    		$dataOrigin->codigo_origen = $wall->codigo_muro;
	   			$dataOrigin->titulo_origen = '';
	   			$dataOrigin->texto_origen = $wall->texto_muro;
	   			$dataOrigin->usuario_origen = $wall->codigo_usuario;
	   			$dataOrigin->imagen_origen = '';
	   			$dataOrigin->url_origen = null;
	    	break;

	    	case 'event':
	    		$event = Evento::find($discussion->codigo_evento);
			    $dataOrigin->nombre_origen = 'Evento';
			    $dataOrigin->codigo_origen = $event->codigo_evento;
			    $dataOrigin->titulo_origen = $event->nombre_evento;
	   			$dataOrigin->texto_origen = $event->resumen_evento;
	   			$dataOrigin->imagen_origen = $event->imagen_evento;
	   			$dataOrigin->usuario_origen = $event->codigo_usuario;
	   			$dataOrigin->url_origen = URL::route('calendario.evento.show', ['evento' => $event->url_evento], false);
	    	break;

	    	case 'forum':
	    		$forum = Foro::find($discussion->codigo_foro);
			    $dataOrigin->nombre_origen = 'Foro';
			    $dataOrigin->codigo_origen = $forum->codigo_foro;
			    $dataOrigin->titulo_origen = $forum->titulo_foro;
	   			$dataOrigin->texto_origen = $forum->descripcion_foro;
	   			$dataOrigin->usuario_origen = $forum->codigo_usuario;
	   			$dataOrigin->url_origen = URL::route('foro.categoria.tema', ['category' => $forum->categoria->url_categoria_foro, 'theme' => $forum->url_foro], false);
	   			$dataOrigin->imagen_origen = '';
	    	break;

	    	case 'call':
			    $call = Convocatoria::find($discussion->codigo_convocatoria);
			    $dataOrigin->nombre_origen = 'Convocatoria';
			    $dataOrigin->codigo_origen = $call->codigo_convocatoria;
			    $dataOrigin->titulo_origen = $call->nombre_convocatoria;
	   			$dataOrigin->texto_origen = $call->resumen_convocatoria;
	   			$dataOrigin->imagen_origen = $call->imagen_convocatoria;
	   			$dataOrigin->usuario_origen = $call->codigo_usuario;
	   			$dataOrigin->url_origen = URL::route('convocatoria.convocatoria', ['convocatoria' => $call->url_convocatoria], false);
	    	break;

		    case 'user':
			    $user = Usuario::find($discussion->user_entrepreneur);
			    $dataOrigin->nombre_origen = 'Emprendimiento';
			    $dataOrigin->codigo_origen = $user->codigo_usuario;
			    $dataOrigin->titulo_origen = $user->nombre_usuario;
	   			$dataOrigin->texto_origen = $user->biografia_usuario;
	   			$dataOrigin->imagen_origen = $user->imagen_usuario;
	   			$dataOrigin->usuario_origen = $user->entidad->seg_codigo_usuario;
	   			$dataOrigin->url_origen = URL::route('proyecto.proyecto.tab', ['proyecto' => $user->nickname_usuario, 'tab' => 'discusiones'], false);
	    	break;

		    case 'product':
			    $product = Producto::find($discussion->codigo_producto);
			    $dataOrigin->nombre_origen = 'Marketplace';
			    $dataOrigin->codigo_origen = $product->codigo_producto;
			    $dataOrigin->titulo_origen = $product->nombre_producto;
	   			$dataOrigin->texto_origen = $product->resumen_producto;
	   			$dataOrigin->imagen_origen = $product->imagen_producto;
	   			$dataOrigin->usuario_origen = $product->codigo_usuario;
	   			$dataOrigin->url_origen = URL::route('marketplace.show', ['marketplace' => $product->url_producto], false);
	    	break;

		    case 'course':
	   			$course = Curso::select('curso.codigo_curso', 'nombre_curso', 'imagen_curso', 'descripcion_curso', 'url_curso', 'url_categoria_curso', 'nombre_categoria_curso', 'codigo_usuario')

	   			->where('curso.codigo_curso', $discussion->codigo_curso )
				->join('aprende.curso_institucion', function($join) {
	       			$join->on('curso.codigo_curso', '=', 'curso_institucion.codigo_curso')
						->where('curso_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
						->where('curso_institucion.codigo_estado', '=', Estado::getState('active'));
		      	})
	        	->join('aprende.categoria_curso', 'curso.codigo_categoria_curso', '=', 'categoria_curso.codigo_categoria_curso')
				->first();

			    $dataOrigin->nombre_origen = 'Aprende';
			    $dataOrigin->codigo_origen = $course->codigo_curso;
			    $dataOrigin->titulo_origen = $course->nombre_curso;
	   			$dataOrigin->texto_origen = $course->descripcion_curso;
	   			$dataOrigin->imagen_origen = $course->imagen_curso;
	   			$dataOrigin->usuario_origen = $course->codigo_usuario;
	   			$dataOrigin->url_origen = URL::route('aprende.contenido', ['type' => 'cursos', 'category' => $course->url_categoria_curso, 'course' => $course->url_curso], false);
	    	break;
		}
		$object->origin = $dataOrigin;
		$object->srcparams = TuProyecto::encryptSrcParams([$discussion->codigo_discucion, Recurso::getResource('discusion.gestion')]);

		return $object;
   	}

   	/**
   	 * Get discussions by content
   	 */
   	public static function getDiscussions(array $filters = [])
   	{
   		$discussions = [];
   		$total_entries = 0;
   		$selects = ['discucion.codigo_discucion', 'discucion.texto_discucion', 'discucion.codigo_usuario', 'usuario.nickname_usuario', DB::raw("COALESCE(usuario.imagen_usuario, '') as imagen_usuario"), DB::raw("(nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '')) as nombre_usuario"), 'discucion.contador_comentarios_discucion', 'discucion.contador_like'];

		$query = Discusion::query();
		// User Discussion
		$query->join('seguridad.usuario', 'discucion.codigo_usuario', '=', 'usuario.codigo_usuario');
        $query->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');

		$query->join('param.discucion_institucion', function($join) {
       		$join->on('discucion.codigo_discucion', '=', 'discucion_institucion.codigo_discucion')
				->where('discucion_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('discucion_institucion.codigo_estado', '=', Estado::getState('active'));
      	});

        $query->where('discucion.codigo_estado', Estado::getState('active'));

        if(Auth::check() && isset($filters['belongs']) && !empty($filters['belongs']) && $filters['belongs'] == 'false'){
            $query->where('discucion.codigo_usuario', Auth::user()->codigo_usuario);
        }

		// filters by content type
		if(
			isset($filters['codigo_modulo']) && !empty($filters['codigo_modulo']) &&
			isset($filters['codigo_recurso_modulo']) && !empty($filters['codigo_recurso_modulo'])
		) {
			if(is_numeric($filters['codigo_recurso_modulo'])) {
				$content_cod = $filters['codigo_recurso_modulo'];
			} else {
				list($content_cod) = TuProyecto::decryptSrcParams($filters['codigo_recurso_modulo']);
			}
			if(!$content_cod || !is_numeric($content_cod)) {
                abort(403);
            }

			switch($filters['codigo_modulo']) {
				case Modulo::getModule('blog'):
					$selects[] = DB::raw("COALESCE(discucion.fecha_discucion, discusion_contenido.fecha_discusion) as fecha_discusion");
					$query->join('core.discusion_contenido', function($join) use($content_cod) {
				   		$join->on('discucion.codigo_discucion', '=', 'discusion_contenido.codigo_discucion')
							->where('discusion_contenido.codigo_contenido', '=', $content_cod);
				  	});
				  	break;
				case Modulo::getModule('wall'):
					$selects[] = DB::raw("discucion.fecha_discucion as fecha_discusion");
					$query->join('core.discucion_muro', function($join) use($content_cod) {
				   		$join->on('discucion.codigo_discucion', '=', 'discucion_muro.codigo_discucion')
							->where('discucion_muro.codigo_muro', '=', $content_cod);
				  	});
					break;
				case Modulo::getModule('forum'):
					$selects[] = DB::raw("discucion.fecha_discucion as fecha_discusion");
					$query->join('core.discusion_foro', function($join) use($content_cod) {
						$join->on('discucion.codigo_discucion', '=', 'discusion_foro.codigo_discucion')
							->where('discusion_foro.codigo_foro', '=', $content_cod);
					});
					break;
				case Modulo::getModule('calendar'):
					$selects[] = DB::raw("discucion.fecha_discucion as fecha_discusion");
					$query->join('core.discusion_evento', function($join) use($content_cod) {
						$join->on('discucion.codigo_discucion', '=', 'discusion_evento.codigo_discucion')
							->where('discusion_evento.codigo_evento', '=', $content_cod);
					});
					break;
				case Modulo::getModule('learn'):
					$selects[] = DB::raw("COALESCE(discucion.fecha_discucion, discucion_curso.fecha_discusion) as fecha_discusion");
					$query->join('aprende.discucion_curso', function ($join) use($content_cod) {
						$join->on('discucion.codigo_discucion', '=', 'discucion_curso.codigo_discucion')
							->where('discucion_curso.codigo_curso', '=', $content_cod);
					});
					break;
				case Modulo::getModule('mentoring'):
					$selects[] = DB::raw("COALESCE(discucion.fecha_discucion, discusion_asesoria.fecha_discusion) as fecha_discusion");
					$query->join('core.discusion_asesoria', function ($join) use($content_cod) {
						$join->on('discucion.codigo_discucion', '=', 'discusion_asesoria.codigo_discucion')
							->where('discusion_asesoria.codigo_asesoria', '=', $content_cod);
					});
					break;
				case Modulo::getModule('calls'):
					$selects[] = DB::raw("COALESCE(discucion.fecha_discucion, discusion_convocatoria.fecha_discusion) as fecha_discusion");
					$query->join('core.discusion_convocatoria', function ($join) use($content_cod) {
						$join->on('discucion.codigo_discucion', '=', 'discusion_convocatoria.codigo_discucion')
							->where('discusion_convocatoria.codigo_convocatoria', '=', $content_cod);
					});
					break;
				case Modulo::getModule('users'):
					$selects[] = DB::raw("COALESCE(discucion.fecha_discucion, discusion_usuario.fecha_discusion) as fecha_discusion");
					$query->join('core.discusion_usuario', function ($join) use($content_cod) {
						$join->on('discucion.codigo_discucion', '=', 'discusion_usuario.codigo_discucion')
							->where('discusion_usuario.codigo_usuario', '=', $content_cod);
					});
					break;
				case Modulo::getModule('marketplace'):
					$selects[] = DB::raw("COALESCE(discucion.fecha_discucion, discucion_producto.fecha_discusion) as fecha_discusion");
					$query->join('core.discucion_producto', function ($join) use($content_cod) {
						$join->on('discucion.codigo_discucion', '=', 'discucion_producto.codigo_discucion')
							->where('discucion_producto.codigo_producto', '=', $content_cod);
                    });
                    break;
				case Modulo::getModule('agreements'):
					$selects[] = DB::raw("COALESCE(discucion.fecha_discucion, discucion_acuerdo_compra.fecha_discusion) as fecha_discusion");
					$query->join('core.discucion_acuerdo_compra', function ($join) use($content_cod) {
						$join->on('discucion.codigo_discucion', '=', 'discucion_acuerdo_compra.codigo_discucion')
							->where('discucion_acuerdo_compra.codigo_acuerdo_compra', '=', $content_cod);
                    });
					break;
				default:
					$selects[] = DB::raw("discucion.fecha_discucion as fecha_discusion");
					break;
			}
		}

		// Get total posts
        $query->select($selects);
		$total_entries = $query->count();
		$query->orderBy('discucion.codigo_discucion','desc');
		if(
			isset($filters['offset']) && is_int((int)$filters['offset']) &&
			isset($filters['limit']) && is_int((int)$filters['limit'])
		) {
			// Get posts
			$data = $query->skip($filters['offset'])->take($filters['limit'])->get();
   		}else{
	   		$data = $query->get();
   		}

   		if(isset($data) && count($data) > 0) {
			foreach ($data as $discussion) {
				$discussions[] = self::buildResults($discussion);
			}
		}

		if(
			!isset($filters['offset']) || !is_int((int)$filters['offset']) ||
			!isset($filters['limit']) || !is_int((int)$filters['limit'])
		) {
			return $discussions;
		}

		$response = new \stdClass();
		$response->total_entries = $total_entries;
		$response->items = $discussions;
   		return $response;
   	}

   	/**
	 *
   	 */
   	public static function buildResults($discussion)
   	{
   		$object = new \stdClass();
   		$object->cod = $discussion->codigo_discucion;
		$object->codigo_discucion = TuProyecto::encryptSrcParams([$discussion->codigo_discucion]);
		$object->codigo_usuario = $discussion->codigo_usuario;
		$object->texto_discucion = $discussion->texto_discucion;
		$object->fecha_discusion = $discussion->fecha_discusion;
		$object->contador_like = $discussion->contador_like;
		$object->contador_comentarios_discucion = $discussion->contador_comentarios_discucion;
		$object->owner = (Auth::check() && Auth::user()->codigo_usuario == $discussion->codigo_usuario) ? true : false;

		$object->nombre_usuario = $discussion->nombre_usuario;
		$object->imagen_usuario = $discussion->imagen_usuario;
		$object->nickname_usuario = $discussion->nickname_usuario;

		$object->nombre_usuario = $discussion->nombre_usuario;
		$object->srcparams = TuProyecto::encryptSrcParams([$discussion->codigo_discucion, Recurso::getResource('discusion.gestion')]);
		return $object;
   	}

	/**
	* Get comments Discussion.
	*/
  	public static function getParticipants(array $filters = [])
   	{
   		$comments = [];
		$query = ComentarioDiscusion::query();

		// Dynamic query select
        $select = [DB::raw('DISTINCT(comentario.codigo_usuario) as codigo_usuario'), DB::raw("(CASE usuario.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '') ELSE nombre_usuario END) as nombre_usuario"),'comentario_discucion.codigo_discucion','comentario_discucion.codigo_estado', 'usuario.imagen_usuario','usuario.nickname_usuario', 'nombre_ciudad', 'nombre_pais'];

        if(Auth::check()) {
            $select = array_collapse([ $select, [DB::raw(sprintf('%s %s', RedUsuario::$raw_friendship, 'as state_friendship'))] ]);
        }
        $query->select($select);

		$query->join('core.discucion', 'discucion.codigo_discucion', '=', 'comentario_discucion.codigo_discucion');
		$query->leftJoin('core.discucion_acuerdo_compra', 'discucion.codigo_discucion', '=', 'discucion_acuerdo_compra.codigo_discucion');

		$query->join('core.comentario', 'comentario_discucion.codigo_comentario', '=', 'comentario.codigo_comentario');
		$query->join('seguridad.usuario', 'comentario.codigo_usuario', '=', 'usuario.codigo_usuario');
		$query->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');

		// City / Country
		$query->leftjoin('core.ciudad', 'usuario.codigo_ciudad', '=', 'ciudad.codigo_ciudad');
		$query->leftjoin('core.pais', 'ciudad.codigo_pais', '=', 'pais.codigo_pais');

		if(Auth::check()) {
            // State friendship
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

		$query->where('comentario_discucion.codigo_estado', Estado::getState('active'));

		// Only discussion
		if(isset($filters['discussion']) && !empty($filters['discussion'])) {
            // Decrypt src-params
            list($codigo_discusion) = TuProyecto::decryptSrcParams($filters['discussion']);
            if(!$codigo_discusion || !is_numeric($codigo_discusion)) {
                abort(403);
            }
			$query->where('comentario_discucion.codigo_discucion', $codigo_discusion);
			$query->where('comentario.codigo_usuario', '!=', Auth::user()->codigo_usuario);
		}

		// All discussion sale agreement
		if(isset($filters['sale_agreement']) && !empty($filters['sale_agreement'])) {
            // Decrypt src-params
            list($codigo_acuerdo_compra) = TuProyecto::decryptSrcParams($filters['sale_agreement']);
            if(!$codigo_acuerdo_compra || !is_numeric($codigo_acuerdo_compra)) {
                abort(403);
            }
			$query->where('discucion_acuerdo_compra.codigo_acuerdo_compra', $codigo_acuerdo_compra);
		}

		if(
			isset($filters['offset']) && is_int((int)$filters['offset']) &&
			isset($filters['limit']) && is_int((int)$filters['limit'])
		) {
			// Get total posts
			$total_entries = $query->count();
			// Get posts
			$data = $query->skip($filters['offset'])->take($filters['limit'])->get();
   		}else{
	   		$data = $query->get();
   		}

		if(isset($data) && count($data) > 0) {
			foreach ($data as $comment) {
				$comments[] = Discusion::buildParticipant($comment);
			}
		}

		if(
			!isset($filters['offset']) || !is_int((int)$filters['offset']) ||
			!isset($filters['limit']) || !is_int((int)$filters['limit'])
		) {
			return $comments;
		}

		$response = new \stdClass();
		$response->total_entries = $total_entries;
		$response->items = $comments;
   		return $response;
   	}

   	/**
	 * Get discussion participants by content
   	 */
   	public static function getContentParticipants($codigo_modulo, $origin)
   	{
   		$participants = [];
		$query = Discusion::query();

		$query->select('discucion.codigo_usuario');
		switch($codigo_modulo) {
			case Modulo::getModule('blog'):
				$query->join('core.discusion_contenido', 'discucion.codigo_discucion', '=', 'discusion_contenido.codigo_discucion');
				$query->where('discusion_contenido.codigo_contenido', $origin->codigo_origen);
			break;

			case Modulo::getModule('wall'):
				$query->join('core.discucion_muro', 'discucion.codigo_discucion', '=', 'discucion_muro.codigo_discucion');
				$query->where('discucion_muro.codigo_muro', $origin->codigo_origen);
			break;

			case Modulo::getModule('calendar'):
				$query->join('core.discusion_evento', 'discucion.codigo_discucion', '=', 'discusion_evento.codigo_discucion');
				$query->where('discusion_evento.codigo_evento', $origin->codigo_origen);
			break;

			case Modulo::getModule('forum'):
				$query->join('core.discusion_foro', 'discucion.codigo_discucion', '=', 'discusion_foro.codigo_discucion');
				$query->where('discusion_foro.codigo_foro', $origin->codigo_origen);
			break;

			case Modulo::getModule('mentoring'):
				$query->join('core.discusion_asesoria', 'discucion.codigo_discucion', '=', 'discusion_asesoria.codigo_discucion');
				$query->where('discusion_asesoria.codigo_asesoria', $origin->codigo_origen);
			break;

			case Modulo::getModule('calls'):
				$query->join('core.discusion_convocatoria', 'discucion.codigo_discucion', '=', 'discusion_convocatoria.codigo_discucion');
				$query->where('discusion_convocatoria.codigo_convocatoria', $origin->codigo_origen);
			break;

			case Modulo::getModule('users'):
				$query->join('core.discusion_usuario', 'discucion.codigo_discucion', '=', 'discusion_usuario.codigo_discucion');
				$query->where('discusion_usuario.codigo_usuario', $origin->codigo_origen);
			break;

			case Modulo::getModule('marketplace'):
				$query->join('core.discucion_producto', 'discucion.codigo_discucion', '=', 'discucion_producto.codigo_discucion');
				$query->where('discucion_producto.codigo_producto', $origin->codigo_origen);
			break;

			case Modulo::getModule('learn'):
				$query->join('aprende.discucion_curso', 'discucion.codigo_discucion', '=', 'discucion_curso.codigo_discucion');
				$query->where('discucion_curso.codigo_curso', $origin->codigo_origen);
			break;

			default:
				return $participants;
			break;
		}

		$query->join('param.discucion_institucion', function($join) {
       		$join->on('discucion.codigo_discucion', '=', 'discucion_institucion.codigo_discucion')
				->where('discucion_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('discucion_institucion.codigo_estado', '=', Estado::getState('active'));
      	});
		$query->whereNotIn('discucion.codigo_usuario', [Auth::user()->codigo_usuario, $origin->usuario_origen]);
		$participants = $query->distinct()->get()->pluck('codigo_usuario')->all();

		return $participants;
   	}

    /**
     * Build ParticipantProgram.
     */
    public static function buildParticipant($partcipant)
    {
        $object = new \stdClass();
        $object->codigo_usuario = TuProyecto::encryptSrcParams([$partcipant->codigo_usuario]);
        $object->nombre_usuario = $partcipant->nombre_usuario;
        $object->imagen_usuario = $partcipant->imagen_usuario;
        $object->nickname_usuario = $partcipant->nickname_usuario;
        $object->profesion_usuario = $partcipant->profesion_usuario;
        $object->nombre_ciudad = $partcipant->nombre_ciudad;
        $object->nombre_pais = $partcipant->nombre_pais;
        $object->state_friendship = $partcipant->state_friendship;
        $object->srcparams = TuProyecto::encryptSrcParams([$partcipant->codigo_usuario]);

        $object->url_profile = $partcipant->usuario->getProfileUrl();
        $object->owner =  Auth::check() && Auth::user()->codigo_usuario == $partcipant->codigo_usuario ? true : false;

        return $object;
    }

   	/**
	 * Defining Relations
	 */
	public function usuario()
    {
        return $this->hasOne('App\Usuario','codigo_usuario','codigo_usuario');
    }

    public function estado()
    {
        return $this->hasOne('App\Estado','codigo_estado','codigo_estado');
    }

   	public function comentarios()
    {
        return $this->hasMany('App\ComentarioDiscusion','codigo_discucion','codigo_discucion');
    }

}
