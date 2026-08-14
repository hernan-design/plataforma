<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

use TuProyecto;

use DB, Input, Auth, Cookie, Validator;

class Contenido extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.contenido';

	protected $primaryKey = 'codigo_contenido';

	public $timestamps = false;

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['codigo_institucion', 'codigo_usuario', 'nombre_contenido', 'resumen_contenido', 'texto_contenido', 'imagen_contenido', 'fuente_contenido', 'privacidad_contenido', 'landing_contenido'];

	/**
	* Valid create content.
	*/
	public function isValid($data)
	{
		$rules = [
			'nombre_contenido'		=> 'required',
			'resumen_contenido'		=> 'required|max:200',
            'codigo_tipo_cont_institucion'	=> 'required'
		];

		$validator = Validator::make($data, $rules);
		if ($validator->passes()) {
			return true;
		}
		$this->errors = $validator->errors();
		return false;
	}

	/**
	* Valid publication article.
	*/
   	public function isValidPublication($data)
    {
        $rules = [
          	'nombre_contenido' => 'required',
            'texto_contenido' => 'required',
          	'imagen_contenido' => 'required'
       	];

     	$validator = Validator::make($data, $rules);
        if ($validator->passes()) {
     		return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

	public static function getPrivacy($privacy)
	{
		switch ($privacy) :
			case 'public': return 1;
            case 'private': return 2;
            case 'hidden': return 3;
			default: return 'Not privacy identified';
		endswitch;
	}

	/**
	 * SQL used to validate the state of article.
	 *
	 * @var string
	 */
	public static $raw_article = '(CASE
			WHEN (COALESCE(contenido_institucion.codigo_estado, 0) = 2)  THEN \'review\'
			WHEN (COALESCE(contenido_institucion.codigo_estado, 0) = 8)  THEN \'published\'
			WHEN (COALESCE(contenido_institucion.codigo_estado, 0) = 9)  THEN \'inactive\'
			WHEN (COALESCE(contenido_institucion.codigo_estado, 0) = 14) THEN \'pending\'
		END)';

	public static function getArticle($article)
	{
		$query = Contenido::query();
		$query->select('contenido.*', 'tipo_contenido_insti.codigo_tipo_contenido','tipo_contenido.nombre_tipo_contenido', 'url_tipo_contenido', 'nickname_usuario', 'imagen_usuario',
			DB::raw("(CASE usuario.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '') ELSE nombre_usuario END) as nombre_usuario"),
			(Auth::check() ? DB::raw(sprintf('%s %s', Contenido::$raw_article, 'as state_article')) : DB::raw('\'\' as state_article')),
            DB::raw(sprintf('%s %s', Seo::$raw_follow, 'as enlaces_motores_busqueda')),
            DB::raw(sprintf('%s %s', Seo::$raw_index, 'as indexar_motores'))
		);

		$query->join('core.contenido_institucion', function($join) {
       		$join->on('contenido.codigo_contenido', '=', 'contenido_institucion.codigo_contenido')
				->where('contenido_institucion.codigo_institucion', '=', RegistroSesion::getInstitution());
      	});

		$query->join('param.tipo_contenido_insti', function($join) {
            $join->on('contenido_institucion.codigo_tipo_cont_institucion', '=', 'tipo_contenido_insti.codigo_tipo_cont_institucion')
                ->where('tipo_contenido_insti.codigo_institucion', '=', RegistroSesion::getInstitution())
                ->where('tipo_contenido_insti.codigo_estado', '=', Estado::getState('active'));
        });
    	$query->join('core.tipo_contenido', 'tipo_contenido_insti.codigo_tipo_contenido', '=', 'tipo_contenido.codigo_tipo_contenido');

		$query->join('seguridad.usuario', 'contenido.codigo_usuario', '=', 'usuario.codigo_usuario');
        $query->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');

        $query->leftJoin('core.seo', function($join){
			$join->on('contenido.codigo_contenido', '=', 'seo.id_recurso')
				->where('seo.codigo_modulo', Modulo::getModule('blog'));
		});

		$query->where(function($query)
		{
			$query->where('contenido_institucion.codigo_estado', '=', Estado::getState('active'));
			if(Auth::check()) {
				$query->orWhere('contenido.codigo_usuario', Auth::user()->codigo_usuario);
			}
		});

		$query->where(function ($query) {
			$query->whereIn('contenido.privacidad_contenido', [PrivacidadContenido::getPrivacy('public'), PrivacidadContenido::getPrivacy('hidden')]);
			if(Auth::check()) {
				$query->orWhere('contenido.codigo_usuario', '=', Auth::user()->codigo_usuario);
			}
		});

		$query->whereRaw("trim(lower(url_contenido)) = trim(lower('$article'))");
		return $query->first();
	}

	public static function getLastArticles($landing = false, $limit = 6)
	{
		$query = Contenido::query();
		$query->select('contenido.codigo_contenido', 'nombre_contenido', 'imagen_contenido', 'resumen_contenido', 'url_contenido', 'tipo_contenido.nombre_tipo_contenido', 'url_tipo_contenido', 'fecha_contenido', 'texto_contenido', 'contenido_institucion.contador_like', 'contenido_institucion.contador_comentario', 'contenido.codigo_usuario',
		(Auth::check() ? DB::raw(sprintf('%s %s', Contenido::$raw_article, 'as state_article')) : DB::raw('\'\' as state_article')));

		$query->join('core.contenido_institucion', function($join) {
       		$join->on('contenido.codigo_contenido', '=', 'contenido_institucion.codigo_contenido')
				->where('contenido_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('contenido_institucion.codigo_estado', '=', Estado::getState('active'));
      	});

		$query->join('param.tipo_contenido_insti', function($join) {
            $join->on('contenido_institucion.codigo_tipo_cont_institucion', '=', 'tipo_contenido_insti.codigo_tipo_cont_institucion')
                ->where('tipo_contenido_insti.codigo_institucion', '=', RegistroSesion::getInstitution())
                ->where('tipo_contenido_insti.codigo_estado', '=', Estado::getState('active'));
        });
    	$query->join('core.tipo_contenido', 'tipo_contenido_insti.codigo_tipo_contenido', '=', 'tipo_contenido.codigo_tipo_contenido');
		$query->where('contenido.codigo_estado', Estado::getState('active'));
    	$query->where('privacidad_contenido', '=', PrivacidadContenido::getPrivacy('public'));

		if($landing) {
			$query->where('contenido_institucion.landing_contenido', true);
		}
		$query->orderBy('contenido.fecha_contenido','desc');
		$query->orderBy('contenido.hora_contenido','desc');
		return $query->take($limit)->get();
	}

   	public static function getArticles()
   	{
   		$articles = [];
   		$total_entries = 0;

		$query = Contenido::query();
		$query->select('contenido.codigo_contenido', 'tipo_contenido.codigo_tipo_contenido', 'nombre_contenido','resumen_contenido', 'texto_contenido', 'imagen_contenido','contenido.codigo_usuario',
			'url_contenido','url_tipo_contenido','fecha_contenido', 'contenido_institucion.contador_like', 'contenido_institucion.contador_comentario', 'imagen_usuario', 'nickname_usuario',
			DB::raw("(CASE usuario.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '') ELSE nombre_usuario END) as nombre_usuario"),
			DB::raw('(COALESCE(contenido.contador_like, 0) + ( COALESCE(contenido.contador_comentario,0)/5 )) as important'),
			(Auth::check() ? DB::raw(sprintf('%s %s', Contenido::$raw_article, 'as state_article')) : DB::raw('\'\' as state_article'))
		);

		$query->join('core.contenido_institucion', function($join) {
       		$join->on('contenido.codigo_contenido', '=', 'contenido_institucion.codigo_contenido')
				->where('contenido_institucion.codigo_institucion', '=', RegistroSesion::getInstitution());
      	});

    	$query->join('param.tipo_contenido_insti', function($join) {
            $join->on('contenido_institucion.codigo_tipo_cont_institucion', '=', 'tipo_contenido_insti.codigo_tipo_cont_institucion')
                ->where('tipo_contenido_insti.codigo_institucion', '=', RegistroSesion::getInstitution())
                ->where('tipo_contenido_insti.codigo_estado', '=', Estado::getState('active'));
        });
    	$query->join('core.tipo_contenido', 'tipo_contenido_insti.codigo_tipo_contenido', '=', 'tipo_contenido.codigo_tipo_contenido');

		$query->join('seguridad.usuario', 'contenido.codigo_usuario', '=', 'usuario.codigo_usuario');
		$query->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');

		$query->where('contenido.codigo_estado', '=', Estado::getState('active'));
		$query->where(function($query)
		{
			$query->where('contenido_institucion.codigo_estado', '=', Estado::getState('active'));
			if(Auth::check()) {
				$query->orWhere('contenido.codigo_usuario', Auth::user()->codigo_usuario);
			}
		});

		$query->where(function ($query) {
            $query->where('privacidad_contenido', '=', 
            PrivacidadContenido::getPrivacy('public'));
			if(Auth::check()) {
				$query->orWhere('contenido.codigo_usuario', '=', Auth::user()->codigo_usuario);
			}
		});

		if( Input::has('category') && !empty(Input::get('category')) ) {
			$category = Input::get('category');
 			$query->whereRaw("trim(lower(url_tipo_contenido)) = trim(lower('$category'))");
 		}

 		if(Input::has('article') && !empty(Input::get('article'))) {
			$article = Input::get('article');
 			$query->whereRaw("trim(lower(url_contenido)) = trim(lower('$article'))");
 		}

 		$query->whereNotIn('contenido.imagen_contenido', [
			'https://lh6.googleusercontent.com/-NtJLiTZeioY/Uk8mE2BraXI/AAAAAAAABlc/0J7qX7azPUo/w370-h206-c/sinimagenproducto.png'
		]);

 		// Filters
		switch (Input::has('typeData')) {
		    case 'mostViewed':
     			$query->where(function($query)
		        {
		            $query->where('contenido_institucion.contador_like', '>', 0)
		                  ->orWhere('contenido_institucion.contador_comentario', '>', 0);
		        });
	        	$query->whereRaw('(contenido_institucion.contador_like + ( contenido_institucion.contador_comentario/5 )) > 0');
		    	break;
		}

		// Filter channel
		if (Input::has('url_canal')) {
			$query->join('core.contenido_canal', function($join) {
	            $join->on('contenido.codigo_contenido', '=', 'contenido_canal.codigo_recurso_modulo')
	                ->where('contenido_canal.codigo_modulo', '=', Modulo::getModule('blog'))
	                ->where('contenido_canal.codigo_estado', '=', Estado::getState('active'));
	        });

	        $query->join('core.canal', function($join) {
	            $join->on('contenido_canal.codigo_canal', '=', 'canal.codigo_canal')
	                ->where('canal.url_canal', '=', Input::get('url_canal'))
					->where('canal.codigo_institucion', '=', RegistroSesion::getInstitution());
	        });
		}

        // Data
		switch (Input::has('typeData')) {
		    case 'mostViewed':
     			$data = $query->take(10)->get();

				$query->orderByRaw('important desc');
   		   		$query->orderBy('contenido.contador_like','desc');
   		   		$query->orderBy('contenido.contador_comentario','desc');
		    	break;
		   	default:
		   		// Get total posts
				$total_entries = $query->get()->count();
    			$query->skip(Input::get('offset'))->take(Input::get('limit'));
		    	break;
		}

		$query->orderBy('contenido.fecha_contenido','desc');
		$query->orderBy('contenido.hora_contenido','desc');

        // Get posts
		$data = $query->get();

		if(count($data) > 0) {
			foreach ($data as $article) {
				$contenido = new \stdClass();
				$contenido->codigo_contenido = $article->codigo_contenido;
				$contenido->imagen_contenido = $article->imagen_contenido;
				$contenido->url_contenido = $article->url_contenido;
				$contenido->url_tipo_contenido = $article->url_tipo_contenido;
				$contenido->fecha_contenido = $article->fecha_contenido;
				$contenido->contador_like = $article->contador_like;
				$contenido->contador_comentario = $article->contador_comentario;
				$contenido->nombre_contenido = $article->nombre_contenido;
				$contenido->resumen_contenido = $article->resumen_contenido;

				$contenido->nombre_usuario = $article->nombre_usuario;
				$contenido->imagen_usuario = $article->imagen_usuario;
				$contenido->nickname_usuario = $article->nickname_usuario;
				$contenido->url_profile = $article->usuario->getProfileUrl();

				// Secure srcparams
				$contenido->srcparams = TuProyecto::encryptSrcParams([$article->codigo_contenido, Recurso::getResource('blog.gestion')]);
				$articles[] = $contenido;
			}
		}

		switch (Input::has('typeData')) {
		    case 'mostViewed':
     			return $articles;
		    default:
			  	$response = new \stdClass();
				$response->total_entries = $total_entries;
				$response->items = $articles;
		   		return $response;
		}
   	}

	/**
	 * Build Article.
	 */
   	public static function buildArticle($article)
   	{
		$object = new \stdClass();

		$object->codigo_contenido = TuProyecto::encryptSrcParams([$article->codigo_contenido]);
		$object->nombre_contenido = $article->nombre_contenido;
		$object->nombre_corto_contenido =  TuProyecto::cutStrictFormatString($article->nombre_contenido, 70);

		$object->codigo_tipo_contenido = $article->codigo_tipo_contenido;
		$object->imagen_contenido = $article->imagen_contenido;
		$object->resumen_contenido = $article->resumen_contenido;
		$object->url_contenido = $article->url_contenido;
		$object->texto_contenido = $article->texto_contenido;
		$object->fecha_contenido = $article->fecha_contenido;
		$object->url_tipo_contenido = $article->categoria->url_tipo_contenido;
		$object->nombre_tipo_contenido = $article->categoria->nombre_tipo_contenido;
		$object->time_ago = TuProyecto::timeAgo($article->fecha_contenido, $article->hora_contenido);
		$object->owner = (Auth::check() && Auth::user()->codigo_usuario == $article->codigo_usuario) ? true : false;
		$object->state_article = $article->state_article;

		$object->contador_like = $article->contador_like;
		$object->contador_comentario = $article->contador_comentario;

		// Get data User
		$object->nombre_usuario = $article->nombre_usuario;
		$object->imagen_usuario = $article->imagen_usuario;
		$object->nickname_usuario = $article->nickname_usuario;

        $object->url_profile = $article->usuario->getProfileUrl();

        // SEO
		$object->nombre_facebook = $article->nombre_facebook;
		$object->nombre_twitter = $article->nombre_twitter;
		$object->descripcion_facebook = $article->descripcion_facebook;
		$object->descripcion_twitter = $article->descripcion_twitter;
		$object->imagen_facebook = $article->imagen_facebook;
		$object->imagen_twitter = $article->imagen_twitter;
        $object->url_canonica = $article->url_canonica;
        $object->directivas = !empty($article->indexar_motores) ? "{$article->indexar_motores},{$article->enlaces_motores_busqueda}" : '';
		$object->tags_content = $article->tags()->get()->implode('texto_tag', ',');

		// Secure srcparams
		$object->srcparams = TuProyecto::encryptSrcParams([$article->codigo_contenido, Recurso::getResource('blog.gestion')]);
		return $object;
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
        return $this->hasOne('App\TipoContenido','codigo_tipo_contenido','codigo_tipo_contenido');
    }

	/**
	 * Get the institutions content for the blog post.
	 */
	public function institutions()
	{
		return $this->hasMany('App\ContenidoInstitucion', 'codigo_contenido', 'codigo_contenido');
	}

	public function tags()
    {
        return $this->belongsToMany('App\Tag', 'core.tag_contenido', 'codigo_contenido', 'codigo_tag');
    }
}
