<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

use DB, Input, Auth, App, TuProyecto;

class Grupo extends Model {

	/**
	 * The database table used by the model of project.
	 *
	 * @var string
	 */
    protected $table = 'core.entidad';

   	protected $primaryKey = 'codigo_entidad';

   	protected $fillable = array('codigo_clase_emprendimiento', 'video_entidad', 'descripcion_entidad');

	public static $raw_joingroup = '(CASE
		WHEN (COALESCE(grupo_usuario.codigo_estado, 0) = 8 and COALESCE(grupo_usuario.codigo_estado, 0) = 8) THEN \'join\'
		WHEN ( (grupo_usuario.codigo_estado is null or COALESCE(grupo_usuario.codigo_estado, 0) = 13) ) THEN \'desert\'
		END)';

   	public static function getGroups()
   	{
   		$groups = [];
		$query = Grupo::query();
		$query->select('entidad.codigo_entidad','entidad.codigo_clase_emprendimiento', 'nombre_clase_emprendimiento','nombre_usuario', 'imagen_usuario', 'biografia_usuario', 'usuario.nickname_usuario as url_nickname', 'contador_comentario', 'contador_like',
			DB::raw('(COALESCE(entidad.contador_like, 0) + ( COALESCE(entidad.contador_comentario,0)/5 )) as important'), 'entidad.seg_codigo_usuario as owner', 'identificacion_usuario', 'descripcion_entidad');

		$query->join('seguridad.usuario', 'entidad.codigo_usuario', '=', 'usuario.codigo_usuario');

		$query->join('core.usuario_institucion', function($join) {
       		$join->on('entidad.codigo_usuario', '=', 'usuario_institucion.codigo_usuario')
				->where('usuario_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('usuario_institucion.codigo_estado', '=', Estado::getState('active'));
      	});

		$query->join('core.dato_entidad', 'usuario_institucion.codigo_usuario_institucion', '=', 'dato_entidad.codigo_usuario_institucion');

		$query->join('core.clase_emprendimiento', 'entidad.codigo_clase_emprendimiento', '=', 'clase_emprendimiento.codigo_clase_emprendimiento');

		$query->where('entidad.codigo_clase_emprendimiento', '=', ClaseEmprendimiento::getClass('group'));

		switch (Input::get('type')) {
		    case 'trending':
				$query->whereNotIn('usuario.imagen_usuario', [
					'https://lh5.googleusercontent.com/-NzhKr_iafRU/VG5tNVnWJbI/AAAAAAAAKPk/I4uuQCQPJT4/w770-h343-no/proyecto_desarrollo.png',
					'https://lh5.googleusercontent.com/-smTUYpMTfv4/UjH44X0eqvI/AAAAAAAABLs/tC3E7y7UbZ0/s444/noimagen.jpg',
					'http://tuproyecto.com/img/no-project.png',
					'https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/svg/no-image-770x460.svg',
					'https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/svg/no-image.svg'
				]);
		    	$query->whereNotNull('usuario.imagen_usuario');
		    	$query->where('dato_entidad.codigo_privacidad_contenido', '=', PrivacidadContenido::getPrivacy('public'));
		   		$query->orderByRaw('important desc');
	        break;

		    case 'owner':
		    	if(Auth::check()) {
     				$query->where('usuario.codigo_usuario', '=', Auth::user()->codigo_usuario);
	        	}
	        break;

		    case 'user':
 				// Decrypt src-params
		        list($codigo_usuario) = TuProyecto::decryptSrcParams(Input::get('srcparams-user'));
		        if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
		            App::abort(403);
		        }

		        $query->where('usuario.codigo_usuario', '=', $codigo_usuario);
		    	$query->where('dato_entidad.codigo_privacidad_contenido', '=', PrivacidadContenido::getPrivacy('public'));
    		break;

    		default:
				$query->whereNotIn('usuario.imagen_usuario', [
					'https://lh5.googleusercontent.com/-NzhKr_iafRU/VG5tNVnWJbI/AAAAAAAAKPk/I4uuQCQPJT4/w770-h343-no/proyecto_desarrollo.png',
					'https://lh5.googleusercontent.com/-smTUYpMTfv4/UjH44X0eqvI/AAAAAAAABLs/tC3E7y7UbZ0/s444/noimagen.jpg',
					'http://tuproyecto.com/img/no-project.png',
					'https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/svg/no-image-770x460.svg',
					'https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/svg/no-image.svg'
				]);
		    	$query->whereNotNull('usuario.imagen_usuario');
		    	$query->where('dato_entidad.codigo_privacidad_contenido', '=', PrivacidadContenido::getPrivacy('public'));
		   		$query->orderBy('usuario.codigo_usuario','desc');
    		break;
		}

		if(Input::has('category')){
			$query->where('dato_entidad.codigo_categoria_proyecto', Input::get('category'));
		}

		if(Input::has('grade')) {
			$query->where('entidad.codigo_categoria_clase_espacio', '=', Input::get('grade'));
		}


   		$query->orderByRaw('important desc');
   		$query->orderBy('entidad.contador_like','desc');
   		$query->orderBy('entidad.contador_comentario','desc');
   		$query->orderBy('entidad.codigo_entidad','desc');


		// Get total posts
		$total_entries = $query->get()->count();

    	$query->skip(Input::get('offset'))->take(Input::get('limit'));

        // Get posts
		$data = $query->get();
		if(count($data) > 0) {
			foreach ($data as $entity) {
				$proyecto = new \stdClass();
				$proyecto->codigo_entidad = $entity->codigo_entidad;
				$proyecto->url_nickname = $entity->url_nickname;
				$proyecto->nombre_usuario = $entity->nombre_usuario;
				$proyecto->imagen_usuario = $entity->imagen_usuario;
				$proyecto->codigo_clase_emprendimiento = $entity->codigo_clase_emprendimiento;
				$proyecto->nombre_clase_emprendimiento = $entity->nombre_clase_emprendimiento;
				$proyecto->resumen_proyecto = $entity->resumen_proyecto;
				$proyecto->contador_comentario = $entity->contador_comentario;
				$proyecto->contador_like = $entity->contador_like;

				$proyecto->owner = (Auth::check() && Auth::user()->codigo_usuario == $entity->owner) ? true : false;
				// Secure srcparams
				$proyecto->srcparams = TuProyecto::encryptSrcParams([$entity->codigo_proyecto, Recurso::getResource('proyectos.gestion')]);
				$groups[] = $proyecto;
			}
		}

		$response = new \stdClass();
		$response->total_entries = $total_entries;
		$response->items = $groups;
   		return $response;
   	}


   	/**
	* Group data detail from url.
	*/
	public static function getGroupUrl($entity)
	{
		$query = Grupo::query();
		$query->select('entidad.*', 'entidad.codigo_usuario as owner', 'nombre_ciudad', 'nombre_pais', 'nombre_privacidad_contenido', 'icono_privacidad_contenido', 'nombre_categoria_proyecto', 'usuario.nombre_usuario', 'usuario.imagen_usuario','biografia_usuario','facebook_usuario','twitter_usuario','linkedin_usuario', 'tiktok_usuario','pagina_web_usuario', 'identificacion_usuario','dato_entidad.codigo_etapa_proyecto','dato_entidad.codigo_categoria_proyecto','dato_entidad.codigo_privacidad_contenido','descripcion_entidad','usuario.codigo_ciudad','nombre_ciudad','nombre_clase_emprendimiento','entidad.codigo_clase_emprendimiento','nombre_categoria_clase_espacio', (Auth::check() ? DB::raw(sprintf('%s %s', Grupo::$raw_joingroup, 'as statejoin')) : DB::raw('\'\' as statejoin')));

		$query->join('seguridad.usuario', 'entidad.codigo_usuario', '=', 'usuario.codigo_usuario');
		// City / Country
		$query->leftjoin('core.ciudad', 'usuario.codigo_ciudad', '=', 'ciudad.codigo_ciudad');
		$query->leftjoin('core.pais', 'ciudad.codigo_pais', '=', 'pais.codigo_pais');

		if(Auth::check()){
			$query->leftjoin('core.grupo_usuario', function($join) {
	       		$join->on('entidad.codigo_usuario', '=', 'grupo_usuario.codigo_usuario')
					->where('grupo_usuario.codigo_usuario', '=', Auth::user()->codigo_usuario);
	      	});
	    }

		$query->join('core.usuario_institucion', function($join) {
       		$join->on('entidad.codigo_usuario', '=', 'usuario_institucion.codigo_usuario')
				->where('usuario_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('usuario_institucion.codigo_estado', '=', Estado::getState('active'));
      	});

		$query->join('core.dato_entidad', 'usuario_institucion.codigo_usuario_institucion', '=', 'dato_entidad.codigo_usuario_institucion');
		$query->join('core.clase_emprendimiento', 'entidad.codigo_clase_emprendimiento', '=', 'clase_emprendimiento.codigo_clase_emprendimiento');

		$query->leftjoin('core.categoria_clase_espacio', 'entidad.codigo_categoria_clase_espacio', '=', 'categoria_clase_espacio.codigo_categoria_clase_espacio');

		$query->leftjoin('core.categoria_proyecto', 'dato_entidad.codigo_categoria_proyecto', '=', 'categoria_proyecto.codigo_categoria_proyecto');

		$query->leftjoin('core.privacidad_contenido', 'dato_entidad.codigo_privacidad_contenido', '=', 'privacidad_contenido.codigo_privacidad_contenido');

		$query->whereRaw("trim(lower(nickname_usuario)) = trim(lower('$nickname'))");
		return $query->first();
	}


   	/**
	 * Build Group.
	*/
   	public static function buildGroup($entity)
   	{

   		$object = new \stdClass();
		$object->id_entidad = $entity->codigo_entidad;
		$object->codigo_entidad = TuProyecto::encryptSrcParams([$entity->codigo_entidad]);
		$object->codigo_usuario = TuProyecto::encryptSrcParams([$entity->codigo_usuario]);
		$object->imagen_usuario = $entity->imagen_usuario;
		$object->video_entidad = $entity->video_entidad;
		$object->nombre_usuario = ucfirst(strtolower($entity->nombre_usuario));
		$object->biografia_usuario = ucfirst(strtolower($entity->biografia_usuario));
		$object->url_nickname = $entity->url_nickname;
		$object->identificacion_usuario = $entity->identificacion_usuario;
		$object->codigo_categoria_clase_espacio = $entity->codigo_categoria_clase_espacio;
		$object->nombre_privacidad_contenido = $entity->nombre_privacidad_contenido;
		$object->icono_privacidad_contenido = $entity->icono_privacidad_contenido;
		$object->nombre_categoria_proyecto = $entity->nombre_categoria_proyecto;

		// Get data ClassEntrepreneurship
		$entityclass = $entity->claseEmprendimiento;
		$object->nombre_clase_emprendimiento = $entityclass->nombre_clase_emprendimiento;

		$object->codigo_etapa_proyecto = $entity->codigo_etapa_proyecto;
		$object->codigo_categoria_proyecto = $entity->codigo_categoria_proyecto;
		$object->codigo_privacidad_contenido = $entity->codigo_privacidad_contenido;

		$object->codigo_clase_emprendimiento = $entity->codigo_clase_emprendimiento;
		$object->codigo_ciudad = $entity->codigo_ciudad;
		$object->nombre_ciudad = $entity->nombre_ciudad;
		$object->nombre_pais = $entity->nombre_pais;
		$object->descripcion_entidad=  $entity->descripcion_entidad;

		$object->contador_comentario = $entity->contador_comentario;
		$object->contador_like = $entity->contador_like;

		$object->facebook_usuario = $entity->facebook_usuario;
		$object->twitter_usuario = $entity->twitter_usuario;
		$object->linkedin_usuario = $entity->linkedin_usuario;
		$object->tiktok_usuario = $entity->tiktok_usuario;
		$object->pagina_web_usuario = $entity->pagina_web_usuario;
		$object->statejoin = $entity->statejoin;

		$user = $entity->usuario;
		$object->tags = $user->tags()->get()->implode('texto_tag', ',');

		$object->owner = false;
		if(Auth::check()){
			$object->owner = Auth::user()->codigo_usuario == $entity->owner ? true : false;
		}
		// Secure srcparams
		$object->srcparams = TuProyecto::encryptSrcParams([$entity->codigo_entidad, Recurso::getResource('proyectos.gestion')]);
		return $object;
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

    public function claseEmprendimiento()
    {
        return $this->hasOne('App\ClaseEmprendimiento','codigo_clase_emprendimiento','codigo_clase_emprendimiento');
    }

}
