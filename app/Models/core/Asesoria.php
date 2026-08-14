<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

use App\Usuario;

use TuProyecto;

use DB, Input, Auth, Validator, Config;

class Asesoria extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.asesoria';

   	protected $primaryKey = 'codigo_asesoria';

   	public $timestamps = false;

   	protected $fillable = array('descripcion_asesoria', 'codigo_tipo_asesoria');

   	public function isValid($data)
    {
        $rules = array(
            'descripcion_asesoria' => 'required'
        );

     	$validator = Validator::make($data, $rules);
        if ($validator->passes()) {
     		return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    /**
	 * Domain 1 Mentor, 2 Emprendedor.
	 *
	 * @var string $type
	 */
    public static function getTypeUser($type) {
        switch ($type):
            case 'mentor': return 1;
            case 'entrepreneur': return 2;
            default: return 'Not type identified';
        endswitch;
	}

	/**
	 * Get Advisory mentor
	 */

	public static function getAdvisoryMentor($user) {
		$query = Asesoria::query();
		$query->select('asesoria.codigo_asesoria', 'emprendimiento.nombre_usuario as nombre_emprendimiento');

		$query->join('aprende.asesoria_institucion', function($join) {
			$join->on('asesoria.codigo_asesoria', '=', 'asesoria_institucion.codigo_asesoria')
				->where('asesoria_institucion.codigo_institucion', '=', RegistroSesion::getInstitution());
		});

		$query->join('core.estado', 'asesoria_institucion.codigo_estado', '=', 'estado.codigo_estado');

		$query->join('core.tipo_asesoria', 'asesoria.codigo_tipo_asesoria', '=', 'tipo_asesoria.codigo_tipo_asesoria');

		// Mentor
		$query->join('seguridad.usuario as mentor', 'asesoria.seg_codigo_usuario', '=', 'mentor.codigo_usuario');
		$query->leftJoin('core.persona as pmentor', 'mentor.codigo_usuario', '=', 'pmentor.codigo_usuario');

		// Emprendedor
		$query->join('seguridad.usuario as emprendedor', 'asesoria.codigo_usuario', '=', 'emprendedor.codigo_usuario');
		$query->leftJoin('core.persona as pemprendedor', 'emprendedor.codigo_usuario', '=', 'pemprendedor.codigo_usuario');

		// Emprendimiento
		$query->join('core.entidad', 'asesoria.codigo_entidad', '=', 'entidad.codigo_entidad');
		$query->join('seguridad.usuario as emprendimiento', 'entidad.codigo_usuario', '=', 'emprendimiento.codigo_usuario');

		$query->where('mentor.identificacion_usuario', $user);

		$query->where('asesoria_institucion.codigo_estado', Estado::getState('active'));
		$query->orderBy('nombre_emprendimiento', 'asc');
		return $query->get();
	}

	/**
	 * Get Advisory Enterpreneur
	 */

	public static function getAdvisoryEnterpreneur($user) {
		$query = Asesoria::query();
		$query->select('asesoria.codigo_asesoria', 'emprendimiento.nombre_usuario as nombre_emprendimiento');

		$query->join('aprende.asesoria_institucion', function($join) {
			$join->on('asesoria.codigo_asesoria', '=', 'asesoria_institucion.codigo_asesoria')
				->where('asesoria_institucion.codigo_institucion', '=', RegistroSesion::getInstitution());
		});

		$query->join('core.estado', 'asesoria_institucion.codigo_estado', '=', 'estado.codigo_estado');

		$query->join('core.tipo_asesoria', 'asesoria.codigo_tipo_asesoria', '=', 'tipo_asesoria.codigo_tipo_asesoria');

		// Mentor
		$query->join('seguridad.usuario as mentor', 'asesoria.seg_codigo_usuario', '=', 'mentor.codigo_usuario');
		$query->leftJoin('core.persona as pmentor', 'mentor.codigo_usuario', '=', 'pmentor.codigo_usuario');

		// Emprendedor
		$query->join('seguridad.usuario as emprendedor', 'asesoria.codigo_usuario', '=', 'emprendedor.codigo_usuario');
		$query->leftJoin('core.persona as pemprendedor', 'emprendedor.codigo_usuario', '=', 'pemprendedor.codigo_usuario');

		// Emprendimiento
		$query->join('core.entidad', 'asesoria.codigo_entidad', '=', 'entidad.codigo_entidad');
		$query->join('seguridad.usuario as emprendimiento', 'entidad.codigo_usuario', '=', 'emprendimiento.codigo_usuario');

		$query->where('emprendedor.identificacion_usuario', $user);

		$query->where('asesoria_institucion.codigo_estado', Estado::getState('active'));

		return $query->get();
	}

	/**
	* Mentoring data detail from url.
	*/
   	public static function getMentoring($codigo_asesoria)
   	{

        $query = Asesoria::query();
		$query->select('asesoria.codigo_asesoria', 'fecha_asesoria', 'hora_asesoria', 'descripcion_asesoria',
		'nombre_tipo_asesoria', 'url_tipo_asesoria', 'asesoria.codigo_usuario', 'asesoria.seg_codigo_usuario',
		'emprendimiento.nombre_usuario as nombre_emprendimiento', 'emprendimiento.biografia_usuario as descripcion_emprendimiento',
		'emprendimiento.nickname_usuario as url_emprendimiento', 'asesoria_institucion.codigo_estado',
		// Entrepreneur data
		DB::raw("emprendedor.codigo_usuario as emprendedor"),
		DB::raw("(CASE emprendedor.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN emprendedor.nombre_usuario || ' ' || COALESCE(pemprendedor.primer_apellido_persona, '') || ' ' || COALESCE(pemprendedor.segundo_apellido_persona, '') ELSE emprendedor.nombre_usuario END) as nombre_usuario_emprendedor"),
		DB::raw("COALESCE(emprendedor.imagen_usuario, '".Config::get('tuproyecto.avatar_image')."') as imagen_usuario_emprendedor"),
		DB::raw("emprendedor.nickname_usuario as nickname_usuario_emprendedor"),
        DB::raw("emprendedor.nombre_usuario as short_name_emprendedor"),
        DB::raw("iemprendedor.ultimo_ingreso_usuario as ultimo_ingreso_emprendedor"),
		DB::raw("emprendedor.correo_electronico as correo_emprendedor"),

		// Mentor data
		DB::raw("mentor.codigo_usuario as mentor"),
		DB::raw("(CASE mentor.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN mentor.nombre_usuario || ' ' || COALESCE(pmentor.primer_apellido_persona, '') || ' ' || COALESCE(pmentor.segundo_apellido_persona, '') ELSE mentor.nombre_usuario END) as nombre_usuario_mentor"),

		DB::raw("COALESCE(mentor.imagen_usuario, '".Config::get('tuproyecto.avatar_image')."') as imagen_usuario_mentor"),
		DB::raw("mentor.nickname_usuario as nickname_usuario_mentor"),
		DB::raw("mentor.nombre_usuario as short_name_mentor"),
        DB::raw("imentor.ultimo_ingreso_usuario as ultimo_ingreso_mentor"),
		DB::raw('(CASE WHEN evaluacion_mentor.codigo_evaluacion_asesoria IS NULL THEN false ELSE true END) as evaluation_mentor'),
		DB::raw('(CASE WHEN evaluacion_emprendedor.codigo_evaluacion_asesoria IS NULL THEN false ELSE true END) as evaluation_entrepreneur'),
		DB::raw("mentor.correo_electronico as correo_mentor"));

		// Users mentoring
        $query->join('seguridad.usuario as mentor', 'asesoria.seg_codigo_usuario', '=', 'mentor.codigo_usuario');
        $query->leftJoin('core.persona as pmentor', 'mentor.codigo_usuario', '=', 'pmentor.codigo_usuario');
        $query->leftJoin('core.usuario_institucion as imentor', function($join) {
            $join->on('mentor.codigo_usuario', '=', 'imentor.codigo_usuario')
             ->where('imentor.codigo_institucion', '=', RegistroSesion::getInstitution())
             ->where('imentor.codigo_estado','=', Estado::getState('active'));
       });

		$query->join('seguridad.usuario as emprendedor', 'asesoria.codigo_usuario', '=', 'emprendedor.codigo_usuario');
		$query->leftJoin('core.persona as pemprendedor', 'emprendedor.codigo_usuario', '=', 'pemprendedor.codigo_usuario');
        $query->leftJoin('core.usuario_institucion as iemprendedor', function($join) {
            $join->on('emprendedor.codigo_usuario', '=', 'iemprendedor.codigo_usuario')
             ->where('iemprendedor.codigo_institucion', '=', RegistroSesion::getInstitution())
             ->where('iemprendedor.codigo_estado','=', Estado::getState('active'));
       });

		// Entrepreneurship
		$query->join('core.entidad', 'asesoria.codigo_entidad', '=', 'entidad.codigo_entidad');
		$query->join('seguridad.usuario as emprendimiento', 'entidad.codigo_usuario', '=', 'emprendimiento.codigo_usuario');
		$query->leftjoin('core.tipo_asesoria', 'asesoria.codigo_tipo_asesoria', '=', 'tipo_asesoria.codigo_tipo_asesoria');

		// City / Country
		$query->leftjoin('core.ciudad', 'emprendedor.codigo_ciudad', '=', 'ciudad.codigo_ciudad');
		$query->leftjoin('core.pais', 'ciudad.codigo_pais', '=', 'pais.codigo_pais');

      	// Filter institution
		$query->join('aprende.asesoria_institucion', function($join) {
       		$join->on('asesoria.codigo_asesoria', '=', 'asesoria_institucion.codigo_asesoria')
				->where('asesoria_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->whereIn('asesoria_institucion.codigo_estado', [Estado::getState('active'), Estado::getState('finalized'), Estado::getState('pending'), Estado::getState('closed'), Estado::getState('rejected')]);
      	});

      	$query->leftJoin('aprende.evaluacion_asesoria as evaluacion_mentor', function($join) {
       		$join->on('asesoria.codigo_asesoria', '=', 'evaluacion_mentor.codigo_asesoria')
				->where('evaluacion_mentor.tipo_evaluacion_asesoria', '=', Asesoria::getTypeUser('mentor'))
				->where('asesoria.seg_codigo_usuario','=', Auth::user()->codigo_usuario);
      	});

		$query->leftJoin('aprende.evaluacion_asesoria as evaluacion_emprendedor', function($join) {
       		$join->on('asesoria.codigo_asesoria', '=', 'evaluacion_emprendedor.codigo_asesoria')
				->where('evaluacion_emprendedor.tipo_evaluacion_asesoria', '=', Asesoria::getTypeUser('entrepreneur'))
				->where('asesoria.codigo_usuario','=', Auth::user()->codigo_usuario);
      	});

      	$query->where('asesoria.codigo_asesoria', '=', $codigo_asesoria);

		return $query->first();
   	}

	/**
	* Mentoring data detail from url.
	*/
   	public static function getMentoringEvaluation($codigo_asesoria)
   	{

        $query = Asesoria::query();
		$query->select('asesoria.codigo_asesoria', 'asesoria.codigo_usuario', 'asesoria.seg_codigo_usuario',
		// Entrepreneur data
		DB::raw("emprendedor.codigo_usuario as emprendedor"),
		DB::raw("(CASE emprendedor.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN emprendedor.nombre_usuario || ' ' || COALESCE(pemprendedor.primer_apellido_persona, '') || ' ' || COALESCE(pemprendedor.segundo_apellido_persona, '') ELSE emprendedor.nombre_usuario END) as nombre_usuario_emprendedor"),
		DB::raw("emprendedor.correo_electronico as correo_usuario_emprendedor"),

		// Mentor data
		DB::raw("mentor.codigo_usuario as mentor"),
		DB::raw("(CASE mentor.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN mentor.nombre_usuario || ' ' || COALESCE(pmentor.primer_apellido_persona, '') || ' ' || COALESCE(pmentor.segundo_apellido_persona, '') ELSE mentor.nombre_usuario END) as nombre_usuario_mentor"),
		DB::raw("mentor.correo_electronico as correo_usuario_mentor"),

		DB::raw('(CASE WHEN evaluacion_mentor.codigo_evaluacion_asesoria IS NULL THEN false ELSE true END) as evaluation_mentor'),
		DB::raw('(CASE WHEN evaluacion_emprendedor.codigo_evaluacion_asesoria IS NULL THEN false ELSE true END) as evaluation_entrepreneur'));

		// Users mentoring
		$query->join('seguridad.usuario as mentor', 'asesoria.seg_codigo_usuario', '=', 'mentor.codigo_usuario');
		$query->leftJoin('core.persona as pmentor', 'mentor.codigo_usuario', '=', 'pmentor.codigo_usuario');
		$query->join('seguridad.usuario as emprendedor', 'asesoria.codigo_usuario', '=', 'emprendedor.codigo_usuario');
		$query->leftJoin('core.persona as pemprendedor', 'emprendedor.codigo_usuario', '=', 'pemprendedor.codigo_usuario');

		// Entrepreneurship
		$query->join('core.entidad', 'asesoria.codigo_entidad', '=', 'entidad.codigo_entidad');
		$query->join('seguridad.usuario as emprendimiento', 'entidad.codigo_usuario', '=', 'emprendimiento.codigo_usuario');
		$query->leftjoin('core.tipo_asesoria', 'asesoria.codigo_tipo_asesoria', '=', 'tipo_asesoria.codigo_tipo_asesoria');

      	// Filter institution
		$query->join('aprende.asesoria_institucion', function($join) {
       		$join->on('asesoria.codigo_asesoria', '=', 'asesoria_institucion.codigo_asesoria')
				->where('asesoria_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->whereIn('asesoria_institucion.codigo_estado',[ Estado::getState('active'), Estado::getState('closed')]);
      	});

      	$query->leftJoin('aprende.evaluacion_asesoria as evaluacion_mentor', function($join) {
       		$join->on('asesoria.codigo_asesoria', '=', 'evaluacion_mentor.codigo_asesoria')
				->where('evaluacion_mentor.tipo_evaluacion_asesoria', '=', Asesoria::getTypeUser('mentor'));
      	});

		$query->leftJoin('aprende.evaluacion_asesoria as evaluacion_emprendedor', function($join) {
       		$join->on('asesoria.codigo_asesoria', '=', 'evaluacion_emprendedor.codigo_asesoria')
				->where('evaluacion_emprendedor.tipo_evaluacion_asesoria', '=', Asesoria::getTypeUser('entrepreneur'));
      	});

      	$query->where('asesoria.codigo_asesoria', '=', $codigo_asesoria);

		return $query->first();
   	}


    /**
	* Mentoring data posts.
	*/
	public static function getPostsMentoring()
	{
		$mentorings = [];
		$query = Asesoria::query();
		$query->select(
			'emprendedor.identificacion_usuario',
			'asesoria.codigo_asesoria',
			'fecha_asesoria',
			'hora_asesoria',
			'descripcion_asesoria',
			'nombre_tipo_asesoria',
			'url_tipo_asesoria',
			'asesoria.codigo_usuario',
			'asesoria.seg_codigo_usuario',
			'asesoria_institucion.codigo_estado',
			'nombre_estado',
			'emprendimiento.nombre_usuario as nombre_emprendimiento',
			'emprendimiento.nickname_usuario as nickname_emprendimiento',
			'asesoria_institucion.codigo_estado',

			//DB::raw("('".Auth::user()->hasRole(['mentor'])."') as isMentor"),
		//DB::raw("(CASE WHEN ('".Auth::user()->hasRole(['mentor']) = true ."') THEN true ELSE false END) as isMentor"),
		DB::raw("COALESCE('".Auth::user()->hasRole(['mentor'])."') as is_mentor"),
		// Entrepreneur data
		DB::raw("emprendedor.codigo_usuario as emprendedor"),
		DB::raw("(CASE emprendedor.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN emprendedor.nombre_usuario || ' ' || COALESCE(pemprendedor.primer_apellido_persona, '') || ' ' || COALESCE(pemprendedor.segundo_apellido_persona, '') ELSE emprendedor.nombre_usuario END) as nombre_usuario_emprendedor"),

		DB::raw("COALESCE(emprendedor.imagen_usuario, '".Config::get('tuproyecto.avatar_image')."') as imagen_usuario_emprendedor"),
		DB::raw("emprendedor.nickname_usuario as nickname_usuario_emprendedor"),
		DB::raw("iemprendedor.ultimo_ingreso_usuario as ultimo_ingreso_emprendedor"),
		DB::raw("emprendedor.nombre_usuario as short_name_emprendedor"),
		// Mentor data
		DB::raw("mentor.codigo_usuario as mentor"),
		DB::raw("(CASE mentor.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN mentor.nombre_usuario || ' ' || COALESCE(pmentor.primer_apellido_persona, '') || ' ' || COALESCE(pmentor.segundo_apellido_persona, '') ELSE mentor.nombre_usuario END) as nombre_usuario_mentor"),

		DB::raw("COALESCE(mentor.imagen_usuario, '".Config::get('tuproyecto.avatar_image')."') as imagen_usuario_mentor"),
		DB::raw("mentor.nickname_usuario as nickname_usuario_mentor"),
		DB::raw("mentor.nombre_usuario as short_name_mentor"),
		DB::raw("imentor.ultimo_ingreso_usuario as ultimo_ingreso_mentor"),

		DB::raw('(CASE WHEN evaluacion_mentor.codigo_evaluacion_asesoria IS NULL THEN false ELSE true END) as evaluation_mentor'),
		DB::raw('(CASE WHEN evaluacion_emprendedor.codigo_evaluacion_asesoria IS NULL THEN false ELSE true END) as evaluation_entrepreneur')
	);

		// Users mentoring
		$query->join('seguridad.usuario as mentor', 'asesoria.seg_codigo_usuario', '=', 'mentor.codigo_usuario');
		$query->leftJoin('core.persona as pmentor', 'mentor.codigo_usuario', '=', 'pmentor.codigo_usuario');
		$query->leftJoin('core.usuario_institucion as imentor', function($join) {
            $join->on('mentor.codigo_usuario', '=', 'imentor.codigo_usuario')
             ->where('imentor.codigo_institucion', '=', RegistroSesion::getInstitution());
	   	});

		// Users entrepreneur
		$query->join('seguridad.usuario as emprendedor', 'asesoria.codigo_usuario', '=', 'emprendedor.codigo_usuario');
		$query->leftJoin('core.persona as pemprendedor', 'emprendedor.codigo_usuario', '=', 'pemprendedor.codigo_usuario');
		$query->leftJoin('core.usuario_institucion as iemprendedor', function($join) {
            $join->on('emprendedor.codigo_usuario', '=', 'iemprendedor.codigo_usuario')
             ->where('iemprendedor.codigo_institucion', '=', RegistroSesion::getInstitution());
	   	});

		// Entrepreneurship
		$query->join('core.entidad', 'asesoria.codigo_entidad', '=', 'entidad.codigo_entidad');
		$query->join('seguridad.usuario as emprendimiento', 'entidad.codigo_usuario', '=', 'emprendimiento.codigo_usuario');



		$query->leftjoin('core.tipo_asesoria', 'asesoria.codigo_tipo_asesoria', '=', 'tipo_asesoria.codigo_tipo_asesoria');

		$query->leftJoin('aprende.evaluacion_asesoria as evaluacion_mentor', function($join) {
       		$join->on('asesoria.codigo_asesoria', '=', 'evaluacion_mentor.codigo_asesoria')
				->where('evaluacion_mentor.tipo_evaluacion_asesoria', '=', Asesoria::getTypeUser('mentor'))
				->where('asesoria.seg_codigo_usuario','=', Auth::user()->codigo_usuario);
      	});

		$query->leftJoin('aprende.evaluacion_asesoria as evaluacion_emprendedor', function($join) {
       		$join->on('asesoria.codigo_asesoria', '=', 'evaluacion_emprendedor.codigo_asesoria')
				->where('evaluacion_emprendedor.tipo_evaluacion_asesoria', '=', Asesoria::getTypeUser('entrepreneur'))
				->where('asesoria.codigo_usuario','=', Auth::user()->codigo_usuario);
      	});

		if (!Input::has('state')) {
			$query->join('aprende.asesoria_institucion', function($join) {
				$join->on('asesoria.codigo_asesoria', '=', 'asesoria_institucion.codigo_asesoria')
					->where('asesoria_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
					->whereIn('asesoria_institucion.codigo_estado',[Estado::getState('active'), Estado::getState('pending'), Estado::getState('finalized'), Estado::getState('closed'), Estado::getState('rejected') ]);
			});
		} else {
			switch (Input::get('state')) {
				case Estado::getState('pending'):
					$query->join('aprende.asesoria_institucion', function($join) {
						$join->on('asesoria.codigo_asesoria', '=', 'asesoria_institucion.codigo_asesoria')
							->where('asesoria_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
							->whereIn('asesoria_institucion.codigo_estado',[Estado::getState('pending')]);
					});
				break;
				case Estado::getState('active'):
					$query->join('aprende.asesoria_institucion', function($join) {
						$join->on('asesoria.codigo_asesoria', '=', 'asesoria_institucion.codigo_asesoria')
							->where('asesoria_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
							->whereIn('asesoria_institucion.codigo_estado',[Estado::getState('active')]);
					});
				break;
				case Estado::getState('closed'):
					$query->join('aprende.asesoria_institucion', function($join) {
						$join->on('asesoria.codigo_asesoria', '=', 'asesoria_institucion.codigo_asesoria')
							->where('asesoria_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
							->whereIn('asesoria_institucion.codigo_estado',[Estado::getState('closed')]);
					});
				break;
				case Estado::getState('finalized'):
					$query->join('aprende.asesoria_institucion', function($join) {
						$join->on('asesoria.codigo_asesoria', '=', 'asesoria_institucion.codigo_asesoria')
							->where('asesoria_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
							->whereIn('asesoria_institucion.codigo_estado',[Estado::getState('finalized')]);
					});
				break;
				case Estado::getState('rejected'):
					$query->join('aprende.asesoria_institucion', function($join) {
						$join->on('asesoria.codigo_asesoria', '=', 'asesoria_institucion.codigo_asesoria')
							->where('asesoria_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
							->whereIn('asesoria_institucion.codigo_estado',[Estado::getState('rejected')]);
					});
				break;
				default:
					$query->join('aprende.asesoria_institucion', function($join) {
						$join->on('asesoria.codigo_asesoria', '=', 'asesoria_institucion.codigo_asesoria')
							->where('asesoria_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
							->whereIn('asesoria_institucion.codigo_estado',[Estado::getState('active'), Estado::getState('finalized'), Estado::getState('pending'), Estado::getState('closed') , Estado::getState('rejected')]);

						});
			}
		}

		$query->join('core.estado', 'asesoria_institucion.codigo_estado', '=', 'estado.codigo_estado');

		switch (Input::get('role')) {
		    case 'mentor':
     			$query->where('asesoria.seg_codigo_usuario', '=', Auth::user()->codigo_usuario);
	        break;

	        case 'emprendedor':
     			$query->where('asesoria.codigo_usuario', '=', Auth::user()->codigo_usuario);
	        break;

    		default:
				$query->where(function ($query) {
					$query->where('asesoria.codigo_usuario', '=', Auth::user()->codigo_usuario)
						->orWhere('asesoria.seg_codigo_usuario', '=', Auth::user()->codigo_usuario);
				});
    		break;
		}

      	if(Input::has('theme')) {
			$query->where('tipo_asesoria.url_tipo_asesoria', Input::get('theme'));
		}

		if(Input::has('identification')) {
			$query->whereRaw("emprendedor.identificacion_usuario::text ilike '%".Input::get('identification')."%' ");
		}


		if (Input::has('number_document') && !empty(Input::get('number_document'))) {
			$query->whereRaw("emprendedor.identificacion_usuario::text like '%".Input::get('number_document')."%' ");
		}

		if (Input::has('name_entrepreneurship') && !empty(Input::get('name_entrepreneurship'))) {
			$query->whereRaw("emprendimiento.nombre_usuario::text ilike '%".Input::get('name_entrepreneurship')."%' ");
		}

		$query->orderBy('fecha_asesoria', 'desc');
		$query->orderBy('hora_asesoria', 'desc');

		// Get posts
		if(Input::get('state') == Estado::getState('active') || Input::get('state') == 'active') {
			// Always use pagination for active mentoring
			$perPage = Input::get('per_page', 20);
			$page = Input::get('page', 1);

			// If limit/offset are sent (from pagination component), convert to page
			if(Input::has('limit') && Input::has('offset')) {
				$limit = Input::get('limit', 10);
				$offset = Input::get('offset', 0);
				$page = floor($offset / $limit) + 1;
				$perPage = $limit;
			}

			$data = $query->paginate($perPage, ['*'], 'page', $page);
			$total_entries = $data->total();
			$items = $data->items();
			$response = new \stdClass();
			$response->total_entries = $total_entries;
			$response->items = [];
			if(count($items) > 0) {
				foreach ($items as $mentoring) {
					$response->items[] = Asesoria::buildAdvice($mentoring);
				}
			}
			$response->current_page = $data->currentPage();
			$response->last_page = $data->lastPage();
			$response->per_page = $data->perPage();
			$response->from = $data->firstItem();
			$response->to = $data->lastItem();
		} else {
			// Handle pagination for other states
			if(Input::has('limit') && Input::has('offset')) {
				$limit = Input::get('limit', 10);
				$offset = Input::get('offset', 0);
				$page = floor($offset / $limit) + 1;
				$data = $query->paginate($limit, ['*'], 'page', $page);
				$total_entries = $data->total();
				$items = $data->items();
				$response = new \stdClass();
				$response->total_entries = $total_entries;
				$response->items = [];
				if(count($items) > 0) {
					foreach ($items as $mentoring) {
						$response->items[] = Asesoria::buildAdvice($mentoring);
					}
				}
				$response->current_page = $data->currentPage();
				$response->last_page = $data->lastPage();
				$response->per_page = $data->perPage();
				$response->from = $data->firstItem();
				$response->to = $data->lastItem();
			} else {
				$data = $query->get();
				$total_entries = $data->count();
				$mentorings = [];
				if(count($data) > 0) {
					foreach ($data as $mentoring) {
						$mentorings[] = Asesoria::buildAdvice($mentoring);
					}
				}
				$response = new \stdClass();
				$response->total_entries = $total_entries;
				$response->items = $mentorings;
			}
		}

   		return $response;
	}

	/**
	 * Build Advice.
	*/
   	public static function buildAdvice($advice)
   	{
		$object = new \stdClass();
		$object->codigo_asesoria = TuProyecto::encryptSrcParams([$advice->codigo_asesoria]);
		$object->url_asesoria = sprintf("%s-%s", 'pregunta', $advice->codigo_asesoria);
		$object->fecha_asesoria = $advice->fecha_asesoria;
		$object->hora_asesoria = $advice->hora_asesoria;
		$object->descripcion_asesoria = $advice->descripcion_asesoria;
		$object->nombre_tipo_asesoria = $advice->nombre_tipo_asesoria;
		$object->codigo_estado = $advice->codigo_estado;
		$object->nombre_estado = $advice->nombre_estado;
		$object->estado = $advice->codigo_estado;
        if(in_array($advice->codigo_estado,[Estado::getState('inactive'),Estado::getState('dropped'), Estado::getState('closed'), Estado::getState('removed')])){
            $object->is_open = false;
        }
		// data entrepreneur
		$object->nombre_usuario_emprendedor = $advice->nombre_usuario_emprendedor;
		$object->identificacion_usuario = $advice->identificacion_usuario;
		$object->imagen_usuario_emprendedor = $advice->imagen_usuario_emprendedor;
		$object->nickname_usuario_emprendedor = $advice->nickname_usuario_emprendedor;
        $object->short_name_emprendedor = $advice->short_name_emprendedor;
        $object->ultimo_ingreso_emprendedor = $advice->ultimo_ingreso_emprendedor;
        $object->ultimo_ingreso_emprendedor_ago = $advice->ultimo_ingreso_emprendedor ? TuProyecto::timeAgo($advice->ultimo_ingreso_emprendedor) : '' ;
		$object->evaluation_entrepreneur = $advice->evaluation_entrepreneur;
		$object->emprendedor = Auth::user()->codigo_usuario == $advice->emprendedor ? true : false;

		// data entrepreneurship
		$object->nombre_emprendimiento = $advice->nombre_emprendimiento;
		$object->nickname_emprendimiento = $advice->nickname_emprendimiento;
		$object->descripcion_emprendimiento = $advice->descripcion_emprendimiento;
		$object->url_emprendimiento = $advice->url_emprendimiento;

		// data mentor
		$object->nombre_usuario_mentor = $advice->nombre_usuario_mentor;
		$object->imagen_usuario_mentor = $advice->imagen_usuario_mentor;
		$object->nickname_usuario_mentor = $advice->nickname_usuario_mentor;
        $object->short_name_mentor = $advice->short_name_mentor;
        $object->ultimo_ingreso_mentor = $advice->ultimo_ingreso_mentor;
        $object->ultimo_ingreso_mentor_ago = $advice->ultimo_ingreso_mentor ? TuProyecto::timeAgo($advice->ultimo_ingreso_mentor) : '';
		$object->evaluation_mentor = $advice->evaluation_mentor;
		$object->isMentor = $advice->is_mentor ? true : false;


		if($advice->mentor instanceof Usuario) {
			$object->mentor = Auth::user()->codigo_usuario == $advice->mentor->codigo_usuario ? true : false;
		}else{
			$object->mentor = Auth::user()->codigo_usuario == $advice->mentor ? true : false;
		}

		if ($advice->url_emprendimiento != null) {
			$etapaProyecto = Asesoria::getEtapaProyecto($advice->url_emprendimiento);
			$object->etapaProyecto = $etapaProyecto;
		}

		$object->url_profile = $advice->usuario->getProfileUrl();

		// Data sessions
		$object->sessions = Mentoria::getMentors([ 'codigo_asesoria' => $advice->codigo_asesoria ]);

		return $object;
	}

	//get etapa de mentoria
	public static function getEtapaProyecto(string $nickname)
	{
		$query = Entidad::query();
		$query->select('dato_entidad.codigo_etapa_proyecto');
		$query->join('seguridad.usuario', 'entidad.codigo_usuario', '=', 'usuario.codigo_usuario');
		$query->join('core.usuario_institucion',  function($join) {
			$join->on('entidad.codigo_usuario', '=', 'usuario_institucion.codigo_usuario')
				->where('usuario_institucion.codigo_institucion', RegistroSesion::getInstitution());
		});

		$query->join('core.dato_entidad', 'usuario_institucion.codigo_usuario_institucion',
			'=', 'dato_entidad.codigo_usuario_institucion');
		$query->where('usuario.nickname_usuario', $nickname);
		$codigo_etapa = $query->get();

		if ($codigo_etapa->isEmpty()) {
			return 'Etapa no definida';
		}

		$query = EtapaProyecto::query();
		$query->select('nombre_etapa_proyecto');
		$query->where('codigo_etapa_proyecto', $codigo_etapa[0]['codigo_etapa_proyecto']);
		$query->where('codigo_institucion', RegistroSesion::getInstitution());
		$etapa = $query->get();

		if ($etapa->isEmpty()) {
			return 'Etapa no encontrada';
		}

		return $etapa[0]['nombre_etapa_proyecto'];
	}

   	public function getAllowedUsers()
  	{
  		// by default, the creator of the resource is allowed
  		return [$this->attributes['codigo_usuario'], $this->attributes['seg_codigo_usuario']];
  	}



   	/**
	 * Defining Relations
	*/

	public function usuario()
    {
        return $this->hasOne('App\Usuario','codigo_usuario','codigo_usuario');
    }

    public function mentor()
    {
        return $this->hasOne('App\Usuario','codigo_usuario','seg_codigo_usuario');
    }

   	public function tipo()
    {
        return $this->hasOne('App\TipoAsesoria', 'codigo_tipo_asesoria', 'codigo_tipo_asesoria');
   	}

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'core.tag_asesoria', 'codigo_asesoria', 'codigo_tag');
    }

}
