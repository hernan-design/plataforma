<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;
use Carbon\Carbon;
use Input, Auth, Lang, URL, DB, Request, Cache, Log, SendEmail;

use TuProyecto;

class Convocatoria extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.convocatoria';

	protected $primaryKey = 'codigo_convocatoria';

	public $timestamps = false;

	public static function getCallType($type) {
		switch ($type):
			case 'internal': return 1;
			case 'external': return 2;
			default: return 'Not type identified';
		endswitch;
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

	public static function getProgramList(array $filters = [])
    {
        $cache = sprintf('_%s_%s', 'program_list', RegistroSesion::getInstitution());
        if (Cache::has($cache)) {
            return Cache::get($cache);
        }

        return Cache::rememberForever($cache, function() {
            $query = Convocatoria::query();
            $query->select('convocatoria.codigo_convocatoria as key', 'nombre_convocatoria as value');
            $query->join('core.convocatoria_institucion', function($join) {
                $join->on('convocatoria.codigo_convocatoria', '=', 'convocatoria_institucion.codigo_convocatoria')
                    ->where('convocatoria_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
                    ->where('convocatoria_institucion.codigo_estado', '=', Estado::getState('active'));
            });

			$query->where('convocatoria.codigo_estado', '=', Estado::getState('active'));
			$query->where('convocatoria.tipo_convocatoria', '=', Convocatoria::getCallType('internal'));
            $query->orderby('nombre_convocatoria','asc');
            return $query->get();
        });
    }


    public static function getProgramListEvaluation()
    {
        $cache = sprintf('_%s_%s', 'program_list_evaluation', RegistroSesion::getInstitution());
        if (Cache::has($cache)) {
            return Cache::get($cache);
        }

        return Cache::rememberForever($cache, function() {
            $query = Convocatoria::query();
            $query->select('convocatoria.codigo_convocatoria as key', 'nombre_convocatoria as value');
            $query->join('core.convocatoria_institucion', function($join) {
                $join->on('convocatoria.codigo_convocatoria', '=', 'convocatoria_institucion.codigo_convocatoria')
                    ->where('convocatoria_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
                    ->where('convocatoria_institucion.codigo_estado', '=', Estado::getState('active'));
            });

			$query->where('evaluacion_convocatoria', '=', true);
			$query->where('convocatoria.codigo_estado', '=', Estado::getState('active'));
			$query->where('convocatoria.tipo_convocatoria', '=', Convocatoria::getCallType('internal'));
            $query->orderby('nombre_convocatoria','asc');
            return $query->get();
        });
	}

	/**
	 * @return array list of programs for selector list
	 */
	public static function getProgramSelectorList(array $filters = []){
				$query = Convocatoria::query();
				$query->select('convocatoria.codigo_convocatoria as id', 'nombre_convocatoria as text'); //DB::raw("trim(initcap(nombre_convocatoria)  as text")
				$query->join('core.convocatoria_institucion', function($join) {
					$join->on('convocatoria.codigo_convocatoria', '=', 'convocatoria_institucion.codigo_convocatoria')
						->where('convocatoria_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
						->where('convocatoria_institucion.codigo_estado', '=', Estado::getState('active'));
				});

				$query->where('convocatoria.codigo_estado', '=', Estado::getState('active'));
				$query->where('convocatoria.tipo_convocatoria', '=', Convocatoria::getCallType('internal'));



				if(Input::has('id') ){
					$query->where("convocatoria.codigo_convocatoria", "=", Input::get('id'));
				}

				if(Input::has('q')) {
					$query->whereRaw("nombre_convocatoria ilike '%".Input::get('q')."%'");
				}

				if(Input::has('dataId')) {
					$query->where("convocatoria.codigo_convocatoria", "=",Input::get('dataId'));
				}


                $query->orderby('nombre_convocatoria','asc');
				$data = $query->limit( 50 )->get();
				$data = $query->get();

				return $data;
	}

	public static function getOpenCalls()
	{
		$query = Convocatoria::query();
		$query->select('convocatoria.*', 'convocatoria_institucion.contador_like', 'convocatoria_institucion.contador_comentario', DB::raw('(CASE WHEN convocatoria.codigo_institucion != convocatoria_institucion.codigo_institucion THEN '.Convocatoria::getCallType('external').' ELSE convocatoria.tipo_convocatoria END) as tipo_convocatoria'), 'agrupacion_registro_multiple');
		$query->join('core.convocatoria_institucion','convocatoria.codigo_convocatoria', '=', 'convocatoria_institucion.codigo_convocatoria');
		$query->leftJoin('core.agrupacion_convocatoria','convocatoria.codigo_agrupacion_convocatoria', '=', 'agrupacion_convocatoria.codigo_agrupacion_convocatoria');
		$query->leftJoin('core.encuesta','convocatoria.codigo_encuesta', '=', 'encuesta.codigo_encuesta');

		$query->where('convocatoria_institucion.codigo_institucion', '=', RegistroSesion::getInstitution());
		$query->where('convocatoria_institucion.codigo_estado', '=', Estado::getState('active'));
		$query->where('convocatoria.codigo_estado', '=', Estado::getState('active'));
        $query->whereRaw('convocatoria.fecha_cierre_convocatoria >= now()  ');
        $query->orWhere(function ($query) {
            $query->where('convocatoria.permanente_convocatoria', true)
                    ->where('convocatoria_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
		            ->where('convocatoria_institucion.codigo_estado', '=', Estado::getState('active'))
		            ->where('convocatoria.codigo_estado', '=', Estado::getState('active'));
        });
		$query->orderBy('convocatoria.fecha_creacion_convocatoria','desc');
		$query->orderBy('convocatoria.hora_creacion_convocatoria','desc');

        return $query->get();
	}

	public static function getCall($call)
	{

		$query = Convocatoria::query();
		$query->select('convocatoria.*', 'url_encuesta', 'agrupacion_registro_multiple', 'convocatoria.codigo_convocatoria',
			'convocatoria_institucion.contador_like', 'convocatoria_institucion.contador_comentario', 'convocatoria_institucion.codigo_estado as codigo_estado_institucion', 'convocatoria.texto_alerta_convocaotoria',
			'organizador.nombre_usuario as nombre_organizador', 'organizador.imagen_usuario as imagen_organizador',
			'organizador.nickname_usuario as url_organizador',
			DB::raw("( SELECT string_agg(categoria_proceso.nombre_categoria_proceso::text, ',') as categorias
			 FROM core.categoria_proceso
			 LEFT JOIN core.categoria_proceso_insti ON categoria_proceso_insti.codigo_categoria_proceso = categoria_proceso.codigo_categoria_proceso
		     LEFT JOIN core.convocatoria_categoria ON convocatoria_categoria.codigo_categoria_proceso = categoria_proceso.codigo_categoria_proceso
		     WHERE categoria_proceso_insti.codigo_institucion = ".RegistroSesion::getInstitution()." AND convocatoria_categoria.codigo_convocatoria = convocatoria.codigo_convocatoria)"),
			DB::raw("(SELECT string_agg(cat.nombre_categoria_proceso, ',') FROM core.categoria_proceso as cat
            	JOIN core.convocatoria_categoria ON  cat.codigo_categoria_proceso = convocatoria_categoria.codigo_categoria_proceso
				WHERE  convocatoria_categoria.codigo_convocatoria = convocatoria.codigo_convocatoria
            	AND convocatoria_categoria.codigo_estado = 8) as categorias"),
			DB::raw("( SELECT string_agg(etapa_proyecto.nombre_etapa_proyecto::text, ',') FROM core.etapa_proyecto
			 LEFT JOIN core.convocatoria_etapa ON convocatoria_etapa.codigo_etapa_proyecto = etapa_proyecto.codigo_etapa_proyecto
		     WHERE etapa_proyecto.codigo_institucion = ".RegistroSesion::getInstitution()." AND convocatoria_etapa.codigo_convocatoria = convocatoria.codigo_convocatoria) as etapas")
		);
		$query->join('core.convocatoria_institucion','convocatoria.codigo_convocatoria', '=', 'convocatoria_institucion.codigo_convocatoria');
		$query->leftJoin('core.agrupacion_convocatoria','convocatoria.codigo_agrupacion_convocatoria', '=', 'agrupacion_convocatoria.codigo_agrupacion_convocatoria');
		$query->leftJoin('core.encuesta','convocatoria.codigo_encuesta', '=', 'encuesta.codigo_encuesta');
		$query->leftJoin('seguridad.usuario as organizador',  'organizador.codigo_usuario','=','convocatoria.seg_codigo_usuario') ;
		$query->whereRaw('convocatoria_institucion.codigo_institucion = convocatoria.codigo_institucion');
		$query->where('convocatoria_institucion.codigo_institucion', '=', RegistroSesion::getInstitution());
        $query->whereRaw("trim(lower(url_convocatoria)) != ''");
        $query->where(function ($query) {
			$query->whereIn('convocatoria.codigo_privacidad_contenido', [PrivacidadContenido::getPrivacy('public'), PrivacidadContenido::getPrivacy('hidden')]);
			if(Auth::check()) {
				$query->orWhere('convocatoria.codigo_usuario', '=', Auth::user()->codigo_usuario);
			}
        });

        $query->whereRaw("trim(lower(url_convocatoria)) = trim(lower('$call'))");

		return $query->first();
	}

	public static function getCalls(array $filters = [])
	{
		$calls = array();
		$query = Convocatoria::query();
		$query->select('convocatoria.*', 'convocatoria_institucion.contador_like', 'convocatoria_institucion.contador_comentario', 'organizador.nombre_usuario as nombre_organizador',
			DB::raw('(CASE WHEN convocatoria.codigo_institucion != convocatoria_institucion.codigo_institucion THEN '.Convocatoria::getCallType('external').' ELSE convocatoria.tipo_convocatoria END) as tipo_convocatoria'),
			DB::raw("(SELECT string_agg(cat.nombre_categoria_proceso, ',') FROM core.categoria_proceso as cat
            	JOIN core.convocatoria_categoria ON  cat.codigo_categoria_proceso = convocatoria_categoria.codigo_categoria_proceso
				WHERE  convocatoria_categoria.codigo_convocatoria = convocatoria.codigo_convocatoria
            	AND convocatoria_categoria.codigo_estado = 8) as categorias"),
			DB::raw("( SELECT string_agg(etapa_proyecto.nombre_etapa_proyecto::text, ',') FROM core.etapa_proyecto
			 LEFT JOIN core.convocatoria_etapa ON convocatoria_etapa.codigo_etapa_proyecto = etapa_proyecto.codigo_etapa_proyecto
		     WHERE etapa_proyecto.codigo_institucion = ".RegistroSesion::getInstitution()." AND convocatoria_etapa.codigo_convocatoria = convocatoria.codigo_convocatoria) as etapas"),
			'agrupacion_registro_multiple');


		$query->join('core.convocatoria_institucion','convocatoria.codigo_convocatoria', '=', 'convocatoria_institucion.codigo_convocatoria');
		$query->leftJoin('core.agrupacion_convocatoria','convocatoria.codigo_agrupacion_convocatoria', '=', 'agrupacion_convocatoria.codigo_agrupacion_convocatoria');
		$query->leftJoin('core.encuesta','convocatoria.codigo_encuesta', '=', 'encuesta.codigo_encuesta');
		$query->leftJoin('core.convocatoria_categoria', 'convocatoria_categoria.codigo_convocatoria', '=', 'convocatoria.codigo_convocatoria');
		$query->leftJoin('core.categoria_proceso', 'categoria_proceso.codigo_categoria_proceso', '=', 'convocatoria_categoria.codigo_categoria_proceso');
		$query->leftJoin('core.convocatoria_etapa', 'convocatoria_etapa.codigo_convocatoria', 'convocatoria.codigo_convocatoria');
		$query->leftJoin('core.etapa_proyecto', 'etapa_proyecto.codigo_etapa_proyecto', '=', 'convocatoria_etapa.codigo_etapa_proyecto');
		$query->leftJoin('seguridad.usuario as organizador',  'organizador.codigo_usuario','=','convocatoria.seg_codigo_usuario') ;
		$query->where('convocatoria_institucion.codigo_institucion', '=', RegistroSesion::getInstitution());
		$query->where('convocatoria_institucion.codigo_estado', '=', Estado::getState('active'));
        $query->where(function ($query) {
			$query->whereIn('convocatoria.codigo_privacidad_contenido', [PrivacidadContenido::getPrivacy('public')]);
			if(Auth::check()) {
				$query->orWhere('convocatoria.codigo_usuario', '=', Auth::user()->codigo_usuario);
			}
        });
		$query->where('convocatoria.codigo_estado', '=', Estado::getState('active'));


		switch (Input::get('type')) {
		    case Convocatoria::getCallType('internal'):
					$query->where('convocatoria.tipo_convocatoria', '=', Convocatoria::getCallType('internal'));
	        break;

		    case Convocatoria::getCallType('external'):
     				$query->where('convocatoria.tipo_convocatoria', '=', Convocatoria::getCallType('external'));
    		break;
		}

		if(Input::has('category')){
			$query->where('convocatoria_institucion.codigo_cat_proceso_insti', Input::get('category'));
		}

		if (isset($filters['categories']) && !empty($filters['categories']) && empty($filters['stages']) && empty($filters['entity'])) {
			$query->where('categoria_proceso.codigo_categoria_proceso', '=', $filters['categories']);
		}

		if (isset($filters['stages']) && !empty($filters['stages']) && empty($filters['categories']) && empty($filters['entity'])) {
			$query->where('convocatoria_etapa.codigo_etapa_proyecto', '=', $filters['stages']);
		}

		if (isset($filters['entity']) && !empty($filters['entity']) && empty($filters['stages']) && empty($filters['categories'])) {
			$query->where('convocatoria.seg_codigo_usuario', '=', $filters['entity']);
		}

		if (isset($filters['categories']) && !empty($filters['categories']) && isset($filters['stages']) && !empty($filters['stages'])) {
			$query->where('convocatoria_institucion.codigo_cat_proceso_insti', '=', $filters['categories']);
			$query->where('convocatoria.codigo_etapa_proyecto', '=', $filters['stages']);
		}

		if (isset($filters['categories']) && !empty($filters['categories']) && isset($filters['entity']) && !empty($filters['entity'])) {
			$query->where('convocatoria_institucion.codigo_cat_proceso_insti', '=', $filters['categories']);
			$query->where('convocatoria.seg_codigo_usuario', '=', $filters['entity']);
		}

		if (isset($filters['stages']) && !empty($filters['stages']) && isset($filters['entity']) && !empty($filters['entity'])) {
			$query->where('convocatoria.codigo_etapa_proyecto', '=', $filters['stages']);
			$query->where('convocatoria.seg_codigo_usuario', '=', $filters['entity']);
		}

		if (isset($filters['categories']) && !empty($filters['categories']) && isset($filters['stages']) && !empty($filters['stages']) && isset($filters['entity']) && !empty($filters['entity'])) {
			$query->where('convocatoria_institucion.codigo_cat_proceso_insti', '=', $filters['categories']);
			$query->where('convocatoria.codigo_etapa_proyecto', '=', $filters['stages']);
			$query->where('convocatoria.seg_codigo_usuario', '=', $filters['entity']);
		}
		// Get total posts
		$total_entries = $query->get()->count();
		$query->groupBy('convocatoria.codigo_convocatoria','convocatoria_institucion.contador_like',
			'convocatoria_institucion.contador_comentario','organizador.nombre_usuario',
			'convocatoria_institucion.codigo_institucion','agrupacion_convocatoria.agrupacion_registro_multiple');
		$query->orderBy(DB::raw('RANDOM()'));
		// Get posts
		$query->skip(Input::get('offset'))->take(Input::get('limit'));
		$data =$query->get();

		if(count($data) > 0) {
			foreach ($data as $call) {
				$calls[] = Convocatoria::buildCall($call);
			}
		}

		$response = new \stdClass();
		$response->total_entries = $total_entries;
		$response->items = $calls;
		return $response;
	}

	/**
	 * Build Call.
	*/
	public static function buildCall($call)
	{
		$object = new \stdClass();
		$object->codigo_convocatoria = TuProyecto::encryptSrcParams([$call->codigo_convocatoria]);
		$object->nombre_convocatoria = $call->nombre_convocatoria;
		$object->imagen_convocatoria = $call->imagen_convocatoria;
		$object->codigo_institucion = $call->codigo_institucion;
		$object->descripcion_convocatoria = $call->descripcion_convocatoria;
		$object->politicas_convocatoria = $call->politicas_convocatoria;
		$object->terminos_convocatoria = $call->terminos_convocatoria;
		$object->contenido_aceptacion_terminos = $call->contenido_aceptacion_terminos;
		$object->codigo_orientacion_convocatoria = $call->codigo_orientacion_convocatoria;
		$object->codigo_estado = $call->codigo_estado;
		$object->url_convocatoria = $call->url_convocatoria;
		$object->contador_like = $call->contador_like;
		$object->contador_inscritos = $call->contador_inscritos;
		$object->resumen_convocatoria = $call->resumen_convocatoria;
		$object->fecha_cierre_convocatoria = $call->fecha_cierre_convocatoria;
		$object->hora_cierre_convocatoria = $call->hora_cierre_convocatoria;
		$object->mensaje_tiempo_restante = TuProyecto::remainingDaysToEndConvocatoria($call->fecha_cierre_convocatoria ? $call->fecha_cierre_convocatoria : null, $call->hora_cierre_convocatoria ? $call->hora_cierre_convocatoria : null );
		$object->fecha_cierre_registro = $call->fecha_cierre_convocatoria;
		$object->hora_cierre_registro = $call->hora_cierre_convocatoria;
        $object->permanente_convocatoria = $call->permanente_convocatoria;
        $object->texto_alerta_convocaotoria = $call->texto_alerta_convocaotoria;
		$object->tipo_convocatoria = $call->tipo_convocatoria;
		$object->url_externa_convocatoria = $call->url_externa_convocatoria;
		$object->agrupacion_registro_multiple = $call->agrupacion_registro_multiple;
		$object->url_encuesta = $call->url_encuesta;
		$object->categorias = $call->categorias ? $call->categorias : null;
		$object->etapas = $call->etapas ? $call->etapas : null;
		$object->texto_boton = $call->texto_boton;
		$object->nombre_organizador =  $call->nombre_organizador;
		$object->imagen_organizador = $call->imagen_organizador;
		$object->url_organizador = $call->url_organizador;
		$object->formatoDias = $call->fecha_cierre_convocatoria ? TuProyecto::dateFormat($call->fecha_cierre_convocatoria. " ".$call->hora_cierre_convocatoria , 'daymonthnameyeartime') : '';
		$object->ocultar_al_finalizar = $call->ocultar_al_finalizar;
		$object->codigo_estado_institucion = $call->codigo_estado_institucion;

		$object->opened =true;


		// Attributes only available whit internal program
			// Documents
			$docs = $call->documentos()->where('adjunto_convocatoria.codigo_estado', '=', Estado::getState('active'))->get();
			$documents = array();
			if(count($docs) > 0) {
				foreach ($docs as $doc) {
					$item = new \stdClass();
					$item->nombre_adjunto = $doc->adjunto->nombre_adjunto;
					$item->direccion_adjunto = $doc->adjunto->direccion_adjunto;
					$documents[] = $item;
				}
			}
			$object->documentos = $documents;
			// dd($call->hora_cierre_convocatoria);
			// Open program
			if(!$call->permanente_convocatoria && isset($call->fecha_cierre_convocatoria) && !empty($call->fecha_cierre_convocatoria)
				&& Carbon::now()->gt(Carbon::createFromFormat('Y-m-d', $call->fecha_cierre_convocatoria))) {
				$object->opened = false;
			}

			if($call->hora_cierre_convocatoria != null && $call->hora_cierre_convocatoria != ""){
				$object->opened = true;
				// Obtener la fecha y hora actual en formato de cadena
				$fecha_actual = date('Y-m-d H:i:s');

				// Obtener la fecha y hora de cierre del llamado
				$fecha_y_hora_cierre = $call->fecha_cierre_convocatoria . ' ' . $call->hora_cierre_convocatoria;

				if (!$call->permanente_convocatoria && isset($call->fecha_cierre_convocatoria) && !empty($call->fecha_cierre_convocatoria)
					&& $fecha_y_hora_cierre < $fecha_actual) {
					$object->opened = false;
				}
			}


			// Phases
			$data = $call->fases()->where('fase.codigo_estado', Estado::getState('active'))->where('fase.codigo_privacidad_contenido', PrivacidadContenido::getPrivacy('public'))
			//->orderBy('fecha_fin_fase','asc')
			//->orderBy('orden_fase')->get();
			->orderBy('codigo_fase')->get();

			$phases = [];
			if(count($data) > 0) {
				foreach ($data as $phase) {
					$item = new  \stdClass();
					$item->nombre_fase = $phase->nombre_fase;
					$item->descripcion_fase = $phase->descripcion_fase;
					$item->resumen_fase = $phase->resumen_fase;
					$item->fecha_inicio_fase = $phase->fecha_inicio_fase;
					$item->fecha_fin_fase = $phase->fecha_fin_fase;

					$resources =[];
					$resourcesList = [];
					if ( Auth::check()){
						$resourcesList =  $phase::getResourceOfPhase($call->codigo_convocatoria, $phase->codigo_fase);
					}

					if( !is_null($resourcesList) && count((array) $resourcesList) > 0) {
						foreach ($resourcesList as $resource) {

							$resources[] = $resource;
						}
					}
					$item->resources = $resources;
					$phases[] = $item;
				}


				$object->fases = $phases;

				// Open program
				if(in_array($call->codigo_estado, [Estado::getState('active')])) {

					// Check registration phase close date
					$phaseRegister = $call->fase_registro();
 					if($phaseRegister instanceof Fase) {
						$object->fecha_cierre_registro = $phaseRegister->fecha_fin_fase;
						$object->opened = true;
					}

					// Check Permanent
					if( $call->permanente_convocatoria){
						$object->opened = true;
					}
				}
			}




			// Check register
			$object->registered = false;

			if(Auth::check()) {
				switch ($call->codigo_orientacion_convocatoria) {
					case OrientacionConvocatoria::getOrientation('entity'):
						// Valid register group
						if(is_numeric($call->codigo_agrupacion_convocatoria) && $object->agrupacion_registro_multiple == false) {
							$query = RegistroFaseUsuario::query();
							$query->join('core.fase', 'registro_fase_usuario.codigo_fase', '=', 'fase.codigo_fase');
							$query->join('core.convocatoria','fase.codigo_convocatoria', '=', 'convocatoria.codigo_convocatoria');
							$query->join('seguridad.usuario','registro_fase_usuario.codigo_usuario', '=', 'usuario.codigo_usuario');
							$query->join('core.entidad','usuario.codigo_usuario', '=', 'entidad.codigo_usuario');
						  	$query->where('registro_fase_usuario.codigo_estado', Estado::getState('active'));
		        			$query->where('convocatoria.codigo_agrupacion_convocatoria', $call->codigo_agrupacion_convocatoria);
				            $query->where('entidad.seg_codigo_usuario', Auth::user()->codigo_usuario);
					        $registered = $query->first();

					        if($registered instanceof RegistroFaseUsuario) {
								$object->registered = true;
					        }
						}
					break;

					case OrientacionConvocatoria::getOrientation('user'):
						// Valid register user
						$query = RegistroFaseUsuario::query();
						$query->join('core.fase', 'registro_fase_usuario.codigo_fase', '=', 'fase.codigo_fase');
						$query->join('core.convocatoria','fase.codigo_convocatoria', '=', 'convocatoria.codigo_convocatoria');
						$query->join('seguridad.usuario','registro_fase_usuario.codigo_usuario', '=', 'usuario.codigo_usuario');
					  	$query->where('registro_fase_usuario.codigo_estado', Estado::getState('active'));
			            $query->where('usuario.codigo_usuario', Auth::user()->codigo_usuario);
			            $query->where('convocatoria.codigo_convocatoria', $call->codigo_convocatoria);
				        $registered = $query->first();

				        if($registered instanceof RegistroFaseUsuario) {
							$object->registered = true;
				        }
					break;
				}
			}

			// Secure srcparams
			$object->srcparams = TuProyecto::encryptSrcParams([$call->codigo_convocatoria, Recurso::getResource('convocatoria.gestion')]);
		return $object;
	}

	public function apply(Usuario $user, UsuarioEncuesta $userSurvey)
	{
		// Register call
		$register = new RegistroConvocatoria;
		$register->codigo_usuario_encuesta = $userSurvey->codigo_usuario_encuesta;
		$register->codigo_convocatoria = $this->codigo_convocatoria;
		$register->codigo_usuario = $user->codigo_usuario;
		$register->codigo_estado = Estado::getState('active');
		$register->fecha_registro_convocatoria = date('Y-m-d');
        $register->hora_registro_convocatoria = date('H:i:s');
		$register->save();

		// Phase register
		$fase = $this->fase_registro();
		if(!$fase instanceof Fase) {
			throw new \Exception(sprintf('%s:%s', 'Convocatoria apply', "find fase $this->codigo_convocatoria"));
		}

		$registro_fase = new RegistroFaseUsuario;
        $registro_fase->codigo_fase = $fase->codigo_fase;
        $registro_fase->codigo_registro_convocatoria = $register->codigo_registro_convocatoria;
        $registro_fase->codigo_usuario = $user->codigo_usuario;
        $registro_fase->visualizacion_usuario = $this->visualizacion_usuario;
		$registro_fase->fecha_registro_fase_usuario = date('Y-m-d');
        $registro_fase->hora_registro_fase_usuario = date('H:i:s');
		$registro_fase->codigo_estado = Estado::getState('active');
		$registro_fase->save();
	}

	public function metatitle()
	{
		return sprintf('%s / %s', Lang::choice('call.call',1), $this->attributes['nombre_convocatoria']);
	}

	public function fase_registro()
	{
		$query = $this->fases()->where('fase.codigo_estado', Estado::getState('active'))->where('fase.fase_registro', true);
		if(!$this->permanente_convocatoria) {
			$query->whereRaw('CURRENT_DATE between fase.fecha_inicio_fase and fase.fecha_fin_fase');
		}
		return $query->first();
	}

	/**
	 * Defining Relations
	*/
	public function fases()
	{
		return $this->hasMany('App\Fase','codigo_convocatoria','codigo_convocatoria');
	}

	public function documentos()
	{
		return $this->hasMany('App\AdjuntoConvocatoria','codigo_convocatoria','codigo_convocatoria');
    }

    public function notification($job, $parameters)
	{

        $program_aplication_number = "";
        $program_aplication_date = "";
   		try {
            // Data User
            $query = Usuario::query();
            if($parameters['codigo_orientacion_convocatoria'] == OrientacionConvocatoria::getOrientation('entity')){
                $query->select('owner.nombre_usuario as nombre_usuario', 'owner.correo_electronico as correo_electronico', 'usuario.nombre_usuario as nombre_entidad', 'nombre_clase_emprendimiento', 'clase_emprendimiento.codigo_clase_emprendimiento as codigo_clase_emprendimiento');

                $query->join('core.entidad', 'usuario.codigo_usuario', '=', 'entidad.codigo_usuario');
                $query->join('core.clase_emprendimiento_insti', 'entidad.codigo_clase_empre_insti', '=', 'clase_emprendimiento_insti.codigo_clase_empre_insti');
                $query->join('core.clase_emprendimiento', 'clase_emprendimiento_insti.codigo_clase_emprendimiento', '=', 'clase_emprendimiento.codigo_clase_emprendimiento');
                $query->join('seguridad.usuario as owner', 'entidad.seg_codigo_usuario', '=', 'owner.codigo_usuario');
                $query->where('usuario.codigo_usuario', $parameters['codigo_usuario']);
            }else{
                $query->select('usuario.nombre_usuario as nombre_usuario', 'usuario.correo_electronico as correo_electronico');
                $query->where('usuario.codigo_usuario', $parameters['codigo_usuario']);
            }
            $user = $query->first();

            $program_register = RegistroConvocatoria::getUsersPrograms($parameters['codigo_convocatoria'], $parameters['codigo_usuario']);

            if($program_register instanceof RegistroConvocatoria){
                $program_aplication_number = $program_register->numero_registro_convocatoria;
                $program_aplication_date = $program_register->fecha_registro_convocatoria;
             	$nombre_aplicante = $program_register->nombre_usuario.' '.$program_register->primer_apellido_persona;
            }
			// Mail notification
			$data = [];
			$data['_subject'] = trans('innpulsa.mail.program');
			$data['_template'] = 'emails.program.notification';
			$data['_to'] = $user->correo_electronico;
			$data['_to_name'] = $user->nombre_usuario;
			$data['_inst'] = $parameters['codigo_institucion'];
            $data['program_name'] = $parameters['nombre_convocatoria'];
            $data['program_aplication_number'] = $program_aplication_number;
            $data['program_aplication_date'] = $program_aplication_date;
			$data['nombre_aplicante'] = $nombre_aplicante;

			SendEmail::notification($data);

			// Mail notification PFC propace al terminar registro
			/*$data = [];
			$data['_subject'] = 'Programa de formación a cuidadores';
			$data['_template'] = 'emails.program.notificationPfc';
			$data['_to'] = $user->correo_electronico;
			$data['_to_name'] = $user->nombre_usuario;
			$data['_inst'] = $parameters['codigo_institucion'];*/
			//$data['program_name'] = $parameters['nombre_convocatoria'];
			//$data['program_aplication_number'] = $program_aplication_number;
			//$data['program_aplication_date'] = $program_aplication_date;
			//$data['nombre_aplicante'] = $nombre_aplicante;

			//SendEmail::notification($data);

			// Delete Job
			$job->delete();

		}catch(\Exception $e){
			Log::error(sprintf('%s:%s', 'Notification general', $e->getMessage()));
		}
	}
}
