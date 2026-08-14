<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Validator, TuProyecto, DB, Input, Auth, Lang, SendEmail, URL, Log;

class DiscusionContenido extends Model
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'core.discusion_contenido';

	public $incrementing = false;

	public $timestamps = false;


	public static function getArticleDiscussions($article)
   	{
   		$discussions = [];
		$query = Discusion::query();
		$query->select('discucion.codigo_discucion', 'discucion.texto_discucion', 'discucion.codigo_usuario', 'usuario.nickname_usuario', 'usuario.imagen_usuario', DB::raw("(CASE usuario.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '') ELSE nombre_usuario END) as nombre_usuario"), 'discusion_contenido.fecha_discusion','discucion.contador_comentarios_discucion','discucion.contador_like');

		$query->join('core.discusion_contenido', 'discucion.codigo_discucion', '=', 'discusion_contenido.codigo_discucion');
		$query->join('core.contenido', 'discusion_contenido.codigo_contenido', '=', 'contenido.codigo_contenido');
		$query->join('core.estado', 'discusion_contenido.codigo_estado', '=', 'estado.codigo_estado');

		// User Discussion
		$query->join('seguridad.usuario', 'discucion.codigo_usuario', '=', 'usuario.codigo_usuario');
		$query->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');

		$query->join('param.discucion_institucion', function($join) {
       		$join->on('discucion.codigo_discucion', '=', 'discucion_institucion.codigo_discucion')
				->where('discucion_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('discucion_institucion.codigo_estado', '=', Estado::getState('active'));
      	});

		$query-> where('discusion_contenido.codigo_contenido', $article);
		$query-> where('discucion_institucion.codigo_estado', Estado::getState('active'));
		$query-> where('discucion.codigo_estado', Estado::getState('active'));

   		$query->orderBy('discucion.codigo_discucion','desc');
		// Get total posts
		$total_entries = $query->get()->count();

		// Get posts
		$data = $query->skip(Input::get('offset'))->take(Input::get('limit'))->get();

		if(count($data) > 0) {
			foreach ($data as $discussion) {
				$discussions[] = DiscusionContenido::buildDiscussion($discussion);
			}
		}

		$response = new \stdClass();
		$response->total_entries = $total_entries;
		$response->items = $discussions;
   		return $response;
   	}

   	public static function getDataDiscussion($discussion)
   	{
   		$query = Discusion::query();
		$query->select('discucion.codigo_discucion', 'discucion.texto_discucion', 'discucion.codigo_usuario', 'usuario.nickname_usuario', 'usuario.imagen_usuario', DB::raw("(CASE usuario.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '') ELSE nombre_usuario END) as nombre_usuario"), 'discusion_contenido.codigo_contenido', 'discusion_contenido.fecha_discusion','discucion.contador_comentarios_discucion','discucion.contador_like');
		$query->join('core.discusion_contenido', 'discucion.codigo_discucion', '=', 'discusion_contenido.codigo_discucion');
		// User Discussion
		$query->join('seguridad.usuario', 'discucion.codigo_usuario', '=', 'usuario.codigo_usuario');
		$query->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');
		
		$query->join('param.discucion_institucion', function($join) {
       		$join->on('discucion.codigo_discucion', '=', 'discucion_institucion.codigo_discucion')
				->where('discucion_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('discucion_institucion.codigo_estado', '=', Estado::getState('active'));
      	});
		$query->where('discucion.codigo_discucion', '=', $discussion);
		$query->where('discucion_institucion.codigo_estado', '=', Estado::getState('active'));
		$query->where('discucion.codigo_estado', Estado::getState('active'));

		//$query->orderBy('discusion_contenido.fecha_discusion','asc');
		$query->orderBy('discucion.codigo_discucion','desc');

		return $query->first();
   	}

   	/**
	* Build Discussion.
	*/
   	public static function buildDiscussion($post)
   	{
		$object = new \stdClass();
		$object->codigo_discucion = TuProyecto::encryptSrcParams([$post->codigo_discucion]);
		$object->codigo_usuario = $post->codigo_usuario;
		$object->texto_discucion = $post->texto_discucion;

		$object->nombre_usuario = $post->nombre_usuario;
		$object->imagen_usuario = $post->imagen_usuario;
		$object->nickname_usuario = $post->nickname_usuario;
		$object->fecha_discusion = $post->fecha_discusion;

		$object->contador_comentarios_discucion = $post->contador_comentarios_discucion;
		$object->contador_like = $post->contador_like;
		$object->owner = (Auth::check() && Auth::user()->codigo_usuario == $post->codigo_usuario) ? true : false;
		$object->url_profile = $post->usuario->getProfileUrl();

		$object->srcparams = TuProyecto::encryptSrcParams([$post->codigo_discucion, Recurso::getResource('discusion.gestion')]);
		return $object;
   	}


    /**
	 * Job Queue notification mail.
	 */
   	public function notification($job, $data)
   	{
   		try
   		{
	   		//Data article
	   		$article = Contenido::select('contenido.*','url_contenido', 'url_tipo_contenido', 'correo_electronico', 'nombre_usuario', 'contenido_institucion.codigo_institucion as institucion')
	   			->where('contenido.codigo_contenido', $data['codigo_contenido'] )
				->join('core.contenido_institucion', function($join) use($data) {
	       			$join->on('contenido.codigo_contenido', '=', 'contenido_institucion.codigo_contenido')
						->where('contenido_institucion.codigo_institucion', '=', $data['codigo_institucion'])
						->where('contenido_institucion.codigo_estado', '=', Estado::getState('active'));
		      	})
		      	->join('param.tipo_contenido_insti', function($join) use($data) {
	            	$join->on('contenido_institucion.codigo_tipo_cont_institucion', '=', 'tipo_contenido_insti.codigo_tipo_cont_institucion')
		                ->where('tipo_contenido_insti.codigo_institucion', '=', $data['codigo_institucion'])
		                ->where('tipo_contenido_insti.codigo_estado', '=', Estado::getState('active'));
	        	})
	        	->join('core.tipo_contenido', 'tipo_contenido_insti.codigo_tipo_contenido', '=', 'tipo_contenido.codigo_tipo_contenido')
	        	->join('seguridad.usuario', 'contenido.codigo_usuario', '=', 'usuario.codigo_usuario')
				->first();

			// Data discussion
			$discussion = Discusion::find($data['codigo_discucion']);
			if(!$discussion instanceof Discusion) {
				throw new \Exception("Error recuperando discusion, notification discusion contenido. {$data['codigo_discucion']}");
			}

		 	// Mail notification
			$data = [];
			$data['_template'] = 'emails.blog.notification';
			$data['_subject'] = Lang::get('blog.mail.comment.subject',['user' => $discussion->usuario->nombre_usuario]);
			// Data Template
			$data['comment'] = $discussion->texto_discucion;
			$data['_url_user_action'] = $discussion->usuario->getProfileUrl();
			$data['url_contenido'] = URL::route('blog.categoria.articulo', ['category' => $article->url_tipo_contenido, 'article' => $article->url_contenido], false);
			$data['_name_user_action'] = $discussion->usuario->nickname_usuario;
			$data['_to'] = $article->correo_electronico;
			$data['_to_name'] = $article->nombre_usuario;
			$data['_inst'] = $article->institucion;
			SendEmail::notification($data);
			
			// Delete Job
			$job->delete();

		}catch(\Exception $e){
			Log::error(sprintf('%s:%s', 'DiscusionContenido notification', $e->getMessage()));
        }
	}
}
