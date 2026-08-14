<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

use TuProyecto;
use App\EventoInstitucion, App\LugarAplicacion,  App\EncuestaInstitucion, App\TemaPrincipalEvento, App\Calendario, App\Asesoria;
use Input, Auth, Validator, Queue, Lang, App, DB, Log;

class Evento extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.evento';

   	protected $primaryKey = 'codigo_evento';

   	public $timestamps = false;

   	protected $fillable = ['nombre_evento', 'descripcion_evento', 'lugar_evento', 'codigo_ciudad', 'imagen_evento'];

   	/**
	* Valid create Event.
	*/
   	public function isValid($data)
    {
        $rules = array(
            'nombre_evento' => 'required|string|max:80',
            'descripcion_evento' => 'required|string',
        	'fecha_inicio' => 'required',
			'fecha_fin' => 'required|after:fecha_inicio',
			// 'codigo_asesoria' => 'required',

        );

		$messages = [
			// 'codigo_asesoria.required' => 'Seleccione un emprendimiento',
			'descripcion_evento.required' => 'Escriba una Descripción',
			'nombre_evento.required' => 'Escriba el titulo del Evento',
			'fecha_inicio.required' => 'Seleccione fecha de inicio',
			'fecha_fin.required' => 'Seleccione fecha fin',
			'fecha_fin.after' => 'La fecha u hora fin debe ser una fecha posterior a la fecha inicio.',
		];

     	$validator = Validator::make($data, $rules, $messages);
        if ($validator->passes()) {
     		return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

   	/**
	* Get event from from url.
	*/

    public static function getUrlEvent($event)
	{
		$query = Evento::query();
        $query->select('evento.*', 'tipo_evento_calendario.codigo_tipo_evento', 'tipo_evento_calendario.codigo_clase_tipo_evento', DB::raw("CASE WHEN tema_principal_evento.nombre_tema_principal_evento IS NULL THEN '' ELSE nombre_tema_principal_evento END AS nombre_tema_principal_evento"),
        'imagen_usuario', 'nickname_usuario', 'seo.*',
            DB::raw("initcap(usuario.nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '')) as nombre_usuario"),
            DB::raw(sprintf('%s %s', Seo::$raw_follow, 'as enlaces_motores_busqueda')),
            DB::raw(sprintf('%s %s', Seo::$raw_index, 'as indexar_motores')),
			DB::raw("( SELECT string_agg(etapa_contenido.nombre_etapa_contenido::text, ',') as etapas
			 FROM core.etapa_contenido
			LEFT JOIN param.etapa_conten_insti ON etapa_conten_insti.codigo_etapa_contenido = etapa_contenido.codigo_etapa_contenido
			LEFT JOIN core.etapa_cont_event ON etapa_cont_event.codigo_etapa_contenido = etapa_contenido.codigo_etapa_contenido
		    WHERE etapa_conten_insti.codigo_institucion = ".RegistroSesion::getInstitution()." AND etapa_cont_event.codigo_evento = evento.codigo_evento)"),
			DB::raw("( SELECT string_agg(categoria_contenido.nombre_categoria_contenido::text, ',') as categorias
			 FROM core.categoria_contenido
			LEFT JOIN param.cat_conten_insti ON cat_conten_insti.codigo_categoria_contenido = categoria_contenido.codigo_categoria_contenido
			LEFT JOIN core.cat_conten_evento ON cat_conten_evento.codigo_categoria_contenido = categoria_contenido.codigo_categoria_contenido
		    WHERE cat_conten_insti.codigo_institucion = ".RegistroSesion::getInstitution()." AND cat_conten_evento.codigo_evento = evento.codigo_evento)"),
            // Evaluate session user register in event
            (Auth::check() ?
                DB::raw('(CASE WHEN usuario_evento.codigo_usuario_evento IS NULL THEN false ELSE true END) AS register') : DB::raw('false AS register')),
            (Auth::check() ?
                DB::raw('usuario_evento.codigo_usuario_evento AS codigo_usuario_evento') : DB::raw('null AS codigo_usuario_evento'))
        );

		$query->join('core.evento_institucion', function($join) {
       		$join->on('evento.codigo_evento', '=', 'evento_institucion.codigo_evento')
				->where('evento_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('evento_institucion.codigo_estado', '=', Estado::getState('active'));
      	});

		$query->join('core.tipo_evento_calendario', 'evento_institucion.codigo_tipo_evento_calendario', '=', 'tipo_evento_calendario.codigo_tipo_evento_calendario');

		$query->leftjoin('core.tema_principal_institucion', function($join) {
			$join->on('evento.codigo_tema_principal_evento', '=', 'tema_principal_institucion.codigo_tema_principal_evento')
			 ->where('tema_principal_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
			 ->where('tema_principal_institucion.codigo_estado', '=', Estado::getState('active'));
		   });

		$query->leftjoin('core.tema_principal_evento', function($join) {
			$join->on('tema_principal_institucion.codigo_tema_principal_evento', '=', 'tema_principal_evento.codigo_tema_principal_evento');
			$join->on('tema_principal_institucion.codigo_tema_principal_evento', '=',  'evento.codigo_tema_principal_evento');
		});

		$query->join('seguridad.usuario', 'evento.codigo_usuario', '=', 'usuario.codigo_usuario');
        $query->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');

        $query->leftJoin('core.seo', function($join){
			$join->on('evento.codigo_evento', '=', 'seo.id_recurso')
				->where('seo.codigo_modulo', Modulo::getModule('calendar'));
		});

        // Evaluate session user register in event
        if(Auth::check()) {
            $query->leftJoin('core.usuario_institucion', function($join) {
                $join->on('usuario_institucion.codigo_institucion', '=', 'evento_institucion.codigo_institucion');
                $join->where('usuario_institucion.codigo_usuario', Auth::user()->codigo_usuario);
            });

            $query->leftJoin('core.usuario_evento', function($join) {
                $join->on('usuario_institucion.codigo_usuario_institucion', '=', 'usuario_evento.codigo_usuario_institucion');
                $join->on('usuario_evento.codigo_evento', '=', 'evento.codigo_evento');
            });
        }

		$query->whereRaw("trim(lower(url_evento)) = trim(lower('$event'))");
		$query->whereRaw("trim(lower(url_evento)) != ''");
		$query->whereNotNull('url_evento');
		return $query->first();
	}


   	/**
	* Get event from from url.
	*/
    public static function getEvent($event)
	{
		$query = Evento::query();
		$query->select(
			'evento.*',
			'tipo_evento_calendario.codigo_tipo_evento',
			DB::raw("trim(initcap(tema_principal_evento.nombre_tema_principal_evento))
				as nombre_tema_principal_evento"),
			'seo.*',
			'emprendimiento.nombre_usuario as nombre_emprendimiento',
			'usuario_em.nombre_usuario as nombre_usuario_emprendimiento',
			'persona.primer_apellido_persona as apellido_usuario_emprendimiento'
		);
		$query->join('core.evento_institucion', function($join) {
       		$join->on('evento.codigo_evento', '=', 'evento_institucion.codigo_evento')
				->where('evento_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('evento_institucion.codigo_estado', '=', Estado::getState('active'));
      	});
        $query->join('core.tipo_evento_calendario', 'evento_institucion.codigo_tipo_evento_calendario', '=', 'tipo_evento_calendario.codigo_tipo_evento_calendario');

		$query->leftjoin('core.tema_principal_institucion', function($join) {
			$join->on('evento.codigo_tema_principal_evento', '=', 'tema_principal_institucion.codigo_tema_principal_evento')
			 ->where('tema_principal_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
			 ->where('tema_principal_institucion.codigo_estado', '=', Estado::getState('active'));
		   });

		$query->leftjoin('core.tema_principal_evento', function($join) {
			$join->on('tema_principal_institucion.codigo_tema_principal_evento', '=', 'tema_principal_evento.codigo_tema_principal_evento');
			$join->on('tema_principal_institucion.codigo_tema_principal_evento', '=',  'evento.codigo_tema_principal_evento');
		});

        $query->leftJoin('core.seo', function($join){
			$join->on('evento.codigo_evento', '=', 'seo.id_recurso')
				->where('seo.codigo_modulo', Modulo::getModule('calendar'));
		});

		$query->join('aprende.mentoria', 'mentoria.codigo_evento', '=', 'evento.codigo_evento');
		$query->join('core.asesoria', 'asesoria.codigo_asesoria', '=', 'mentoria.codigo_asesoria');
		$query->join('core.entidad', 'entidad.codigo_entidad', '=', 'asesoria.codigo_entidad');
		$query->join('seguridad.usuario as emprendimiento', 'emprendimiento.codigo_usuario', '=', 'entidad.codigo_usuario');

		$query->join('seguridad.usuario as usuario_em', 'usuario_em.codigo_usuario', '=', 'entidad.seg_codigo_usuario');
		$query->join('core.persona', 'persona.codigo_usuario', '=', 'usuario_em.codigo_usuario');

		$query->whereNotIn('evento.codigo_estado', [Estado::getState('removed')]);
		$query->where('evento.codigo_evento', $event);
		$query->orderBy('evento.codigo_evento','desc');
		return $query->first();
	}

	public static function getEvents(array $filters = [])
	{
		$events = [];

		$query = Evento::query();
        $query->select('evento.resumen_evento','evento.codigo_evento', 'evento.pago_evento', 'tipo_evento_calendario.codigo_tipo_evento as codigo_tipo_evento', 'tipo_evento_calendario.codigo_clase_tipo_evento', 'nombre_evento', 'lugar_evento', 'url_evento', 'fecha_evento', 'fecha_fin_evento', 'hora_inicio_evento', 'hora_fin_evento', 'nombre_ciudad', 'evento.codigo_estado', 'evento.codigo_usuario as owner', 'mentoria.codigo_usuario as entrepreneur', 'usuario.nickname_usuario', 'usprorg.nickname_usuario as nickname_organizador', 'usuario.imagen_usuario', 'icono_tipo_evento', 'evento.imagen_evento',
        DB::raw("initcap(usuario.nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') ) as nombre_usuario"),
		DB::raw('usprorg.nombre_usuario as nombre_organizador_principal', 'usprorg.imagen_usuario as imagen_organizador_principal'),
        DB::raw("initcap(usuario.nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') ) as nombre_usuario"),
		DB::raw("( SELECT string_agg(etapa_contenido.nombre_etapa_contenido::text, ',') as etapas
			FROM core.etapa_contenido
		LEFT JOIN param.etapa_conten_insti ON etapa_conten_insti.codigo_etapa_contenido = etapa_contenido.codigo_etapa_contenido
		LEFT JOIN core.etapa_cont_event ON etapa_cont_event.codigo_etapa_contenido = etapa_contenido.codigo_etapa_contenido
        WHERE etapa_conten_insti.codigo_institucion = ".RegistroSesion::getInstitution()." AND etapa_cont_event.codigo_evento = evento.codigo_evento)"),
		DB::raw("( SELECT string_agg(categoria_contenido.nombre_categoria_contenido::text, ',') as categorias
			FROM core.categoria_contenido
		LEFT JOIN param.cat_conten_insti ON cat_conten_insti.codigo_categoria_contenido = categoria_contenido.codigo_categoria_contenido
		LEFT JOIN core.cat_conten_evento ON cat_conten_evento.codigo_categoria_contenido = categoria_contenido.codigo_categoria_contenido
        WHERE cat_conten_insti.codigo_institucion = ".RegistroSesion::getInstitution()." AND cat_conten_evento.codigo_evento = evento.codigo_evento)"),
        (Auth::check() ?
        DB::raw("(SELECT CASE WHEN usuario_evento.codigo_usuario_institucion IS NULL THEN FALSE ELSE TRUE END AS registrado FROM core.usuario_institucion
            JOIN core.evento_institucion ON usuario_institucion.codigo_institucion = evento_institucion.codigo_institucion
                AND usuario_institucion.codigo_usuario = ".Auth::user()->codigo_usuario."
            JOIN core.usuario_evento ON usuario_institucion.codigo_usuario_institucion = usuario_evento.codigo_usuario_institucion AND
            usuario_evento.codigo_evento =  evento.codigo_evento LIMIT 1 )") : DB::raw('FALSE AS registrado'))
		);


        $query->join('core.ciudad', 'evento.codigo_ciudad', '=', 'ciudad.codigo_ciudad');
		$query->join('core.evento_institucion', function($join) {
			$join->on('evento.codigo_evento', '=', 'evento_institucion.codigo_evento')
				->where('evento_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('evento_institucion.codigo_estado', '=', Estado::getState('active'));
		});
		$query->join('core.tipo_evento_calendario', 'evento_institucion.codigo_tipo_evento_calendario', '=', 'tipo_evento_calendario.codigo_tipo_evento_calendario');

		$query->join('core.tipo_evento', 'tipo_evento_calendario.codigo_tipo_evento', '=', 'tipo_evento.codigo_tipo_evento');

		$query->join('seguridad.usuario', 'evento.codigo_usuario', '=', 'usuario.codigo_usuario');
		$query->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');

		$query->leftJoin('seguridad.usuario as usprorg', 'usprorg.codigo_usuario', '=', 'evento.seg_codigo_usuario');

		// Left join mentoring
		$query->leftJoin('aprende.mentoria',function($join) {
			$join->on('evento.codigo_evento', '=', 'mentoria.codigo_evento')
			->whereNotIn('mentoria.codigo_estado', [Estado::getState('removed')]);
			});

		// Filter channel
		if (isset($filters['url_canal']) && !empty($filters['url_canal'])) {
			$query->join('core.contenido_canal', function($join) {
	            $join->on('evento.codigo_evento', '=', 'contenido_canal.codigo_recurso_modulo')
	                ->where('contenido_canal.codigo_modulo', '=', Modulo::getModule('calendar'))
	                ->where('contenido_canal.codigo_estado', '=', Estado::getState('active'));
	        });

	        $query->join('core.canal', function($join) use($filters){
	            $join->on('contenido_canal.codigo_canal', '=', 'canal.codigo_canal')
	                ->where('canal.url_canal', '=', $filters['url_canal'])
					->where('canal.codigo_institucion', '=', RegistroSesion::getInstitution());
	        });
		}

           // Evaluate session user register in event
        if(Auth::check()) {
            $query->join('core.usuario_institucion', function($join) {
                $join->on('usuario_institucion.codigo_institucion', '=', 'evento_institucion.codigo_institucion');
                $join->where('usuario_institucion.codigo_usuario', Auth::user()->codigo_usuario);
            });

            $query->leftJoin('core.usuario_evento', function($join) {
                $join->on('usuario_institucion.codigo_usuario_institucion', '=', 'usuario_evento.codigo_usuario_institucion');
                $join->on('usuario_evento.codigo_evento', '=', 'evento.codigo_evento');
            });
		}

		// Evaluate specific calendar
		if (isset($filters['calendar']) && !empty($filters['calendar'])) {
			$calendar = Calendario::where('url_calendario', $filters['calendar'])->first();
			if (!$calendar instanceof Calendario) {
				abort(404);
			}

			$query->where('evento.codigo_calendario', $calendar->codigo_calendario);
		}

		// Filters
		switch (isset($filters['type']) && !empty($filters['type']) ? $filters['type'] : '') {

			// Case calendar module

		    case 'calendar':
				if(!empty($filters['month'])) {
					$month = $filters['month'];
					$query->whereRaw("EXTRACT(month from fecha_evento) = $month");
				}

				if(isset($filters['fecha_evento']) && !empty($filters['fecha_evento'])
					&& preg_replace("/[^a-zA-Z0-9]/", "", $filters['fecha_evento']) != '' ) {
					$date = $filters['fecha_evento'];
					$query->where('fecha_evento','>=',$date);
				} else {
					$date = date("Y-m-d");
					$query->where('fecha_fin_evento','>=',$date);
				}


                if(isset($filters['fecha_fin_evento']) && !empty($filters['fecha_fin_evento'])
					&& preg_replace("/[^a-zA-Z0-9]/", "", $filters['fecha_fin_evento']) != '' ) {
					$date = $filters['fecha_fin_evento'];
					$query->where('fecha_fin_evento','<=',$date);
				}else {
					$date = date("Y-m-d");
					$query->where('fecha_fin_evento','>=',$date);
				}

				if(!empty($filters['year'])) {
					$year = $filters['year'];
					$query->whereRaw("EXTRACT(year from fecha_evento) = $data");
				}


		 		if(!empty($filters['city'])) {
			 		$query->where('evento.codigo_ciudad', $filters['city']);
		 		}

				if(isset($filters['categories']) && !empty($filters['categories'])){
					$query->whereIn('tipo_evento_calendario.codigo_tipo_evento', is_array($filters['categories']) ? $filters['categories'] : [$filters['categories']]);
				}

				$query->where('tipo_evento_calendario.codigo_clase_tipo_evento', ClaseTipoEvento::getClass('platform'));

		        // Get posts
		 		$total_entries = $query->count();

		 		$query->where('evento.codigo_privacidad_contenido', '=', PrivacidadContenido::getPrivacy('public'));
				$query->orderBy('evento.fecha_evento','desc');
				$query->orderBy('evento.hora_inicio_evento','desc');
		   		$query->skip($filters['offset'])->take($filters['limit']);
				$data = $query->get();
		        break;

			// Case schedule
		    case 'schedule':
				// Filter Events

		    	$query->where(function ($query) use ($filters) {

                    $query->whereRaw("usuario_evento.codigo_usuario_institucion  IN (
                        SELECT usuario_institucion.codigo_usuario_institucion FROM core.usuario_institucion
                        JOIN core.evento_institucion ON usuario_institucion.codigo_institucion = evento_institucion.codigo_institucion
                            AND usuario_institucion.codigo_usuario = ".Auth::user()->codigo_usuario."
                        JOIN core.usuario_evento ON usuario_institucion.codigo_usuario_institucion = usuario_evento.codigo_usuario_institucion AND
                        usuario_evento.codigo_evento =  evento.codigo_evento ) AND
                        (CURRENT_DATE between fecha_evento and fecha_fin_evento OR fecha_fin_evento >= CURRENT_DATE)");

                    $query->orWhere('mentoria.codigo_usuario', '=', Auth::user()->codigo_usuario);
				    // Decrypt src-params
			    	if(isset($filters['codigo_usuario']) && !empty($filters['codigo_usuario'])){
						if(is_numeric($filters['codigo_usuario'])){
							$codigo_usuario = (int) $filters['codigo_usuario'];
						}else{
							list($codigo_usuario) = TuProyecto::decryptSrcParams($filters['codigo_usuario']);
						}

						if( !empty($codigo_usuario) && is_numeric($codigo_usuario)) {
							$query->orWhere('evento.codigo_usuario', '=', $codigo_usuario);
						}


					}else{
                        $query->orWhere('evento.codigo_usuario', '=', Auth::user()->codigo_usuario);

                    }

                    $query->orWhere(function ($query) {
                        $query->where('tipo_evento_calendario.codigo_clase_tipo_evento', ClaseTipoEvento::getClass('platform'));
                        $query->where('evento.codigo_estado', Estado::getState('active'));
                        $query->where('evento.codigo_privacidad_contenido', '=', PrivacidadContenido::getPrivacy('public'));
                    });

				});

				if(!empty($filters['event']) && $filters['event'] == 'mentoring') {
					$query->where('tipo_evento_calendario.codigo_tipo_evento', TipoEvento::getTypeEvent('mentoring'));

				}
				if(!empty($filters['start']) && $filters['start'] ) {
					$query->where('evento.fecha_evento', '>=', $filters['start']);
				}
				if(!empty($filters['end']) && $filters['end'] == 'mentoring') {
					$query->where('evento.fecha_fin_evento', '<=', $filters['end']);
				}

				$query->where('evento.codigo_estado', '!=', Estado::getState('removed'));
                $data = $query->get();
		   		break;

	    	default:

	    		$query->whereRaw('(CURRENT_DATE between fecha_evento and fecha_fin_evento OR fecha_fin_evento >= CURRENT_DATE)');

    			$query->where('evento.privacidad_evento', false);
				$query->where('evento.codigo_estado', Estado::getState('active'));
		 		$query->where('tipo_evento_calendario.codigo_clase_tipo_evento', ClaseTipoEvento::getClass('platform'));

		    	$query->orderBy('evento.fecha_evento','asc');
				$query->orderBy('evento.hora_inicio_evento','asc');

		        // Get posts
				$data = $query->take($filters['limit'])->get();
				break;
		}


		if(count($data) > 0) {
	   		foreach ($data as $event) {
	   			$object = new \stdClass();
		    	$object->codigo_evento = \TuProyecto::encryptSrcParams([$event->codigo_evento]);

				switch (isset($filters['type']) && !empty($filters['type']) ? $filters['type'] : '') {
					// Case schedule
				    case 'schedule':
			    		$object->id = $event->codigo_evento;
						$object->title = $event->nombre_evento;
						$object->start = $event->fecha_evento.'T'.$event->hora_inicio_evento;
                        $object->end = $event->fecha_fin_evento.'T'.$event->hora_fin_evento;
                        $object->view = $event->fecha_fin_evento < date("Y-m-d") ? false : true;
                        $object->url_evento = $event->url_evento;


						switch ($event->codigo_estado) {
							case Estado::getState('active'):
								$object->className = 'available';
								break;
							case Estado::getState('confirm'):
								$object->className = sprintf("%s %s", in_array(Auth::getUser()->codigo_usuario, [$event->owner, $event->entrepreneur]) ? '' : 'disabled', 'confirm');
								break;
							case Estado::getState('confirmed'):
								$object->className = sprintf("%s %s", in_array(Auth::getUser()->codigo_usuario, [$event->owner, $event->entrepreneur]) ? '' : 'disabled', 'confirmed');
								break;
							default:
								$object->className = 'disabled';
								break;
                        }


                        $object->owner = Auth::user()->codigo_usuario == $event->owner ? true : false;
                        $object->registrado = $event->registrado ?? false;
                        $object->registrado = true;
                        $object->clase_tipo_evento = $event->codigo_clase_tipo_evento ?? ClaseTipoEvento::getClass('user');

                        if(  !$object->owner &&  !$object->registrado ){
                                $object->color = 'gray';
                                $object->className = 'disabled';
                                if(Estado::getState('active') && ($event->fecha_evento >= date("Y-m-d") ) ){
                                    $object->className = 'unregistered';
                                    //$object->className = 'confirm';
                                }
                        }
		   			break;

					default:
						$object->nombre_evento = strip_tags($event->nombre_evento);
						$object->lugar_evento = strip_tags($event->lugar_evento);
						$object->fecha_evento = strip_tags($event->fecha_evento);

						$object->url_evento = $event->url_evento;
						$object->fecha_evento = $event->fecha_evento;
						$object->fecha_fin_evento = $event->fecha_fin_evento;
						$object->hora_inicio_evento = $event->hora_inicio_evento;
						$object->hora_fin_evento = $event->hora_fin_evento;
						$object->nombre_ciudad = $event->nombre_ciudad;
						$object->nombre_usuario = $event->nombre_usuario;
						$object->nickname_usuario = $event->nickname_usuario;
						$object->nickname_organizador = $event->nickname_organizador ? $event->nickname_organizador : '';
						$object->imagen_usuario = $event->imagen_usuario;
						$object->imagen_organizador_principal = $event->imagen_organizador_principal;
						$object->icono_tipo_evento = $event->icono_tipo_evento;
						$object->imagen_evento = $event->imagen_evento;
                        $object->resumen_evento = $event->resumen_evento;
                        $object->clase_tipo_evento = $event->codigo_clase_tipo_evento;
						$object->view = $event->fecha_fin_evento < date("Y-m-d") ? false : true;
						$object->pago_evento = $event->pago_evento;
						$object->nombre_organizador_principal = $event->nombre_organizador_principal;
						$object->etapas = $event->etapas ? $event->etapas : null;
						$object->categorias = $event->categorias ? $event->categorias : null;
					break;
				}
				$events[] = $object;
	   		}
	   	}

		switch (isset($filters['type']) && !empty($filters['type']) ? $filters['type'] : '') {
			// Case calendar module
		    case 'calendar':
     			$response = new \stdClass();
				$response->total_entries = $total_entries;
				$response->fecha_evento = $filters['fecha_evento'] ?? '';
				$response->items = $events;
		   		return $response;

            default:
			  	return $events;
		}

   	}

   	/**
	 * Build event.
	 */
   	public static function buildEvent($event)
   	{
		$object = new \stdClass();
		$object->codigo_evento = TuProyecto::encryptSrcParams([$event->codigo_evento]);
		$object->url_evento = $event->url_evento;
		$object->url_evento_organizador = $event->url_evento_organizador;
		$object->nombre_evento = strip_tags($event->nombre_evento);
		$object->descripcion_evento = $event->descripcion_evento;
		$object->resumen_evento = $event->resumen_evento;
		$object->lugar_evento = $event->lugar_evento;
		$object->codigo_tipo_evento = $event->codigo_tipo_evento;
		$object->codigo_tema_principal_evento = $event->codigo_tema_principal_evento;
		$object->nombre_tema_principal_evento = $event->nombre_tema_principal_evento;
		$object->codigo_ciudad = $event->codigo_ciudad;
		$object->nombre_ciudad = $event->ciudad->nombre_ciudad;
		$object->fecha_evento = $event->fecha_evento;
		$object->fecha_fin_evento = $event->fecha_fin_evento;
		$object->hora_inicio_evento = $event->hora_inicio_evento;
		$object->hora_fin_evento = $event->hora_fin_evento;
		$object->imagen_evento = $event->imagen_evento;
		$object->resumen_evento = $event->resumen_evento;
		$object->pago_evento = $event->pago_evento;
		$object->registro_interes_evento = $event->registro_interes_evento;
		$object->etapas = $event->etapas ? $event->etapas : null;
		$object->categorias = $event->categorias ? $event->categorias : null;
		$object->nombre_usuario = isset($event->nombre_usuario) ? $event->nombre_usuario : '';
		$object->nickname_usuario = isset($event->nickname_usuario) ? $event->nickname_usuario : '';
		$object->imagen_usuario = isset($event->imagen_usuario) ? $event->imagen_usuario : '';
		$object->fecha_label_evento = TuProyecto::dateFormat($event->fecha_evento, 'short');
		$object->owner = (Auth::check() && Auth::user()->codigo_usuario == $event->codigo_usuario) ? true : false;
		$object->start = $event->fecha_evento.'T'.$event->hora_inicio_evento;
        $object->end = $event->fecha_fin_evento.'T'.$event->hora_fin_evento;
        $object->clase_tipo_evento = $event->codigo_clase_tipo_evento;
		$object->view = $event->fecha_fin_evento < date("Y-m-d") ? false : true;
		$object->nombre_emprendimiento = $event->nombre_emprendimiento;
		$object->nombre_usuario_emprendimiento = $event->nombre_usuario_emprendimiento;
		$object->apellido_usuario_emprendimiento = $event->apellido_usuario_emprendimiento;

		// SEO
		$object->nombre_facebook = $event->nombre_facebook;
		$object->nombre_twitter = $event->nombre_twitter;
		$object->descripcion_facebook = $event->descripcion_facebook;
		$object->descripcion_twitter = $event->descripcion_twitter;
		$object->imagen_facebook = $event->imagen_facebook;
		$object->imagen_twitter = $event->imagen_twitter;
        $object->url_canonica = $event->url_canonica;
        $object->directivas = !empty($event->indexar_motores) ? "{$event->indexar_motores},{$event->enlaces_motores_busqueda}" : '';
        $object->tags_content = $event->tags()->get()->implode('texto_tag', ',');

        $object->register = $event->register;
        $object->codigo_usuario_evento = $event->codigo_usuario_evento;

		switch ($event->codigo_tipo_evento) {
			case TipoEvento::getTypeEvent('mentoring'):
				$mentoring = Mentoria::getMentoringEvent($event->codigo_evento);

				if($mentoring instanceof Mentoria) {
					$object->descripcion_mentoria = $mentoring->descripcion_mentoria;
					$object->url_mentoria = sprintf("%s-%s", 'sesion', $mentoring->codigo_mentoria);

					$data = $mentoring->objetivos()->where('codigo_estado', Estado::getState('active'))->get();
					$objectives = [];
					if(count($data) > 0) {
						foreach ($data as $target) {
							$objective = new \stdClass();
							$objective->texto_tag = $target->descripcion_objetivo_mentoria;
							$objectives[] = $objective;
						}
					}
					$object->objetivos_mentoria = $objectives;
				}
				break;
			default:
				$organizers = $event->organizers()->get();
				$items = [];
				if(count($organizers) > 0) {
					foreach ($organizers as $organizer) {
						$item = new \stdClass();
						$item->nombre_patrocinador = $organizer->organizador->nombre_patrocinador;
						$item->imagen_patrocinador = $organizer->organizador->imagen_patrocinador;
						$item->url_patrocinador = $organizer->organizador->url_patrocinador;
						$items[] = $item;
					}
				}
				$object->organizadores = $items;
				break;
		}

		return $object;
   	}

   	public static function updateEvent(Evento $event)
   	{
		$typeEvenCalendar = TipoEventoCalendario::getCalendarInstitution(Input::get('codigo_tipo_evento'));
		if(!$typeEvenCalendar instanceof TipoEventoCalendario) {
			abort(403);
		}

		$data = Input::all();
		if ($event->isValid($data)) {
			$event->fill($data);
			$event->codigo_calendario = $typeEvenCalendar->codigo_calendario;

   			// Date start event
			if( Input::has('fecha_inicio') && !empty(Input::get('fecha_inicio')) ) {
				list($date, $time) = explode(' ', Input::get('fecha_inicio'));
	   			$event->fecha_evento = $date;
				$event->hora_inicio_evento = $time;
			}

   			// Date end event
			if( Input::has('fecha_fin') && !empty(Input::get('fecha_fin')) ) {
				list($date, $time) = explode(' ', Input::get('fecha_fin'));
	   			$event->fecha_fin_evento = $date;
				$event->hora_fin_evento = $time;
			}
			$event->save();

			// Update event institution
			EventoInstitucion::where('codigo_evento', $event->codigo_evento)->where('codigo_institucion', RegistroSesion::getInstitution())
				->update(['codigo_tipo_evento_calendario' => $typeEvenCalendar->codigo_tipo_evento_calendario]);
			return;
		}
		throw new \Exception($event->errors);
	}

	public static function createMentoring(Evento $event) {
		DB::beginTransaction();
		try {
			$mentoring = new Mentoria;
			$event->codigo_estado = Estado::getState('confirm');
			$event->save();

			$advisory = Asesoria::select('usuario.codigo_usuario')
				->join('core.entidad', 'entidad.codigo_entidad', '=', 'asesoria.codigo_entidad')
				->join('seguridad.usuario', 'usuario.codigo_usuario', '=', 'entidad.seg_codigo_usuario')
				->where('codigo_asesoria', '=', Input::get('codigo_asesoria'))
				->first();

			$mentoring->codigo_usuario = $advisory->codigo_usuario;
			$mentoring->codigo_estado = Estado::getState('pending');
			$mentoring->descripcion_mentoria = Input::get('descripcion_evento');
			$mentoring->fecha_mentoria = date('Y-m-d');
			$mentoring->hora_mentoria = date('H:i:s');
			$mentoring->codigo_evento = $event->codigo_evento;
			$mentoring->seg_codigo_usuario = $event->codigo_usuario;
			$mentoring->codigo_asesoria = Input::get('codigo_asesoria');
			$mentoring->save();

			$mentoringInstitution = new MentoriaInstitucion;
			$mentoringInstitution->codigo_mentoria = $mentoring->codigo_mentoria;
			$mentoringInstitution->codigo_institucion = RegistroSesion::getInstitution();
			$mentoringInstitution->codigo_estado = Estado::getState('active');
			$mentoringInstitution->save();

			$themeEvent = TemaPrincipalEvento::find(Input::get('codigo_tema_principal_evento'));

			$omentoring = new ObjetivoMentoria;
			$omentoring->codigo_estado = Estado::getState('active');
			$omentoring->codigo_mentoria = $mentoring->codigo_mentoria;
			$omentoring->descripcion_objetivo_mentoria = $themeEvent->nombre_tema_principal_evento;
			$omentoring->save();

   			// Mail notification
			/*Queue::push('App\Mentoria@notification', ['codigo_mentoria' => $mentoring->codigo_mentoria,
			'codigo_evento' => $event->codigo_evento ]);*/

			// Commit Transaction
			DB::commit();
			return Lang::get('mentoring.notification.schedule');
		} catch (\Exception $e) {
			DB::rollback();
			Log::error(sprintf('%s:%s', 'EventoController store', $mentoring->errors));
			throw new \Exception($mentoring->errors);
		}
	}

   	public static function scheduleMentoring(Evento $event)
   	{
   		$mentoring = new Mentoria;
		if ($mentoring->isValid( Input::all() ))
		{
			$event->codigo_estado = Estado::getState('confirm');
			$event->save();

			$mentoring->codigo_usuario = Auth::user()->codigo_usuario;
			$mentoring->codigo_estado = Estado::getState('pending');
			$mentoring->descripcion_mentoria = Input::get('descripcion_mentoria');
			$mentoring->fecha_mentoria = date('Y-m-d');
			$mentoring->hora_mentoria = date('H:i:s');
			$mentoring->codigo_evento = $event->codigo_evento;
			$mentoring->seg_codigo_usuario = $event->codigo_usuario;
			$mentoring->codigo_asesoria = Input::get('codigo_asesoria');
			$mentoring->save();

			$mentoringInstitution = new MentoriaInstitucion;
			$mentoringInstitution->codigo_mentoria = $mentoring->codigo_mentoria;
			$mentoringInstitution->codigo_institucion = RegistroSesion::getInstitution();
			$mentoringInstitution->codigo_estado = Estado::getState('active');
			$mentoringInstitution->save();

   			if(Input::has('objetivos_mentoria')) {
	   			if(is_array(Input::get('objetivos_mentoria')) && count(Input::get('objetivos_mentoria')) > 0)
	   			{
	   				$objectives = Input::get('objetivos_mentoria');
		   			foreach ($objectives as $objective) {
		   				$omentoring = new ObjetivoMentoria;
						$omentoring->codigo_estado = Estado::getState('active');
						$omentoring->codigo_mentoria = $mentoring->codigo_mentoria;
			   			$omentoring->descripcion_objetivo_mentoria = $objective;
			   			$omentoring->save();
		   			}
		   		}else{
	   				$omentoring = new ObjetivoMentoria;
					$omentoring->codigo_estado = Estado::getState('active');
					$omentoring->codigo_mentoria = $mentoring->codigo_mentoria;
		   			$omentoring->descripcion_objetivo_mentoria = Input::get('objetivos_mentoria');
		   			$omentoring->save();
		   		}
			   }

   			// Mail notification
			Queue::push('App\Mentoria@notification', ['codigo_mentoria' => $mentoring->codigo_mentoria,
			'codigo_evento' => $event->codigo_evento ]);
			return Lang::get('mentoring.notification.schedule');
		}
		throw new \Exception($mentoring->errors);
   	}

   	public static function confirmMentoring(Evento $event)
   	{
   		$mentoring = Mentoria::getMentoringEvent($event->codigo_evento);
		if($mentoring instanceof Mentoria) {
			$mentoring->codigo_estado = Estado::getState('active');
			$mentoring->save();
			$event->codigo_estado = Estado::getState('confirmed');
			$event->save();

			// Mail notification Confirm
			Queue::push('App\Mentoria@notificationConfirm', ['codigo_mentoria' => $mentoring->codigo_mentoria, 'codigo_evento' => $event->codigo_evento, 'codigo_institucion' => $mentoring->codigo_institucion]);
			return Lang::get('mentoring.notification.schedule.confirm');
		}
		throw new \Exception('Evento::confirmMentoring -> Mentoring not found');
   	}

   	/**
	 * Defining Relations
	*/
	public function usuario()
    {
        return $this->hasOne('App\Usuario','codigo_usuario','codigo_usuario');
    }

    public function ciudad()
    {
        return $this->hasOne('App\Ciudad','codigo_ciudad','codigo_ciudad');
    }

    public function organizers()
    {
        return $this->hasMany('App\OrganizadorEvento','codigo_evento','codigo_evento');
    }

	public function usuarioEvento()
	{
		return $this->hasOne('App\UsuarioEvento', 'codigo_usuario_institucion', 'codigo_usuario_institucion');
	}

	public function tags()
    {
        return $this->belongsToMany('App\Tag', 'core.tag_evento', 'codigo_evento', 'codigo_tag');
    }
}
