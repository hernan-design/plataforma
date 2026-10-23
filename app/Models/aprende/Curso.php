<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

use App\Institucion;

use TuProyecto;

use DB, Auth, Cookie, Log;

use Carbon\Carbon;


class Curso extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'aprende.curso';

   	protected $primaryKey = 'codigo_curso';

	public $timestamps = false;

	public static function typeCourse($type) {
    	switch ($type) :
		    case 'course': return 1;
		    case 'webinar': return 2;
		    case 'lecture': return 3;
		    case 'capacitacion': return 4;
		    case 'bienestar': return 5;
			default: return 'Not type course identified';
		endswitch;
    }

	public static function getOrientation($orientation) {
    	switch ($orientation) :
		    case 'internal': return 1;
		    case 'external': return 2;
			default: return 'Not orientation course identified';
		endswitch;
    }

   	/**
	* Course data detail from url.
	*/
	public static function getCourseUrl($course, $category = null, $theme = null, $class = null )
	{
		$query = Curso::query();
		$query->select('curso.precio_curso','curso.codigo_curso', 'nombre_curso', 'imagen_curso', 'descripcion_curso', 'url_curso', 'url_categoria_curso', 'fecha_apertura_curso', 'url_tipo_curso', 'log_curso', 'log_biofacial',
			'fecha_cierre_curso', 'url_externa_curso', 'codigo_orientacion_curso', 'nombre_categoria_curso', 'curso_institucion.contador_like' , 'contador_inscritos', 'curso_gratis', 'seo.*', 'certificado_curso',
			// Validations course registration
			// Inscripcion
			(Auth::check() ?
			DB::raw('(CASE COALESCE(inscripcion_curso.codigo_estado, 0) WHEN '.Estado::getState('active').' THEN true ELSE false END) AS inscripcion') : DB::raw('false AS inscripcion')),
			// Advance
			(Auth::check() ? DB::raw('COALESCE(inscripcion_curso.porcentaje_progreso, 0) AS porcentaje_progreso') : DB::raw('0 AS porcentaje_progreso')),
			// Usuario
			(Auth::check() ? DB::raw('COALESCE(inscripcion_curso.codigo_usuario, 0) AS codigo_usuario') : DB::raw('0 AS codigo_usuario')),
            DB::raw(sprintf('%s %s', Seo::$raw_follow, 'as enlaces_motores_busqueda')),
            DB::raw(sprintf('%s %s', Seo::$raw_index, 'as indexar_motores'))
        );


    	$query->join('aprende.tipo_curso', 'curso.tipo_curso', '=', 'tipo_curso.codigo_tipo_curso');
		$query->join('aprende.categoria_curso', 'curso.codigo_categoria_curso', '=', 'categoria_curso.codigo_categoria_curso');
        $query->join('aprende.curso_institucion', function($join) {
       		$join->on('curso.codigo_curso', '=', 'curso_institucion.codigo_curso')
				->where('curso_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('curso_institucion.codigo_estado', '=', Estado::getState('active'));
      	});

		if(Auth::check()) {
			$query->leftjoin('aprende.inscripcion_curso', function($join) {
				$join->on('inscripcion_curso.codigo_curso', '=', 'curso.codigo_curso')
					->on('inscripcion_curso.codigo_institucion', '=', 'curso_institucion.codigo_institucion')
					->where('inscripcion_curso.codigo_usuario', '=', Auth::user()->codigo_usuario)
					->where('inscripcion_curso.codigo_estado', '=', Estado::getState('active'));
	        });
		}

		if($category) {
			$query->where('url_categoria_curso', '=', strtolower(trim($category)));
		}

		if($theme) {
			$query->join('aprende.tema_curso', 'curso.codigo_curso','=', 'tema_curso.codigo_curso');
			$query->leftJoin('aprende.adjunto_tema', 'tema_curso.codigo_tema_curso','=', 'adjunto_tema.codigo_tema_curso');
			$query->whereRaw("lower(trim(tema_curso.url_tema_curso)) = '".strtolower(trim($theme))."'");

			if($class) {
				$query->leftJoin('core.adjunto', 'adjunto_tema.codigo_adjunto','=', 'adjunto.codigo_adjunto');
				$query->whereRaw("lower(trim(adjunto_tema.url_adjunto)) = '".strtolower(trim($class))."'");
			}
		}

		$query->where(function ($query) {
			$query->whereIn('curso.codigo_privacidad_contenido', [PrivacidadContenido::getPrivacy('public'), PrivacidadContenido::getPrivacy('hidden')]);
			if(Auth::check()) {
				$query->orWhere('curso.codigo_usuario', '=', Auth::user()->codigo_usuario);
			}
        });

        $query->leftJoin('core.seo', function($join){
			$join->on('curso.codigo_curso', '=', 'seo.id_recurso')
				->where('seo.codigo_modulo', Modulo::getModule('learn'));
		});

		$query->where('url_curso', '=', strtolower(trim($course)));
		return $query->first();
	}

	/**
	* Course data detail from url and url category.
	*/
	public static function getCategoryCourseUrl($course, $category)
	{
		return Curso::select('curso.*','categoria_curso.nombre_categoria_curso')
			->join('aprende.categoria_curso', 'aprende.categoria_curso.codigo_categoria_curso','=', 'aprende.curso.codigo_categoria_curso')
			->where('categoria_curso.url_categoria_curso', '=', strtolower(trim($category)))
			->where('url_curso', '=', strtolower(trim($course)))->first();
	}

   	public static function getCourses(array $filters = [])
   	{
   		$courses = [];
		$query = Curso::query();
		$query->select('curso.codigo_curso', 'nombre_curso', 'imagen_curso', 'descripcion_curso', 'url_curso', 'url_categoria_curso', 'url_tipo_curso', 'url_externa_curso', 'fecha_apertura_curso', 'fecha_cierre_curso', 'curso_institucion.contador_inscritos', 'codigo_orientacion_curso', 'curso_gratis', 'nombre_categoria_curso', 'integracion_inicio_sesion', 'codigo_patrocinador', 'certificado_curso', 'log_curso', 'log_biofacial',
			// Inscripcion
			(Auth::check() ?
			DB::raw('(CASE COALESCE(inscripcion_curso.codigo_estado, 0) WHEN '.Estado::getState('active').' THEN true ELSE false END) AS inscripcion') : DB::raw('false AS inscripcion')),
			// Advance
			(Auth::check() ? DB::raw('COALESCE(inscripcion_curso.porcentaje_progreso, 0) AS porcentaje_progreso') : DB::raw('0 AS porcentaje_progreso'))
		);
    	$query->join('aprende.categoria_curso', 'curso.codigo_categoria_curso', '=', 'categoria_curso.codigo_categoria_curso');
    	$query->join('aprende.tipo_curso', 'curso.tipo_curso', '=', 'tipo_curso.codigo_tipo_curso');
		$query->join('aprende.curso_institucion', function($join) {
       		$join->on('curso.codigo_curso', '=', 'curso_institucion.codigo_curso')
				->where('curso_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('curso_institucion.codigo_estado', '=', Estado::getState('active'));
      	});

        if(Auth::check()) {
	        $query->leftJoin('aprende.inscripcion_curso', function($join) {
				$join->on('inscripcion_curso.codigo_curso', '=', 'curso.codigo_curso')
					->on('inscripcion_curso.codigo_institucion', '=', 'curso_institucion.codigo_institucion')
					->where('inscripcion_curso.codigo_usuario', '=', Auth::user()->codigo_usuario)
					->where('inscripcion_curso.codigo_estado', '=', Estado::getState('active'));
	        });
	    }

		$typeCourse = isset($filters['typeCourse']) && !empty($filters['typeCourse']) ? $filters['typeCourse'] : 'course';
		if ($typeCourse) {
			switch ($typeCourse) {
				case 'bienestarNoted':
					$query->where('curso.tipo_curso', '=', Curso::typeCourse('bienestar'));
					break;
				case 'bienestar':
					$query->where('curso.tipo_curso', '=', Curso::typeCourse('bienestar'));
					break;
				case 'coursescolaboratorsNoted':
					$query->where('curso.tipo_curso', '=', Curso::typeCourse('capacitacion'));
					break;
				case 'coursescolaborators':
					$query->where('curso.tipo_curso', '=', Curso::typeCourse('capacitacion'));
					break;
			    case 'coursesNoted':
			    	$query->where('curso.tipo_curso', '=', Curso::typeCourse('course'));
		 		break;
				case 'course':
					$query->where('curso.tipo_curso', '=', Curso::typeCourse('course'));
					break;
		 		case 'webinar':
			    	$query->where('curso.tipo_curso', '=', Curso::typeCourse('webinar'));
		 		break;
				case 'webinarsNoted':
					$query->where('curso.tipo_curso', '=', Curso::typeCourse('webinar'));
					break;
		 		case 'lecture':
			    	$query->where('curso.tipo_curso', '=', Curso::typeCourse('lecture'));
		 		break;
				case 'lecturesNoted':
					$query->where('curso.tipo_curso', '=', Curso::typeCourse('lecture'));
					break;
			    case 'micontenido':
			    	if(Auth::check()) {
		 				$query->whereRaw('(CASE COALESCE(inscripcion_curso.codigo_estado, 0) WHEN 8 THEN true ELSE false END) = true');
					 }

					 $query->orWhere('curso.codigo_privacidad_contenido', '=', PrivacidadContenido::getPrivacy('hidden'));
		 		break;
			}
		}

		if(isset($filters['payment'])){
			$payment = $filters['payment'];
			switch ($payment){
				case 'pago' :
					$query->where('curso.curso_gratis', '=', false);
				break;
				case 'gratis':
					$query->where('curso.curso_gratis', '=', true);
				break;

			}
		}

		if(isset($filters['name'])){
			$nameCourse = $filters['name'];
			$query->where(DB::raw('lower(curso.nombre_curso)'), 'like', '%'.strtolower($nameCourse).'%');
		}

		// Filter channel
		if (isset($filters['url_canal']) && !empty($filters['url_canal'])) {
			$query->join('core.contenido_canal', function($join) {
	            $join->on('curso.codigo_curso', '=', 'contenido_canal.codigo_recurso_modulo')
	                ->where('contenido_canal.codigo_modulo', '=', Modulo::getModule('learn'))
	                ->where('contenido_canal.codigo_estado', '=', Estado::getState('active'));
	        });

	        $query->join('core.canal', function($join) use($filters){
	            $join->on('contenido_canal.codigo_canal', '=', 'canal.codigo_canal')
	                ->where('canal.url_canal', '=', $filters['url_canal'])
					->where('canal.codigo_institucion', '=', RegistroSesion::getInstitution());
	        });
		}

		if(isset($filters['category']) && !empty($filters['category'])) {
			$category = $filters['category'];
 			$query->whereRaw("trim(lower(url_categoria_curso)) = trim(lower('$category'))");
 		}

 		// Privacy
		$query->where(function ($query) {
			$query->where('curso.codigo_privacidad_contenido', '=', PrivacidadContenido::getPrivacy('public'));
			if(Auth::check()) {
				$query->orWhere('curso.codigo_usuario', '=', Auth::user()->codigo_usuario);
			}
		});
 		// Order

		// Get total posts
		$total_entries = $query->get()->count();

		// Get posts
		if($typeCourse == 'coursesNoted' || $typeCourse == 'webinarsNoted' || $typeCourse == 'lecturesNoted' || $typeCourse == 'coursesNoted'){
   			$query->orderBy('curso_institucion.contador_inscritos','desc');
		} else {
			$query->orderBy('curso.orden_curso', 'asc');
			$query->orderBy('curso.fecha_registro_curso', 'desc');
		}
		$offset = !empty($filters['offset']) ? (int)$filters['offset'] : 0;
		$limit = !empty($filters['limit']) ? (int)$filters['limit'] : 10;
		$data = $query->skip($offset)->take($limit)->get();
		if(count($data) > 0) {
			foreach ($data as $course) {
				$course->url_externa_curso = $course->parseExternalURL();
				$courses[] = $course;
			}
		}

		$response = new \stdClass();
		$response->total_entries = $total_entries;
		$response->items = $courses;
   		return $response;
   	}

   	/**
	 * Build Course.
	*/
   	public static function buildCourse($course)
   	{
		$object = new \stdClass();
		$object->codigo_curso = TuProyecto::encryptSrcParams([$course->codigo_curso]);
		$object->codigo_usuario = TuProyecto::encryptSrcParams([$course->codigo_usuario]);
		$object->imagen_curso = $course->imagen_curso;
		$object->curso_gratis = $course->curso_gratis;
		$object->precio_curso = $course->precio_curso;
		$object->nombre_curso = $course->nombre_curso;
		$object->descripcion_curso =  $course->descripcion_curso;
		$object->contador_inscritos =  $course->contador_inscritos;
		$object->contador_likes =  $course->contador_like;
		$object->url_curso = $course->url_curso;

		$object->nombre_categoria_curso = $course->nombre_categoria_curso;
		$object->url_categoria_curso = $course->url_categoria_curso;
		$course->url_externa_curso = $course->parseExternalURL();
		$object->codigo_orientacion_curso = $course->codigo_orientacion_curso;
		$object->fecha_apertura_curso = $course->fecha_apertura_curso;
		$object->fecha_cierre_curso = $course->fecha_cierre_curso;
		$object->url_tipo_curso = $course->url_tipo_curso;
		$object->log_curso = $course->log_curso;
		$object->log_biofacial = $course->log_biofacial;

		// SEO
		$object->nombre_facebook = $course->nombre_facebook;
		$object->nombre_twitter = $course->nombre_twitter;
		$object->descripcion_facebook = $course->descripcion_facebook;
		$object->descripcion_twitter = $course->descripcion_twitter;
		$object->imagen_facebook = $course->imagen_facebook;
		$object->imagen_twitter = $course->imagen_twitter;
        $object->url_canonica = $course->url_canonica;
        $object->directivas = !empty($course->indexar_motores) ? "{$course->indexar_motores},{$course->enlaces_motores_busqueda}" : '';
		$object->tags_content = $course->tags()->get()->implode('texto_tag', ',');

		$datasponsors = $course->patrocinadores()->get();

		$sponsors = [];
		if(count($datasponsors) > 0) {
			foreach ($datasponsors as $sponsor) {
				$patrocinador = new \stdClass();
				$patrocinador->codigo_patrocinador = $sponsor->patrocinador->codigo_patrocinador;
				$patrocinador->nombre_patrocinador = $sponsor->patrocinador->nombre_patrocinador;
				$patrocinador->imagen_patrocinador = $sponsor->patrocinador->imagen_patrocinador;
				$patrocinador->url_patrocinador = $sponsor->patrocinador->url_patrocinador;
				$sponsors[] = $patrocinador;
			}
		}

		$object->organizadores = $sponsors;

		$object->inscripcion = $course->inscripcion;
		$object->porcentaje_progreso = $course->porcentaje_progreso;
		$object->certificado_curso = $course->certificado_curso;
		$object->srcparams = TuProyecto::encryptSrcParams([$course->codigo_curso, Recurso::getResource('aprende.gestion')]);
		return $object;
   	}

   	public function parseExternalURL()
   	{
		if($this->codigo_orientacion_curso == self::getOrientation('external') && $this->integracion_inicio_sesion && Auth::check()) {
			switch ($this->codigo_patrocinador) {
				case Patrocinador::getSponsor('unipymes'):
					$user = Auth::user();
					$token = base64_encode("email=$user->correo_electronico&cedula=$user->identificacion_usuario&aula_virtual=99");
					return sprintf('%s=%s','https://www.edufundacioncoomeva.com/usuario/autenticarUsuarioToken?token', $token);
				break;
			}
   		}
   		return $this->url_externa_curso;
   	}

	/*  Function to Show get certificate */

	public static function getCoursesComplete( $codeCourses ) {
		switch (RegistroSesion::getInstitution()) {
			case Institucion::getInstitution('propace'):
				$query = Curso::query();
				$query->select();
				$query->join('aprende.curso_institucion', function($join){
					$join->on('curso_institucion.codigo_curso', '=', 'curso.codigo_curso')
						->where('curso_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
						->where('curso_institucion.codigo_estado', '=', Estado::getState('active'));
				});
				$query->where('curso.codigo_estado', '=', Estado::getState('active'));
				$query->where('curso.tipo_curso', '=', Curso::typeCourse('course'));
				$query->whereBetween('curso.codigo_curso', $codeCourses);
				$countCourses = $query->count();

				$queryCompleted = Curso::query();
				$queryCompleted->select();
				$queryCompleted->join('aprende.curso_institucion', function($join){
					$join->on('curso_institucion.codigo_curso', '=', 'curso.codigo_curso')
						->where('curso_institucion.codigo_estado', Estado::getState('active'))
						->where('curso_institucion.codigo_institucion', '=', RegistroSesion::getInstitution());
				});
				$queryCompleted->join('aprende.inscripcion_curso', 'inscripcion_curso.codigo_curso', '=', 'curso.codigo_curso');
				$queryCompleted->where('inscripcion_curso.codigo_usuario', '=', Auth::user()->codigo_usuario);
				$queryCompleted->where('curso.tipo_curso', '=', Curso::typeCourse('course'));
				$queryCompleted->where('inscripcion_curso.porcentaje_progreso', '=', '100');
				$countCoursesCompleted = $queryCompleted->count();

				$dateInscriptionCourses = $queryCompleted->get();
				$dateInscription = [];

				if ($countCourses == $countCoursesCompleted) {
					return  true ;
				} else {
					return false;
				}

			break;
			default:
				return false;
			break;
		}
	}

    /**
	 * Defining Relations
	*/
	public function usuario()
    {
        return $this->hasOne('App\Usuario','codigo_usuario','codigo_usuario');
    }

    public function temas()
    {
        return $this->hasMany('App\TemaCurso','codigo_curso','codigo_curso');
    }

    public function patrocinadores()
    {
        return $this->hasMany('App\PatrocinadorCurso','codigo_curso','codigo_curso');
    }

	public function tags()
    {
        return $this->belongsToMany('App\Tag', 'core.tag_curso', 'codigo_curso', 'codigo_tag');
    }
}
