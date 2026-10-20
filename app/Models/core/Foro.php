<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

use TuProyecto;

use DB, Input, Auth, Validator, Lang;

class Foro extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.foro';

   	protected $primaryKey = 'codigo_foro';

   	public $timestamps = false;

   	protected $fillable = ['titulo_foro', 'descripcion_foro', 'codigo_categoria_foro'];

   	/**
	 * Items by category main forum.
	 *
	 * @var Int
	 */
   	public static $perCategory = 4;

   	public function isValid($data)
    {
        $rules = array(
            'titulo_foro' => 'required|max:125',
            'descripcion_foro' => 'required',
            'codigo_categoria_foro' => 'required'
        );

     	$validator = Validator::make($data, $rules);
        if ($validator->passes()) {
     		return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

   	public static function getForum($forum)
   	{
   		$query = Foro::query();

   		$query->select('foro.*', 'categoria_foro.url_categoria_foro', DB::raw("(CASE usuario.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '') ELSE nombre_usuario END) as nombre_usuario"));
		$query->join('seguridad.usuario', 'foro.codigo_usuario', '=', 'usuario.codigo_usuario');

		// Forum institution
		$query->join('core.foro_institucion', function ($join) {
			$join->on('foro.codigo_foro', '=', 'foro_institucion.codigo_foro')
				->where('foro_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('foro_institucion.codigo_estado', '=', Estado::getState('active'));
		});

		// Forum category
  		$query->join('core.categoria_foro', function($join) {
  			$join->on('foro.codigo_categoria_foro', '=', 'categoria_foro.codigo_categoria_foro')
  				->where('categoria_foro.codigo_estado', '=', Estado::getState('active'));
  		});

  		$query->join('core.categoria_foro_institucion', function ($join) {
            $join->on('categoria_foro.codigo_categoria_foro', '=', 'categoria_foro_institucion.codigo_categoria_foro')
                ->on('categoria_foro_institucion.codigo_institucion', '=', 'foro_institucion.codigo_institucion')
                ->where('categoria_foro_institucion.codigo_estado', '=', Estado::getState('active'));
        });

		$query->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');
		$query->where('url_foro', '=', strtolower(trim($forum)));
		return $query->first();
   	}

    public static function getGlobalData()
    {
    	$categories = CategoriaForo::getForumCategories()->toArray();
    	return compact('categories');
    }

    /**
	 * Forum Posts grouped by category.
	 */
    public static function getLastFaq()
    {
		$query = Foro::query();
		$query->select('titulo_foro', 'url_foro', 'url_categoria_foro');
		$query->join('core.usuario_institucion', function($join) {
	        $join->on('foro.codigo_usuario', '=', 'usuario_institucion.codigo_usuario')
				->where('usuario_institucion.codigo_estado', '=', Estado::getState('active'));
			if(RegistroSesion::getPrivacy()) {
    			$join->where('usuario_institucion.codigo_institucion', '=', RegistroSesion::getInstitution());
			}
      	});
		$query->join('param.institucion', 'usuario_institucion.codigo_institucion', '=', 'institucion.codigo_institucion');
		$query->where('institucion.privacidad_institucion', '=', RegistroSesion::getPrivacy());
		$query->join('core.categoria_foro', 'foro.codigo_categoria_foro', '=', 'categoria_foro.codigo_categoria_foro');
	  	$query->where('foro.codigo_categoria_foro', CategoriaForo::getForumCategory('faq'));
		$query->orderBy('foro.fecha_apertura_foro','desc');
		$query->orderBy('foro.hora_apertura_foro','desc');
		$query->groupBy('foro.codigo_foro','categoria_foro.url_categoria_foro');
		return $query->take(6)->get();
    }

   	/**
	 * Forum Posts grouped by category.
	 */
    public static function getLastPost()
    {
    	$lastPost = array();
		$categories = CategoriaForo::where('core.categoria_foro.codigo_estado', Estado::getState('active'))->get();
		foreach ($categories as $category) {
			$object = Foro::getPost($category, Foro::$perCategory);
			if($object != null) {
				$lastPost[] = $object;
			}
		}
		return $lastPost;
    }

    /**
	 * Forum data posts.
	 */
	public static function getPost($category, $limit = null)
	{
		$object = null;
		$posts = $category->foros()->select('foro.codigo_foro', 'foro.titulo_foro', 'foro.url_foro', 'foro.codigo_usuario', 'fecha_apertura_foro', 'hora_apertura_foro', 'foro_institucion.contador_comentario', 'foro_institucion.contador_like')
		->where('core.foro.codigo_estado', Estado::getState('active'))

   		// Forum institution
		->join('core.foro_institucion', function($join) {
   			$join->on('foro.codigo_foro', '=', 'foro_institucion.codigo_foro')
				->where('foro_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('foro_institucion.codigo_estado', '=', Estado::getState('active'));
  		})

		->join('core.categoria_foro_institucion', function ($join) {
            $join->on('categoria_foro.codigo_categoria_foro', '=', 'categoria_foro_institucion.codigo_categoria_foro')
                ->on('categoria_foro_institucion.codigo_institucion', '=', 'foro_institucion.codigo_institucion')
                ->where('categoria_foro_institucion.codigo_estado', '=', Estado::getState('active'));
        })

		->orderBy('core.foro.fecha_apertura_foro','desc')
		->orderBy('core.foro.hora_apertura_foro','desc')
		->take($limit)->get();

		/*$query*/
		if(count($posts) > 0) {
			$forums = array();
			foreach ($posts as $post) {
				$forum = new \stdClass();
				$forum->titulo_foro = $post->titulo_foro;
				$forum->url_foro = $post->url_foro;
				$forum->nickname_usuario = $post->usuario->nickname_usuario;
				$forum->nickname = $post->usuario->nickname();
				$forum->time_ago = TuProyecto::timeAgo($post->fecha_apertura_foro, $post->hora_apertura_foro);
				$forum->comments_num = $post->contador_comentario;
				$forum->url_profile = $post->usuario->getProfileUrl();

				$lastComment = $post->respuestas()->where('core.respuesta_foro.codigo_estado', Estado::getState('active'))->first();
				if($lastComment instanceof RespuestaForo){
					$forum->comment_date_time = TuProyecto::postsDateFormat($lastComment->fecha_respuesta_foro, $lastComment->hora_respuesta_foro);
					$forum->comment_nickname_usuario = $lastComment->usuario->nickname_usuario;
					$forum->comment_nickname = $lastComment->usuario->nickname();
				}
				$forums[] = $forum;
			}

			$data = DB::table('core.foro')
				->where('foro.codigo_estado', Estado::getState('active'))
				->where('foro.codigo_categoria_foro', $category->codigo_categoria_foro)

		   		// Forum institution
				->join('core.foro_institucion', function($join) {
		   			$join->on('foro.codigo_foro', '=', 'foro_institucion.codigo_foro')
						->where('foro_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
						->where('foro_institucion.codigo_estado', '=', Estado::getState('active'));
		  		})

				->join('core.categoria_foro_institucion', function ($join) {
		            $join->on('categoria_foro.codigo_categoria_foro', '=', 'categoria_foro_institucion.codigo_categoria_foro')
		                ->on('categoria_foro_institucion.codigo_institucion', '=', 'foro_institucion.codigo_institucion')
		                ->where('categoria_foro_institucion.codigo_estado', '=', Estado::getState('active'));
		        })
				->count();

			$object = new \stdClass();
			$object->codigo_categoria_foro = $category->codigo_categoria_foro;
			$object->nombre_categoria_foro = $category->nombre_categoria_foro;
			$object->url_categoria_foro = $category->url_categoria_foro;
			$object->posts_num = $data;
			$object->posts = $forums;
		}
		return $object;
	}

	/**
	 * @param {array} $filters
	 * forum posts
	 */
	public static function getPosts(array $filters = [])
	{
		$forums = [];
		$query = Foro::query();

		// $query->select('foro.codigo_foro', 'foro.titulo_foro', 'foro.url_foro', 'fecha_apertura_foro', 'hora_apertura_foro');
		$query->where('core.foro.codigo_estado', Estado::getState('active'));

   		// Forum institution
		$query->join('core.foro_institucion', function($join) {
   			$join->on('foro.codigo_foro', '=', 'foro_institucion.codigo_foro')
				->where('foro_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('foro_institucion.codigo_estado', '=', Estado::getState('active'));
  		});
  		// Forum category
  		$query->join('core.categoria_foro', function($join) {
  			$join->on('foro.codigo_categoria_foro', '=', 'categoria_foro.codigo_categoria_foro')
  				->where('categoria_foro.codigo_estado', '=', Estado::getState('active'));
  		});

  		$query->join('core.categoria_foro_institucion', function ($join) {
            $join->on('categoria_foro.codigo_categoria_foro', '=', 'categoria_foro_institucion.codigo_categoria_foro')
                ->on('categoria_foro_institucion.codigo_institucion', '=', 'foro_institucion.codigo_institucion')
                ->where('categoria_foro_institucion.codigo_estado', '=', Estado::getState('active'));
        });

  		// Forum user
  		$query->join('seguridad.usuario', 'foro.codigo_usuario', '=', 'usuario.codigo_usuario');

		// Filter by channel
		if( isset($filters['url_canal']) && !empty($filters['url_canal']) ) {
			$query->join('core.contenido_canal', function($join) {
	            $join->on('foro.codigo_foro', '=', 'contenido_canal.codigo_recurso_modulo')
	                ->where('contenido_canal.codigo_modulo', '=', Modulo::getModule('forum'))
	                ->where('contenido_canal.codigo_estado', '=', Estado::getState('active'));
	        });

	        $query->join('core.canal', function($join) {
	            $join->on('contenido_canal.codigo_canal', '=', 'canal.codigo_canal')
	                ->where('canal.url_canal', '=', $filters['url_canal'])
					->where('canal.codigo_institucion', '=', RegistroSesion::getInstitution());
	        });
		}
		// Filter by category
		if( isset($filters['url_categoria_foro']) && !empty($filters['url_categoria_foro']) ) {
			$query->where('categoria_foro.url_categoria_foro', '=', $filters['url_categoria_foro']);
		}

		// Get total posts count
		$total_entries = $query->count();

		// Filter by
		if(isset($filters['filterBy'])) {
			switch ($filters['filterBy']) {
				case 'more-commented':
					$query->orderBy('foro_institucion.contador_comentario','desc');
					break;
			}
		}

		$query->orderBy('core.foro.fecha_apertura_foro','desc');
		$query->orderBy('core.foro.hora_apertura_foro','desc');
		$offset = isset($filters['offset']) ? (int) $filters['offset'] : 0;
		$limit = isset($filters['limit']) ? (int) $filters['limit'] : 15;
		$query->skip($offset)->take($limit);
		$results = $query->get();

   		if(isset($results) && count($results) > 0) {
   			foreach ($results as $f) {
   				$forums[] = Foro::buildForum($f);
   			}
   		}

		$response = new \stdClass();
		$response->total_entries = $total_entries;
		$response->items = $forums;
		return $response;
	}

	/**
	 * Forum most commented posts.
	 */
   	public static function getMostCommentedPost()
   	{
        return Foro::join('core.categoria_foro', 'core.foro.codigo_categoria_foro', '=', 'core.categoria_foro.codigo_categoria_foro')
           	->select('core.foro.codigo_foro', 'core.foro.titulo_foro', 'core.foro.url_foro', 'core.categoria_foro.url_categoria_foro', 'foro_institucion.contador_comentario', 'foro_institucion.contador_like', 'usuario.nombre_usuario', 'usuario.imagen_usuario')
       		// Forum institution
			->join('core.foro_institucion', function($join) {
       			$join->on('foro.codigo_foro', '=', 'foro_institucion.codigo_foro')
					->where('foro_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
					->where('foro_institucion.codigo_estado', '=', Estado::getState('active'));
      		})
      		->join('core.categoria_foro_institucion', function ($join) {
	            $join->on('categoria_foro.codigo_categoria_foro', '=', 'categoria_foro_institucion.codigo_categoria_foro')
	                ->on('categoria_foro_institucion.codigo_institucion', '=', 'foro_institucion.codigo_institucion')
	                ->where('categoria_foro_institucion.codigo_estado', '=', Estado::getState('active'));
	        })
      		// Forum user
  			->join('seguridad.usuario', 'foro.codigo_usuario', '=', 'usuario.codigo_usuario')
   			->orderBy('foro_institucion.contador_comentario','desc')
			->take(Input::get('limit')?:4)->get();
   	}

   	/**
	 * get related topics by one theme
	 * @param {Foro} $forum
	 * @param {array} $filters
	 * @return {stdClass} $response
   	 */
   	public static function getRelatedThemes($forum, array $filters = [])
   	{
   		if(!$forum instanceof Foro) {
   			abort(404);
   		}

   		$forumTags = $forum->tags()->get()->implode('codigo_tag', ',');

   		$query = Foro::query();
   		// Forum institution
   		$query->join('core.foro_institucion', function($join){
   			$join->on('foro.codigo_foro', '=', 'foro_institucion.codigo_foro')
   				->where('foro_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('foro_institucion.codigo_estado', '=', Estado::getState('active'));
   		});

   		// Query to tags relationships
   		$query->where(function($query) use($forumTags, $forum){
   			if(strlen($forumTags)) {
		   		$query->whereRaw("foro.codigo_foro in (select codigo_foro
		   			from core.tag_foro
		   			where codigo_tag in($forumTags)
		   		)");
   			}
			$query->orWhere('foro.codigo_categoria_foro', $forum->codigo_categoria_foro);
   		});
   		$query->where('foro.codigo_foro', '!=', $forum->codigo_foro);
   		$query->where('foro.codigo_usuario', '!=', $forum->codigo_usuario);

   		// Get total posts count
		$total_entries = $query->count();

   		$query->orderBy('foro.fecha_apertura_foro', 'desc');
   		$query->orderBy('foro_institucion.contador_like', 'desc');
   		if(
			isset($filters['offset']) && is_int((int)$filters['offset']) &&
			isset($filters['limit']) && is_int((int)$filters['limit'])
		) {
			$query->skip($filters['offset'])->take($filters['limit']);
   		}
   		// Get posts
		$results = $query->get();

   		$forums = [];
   		if(isset($results) && count($results) > 0) {
   			foreach ($results as $f) {
   				$forums[] = Foro::buildForum($f);
   			}
   		}

		$response = new \stdClass();
		$response->total_entries = $total_entries;
		$response->items = $forums;
		return $response;
   	}

   	/**
	 * get related forum themes by author
	 * @param {array} filters
	 * @return {stdClass} $response
   	 */
   	public static function themesByAuthor(array $filters = [])
   	{
   		if(!isset($filters['nickname'])) {
   			abort(404);
   		}
   		$query = Foro::query();

   		// Forum institution
   		$query->join('core.foro_institucion', function($join){
   			$join->on('foro.codigo_foro', '=', 'foro_institucion.codigo_foro')
   				->where('foro_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('foro_institucion.codigo_estado', '=', Estado::getState('active'));
   		});

   		// themes by author
		$usuario = Usuario::getUser($filters['nickname']);
		if(!$usuario instanceof Usuario) {
			return array('success' => false, 'errors' => "El usuario con el nickname '".$filters['nickname']."' no se encuentra");
		}
		$query->where('foro.codigo_usuario', '=', $usuario->codigo_usuario);

   		// unlike current forum
   		if(isset($filters['url_foro']) && !empty($filters['url_foro'])) {
   			$forum = Foro::getForum($filters['url_foro']);

   			if($forum instanceof Foro) {
   				$query->where('foro.codigo_foro', '!=', $forum->codigo_foro);
   			}
   		}

   		// Get total posts count
		$total_entries = $query->count();

   		$query->orderBy('foro.fecha_apertura_foro', 'desc');
   		$query->orderBy('foro_institucion.contador_like', 'desc');

   		if(
			isset($filters['offset']) && is_int((int)$filters['offset']) &&
			isset($filters['limit']) && is_int((int)$filters['limit'])
		) {
			$query->skip($filters['offset'])->take($filters['limit']);
   		}
		// Get posts
		$results = $query->get();

   		$forums = [];
   		if(isset($results) && count($results) > 0) {
   			foreach ($results as $f) {
   				$forums[] = Foro::buildForum($f);
   			}
   		}

		$response = new \stdClass();
		$response->total_entries = $total_entries;
		$response->items = $forums;
		return $response;
   	}

   	/**
	 * Build forum.
	 */
   	public static function buildForum($forum)
   	{
		$object = new \stdClass();
		$object->cod = $forum->codigo_foro;
		$object->codigo_foro = TuProyecto::encryptSrcParams([$forum->codigo_foro]);
		$object->titulo_foro = $forum->titulo_foro;
		$object->codigo_categoria_foro = $forum->codigo_categoria_foro;
		$object->url_foro = $forum->url_foro;
		$object->nombre_categoria_foro = $forum->categoria->nombre_categoria_foro;
		$object->url_categoria_foro = $forum->categoria->url_categoria_foro;
		$object->descripcion_foro = $forum->descripcion_foro;
		$object->fecha_apertura_foro = $forum->fecha_apertura_foro;
		$object->hora_apertura_foro = $forum->hora_apertura_foro;
		$object->time_ago = TuProyecto::timeAgo($forum->fecha_apertura_foro, $forum->hora_apertura_foro);

		$object->nombre_usuario = $forum->nombre_usuario ?:$forum->usuario->nombre_usuario;
		$object->imagen_usuario = $forum->usuario->imagen_usuario;
		$object->nickname_usuario = $forum->usuario->nickname_usuario;
		$object->nickname = $forum->usuario->nickname();
		$object->contador_comentario = $forum->institucion->contador_comentario?:0;
		$object->contador_like = $forum->institucion->contador_like?:0;
		$object->url_profile = $forum->usuario->getProfileUrl();
		$object->ciudad_usuario = '';
		if($forum->usuario->codigo_ciudad) {
			$object->ciudad_usuario = $forum->usuario->ciudad->cityFormat();
		}

		$object->tags = $forum->tags()->get()->implode('texto_tag', ',');

		// Secure srcparams
		$object->srcparams = TuProyecto::encryptSrcParams([$forum->codigo_foro, Recurso::getResource('foro.gestion')]);
		return $object;
   	}

   	public function metatitle()
   	{
   		$meta_title = "%s / %s: %s";
		return sprintf($meta_title, Lang::get('forum.forum'), $this->categoria->nombre_categoria_foro, $this->attributes['titulo_foro']);
   	}

	/**
	 * Defining Relations
	*/

	public function usuario()
    {
        return $this->hasOne('App\Usuario','codigo_usuario','codigo_usuario');
    }

    public function categoria()
    {
        return $this->hasOne('App\CategoriaForo','codigo_categoria_foro','codigo_categoria_foro');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'core.tag_foro', 'codigo_foro', 'codigo_tag');
    }

    public function institucion()
    {
    	return $this->belongsTo('App\ForoInstitucion', 'codigo_foro', 'codigo_foro')
    			->where('codigo_institucion', RegistroSesion::getInstitution())
    			->where('codigo_estado', Estado::getState('active'));
    }
}
