<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB, Auth, Input, App, Lang, Validator, URL, SendEmail, Log, Cache, Cookie;

use TuProyecto;

use App\Rol,
	App\Producto;

class Entidad extends BaseModel {

    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.entidad';

   	protected $primaryKey = 'codigo_entidad';

   	protected $fillable = ['video_entidad', 'descripcion_entidad', 'cubrimiento_entidad', 'codigo_tipo_sociedad', 'codigo_sector_interes', 'codigo_tipo_identificacion'];

	public $timestamps = false;

	/**
	 * Cover
	 *
	 * @var array
	 */
	public static $cover = [1 => 'Local', 2 => 'Regional', 3 => 'Nacional', 4 => 'Internacional'];

	/**
	 * Cover
	 *
	 * @var array
	 */
	public static $size = [1 => 'Micro', 2 => 'Pequeña', 3 => 'Mediana', 4 => 'Grande'];

   	/**
	* Valid create Entity.
	*/
   	public function isValid($data)
    {
        $rules = [
            'nombre_usuario' => 'required',
            'biografia_usuario' => 'required|string',
        ];

     	$validator = Validator::make($data, $rules);
        if ($validator->passes()) {
     		return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

   	/**
	* Valid register Entity.
	*/
   	public function isValidRegister($data)
    {
        $rules = array(
            'nombre_usuario' => 'required|max:250'
        );

     	$validator = Validator::make($data, $rules);
        if ($validator->passes()) {
     		return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getEntitysList(array $filters = [])
    {
        $query = Entidad::query();
        $query->select('entidad.codigo_usuario as key', DB::raw("trim(nombre_usuario) as value"));
		$query->join('seguridad.usuario', 'entidad.codigo_usuario', '=', 'usuario.codigo_usuario');

      	$query->join('core.usuario_institucion', function($join) {
   			$join->on('entidad.codigo_usuario', '=', 'usuario_institucion.codigo_usuario')
			->where('usuario_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
			->where('usuario_institucion.codigo_estado', '=', Estado::getState('active'));
  		});
        $query->where('entidad.seg_codigo_usuario', '=', Auth::user()->codigo_usuario);

        $query->orderby('entidad.codigo_usuario','asc');
       	$return =  $query->get();

       return $return;
    }

	public static function getEntitiesCacheList()
	{
		$cache = sprintf('_%s_%s', 'entity_program', RegistroSesion::getInstitution());
		if (Cache::has($cache)) {
			return Cache::get($cache);
		}

		return Cache::rememberForever($cache, function() {

			$query = Convocatoria::query();
			$query->select('usuario.codigo_usuario as key', DB::raw("trim(usuario.nombre_usuario) as value"));
			$query->join('core.convocatoria_institucion', 'convocatoria_institucion.codigo_convocatoria', '=', 'convocatoria.codigo_convocatoria');
			$query->join('seguridad.usuario', 'convocatoria.seg_codigo_usuario', '=', 'usuario.codigo_usuario');
			$query->where('convocatoria_institucion.codigo_institucion', '=',RegistroSesion::getInstitution());
			$query->orderby('usuario.nombre_usuario','asc');
			$query->groupBy('usuario.codigo_usuario');
			$return =  $query->get();
			return $return;
		});
	}

    public static function getUserEntitys($call)
   	{
		$query = Entidad::query();
		$query->select('nombre_usuario','usuario.codigo_usuario');
		$query->join('seguridad.usuario', 'entidad.codigo_usuario', '=', 'usuario.codigo_usuario');
		$query->leftjoin('core.registro_fase_usuario', 'usuario.codigo_usuario', '=', 'registro_fase_usuario.codigo_usuario');

		$query->join('core.usuario_institucion', function($join) {
       		$join->on('entidad.codigo_usuario', '=', 'usuario_institucion.codigo_usuario')
				->where('usuario_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('usuario_institucion.codigo_estado', '=', Estado::getState('active'));
      	});

      	$query->join('core.clase_emprendimiento_insti', function($join) {
                $join->on('entidad.codigo_clase_empre_insti', '=', 'clase_emprendimiento_insti.codigo_clase_empre_insti')
                    ->where('clase_emprendimiento_insti.codigo_institucion', '=',RegistroSesion::getInstitution())
                    ->where('clase_emprendimiento_insti.codigo_estado', '=', Estado::getState('active'));
            });

        $query->join('core.clase_emprendimiento', 'clase_emprendimiento_insti.codigo_clase_emprendimiento', '=', 'clase_emprendimiento.codigo_clase_emprendimiento');
		$query->join('core.dato_entidad', 'usuario_institucion.codigo_usuario_institucion', '=', 'dato_entidad.codigo_usuario_institucion');
        $query->leftjoin('core.etapa_proyecto', 'dato_entidad.codigo_etapa_proyecto', '=', 'etapa_proyecto.codigo_etapa_proyecto');

      	$query->whereNotIn('entidad.codigo_usuario', function($query) use($call){
		    $query->select('registro_fase_usuario.codigo_usuario')
		    ->from("core.registro_fase_usuario")
		    ->join('core.fase', 'registro_fase_usuario.codigo_fase', '=', 'fase.codigo_fase')
		    ->where('fase.codigo_convocatoria',$call);
		});

		$query->where('entidad.seg_codigo_usuario', '=', Auth::user()->codigo_usuario);
		$query->whereIn('clase_emprendimiento.codigo_clase_emprendimiento', [ClaseEmprendimiento::getClass('entrepreneurship'), ClaseEmprendimiento::getClass('company')]);
		$query->where('usuario.codigo_estado', '=', Estado::getState('active'));
		$query->where('usuario.tipo_usuario',Usuario::typeUser('entity'));

		$entitysUser = $query->get();

		$entitys = [];
		foreach ($entitysUser as $user) {
			$item = new  \stdClass();
			$item->codigo_usuario = TuProyecto::encryptSrcParams([$user->codigo_usuario]);
			$item->nombre_usuario = $user->nombre_usuario;
			$entitys[] = $item;
		}

		return $entitys;
   	}

   	public static function getLastEntitys()
   	{
		$query = Entidad::query();
		$query->select('imagen_usuario', 'nombre_usuario', 'nickname_usuario', 'video_entidad');

		$query->join('seguridad.usuario', 'entidad.codigo_usuario', '=', 'usuario.codigo_usuario');
		$query->join('core.usuario_institucion', function($join) {
       		$join->on('entidad.codigo_usuario', '=', 'usuario_institucion.codigo_usuario')
				->where('usuario_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('usuario_institucion.codigo_estado', '=', Estado::getState('active'));
      	});

		$query->whereNotIn('usuario.imagen_usuario', [
			'https://lh5.googleusercontent.com/-NzhKr_iafRU/VG5tNVnWJbI/AAAAAAAAKPk/I4uuQCQPJT4/w770-h343-no/proyecto_desarrollo.png',
			'https://lh5.googleusercontent.com/-smTUYpMTfv4/UjH44X0eqvI/AAAAAAAABLs/tC3E7y7UbZ0/s444/noimagen.jpg',
			'http://tuproyecto.com/img/no-project.png',
			'http://static.tuproyecto.com/images/svg/no-image.svg'
		]);
    	$query->whereNotNull('usuario.imagen_usuario');
    	$query->whereNotNull('entidad.video_entidad');

		return $query->take(10)->get();
   	}

   	public static function getNameOfEntities() {

        $cache = sprintf('_%s_%s', 'entity_name_list', RegistroSesion::getInstitution());
		if (Cache::has($cache)) {
			return Cache::get($cache);
        }

		return Cache::rememberForever($cache, function() {
			$query = Convocatoria::query();
			$query->select('usuario.codigo_usuario','usuario.nombre_usuario');
			$query->join('core.convocatoria_institucion', 'convocatoria_institucion.codigo_convocatoria', '=', 'convocatoria.codigo_convocatoria');
			$query->join('seguridad.usuario', 'convocatoria.seg_codigo_usuario', '=', 'usuario.codigo_usuario');
			$query->where('convocatoria_institucion.codigo_institucion', '=', RegistroSesion::getInstitution());
			return $query->distinct()->pluck('usuario.nombre_usuario','usuario.codigo_usuario')->toArray();
		});
	}

    public static function getEntitys()
   	{
		$entitys = [];
		$query = Entidad::query();
		$query->select('entidad.codigo_entidad','clase_emprendimiento.codigo_clase_emprendimiento', 'nombre_clase_emprendimiento','usuario.nombre_usuario',
		'usuario.imagen_usuario', 'usuario.biografia_usuario', 'usuario.nickname_usuario', 'usuario_institucion.contador_comentario', 'usuario_institucion.contador_votos',
		'entidad.contador_like', 'entidad.seg_codigo_usuario','usuario.identificacion_usuario','descripcion_entidad', 'entidad.codigo_usuario', 'categoria_proyecto.nombre_categoria_proyecto',
			DB::raw('(COALESCE(entidad.contador_like, 0) + ( COALESCE(entidad.contador_comentario,0)/5 )) as important'),
			DB::raw("trim(initcap(ciudad.nombre_ciudad)) as nombre_ciudad"),
			DB::raw("trim(initcap(etapa_proyecto.nombre_etapa_proyecto)) as stage"),
			DB::raw("COALESCE(initcap(ciudad.distrito_ciudad), '') as distrito_ciudad")
		);

		$query->join('seguridad.usuario', 'entidad.codigo_usuario', '=', 'usuario.codigo_usuario');
		$query->join('core.usuario_institucion', function($join) {
       		$join->on('entidad.codigo_usuario', '=', 'usuario_institucion.codigo_usuario')
				->where('usuario_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('usuario_institucion.codigo_estado', '=', Estado::getState('active'));
		  });

		$query->join('core.dato_entidad', 'usuario_institucion.codigo_usuario_institucion', '=', 'dato_entidad.codigo_usuario_institucion');
		$query->join('core.clase_emprendimiento_insti', function($join) {
            $join->on('entidad.codigo_clase_empre_insti', '=', 'clase_emprendimiento_insti.codigo_clase_empre_insti')
                ->where('clase_emprendimiento_insti.codigo_institucion', '=',RegistroSesion::getInstitution())
                ->where('clase_emprendimiento_insti.codigo_estado', '=', Estado::getState('active'));
        });
		$query->join('core.clase_emprendimiento', 'clase_emprendimiento_insti.codigo_clase_emprendimiento', '=', 'clase_emprendimiento.codigo_clase_emprendimiento');
		$query->leftjoin('core.etapa_proyecto', 'dato_entidad.codigo_etapa_proyecto', '=', 'etapa_proyecto.codigo_etapa_proyecto');
		$query->leftjoin('core.categoria_proyecto', 'dato_entidad.codigo_categoria_proyecto', '=', 'categoria_proyecto.codigo_categoria_proyecto');
		$query->leftJoin('core.ciudad', 'usuario.codigo_ciudad', '=', 'ciudad.codigo_ciudad');
		$query->leftJoin('core.pais', 'ciudad.codigo_pais', '=', 'pais.codigo_pais');
		$query->leftJoin('core.pais_institucion', function($join) {
			$join->on('pais.codigo_pais', '=', 'pais_institucion.codigo_pais')
			->where('pais_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
			->where('pais_institucion.codigo_estado', '=', Estado::getState('active'));
		});

		$query->leftJoin('seguridad.usuario as entity_user', 'entity_user.codigo_usuario', '=', 'entidad.seg_codigo_usuario');

		switch (Input::get('type')) {
		    case 'micontenido':
		    	if(Auth::check()) {
		     		$query->where(function ($query) {
						$query->where('entidad.codigo_usuario', '=', Auth::user()->codigo_usuario)
							->orWhere('entidad.seg_codigo_usuario', '=', Auth::user()->codigo_usuario);
					});
	        	}
	        break;

			case 'proyectos':
    			$query->where('clase_emprendimiento.codigo_clase_emprendimiento', ClaseEmprendimiento::getClass('entrepreneurship'));
	        break;

	        case 'empresas':
    			$query->where('clase_emprendimiento.codigo_clase_emprendimiento', ClaseEmprendimiento::getClass('company'));
	        break;

	        case 'grupos':
    			$query->where('clase_emprendimiento.codigo_clase_emprendimiento', ClaseEmprendimiento::getClass('group'));
	        break;

		    case 'user':
 				// Decrypt src-params
		        list($codigo_usuario) = TuProyecto::decryptSrcParams(Input::get('srcparams-user'));
		        if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
		            abort(403);
		        }
				$query->leftJoin('core.grupo_usuario', function($join) use($codigo_usuario) {
					$join->on('entidad.codigo_usuario', '=', 'grupo_usuario.codigo_usuario');
				});
				$query->where('entidad.seg_codigo_usuario', '=', $codigo_usuario);
				$query->orWhere('grupo_usuario.seg_codigo_usuario', '=', $codigo_usuario);
				if(Auth::user()->codigo_usuario != $codigo_usuario){
					$query->where('dato_entidad.codigo_privacidad_contenido', '=', PrivacidadContenido::getPrivacy('public'));
				}
    		break;

    		default:
		    	$query->where('dato_entidad.codigo_privacidad_contenido', '=', PrivacidadContenido::getPrivacy('public'));
    		break;
		}

		if(Input::has('program')) {
			$query->join('core.registro_convocatoria', function($join) {
	       		$join->on('entidad.codigo_usuario', '=', 'registro_convocatoria.codigo_usuario')
					->where('registro_convocatoria.codigo_convocatoria', '=', Input::get('program'))
					->where('registro_convocatoria.codigo_estado', '=', Estado::getState('active'));
	      	});
		}

		if(Input::has('department')){
			$query->whereRaw("distrito_ciudad ilike '%".Input::get('department')."%'");
		}

		if(Input::has('city')){
			$query->where('usuario.codigo_ciudad', Input::get('city'));
		}

        if(Input::has('stage')){
			$query->where('dato_entidad.codigo_etapa_proyecto', Input::get('stage'));
		}

		if(Input::has('category')) {
			$query->where('dato_entidad.codigo_categoria_proyecto', Input::get('category'));
		}

		if(Input::has('name')) {
			$query->whereRaw("usuario.nombre_usuario ilike '%".Input::get('name')."%' ");
		}

		if(Input::has('identification')) {
			$query->whereRaw("entity_user.identificacion_usuario::text ilike '%".Input::get('identification')."%' ");
		}

		// Get total posts
		$total_entries = $query->count();

		// Get posts
		if(RegistroSesion::getVotation()){
			$query->orderBy('usuario_institucion.contador_votos','desc');
		} else {
			$query->orderByRaw('important desc');
			$query->orderBy('entidad.contador_like','desc');
   			$query->orderBy('entidad.contador_comentario','desc');
		}

		$query->orderBy('entidad.codigo_entidad','desc');
		$data = $query->skip(Input::get('offset'))->take(Input::get('limit'))->get();

		if(count($data) > 0) {
			foreach ($data as $entity) {
				$entity->owner = Auth::check() && in_array(Auth::user()->codigo_usuario, $entity->getAllowedUsers() ) ? true : false;

				// Secure srcparams
				$entity->srcparams = TuProyecto::encryptSrcParams([$entity->codigo_entidad, Recurso::getResource('proyectos.gestion')]);
			}
		}

		$response = new \stdClass();
		$response->total_entries = $total_entries;
		$response->items = $data;

   		return $response;
   	}

    /**
	* Entity data detail from url.
	*/
	public static function getEntityUrl($nickname)
	{
        $query = Entidad::query();
		$query->select(
			'entidad.*',
			'usuario.descripcion_adicional_usuario',
			'usuario.fecha_nacimiento_usuario',
			'usuario.telefono_usuario',
			'usuario.numero_whatsapp',
			'entidad.correo_contacto_entidad',
			DB::raw("trim(initcap(ciudad.nombre_ciudad)) as nombre_ciudad"),
			DB::raw("COALESCE(initcap(ciudad.distrito_ciudad), '') as distrito_ciudad"),'pais.nombre_pais', 'nombre_privacidad_contenido', 'icono_privacidad_contenido', 'usuario.nombre_usuario', 'usuario.imagen_usuario', 'usuario.biografia_usuario', 'usuario.facebook_usuario',
			'usuario.instagram_usuario', 'usuario.twitter_usuario', 'usuario.linkedin_usuario', 'usuario.tiktok_usuario', 'usuario.pagina_web_usuario', 'usuario.nickname_usuario', 'usuario.identificacion_usuario', 'dato_entidad.codigo_etapa_proyecto',  'dato_entidad.codigo_privacidad_contenido', 'descripcion_entidad','usuario.codigo_ciudad', 'nombre_clase_emprendimiento', 'clase_emprendimiento_insti.codigo_clase_emprendimiento', 'usuario.cargo_entidad',
			'founder.codigo_usuario as codigo_founder', 'founder.nickname_usuario as nickname_founder', 'founder.imagen_usuario as imagen_founder', 'founder.correo_electronico as correo_electronico_usuario', 'usuario_institucion.contador_votos',
			DB::raw("trim(initcap(ciudadf.nombre_ciudad)) as ciudad_founder"),
			DB::raw("trim(initcap(etapa_proyecto.nombre_etapa_proyecto)) as stage"),
			DB::raw("COALESCE(initcap(ciudadf.distrito_ciudad), '') as distrito_ciudad_founder"), 'paisf.nombre_pais as pais_founder',
			DB::raw("(CASE WHEN founder.tipo_usuario = ".Usuario::typeUser('person')." THEN (trim(founder.nombre_usuario) || ' ' || trim(personaf.primer_apellido_persona) || ' ' || trim(personaf.segundo_apellido_persona)) ELSE founder.nombre_usuario END) as nombre_founder"), 'dato_entidad.codigo_categoria_proyecto', 'categoria_proyecto.nombre_categoria_proyecto', 'dato_entidad.cor_codigo_categoria_proyecto', 'scategoria.nombre_categoria_proyecto as cor_nombre_categoria_proyecto', 'modelo_negocio_institucion');

		// User City / Country
		$query->join('seguridad.usuario', 'entidad.codigo_usuario', '=', 'usuario.codigo_usuario');
		$query->leftjoin('core.ciudad', 'usuario.codigo_ciudad', '=', 'ciudad.codigo_ciudad');
		$query->leftjoin('core.pais', 'ciudad.codigo_pais', '=', 'pais.codigo_pais');

		// Founder City / Country
		$query->join('seguridad.usuario as founder', 'entidad.seg_codigo_usuario', '=', 'founder.codigo_usuario');
		$query->leftjoin('core.ciudad as ciudadf', 'founder.codigo_ciudad', '=', 'ciudadf.codigo_ciudad');
		$query->leftjoin('core.pais as paisf', 'ciudadf.codigo_pais', '=', 'paisf.codigo_pais');
		$query->leftjoin('core.persona as personaf', 'personaf.codigo_usuario', '=', 'founder.codigo_usuario');

		$query->join('core.usuario_institucion', function($join){
       		$join->on('entidad.codigo_usuario', '=', 'usuario_institucion.codigo_usuario')
				->where('usuario_institucion.codigo_institucion', '=',RegistroSesion::getInstitution());
      	});
        $query->join('param.institucion', 'institucion.codigo_institucion', '=', 'usuario_institucion.codigo_institucion');

		$query->join('core.dato_entidad', 'usuario_institucion.codigo_usuario_institucion', '=', 'dato_entidad.codigo_usuario_institucion');
		$query->join('core.clase_emprendimiento_insti', function($join) {
            $join->on('entidad.codigo_clase_empre_insti', '=', 'clase_emprendimiento_insti.codigo_clase_empre_insti')
                ->where('clase_emprendimiento_insti.codigo_institucion', '=',RegistroSesion::getInstitution())
                ->where('clase_emprendimiento_insti.codigo_estado', '=', Estado::getState('active'));
        });
		$query->join('core.clase_emprendimiento', 'clase_emprendimiento_insti.codigo_clase_emprendimiento', '=', 'clase_emprendimiento.codigo_clase_emprendimiento');

		$query->leftjoin('core.categoria_proyecto', 'dato_entidad.codigo_categoria_proyecto', '=', 'categoria_proyecto.codigo_categoria_proyecto');
		$query->leftjoin('core.categoria_proyecto as scategoria', 'dato_entidad.cor_codigo_categoria_proyecto', '=', 'scategoria.codigo_categoria_proyecto');
		$query->leftjoin('core.privacidad_contenido', 'dato_entidad.codigo_privacidad_contenido', '=', 'privacidad_contenido.codigo_privacidad_contenido');
		$query->leftjoin('core.etapa_proyecto', 'dato_entidad.codigo_etapa_proyecto', '=', 'etapa_proyecto.codigo_etapa_proyecto');
        if(Auth::check()) {
            $query->leftJoin('core.asesoria', function($join) {
                $join->on('asesoria.codigo_entidad', '=', 'entidad.codigo_entidad');
                $join->where('asesoria.codigo_estado', '=', Estado::getState('active'));
            });
            $query->leftJoin('aprende.asesoria_institucion', function($join) {
                $join->on('asesoria.codigo_entidad', '=', 'entidad.codigo_entidad');
                $join->where('asesoria_institucion.codigo_institucion', '=', RegistroSesion::getInstitution());
            });
            $query->leftJoin('seguridad.usuario as mentor', function($join) {
                $join->on('mentor.codigo_usuario', '=', 'asesoria.seg_codigo_usuario');
                $join->where('mentor.codigo_estado', '=', Estado::getState('active'));
            });

            $query->leftJoin('core.usuario_institucion as imentor', function($join) {
                $join->on('imentor.codigo_usuario', '=', 'mentor.codigo_usuario');
                $join->where('imentor.codigo_institucion', '=', RegistroSesion::getInstitution());
            });

        }
		$query->where(function ($query) {
			$query->whereIn('dato_entidad.codigo_privacidad_contenido', [PrivacidadContenido::getPrivacy('public'), PrivacidadContenido::getPrivacy('hidden')]);
			if(Auth::check()) {
                $query->orWhere('entidad.seg_codigo_usuario', '=', Auth::user()->codigo_usuario);
                $query->orWhere(function ($query) {
                    $query->where('mentor.codigo_usuario',  Auth::user()->codigo_usuario);
                    $query->whereIn('asesoria_institucion.codigo_estado', [Estado::getState('active')]);
                    $query->where('imentor.codigo_estado', Estado::getState('active') );
                });
			}
		});

        $query->whereRaw("trim(lower(usuario.nickname_usuario)) = trim(lower('$nickname'))");

        return $query->first();
	}

	public function getAllowedUsers()
  	{
  		// By default, the creator of the resource is allowed
  		$allowed = [$this->attributes['seg_codigo_usuario']];

  		// Entity session
  		if(Auth::check() && Auth::user()->codigo_usuario == $this->attributes['codigo_usuario'] ){
  			$allowed[] = $this->attributes['codigo_usuario'];
  		}
  		return $allowed;
  	}

	/**
	* Build Entity.
	*/
   	public static function buildEntity($entity)
   	{
		$object = new \stdClass();
		$object->id_entidad = $entity->codigo_entidad;
		$object->codigo_entidad = TuProyecto::encryptSrcParams([$entity->codigo_entidad]);
		$object->codigo_usuario = TuProyecto::encryptSrcParams([$entity->codigo_usuario]);
		$object->imagen_usuario = $entity->imagen_usuario;
		$object->descripcion_adicional_usuario = $entity->descripcion_adicional_usuario;
		$object->video_entidad = $entity->video_entidad;
		$object->nombre_usuario = ucfirst(strtolower($entity->nombre_usuario));
		$object->biografia_usuario = $entity->biografia_usuario;
		$object->nickname_usuario = $entity->nickname_usuario;
		$object->identificacion_usuario = $entity->identificacion_usuario;
		$object->codigo_categoria_clase_espacio = $entity->codigo_categoria_clase_espacio;
		$object->nombre_privacidad_contenido = $entity->nombre_privacidad_contenido;
		$object->icono_privacidad_contenido = $entity->icono_privacidad_contenido;
		$object->nombre_categoria_proyecto = $entity->nombre_categoria_proyecto;
		$object->cor_nombre_categoria_proyecto = $entity->cor_nombre_categoria_proyecto;
		$object->cargo_entidad = $entity->cargo_entidad;
		$object->fecha_nacimiento_usuario = $entity->fecha_nacimiento_usuario;
		$object->telefono_usuario = $entity->telefono_usuario;
		$object->correo_electronico_usuario = $entity->correo_electronico_usuario;
		$object->codigo_tipo_identificacion = $entity->codigo_tipo_identificacion;

		$object->codigo_etapa_proyecto = $entity->codigo_etapa_proyecto;
		$object->cor_codigo_categoria_proyecto = $entity->cor_codigo_categoria_proyecto;
		$object->codigo_categoria_proyecto = $entity->codigo_categoria_proyecto;
		$object->codigo_privacidad_contenido = $entity->codigo_privacidad_contenido;

		$object->codigo_clase_emprendimiento = $entity->codigo_clase_emprendimiento;
		$object->codigo_ciudad = $entity->codigo_ciudad;
		$object->nombre_ciudad = $entity->nombre_ciudad;
		$object->distrito_ciudad = $entity->distrito_ciudad;
		$object->nombre_pais = $entity->nombre_pais;
		$object->descripcion_entidad=  $entity->descripcion_entidad;
		$object->codigo_sector_interes = $entity->codigo_sector_interes;
		$object->codigo_tipo_sociedad = $entity->codigo_tipo_sociedad;
		$object->cubrimiento_entidad = $entity->cubrimiento_entidad;

		$object->contador_comentario = $entity->contador_comentario;
		$object->contador_like = $entity->contador_like;
		$object->contador_votos = $entity->contador_votos;

		$object->facebook_usuario = $entity->facebook_usuario;
		$object->twitter_usuario = $entity->twitter_usuario;
		$object->linkedin_usuario = $entity->linkedin_usuario;
		$object->tiktok_usuario = $entity->tiktok_usuario;
		$object->instagram_usuario = $entity->instagram_usuario;
		$object->pagina_web_usuario = $entity->pagina_web_usuario;
		$object->institution = RegistroSesion::getInstitution();
		$object->url_nickname = $entity->nickname_usuario;
		$object->correo_contacto = $entity->correo_contacto_entidad;

		$user = $entity->usuario;
		$object->tags = $user->tags()->get()->implode('texto_tag', ',');
		$object->stage =   $entity->stage ?? '' ;
		$object->categories =   $entity->categories ?? '' ;

		$object->creator =  Auth::check() && Auth::user()->codigo_usuario == $entity->seg_codigo_usuario ? true : false;
		$object->owner = Auth::check() && in_array(Auth::user()->codigo_usuario, $entity->getAllowedUsers() ) ? true : false;

		// Founder
		$object->codigo_founder = $entity->codigo_founder;
		$object->nickname_founder = $entity->nickname_founder;
		$object->imagen_founder = $entity->imagen_founder;
		$object->nombre_founder = $entity->nombre_founder;
		$object->ciudad_founder = $entity->ciudad_founder;
		$object->distrito_ciudad_founder = $entity->distrito_ciudad_founder;
		$object->pais_founder = $entity->pais_founder;

		// Permissions
		$object->permissions = self::getPermissions();
		$object->modelo_negocio_institucion = $entity->modelo_negocio_institucion;
		$object->haveProducts =	Producto::haveProducts($entity->codigo_usuario);
		$object->provider = $entity->codigo_usuario;
		$object->numero_whatsapp = $entity->numero_whatsapp;
		// Secure srcparams
		$object->srcparams = TuProyecto::encryptSrcParams([$entity->codigo_entidad, Recurso::getResource('proyectos.gestion')]);
		return $object;
   	}

	public static function getPermissions()
  	{
		$permissions = new \stdClass();
		$permissions->see_programs_apply = Auth::check() && Auth::user()->ability('admin,super-admin', 'view-programs-results', ['module'  => '/proyecto']) ? true : false;
		$permissions->see_bussines_model = Auth::check() && Auth::user()->ability('admin,super-admin', 'view-business-model', ['module'  => '/proyecto']) ? true : false;
  		return $permissions;
  	}

   	/**
	 * Job Queue notification mail.
	 */
   	public function notification($job, $dataEntity)
   	{
   		try
   		{
   			//Data entity
	   		$entity = Entidad::select('entity.codigo_usuario','clase_emprendimiento_insti.codigo_clase_emprendimiento','entity.nombre_usuario', 'user.nickname_usuario', 'user.correo_electronico', 'user.nombre_usuario as owner')
	   			->where('entidad.codigo_entidad', $dataEntity['codigo_entidad'] )
	        	->join('core.clase_emprendimiento_insti', 'entidad.codigo_clase_empre_insti', '=', 'clase_emprendimiento_insti.codigo_clase_empre_insti')
	        	->join('seguridad.usuario as entity', 'entidad.codigo_usuario', '=', 'entity.codigo_usuario')
	        	->join('seguridad.usuario as user', 'entidad.seg_codigo_usuario', '=', 'user.codigo_usuario')
				->first();

			// Mail notification
			$data = [];
			switch ($entity->codigo_clase_emprendimiento) {
			    case ClaseEmprendimiento::getClass('idea'):
			    	$data['_subject'] = Lang::get('project.mail.create.idea.subject');
			    	$data['_template'] = 'emails.project.createidea';
			        break;

			    case ClaseEmprendimiento::getClass('entrepreneurship'):
			    	$data['_subject'] = Lang::get('project.mail.create.subject');
			    	$data['_template'] = 'emails.project.create';

			        break;

			    case ClaseEmprendimiento::getClass('group'):
			    	$data['_subject'] = Lang::get('project.mail.create.group.subject');
			    	$data['_template'] = 'emails.project.creategroup';
			        break;

			    case ClaseEmprendimiento::getClass('company'):
					$data['_subject'] = Lang::get('project.mail.create.company.subject');
					$data['_template'] = 'emails.project.createcompany';
			        break;
			}

			$data['nombre_proyecto'] = $entity->nombre_usuario;
			$data['url_proyecto'] = URL::route('proyecto.proyecto', ['proyecto' => $entity->nickname_usuario], false);
			$data['_url_user_action'] = $entity->usuario->getProfileUrl();
			$data['_name_user_action'] = $entity->nombre_usuario;
			$data['_to'] = $entity->correo_electronico;
			$data['_to_name'] = $entity->owner;
			$data['_inst'] = $dataEntity['codigo_institucion'];

			SendEmail::notification($data);

			// Delete Job
			$job->delete();

		}catch(\Exception $e){
			Log::error(sprintf('%s:%s', 'Entidad notification', $e->getMessage()));
        }
	}

   	/**
	* Defining Relations
	*/

	public function usuario()
    {
        return $this->hasOne('App\Usuario','codigo_usuario','codigo_usuario');
    }

    public function founder()
    {
        return $this->hasOne('App\Usuario','codigo_usuario','seg_codigo_usuario');
    }
}
