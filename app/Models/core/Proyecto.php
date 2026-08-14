<?php
namespace App;

use DB, Auth, Input, App, Lang, Validator, URL;

use TuProyecto;

use App\Models;

class Proyecto extends BaseModel {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.proyecto';

   	protected $primaryKey = 'codigo_proyecto';

	protected $fillable = array('nombre_proyecto','resumen_proyecto','codigo_clase_emprendimiento', 'identificacion_proyecto','imagen_proyecto', 'video_proyecto','descripcion_proyecto','facebook_proyecto','twitter_proyecto','linkedin_proyecto','pagina_web_proyecto','codigo_ciudad','codigo_categoria_clase_espacio');

	protected $nullable = ['codigo_ciudad', 'codigo_categoria_clase_espacio'];

    public static function getPrivacy($privacy)
    {
    	switch ($privacy) :
		    case 'private': return 0;
		    case 'public': return 1;
			default: return 'Not privacy identified';
		endswitch;
    }

    // Can be used to set columns to be returned as instances of Carbon
	public function getDates()
	{
		return [];
	}

    public function getUpdatedAtAttribute($date)
	{
		return date('Y-m-d H:i:s', strtotime($date));
	}

    public static function getPrivacies()
    {
    	return [1 => 'Publico', 2  => 'Mi red', 3 => 'Mi Institucion', 5 => 'Privado'];
   	}

   	/**
	* Valid create Project.
	*/
   	public function isValid($data)
    {
        $rules = array(
            'nombre_proyecto' => 'required|max:80',
            'resumen_proyecto' => 'required|string|words:1,200'
        );

     	$validator = Validator::make($data, $rules);
        if ($validator->passes()) {
     		return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    /**
	* Project data detail from url.
	*/

	public static function getProjectUrl($project)
	{
		$query = Proyecto::query();
		$query->select('proyecto.*', 'proyecto.codigo_usuario as owner', 'nombre_ciudad', 'nombre_pais', 'nombre_privacidad_contenido', 'icono_privacidad_contenido', 'nombre_categoria_proyecto');

		// City / Country
		$query->leftjoin('core.ciudad', 'proyecto.codigo_ciudad', '=', 'ciudad.codigo_ciudad');
		$query->leftjoin('core.pais', 'ciudad.codigo_pais', '=', 'pais.codigo_pais');

		$query->join('core.proyecto_institucion', function($join) {
       		$join->on('proyecto.codigo_proyecto', '=', 'proyecto_institucion.codigo_proyecto')
				->where('proyecto_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('proyecto_institucion.codigo_estado', '=', Estado::getState('active'));
      	});

		$query->leftjoin('core.categoria_proyecto', 'proyecto_institucion.codigo_categoria_proyecto', '=', 'categoria_proyecto.codigo_categoria_proyecto');

		$query->leftjoin('core.privacidad_contenido', 'proyecto_institucion.codigo_privacidad_contenido', '=', 'privacidad_contenido.codigo_privacidad_contenido');

		$query->whereRaw(("trim(lower(url_proyecto)) = trim(lower('$project'))"));
		return $query->first();
	}

   	public static function getLastProjects($codigo_institucion, $privacidad_institucion, $limit = 8)
   	{
		$query = Proyecto::query();
		$query->select('codigo_proyecto', 'nombre_proyecto', 'imagen_proyecto', 'resumen_proyecto', 'url_proyecto');

		// Validate privacy user institucion
		$query->join('core.usuario_institucion', function($join) use($codigo_institucion, $privacidad_institucion) {
	        $join->on('proyecto.codigo_usuario', '=', 'usuario_institucion.codigo_usuario')
				->where('usuario_institucion.codigo_estado', '=', Estado::getState('active'));
				if($privacidad_institucion) {
	    			$join->where('usuario_institucion.codigo_institucion', '=', $codigo_institucion);
				}
	      	});
		$query->join('param.institucion', 'usuario_institucion.codigo_institucion', '=', 'institucion.codigo_institucion');
		$query->where('institucion.privacidad_institucion', '=', $privacidad_institucion);

	  	$query->where('proyecto.codigo_estado', Estado::getState('active'));
		$query->whereNotIn('proyecto.imagen_proyecto', [
			'https://lh5.googleusercontent.com/-NzhKr_iafRU/VG5tNVnWJbI/AAAAAAAAKPk/I4uuQCQPJT4/w770-h343-no/proyecto_desarrollo.png',
			'https://lh5.googleusercontent.com/-smTUYpMTfv4/UjH44X0eqvI/AAAAAAAABLs/tC3E7y7UbZ0/s444/noimagen.jpg',
			'http://tuproyecto.com/img/no-project.png',
			'http://static.tuproyecto.com/images/svg/no-image.svg'
		]);
		$query->groupBy('codigo_proyecto');
		$query->orderBy('proyecto.codigo_proyecto','desc');
		return $query->take($limit)->get();
   	}

   	public static function getProjects()
   	{
   		$projects = [];
		$query = Proyecto::query();
		$query->select('proyecto.codigo_proyecto','proyecto.codigo_clase_emprendimiento', 'nombre_clase_emprendimiento','nombre_proyecto', 'imagen_proyecto', 'resumen_proyecto', 'url_proyecto', 'contador_comentario', 'contador_like',
			DB::raw('(COALESCE(proyecto.contador_like, 0) + ( COALESCE(proyecto.contador_comentario,0)/5 )) as important'), 'proyecto.codigo_usuario as owner');

		$query->join('core.proyecto_institucion', function($join) {
       		$join->on('proyecto.codigo_proyecto', '=', 'proyecto_institucion.codigo_proyecto')
				->where('proyecto_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('proyecto_institucion.codigo_estado', '=', Estado::getState('active'));
      	});

		$query->join('core.clase_emprendimiento', 'proyecto.codigo_clase_emprendimiento', '=', 'clase_emprendimiento.codigo_clase_emprendimiento');

		switch (Input::get('type')) {
		    case 'trending':
				$query->whereNotIn('proyecto.imagen_proyecto', [
					'https://lh5.googleusercontent.com/-NzhKr_iafRU/VG5tNVnWJbI/AAAAAAAAKPk/I4uuQCQPJT4/w770-h343-no/proyecto_desarrollo.png',
					'https://lh5.googleusercontent.com/-smTUYpMTfv4/UjH44X0eqvI/AAAAAAAABLs/tC3E7y7UbZ0/s444/noimagen.jpg',
					'http://tuproyecto.com/img/no-project.png',
					'http://static.tuproyecto.com/images/svg/no-image.svg'
				]);
		    	$query->whereNotNull('proyecto.imagen_proyecto');
		    	$query->where('proyecto_institucion.codigo_privacidad_contenido', '=', PrivacidadContenido::getPrivacy('public'));
		   		$query->orderByRaw('important desc');
	        break;

		    case 'owner':
		    	if(Auth::check()) {
     				$query->where('proyecto.codigo_usuario', '=', Auth::user()->codigo_usuario);
	        	}
	        break;

		    case 'user':
 				// Decrypt src-params
		        list($codigo_usuario) = TuProyecto::decryptSrcParams(Input::get('srcparams-user'));
		        if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
		            App::abort(403);
		        }

		        $query->where('proyecto.codigo_usuario', '=', $codigo_usuario);
		    	$query->where('proyecto_institucion.codigo_privacidad_contenido', '=', PrivacidadContenido::getPrivacy('public'));
    		break;

    		default:
				$query->whereNotIn('proyecto.imagen_proyecto', [
					'https://lh5.googleusercontent.com/-NzhKr_iafRU/VG5tNVnWJbI/AAAAAAAAKPk/I4uuQCQPJT4/w770-h343-no/proyecto_desarrollo.png',
					'https://lh5.googleusercontent.com/-smTUYpMTfv4/UjH44X0eqvI/AAAAAAAABLs/tC3E7y7UbZ0/s444/noimagen.jpg',
					'http://tuproyecto.com/img/no-project.png',
					'http://static.tuproyecto.com/images/svg/no-image.svg'
				]);
		    	$query->whereNotNull('proyecto.imagen_proyecto');
		    	$query->where('proyecto_institucion.codigo_privacidad_contenido', '=', PrivacidadContenido::getPrivacy('public'));
		   		$query->orderBy('proyecto.codigo_proyecto','desc');
    		break;
		}

		if(Input::has('category')){
			$query->where('proyecto_institucion.codigo_categoria_proyecto', Input::get('category'));
		}

		if(Input::has('grade')) {
			$query->where('clase_emprendimiento.url_clase_emprendimiento', '=', Input::get('grade'));
		}

   		$query->orderByRaw('important desc');
   		$query->orderBy('proyecto.contador_like','desc');
   		$query->orderBy('proyecto.contador_comentario','desc');
   		$query->orderBy('proyecto.codigo_proyecto','desc');

		// Get total posts
		$total_entries = $query->get()->count();

    	$query->skip(Input::get('offset'))->take(Input::get('limit'));

        // Get posts
		$data = $query->get();
		if(count($data) > 0) {
			foreach ($data as $project) {
				$proyecto = new \stdClass();
				$proyecto->codigo_proyecto = $project->codigo_proyecto;
				$proyecto->url_proyecto = $project->url_proyecto;
				$proyecto->nombre_proyecto = $project->nombre_proyecto;
				$proyecto->imagen_proyecto = $project->imagen_proyecto;
				$proyecto->codigo_clase_emprendimiento = $project->codigo_clase_emprendimiento;
				$proyecto->nombre_clase_emprendimiento = $project->nombre_clase_emprendimiento;
				$proyecto->identificacion_proyecto = $project->identificacion_proyecto;
				$proyecto->resumen_proyecto = $project->resumen_proyecto;

				$proyecto->contador_comentario = $project->contador_comentario;
				$proyecto->contador_like = $project->contador_like;

				$proyecto->owner = (Auth::check() && Auth::user()->codigo_usuario == $project->owner) ? true : false;
				// Secure srcparams
				$proyecto->srcparams = TuProyecto::encryptSrcParams([$project->codigo_proyecto, Recurso::getResource('proyectos.gestion')]);
				$projects[] = $proyecto;
			}
		}

		$response = new \stdClass();
		$response->total_entries = $total_entries;
		$response->items = $projects;
   		return $response;
   	}

   	/**
	 * Build Project.
	*/
   	public static function buildProject($project)
   	{
		$object = new \stdClass();
		$object->id_proyecto = $project->codigo_proyecto;
		$object->codigo_proyecto = TuProyecto::encryptSrcParams([$project->codigo_proyecto]);
		$object->imagen_proyecto = $project->imagen_proyecto;
		$object->video_proyecto = $project->video_proyecto;
		$object->identificacion_proyecto = $project->identificacion_proyecto;
		$object->codigo_categoria_clase_espacio = $project->codigo_categoria_clase_espacio;
		$object->nombre_privacidad_contenido = $project->nombre_privacidad_contenido;
		$object->icono_privacidad_contenido = $project->icono_privacidad_contenido;
		$object->nombre_categoria_proyecto = $project->nombre_categoria_proyecto;

		// Get data ClassEntrepreneurship
		$projectclass = $project->claseEmprendimiento;
		$object->nombre_clase_emprendimiento = $projectclass->nombre_clase_emprendimiento;

		// Get data Project Institution
		$projectinstitution = $project->proyectoInstitucion;
		$object->codigo_etapa_proyecto = $projectinstitution->codigo_etapa_proyecto;
		$object->codigo_categoria_proyecto = $projectinstitution->codigo_categoria_proyecto;
		$object->codigo_privacidad_contenido = $projectinstitution->codigo_privacidad_contenido;

		$object->codigo_clase_emprendimiento = $project->codigo_clase_emprendimiento;
		$object->codigo_ciudad = $project->codigo_ciudad;
		$object->nombre_ciudad = $project->nombre_ciudad;
		$object->nombre_pais = $project->nombre_pais;

		$object->nombre_proyecto = ucfirst(strtolower($project->nombre_proyecto));
		$object->resumen_proyecto = ucfirst(strtolower($project->resumen_proyecto));
		$object->descripcion_proyecto =  $project->descripcion_proyecto;

		$object->url_proyecto = $project->url_proyecto;
		$object->url_edit_proyecto = $project->url_proyecto;

		$object->contador_comentario = $project->contador_comentario;
		$object->contador_like = $project->contador_like;

		$object->facebook_proyecto = $project->facebook_proyecto;
		$object->twitter_proyecto = $project->twitter_proyecto;
		$object->linkedin_proyecto = $project->linkedin_proyecto;
		$object->pagina_web_proyecto = $project->pagina_web_proyecto;

		// Get data User
		$user = $project->usuario;
		$object->codigo_usuario = TuProyecto::encryptSrcParams([$user->codigo_usuario]);
		$object->nombre_usuario = $user->nombre_usuario;
		$object->imagen_usuario = $user->imagen_usuario;
		$object->nickname_usuario = $user->nickname_usuario;
		$object->contador_gamification = $user->contador_gamification;
		$object->posicion_gamification = $user->posicion_gamification;

		$object->tags = $project->tags()->get()->implode('texto_tag', ',');
		$object->updated_at = $project->updated_at;

		$object->owner = false;
		if(Auth::check()){
			$object->owner = Auth::user()->codigo_usuario == $project->owner ? true : false;
		}
		// Secure srcparams
		$object->srcparams = TuProyecto::encryptSrcParams([$project->codigo_proyecto, Recurso::getResource('proyectos.gestion')]);
		return $object;
   	}

   	public function metatitle()
   	{
   		$meta_title = "%s / %s";
		return sprintf($meta_title, Lang::choice('project.project',1), $this->attributes['nombre_proyecto']);
   	}

	/**
	* Job Queue notification mail.
	*/
  	public function notification($job, $data)
    {
	    $project = Proyecto::find($data['codigo_proyecto']);
	    if(!$project instanceof Proyecto) {
	      throw new Exception("Proyecto not found");
	    }
	    // Mail notification
	    $data = array();
	    $data['_subject'] = Lang::get('project.mail.create.subject');
	    $data['_template'] = 'emails.project.create';

	    // Data Template
	    $data['nombre_proyecto'] = $project->nombre_proyecto;
	    $data['url_proyecto'] = URL::route('proyecto.proyecto', array('proyecto' => $project->url_proyecto), false);

	    $data['_url_user_action'] = $project->usuario->getProfileUrl();
	    $data['_name_user_action'] = $project->usuario->nombre_usuario;

	    $data['_to'] = $project->usuario->correo_electronico;
	    $data['_to_name'] = $project->usuario->nombre_usuario;

	    SendEmail::notification($data);

	    // Delete Job
	    $job->delete();
  	}

  	public function getAllowedUsers()
  	{
  		return [$this->attributes['codigo_usuario']];
  	}

   	/**
	 * Defining Relations
	*/

	public function usuario()
    {
        return $this->hasOne('App\Usuario','codigo_usuario','codigo_usuario');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'core.tag_proyecto', 'codigo_proyecto', 'codigo_tag');
    }

    public function comentarios()
    {
        return $this->hasMany('App\ComentarioProyecto','codigo_proyecto','codigo_proyecto');
    }

    public function proyectoInstitucion()
    {
        return $this->hasOne('App\ProyectoInstitucion','codigo_proyecto','codigo_proyecto');
    }

    public function claseEmprendimiento()
    {
        return $this->hasOne('App\ClaseEmprendimiento','codigo_clase_emprendimiento','codigo_clase_emprendimiento');
    }

    public function intereses()
    {
        return $this->hasMany('App\SectorInteresProyecto','codigo_proyecto','codigo_proyecto');
    }
}
