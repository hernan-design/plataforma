<?php

namespace App;

use App\Custom\Bolivar;
use App\Custom\Cenisoft;
use App\Custom\Compensar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

use Illuminate\Http\Request;

use TuProyecto;

use App\Estado;
use App\DetalleVoucher;
use App\UsuarioInstitucion;
use App\Institucion;

use Auth, URL, DB, Input, Queue, Log;

use Custom\Terpel,
	Custom\Innpulsa,
	Custom\RedBavaria,
	Custom\Dinamiza,
	Custom\Propace,
	App\Custom\Rutan;

class Encuesta extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.encuesta';

	protected $primaryKey = 'codigo_encuesta';

	public $timestamps = false;

	public static function getSurvey($survey) {
    	switch ($survey) :
		    case 'angels': return 2;
			default: return 'Not survey identified';
		endswitch;
    }

	public static function getFieldType($type) {
    	switch ($type) :
		    case 'file': return 13;
			default: return 'Not type identified';
		endswitch;
    }

    public static function getAdvanceType($type) {
    	switch ($type) :
		    case 'page': return 1;
		    case 'questions': return 2;
			default: return 'Not type advance identified';
		endswitch;
    }

    public static function getSurveyEntity($user)
   	{
   		$surveys = [];
		$query = Encuesta::query();
		$query->select('encuesta.codigo_encuesta','encuesta.nombre_encuesta', 'usuario.nombre_usuario','imagen_encuesta','url_encuesta','usuario_encuesta.codigo_usuario', 'convocatoria.url_convocatoria');
		$query->join('core.usuario_encuesta', 'encuesta.codigo_encuesta', '=', 'usuario_encuesta.codigo_encuesta');

		// User survey
		$query->join('seguridad.usuario', 'usuario_encuesta.codigo_usuario', '=', 'usuario.codigo_usuario');
		$query->leftJoin('core.entidad', 'usuario.codigo_usuario', '=', 'entidad.codigo_usuario');

		$query->join('core.encuesta_institucion', function($join) {
       		$join->on('encuesta.codigo_encuesta', '=', 'encuesta_institucion.codigo_encuesta')
				->where('encuesta_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('encuesta_institucion.codigo_estado', '=', Estado::getState('active'));
      	});

		$query->leftJoin('core.requisito_fase', function($join) {
       		$join->on('encuesta.codigo_encuesta', '=', 'requisito_fase.codigo_registro_modulo')
				->where('requisito_fase.codigo_modulo', '=', Modulo::getModule('surveys'))
				->where('requisito_fase.codigo_estado', '=', Estado::getState('active'));
      	});
		$query->leftJoin('core.fase', 'requisito_fase.codigo_fase', '=', 'fase.codigo_fase');
		$query->leftJoin('core.convocatoria', 'fase.codigo_convocatoria', '=', 'convocatoria.codigo_convocatoria');

		$query-> where('usuario_encuesta.codigo_usuario', $user);
		$query-> where('usuario_encuesta.codigo_estado', Estado::getState('complete'));
   		$query->orderBy('encuesta.codigo_encuesta','asc');

		// Get total posts
		$total_entries = $query->get()->count();

		// Get posts
		$data = $query->skip(Input::get('offset'))->take(Input::get('limit'))->get();

		if(count($data) > 0) {
			foreach ($data as $survey) {

				$datasurvey = new \stdClass();
				$datasurvey->codigo_usuario =  TuProyecto::encryptSrcParams([$survey->codigo_usuario]);
				$datasurvey->codigo_encuesta = $survey->codigo_encuesta;
				$datasurvey->nombre_encuesta = $survey->nombre_encuesta;
				$datasurvey->nombre_usuario = $survey->nombre_usuario;
				$datasurvey->imagen_encuesta = $survey->imagen_encuesta;
				$datasurvey->url_encuesta = $survey->url_encuesta;
				$datasurvey->url_convocatoria = $survey->url_convocatoria;
				$datasurvey->owner = Auth::check() && in_array(Auth::user()->codigo_usuario, $survey->usuario_encuesta->usuario->getAllowedUsers() ) ? true : false;
				$surveys[] = $datasurvey;
			}
		}

		$response = new \stdClass();
		$response->total_entries = $total_entries;
		$response->items = $surveys;
   		return $response;
   	}

	public static function getClass($class) {
    	switch ($class) :
		    case 'internal': return 1;
		    case 'surveygizmo': return 2;
			default: return 'Not class identified';
		endswitch;
    }

	public static function getSurveyUrl($url) {

		return Encuesta::whereRaw("trim(lower(url_encuesta)) = trim(lower('$url'))")
			->whereRaw("trim(lower(url_encuesta)) != ''")
			->whereNotNull('url_encuesta')
			->join('core.encuesta_institucion', function($join) {
				$join->on('encuesta_institucion.codigo_encuesta', '=', 'encuesta.codigo_encuesta')
					->where('encuesta_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
					->where('encuesta_institucion.codigo_estado', '=', Estado::getState('active'));
	        })
			->first();
       }

       public static function getCompletedSurveyUrl($url) {

		return Encuesta::whereRaw("trim(lower(url_encuesta)) = trim(lower('$url'))")
			->whereRaw("trim(lower(url_encuesta)) != ''")
			->whereNotNull('url_encuesta')
			->join('core.encuesta_institucion', function($join) {
				$join->on('encuesta_institucion.codigo_encuesta', '=', 'encuesta.codigo_encuesta')
					->where('encuesta_institucion.codigo_institucion', '=', RegistroSesion::getInstitution());

	        })
			->first();
   	}

	/**
	 * Get register survey session institution.
	 *
	 * @return Encuesta
	 */
   	public static function getSurveyApplication($module, Usuario $user = null)
   	{
   		$query = Encuesta::join('core.encuesta_institucion', function($join) {
				$join->on('encuesta_institucion.codigo_encuesta', '=', 'encuesta.codigo_encuesta')
					->where('encuesta_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
					->where('encuesta_institucion.codigo_estado', '=', Estado::getState('active'));
	        })
			->join('core.lugar_aplicacion', 'encuesta_institucion.codigo_lugar_aplicacion', '=', 'lugar_aplicacion.codigo_lugar_aplicacion')
   			->where('lugar_aplicacion.codigo_modulo', $module)
			->where('lugar_aplicacion.codigo_estado', Estado::getState('active'));

		if($user instanceof Usuario) {
			$query->leftJoin('core.usuario_encuesta', function($join) use($user) {
				$join->on('encuesta.codigo_encuesta', '=', 'usuario_encuesta.codigo_encuesta')
					->where('usuario_encuesta.codigo_usuario', '=', $user->codigo_usuario);
			});
		}
		return $query->first();
   	}

   	public static function buildSurvey(Encuesta $survey, $userSurvey = null, $arAnswers = null, $nickname =  null)
   	{
   		$object = new \stdClass();
		$object->codigo_encuesta = TuProyecto::encryptSrcParams([$survey->codigo_encuesta]);
		$object->url_encuesta = $survey->url_encuesta;
		$object->nombre_encuesta = $survey->nombre_encuesta;
		$object->descripcion_encuesta = $survey->descripcion_encuesta;
		$object->clase_encuesta = $survey->clase_encuesta;
        $object->nickname_usuario = $nickname;
        $object->completed = $userSurvey instanceof UsuarioEncuesta && $userSurvey->codigo_estado == Estado::getState('complete') ;

		switch ($survey->clase_encuesta) {

			case Encuesta::getClass('internal'):
				// Internal
				$object->label_finalizar = $survey->label_boton_finalizar_encuesta;
				$object->color_fondo_encuesta = $survey->color_fondo_encuesta;
				$object->color_encuesta = $survey->color_encuesta;
				$object->paginacion_encuesta = $survey->paginacion_encuesta;
				$object->redirect_to = $survey->redirect_encuesta;
				$object->preguardado_encuesta = $survey->preguardado_encuesta;
				$object->cancelar_encuesta = $survey->cancelar_encuesta;
				$object->tipo_paginacion_encuesta = $survey->tipo_paginacion_encuesta;
                $object->tipo_porcentaje_avance = $survey->tipo_porcentaje_avance;


				// Survey version
                $version = ( $userSurvey instanceof UsuarioEncuesta && $userSurvey->codigo_estado == Estado::getState('complete') ) ? $userSurvey->codigo_version_encuesta : $survey->codigo_version_encuesta;


				// Prepare questions
				$query = $survey->questions();
				$query->select('pregunta_encuesta.*', 'ver_preg_encuesta.numero_pregunta_version as numero_pregunta_encuesta', 'pregunta.cor_codigo_pregunta_encuesta as pregunta_padre', 'pregunta.codigo_opcion_encuesta', 'sigla_moneda', 'ver_preg_encuesta.clase_pregunta_encuesta');

				$query->join('core.ver_preg_encuesta', 'pregunta_encuesta.codigo_pregunta_encuesta', '=', 'ver_preg_encuesta.codigo_pregunta_encuesta');
				$query->leftJoin('core.subpregunta_encuesta as pregunta', function($join) {
					$join->on('pregunta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
					$join->on('pregunta.codigo_version_encuesta', '=', 'ver_preg_encuesta.codigo_version_encuesta');
					$join->where('pregunta.codigo_estado', '=', Estado::getState('active'));
		        });
				$query->leftJoin('core.moneda', 'pregunta_encuesta.codigo_moneda', '=', 'moneda.codigo_moneda');

				$query->where('pregunta_encuesta.codigo_estado', Estado::getState('active'));
				$query->where('ver_preg_encuesta.codigo_estado', Estado::getState('active'));
				$query->where('ver_preg_encuesta.codigo_version_encuesta', $version);

				$query->orderBy('ver_preg_encuesta.numero_pregunta_version', 'asc');
				$query->orderBy('pregunta.orden_subpregunta_encuesta', 'desc');
				$query->orderBy('pregunta_encuesta.codigo_pregunta_encuesta', 'asc');
				$arQuestions = $query->get();

				if($arQuestions->count() > 0) {
					// Percentage advance
					$object->total_preguntas_padre = $arQuestions->where('clase_pregunta_encuesta', PreguntaEncuesta::getClass('question'))->count();
					$object->total_respuestas_padre = 0;

					if($survey->tipo_porcentaje_avance == self::getAdvanceType('questions')) {
						if(Auth::check() && $userSurvey instanceof UsuarioEncuesta) {
							$object->total_respuestas_padre = $userSurvey->answers($version);
						}
					}

					$questions = [];
					foreach ($arQuestions as $question) {
						$item = new \stdClass();
						$item->codigo_pregunta_encuesta = $question->codigo_pregunta_encuesta;
						$item->texto_pregunta_encuesta = $question->texto_pregunta_encuesta;
						$item->texto_opcional_pregunta = $question->texto_opcional_pregunta;
						$item->tipo_pregunta_encuesta = $question->tipo_pregunta_encuesta;
						$item->tipo_campo_pregunta = $question->tipo_campo_pregunta;
						$item->opcional_pregunta_encuesta = $question->opcional_pregunta_encuesta;
						$item->clase_pregunta_encuesta = $question->clase_pregunta_encuesta;
						$item->codigo_grupo_pregunta_encuesta = $question->codigo_grupo_pregunta_encuesta;
						$item->numero_pregunta_encuesta = $question->numero_pregunta_encuesta;
						$item->longitud_pregunta_encuesta = $question->longitud_pregunta_encuesta;

						$item->subpregunta_pregunta = $question->subpregunta_pregunta;
						$item->pregunta_padre = $question->pregunta_padre;
						$item->codigo_opcion_encuesta = $question->codigo_opcion_encuesta;

						// Only matriz titile of left options
						$item->titulo_opciones_pregunta = $question->titulo_opciones_pregunta;

						// Currency questions
						$item->codigo_moneda = $question->codigo_moneda;
						$item->sigla_moneda = $question->sigla_moneda;

						// Options questions closed, unique or mulplique answer (y-axis)
						$options = [];
						if(in_array($question->tipo_pregunta_encuesta, [PreguntaEncuesta::getType('single'), PreguntaEncuesta::getType('multiple'), PreguntaEncuesta::getType('matriz')])) {
							// Choices closed questions
							$arChoices = $question->choices()->where('codigo_estado', Estado::getState('active'))->where('eje_opcion', OpcionPreguntaEncuesta::getAxis('y'))->orderBy('orden_opcion_encuesta', 'asc')->orderBy('codigo_opcion_encuesta', 'asc')->get();
							if($arChoices->count() > 0) {
								foreach ($arChoices as $choice) {
									$choiceItem = new \stdClass();
									$choiceItem->codigo_opcion_encuesta = $choice->codigo_opcion_encuesta;
									$choiceItem->texto_opcion_encuesta = $choice->texto_opcion_encuesta;
									$choiceItem->calculado_opcion_encuesta = $choice->calculado_opcion_encuesta;
									$choiceItem->referencia_opcion_encuesta = $choice->referencia_opcion_encuesta;
									$choiceItem->tipo_campo_opcion = $choice->tipo_campo_opcion;
									if($choice->calculado_opcion_encuesta == true){
										$choiceItem->formula_opcion_encuesta = $choice->formula_opcion_encuesta;
									}

									// Options field select in matriz
									$choiceItem->opciones = [];
									if( in_array($choice->tipo_campo_opcion , [PreguntaEncuesta::getTypeField('select')]) ) {
										$choiceItem->opciones = $choice->choices()->select('codigo_item_opcion_encuesta', 'nombre_item_opcion_encuesta')->where('codigo_estado', Estado::getState('active'))->get();
									}

									$options[] = $choiceItem;
								}
							}
						}
						$item->opciones = $options;

						// Options questions matriz (x-axis)
						$campos_opciones = [];
						if(in_array($question->tipo_pregunta_encuesta, [PreguntaEncuesta::getType('matriz')])) {
							// Choices closed questions
							$arChoices = $question->choices()->where('codigo_estado', Estado::getState('active'))->where('eje_opcion', OpcionPreguntaEncuesta::getAxis('x'))->orderBy('orden_opcion_encuesta', 'asc')->orderBy('codigo_opcion_encuesta', 'asc')->get();
							if($arChoices->count() > 0) {
								foreach ($arChoices as $choice) {
									$choiceItem = new \stdClass();
									$choiceItem->codigo_opcion_encuesta = $choice->codigo_opcion_encuesta;
									$choiceItem->texto_opcion_encuesta = $choice->texto_opcion_encuesta;
									$choiceItem->calculado_opcion_encuesta = $choice->calculado_opcion_encuesta;
									$choiceItem->referencia_opcion_encuesta = $choice->referencia_opcion_encuesta;
									$choiceItem->tipo_campo_opcion = $choice->tipo_campo_opcion;
									if($choice->calculado_opcion_encuesta == true){
										$choiceItem->formula_opcion_encuesta = $choice->formula_opcion_encuesta;
									}

									// Options field select in matriz
									$choiceItem->opciones = [];
									if( in_array($choice->tipo_campo_opcion , [PreguntaEncuesta::getTypeField('select')]) ) {
										$choiceItem->opciones = $choice->choices()->select('codigo_item_opcion_encuesta', 'nombre_item_opcion_encuesta')->where('codigo_estado', Estado::getState('active'))->get();
									}

									$campos_opciones[] = $choiceItem;
								}
							}
						}
						$item->campos_opciones = $campos_opciones;

						if(in_array($question->tipo_pregunta_encuesta, [PreguntaEncuesta::getType('upload')])) {
							$config = new \stdClass();
							$config->minWidthImg = $question->ancho_pregunta_encuesta;
							$config->minHeightImg = $question->alto_pregunta_encuesta;

							$item->upload_config = $config;
						}

						if(in_array($question->tipo_pregunta_encuesta, [PreguntaEncuesta::getType('open')]) && $question->tipo_campo_pregunta == PreguntaEncuesta::getTypeField('select')) {
							$arChoices = $question->choices()->where('codigo_estado', Estado::getState('active'))->where('eje_opcion', OpcionPreguntaEncuesta::getAxis('y'))->orderBy('orden_opcion_encuesta', 'asc')->orderBy('codigo_opcion_encuesta', 'asc')->get();
							if($arChoices->count() > 0) {
								foreach ($arChoices as $choice) {
									$choiceItem = new \stdClass();
									$choiceItem->codigo_opcion_encuesta = $choice->codigo_opcion_encuesta;
									$choiceItem->texto_opcion_encuesta = $choice->texto_opcion_encuesta;
									$choiceItem->calculado_opcion_encuesta = $choice->calculado_opcion_encuesta;
									$choiceItem->referencia_opcion_encuesta = $choice->referencia_opcion_encuesta;
									$choiceItem->tipo_campo_opcion = $choice->tipo_campo_opcion;
									if($choice->calculado_opcion_encuesta == true){
										$choiceItem->formula_opcion_encuesta = $choice->formula_opcion_encuesta;
									}

									// Options field select in matriz
									$choiceItem->opciones = [];
									if( in_array($choice->tipo_campo_opcion , [PreguntaEncuesta::getTypeField('select')]) ) {
										$choiceItem->opciones = $choice->choices()->select('codigo_item_opcion_encuesta', 'nombre_item_opcion_encuesta')->where('codigo_estado', Estado::getState('active'))->get();
									}

									$options[] = $choiceItem;
								}
							}
						}

						$item->opciones = $options;

						// Build answer
						$item->respuesta = [];
						if($arAnswers instanceof Collection) {
							$item->respuesta = RespuestaEncuesta::buildAnswer($arAnswers, $question->tipo_pregunta_encuesta, $question->codigo_pregunta_encuesta);
						}

						// Add item
						$questions[] = $item;
					}
					// Add questions
					$object->preguntas = $questions;

					// Options questions closed unique or mulplique answer
					$object->agrupaciones = $survey->groups()->select('codigo_grupo_pregunta_encuesta', 'nombre_grupo_pregunta_encuesta', 'desc_grupo_pregunta_encuesta', 'pagina_grupo_pregunta')->get();
				}
			break;
		}

		return $object;
   	}

	/**
	 * Callback response resource.
	 */
   	public function callback(Usuario $user, Request $request, UsuarioEncuesta $userSurvey)
   	{
		// Check middleware requirements
		$step = PasoIngresoInstitucion::query()
			->where('codigo_institucion', RegistroSesion::getInstitution())
			->where('codigo_estado', Estado::getState('active'))
			->where('codigo_modulo', Modulo::getModule('surveys'))
			->where('codigo_recurso_modulo', $this->codigo_encuesta)
			->first();

		$detallevoucher = DetalleVoucher::query()
			->where('detalle_voucher.codigo_usuario', '=', Auth::user()->codigo_usuario)
			->where('detalle_voucher.codigo_estado', '=', Estado::getState('finalized'))
			->orderBy('detalle_voucher.fecha_detalle_voucher','desc')
			->orderBy('detalle_voucher.codigo_detalle_voucher','desc')
			->first();

		if( $detallevoucher instanceof DetalleVoucher){
			$detallevoucher->codigo_estado = Estado::getState('complete');
			$detallevoucher->save();
		}

		// Check middleware requirements
		if($step instanceof PasoIngresoInstitucion)
		{
			$response = PasoUsuario::query()
				->where('codigo_institucion', $step->codigo_institucion)
				->where('codigo_paso_ingreso', $step->codigo_paso_ingreso)
				->where('codigo_usuario', $user->codigo_usuario)->first();
			if(!$response instanceof PasoUsuario) {

				$response = new PasoUsuario();
				$response->codigo_institucion = $step->codigo_institucion;
				$response->codigo_paso_ingreso = $step->codigo_paso_ingreso;
				$response->codigo_usuario = $user->codigo_usuario;
				$response->fecha_paso_usuario = date('Y-m-d H:i:s');
				$response->hora_paso_usuario = date('H:i:s');
				$response->save();
			}
		}

		// Calculate score survey
		$total_score = $this->calculateScore($userSurvey);

		// Set complete user survey
		$userSurvey->codigo_version_encuesta = $this->codigo_version_encuesta;
		$userSurvey->codigo_estado = Estado::getState('complete');
        $userSurvey->puntaje_total_encuesta = $total_score;
        $userSurvey->fecha_fin_usuario_encuesta = date('Y-m-d H:i:s');
		$userSurvey->save();

		// If survey is required for apply program
		if($request->has('codigo_convocatoria'))
		{
			// Decrypt src-params
			list($codigo_convocatoria) = TuProyecto::decryptSrcParams($request->codigo_convocatoria);
			if(!$codigo_convocatoria || !is_numeric($codigo_convocatoria)) {
				throw new \Exception(sprintf('%s:%s', 'Encuesta callback', "decryptSrcParams codigo_convocatoria $codigo_convocatoria"));
			}
			$call = Convocatoria::find($codigo_convocatoria);
			if(!$call instanceof Convocatoria) {
				throw new \Exception(sprintf('%s:%s', 'Encuesta callback', "find codigo_convocatoria $codigo_convocatoria"));
			}

			$call->apply($user, $userSurvey);
			Log::debug(['codigo_encuesta'=>$this->codigo_encuesta, 'nombre_convocatoria' => $call->nombre_convocatoria, 'codigo_convocatoria' => $call->codigo_convocatoria]);
			// Send apply message
			if(in_array($this->codigo_encuesta, [Innpulsa::$challenge])){
				// Queue email Innpulsa
				Queue::push('Custom\Innpulsa@notification', ['codigo_usuario' => $user->codigo_usuario, 'codigo_convocatoria' => $call->codigo_convocatoria, 'codigo_institucion' => RegistroSesion::getInstitution(), 'nombre_convocatoria' => $call->nombre_convocatoria]);
            }else if(in_array($this->codigo_encuesta, [Innpulsa::$challenge_empodera])){
				// Queue email Innpulsa
				Queue::push('Custom\Innpulsa@notification', ['codigo_usuario' => $user->codigo_usuario, 'codigo_convocatoria' => $call->codigo_convocatoria, 'codigo_institucion' => RegistroSesion::getInstitution(), 'nombre_convocatoria' => $call->nombre_convocatoria]);
            }else if(in_array($this->codigo_encuesta, [Terpel::$challenge])){
				// Queue email Innpulsa
				Queue::push('Custom\Terpel@notification', ['codigo_orientacion_convocatoria' => $call->codigo_orientacion_convocatoria ,'codigo_usuario' => $user->codigo_usuario, 'codigo_convocatoria' => $call->codigo_convocatoria, 'codigo_institucion' => RegistroSesion::getInstitution(), 'nombre_convocatoria' => $call->nombre_convocatoria]);
            }else if(in_array($this->codigo_encuesta, [Innpulsa::$challenge_empodera_2020])) {
				// Queue email Empodera2020
				Queue::push('Custom\Innpulsa@notificationEmpodera2020', ['codigo_usuario' => $user->codigo_usuario, 'codigo_convocatoria' => $call->codigo_convocatoria, 'codigo_institucion' => RegistroSesion::getInstitution(), 'nombre_convocatoria' => $call->nombre_convocatoria]);
			}else if(in_array($this->codigo_encuesta, [Innpulsa::$challenge_innpulsa_20])) {
				// Queue email Empodera2020
				Log::info('Correo de aldea 2.0 => Apagado');
				//Queue::push('Custom\Innpulsa@notificationAldea20', ['codigo_usuario' => $user->codigo_usuario, 'codigo_convocatoria' => $call->codigo_convocatoria, 'codigo_institucion' => RegistroSesion::getInstitution(), 'nombre_convocatoria' => $call->nombre_convocatoria]);
			}else if (in_array($this->codigo_encuesta, [Innpulsa::$program_nucleo])) {
				// Queue email Nucleo
				Queue::push('Custom\Innpulsa@notificationNucleo', ['codigo_orientacion_convocatoria' => $call->codigo_orientacion_convocatoria, 'codigo_usuario' => $user->codigo_usuario, 'codigo_convocatoria' => $call->codigo_convocatoria, 'codigo_institucion' => RegistroSesion::getInstitution(), 'nombre_convocatoria' => $call->nombre_convocatoria]);
			}else{
                Queue::push('App\Convocatoria@notification', [
						'codigo_orientacion_convocatoria' => $call->codigo_orientacion_convocatoria,
						'codigo_usuario' => $user->codigo_usuario,
						'codigo_convocatoria' => $call->codigo_convocatoria,
						'codigo_institucion' => RegistroSesion::getInstitution(),
						'nombre_convocatoria' => $call->nombre_convocatoria
					]);
            }

		}

		// After actions
		if(in_array($this->codigo_encuesta, [Terpel::$challenge])) {
			Terpel::challenge($user, $userSurvey);
        }

        if(in_array($this->codigo_encuesta, [Dinamiza::$challenge])) {
			Dinamiza::challenge($user, $userSurvey);
		}

        if (in_array($this->codigo_encuesta, [Dinamiza::$mentor_provider])) {
        	Dinamiza::addValuesOfMentorProvider($user, $request);
		}

        if (in_array($this->codigo_encuesta, [Bolivar::$survey_emprende_2020])) {
        	Bolivar::sendMailEndApplication($user);
        }

        return true;
   	}

	/**
	 * Custom validate after insert.
	 */

	public function afterApplyDiagnostic(Usuario $user, Request $request, UsuarioEncuesta $userSurvey) {

		if(!$userSurvey instanceof UsuarioEncuesta) {
			throw new \Exception(sprintf('%s:%s', 'Encuesta callback', "No encontro usuario_encuesta en afterApplyDiagnostic"));
		}

		// Validate score survey
		$this->validateScore($userSurvey);

		// If survey is required for apply program
		if($request->has('codigo_convocatoria')) {

			// Decrypt src-params
			list($codigo_convocatoria) = TuProyecto::decryptSrcParams($request->codigo_convocatoria);
			if(!$codigo_convocatoria || !is_numeric($codigo_convocatoria)) {
				throw new \Exception(sprintf('%s:%s', 'Encuesta callback', "decryptSrcParams codigo_convocatoria $codigo_convocatoria"));
			}
			$call = Convocatoria::find($codigo_convocatoria);
			if(!$call instanceof Convocatoria) {
				throw new \Exception(sprintf('%s:%s', 'Encuesta callback', "find codigo_convocatoria $codigo_convocatoria"));
			}

			if (in_array($this->codigo_encuesta, [Dinamiza::$diagnostic])) {
				Dinamiza::diagnostic($user, $userSurvey, RegistroSesion::getInstitution(), $call->codigo_convocatoria);
			}

			if (in_array($this->codigo_encuesta, [Cenisoft::$diagnostic])) {
				Cenisoft::diagnostic($user, $userSurvey, RegistroSesion::getInstitution(),  $call->codigo_convocatoria);
			}

			if (in_array($this->codigo_encuesta, [Compensar::$diagnostic])) {
				Compensar::diagnostic($user, $userSurvey, RegistroSesion::getInstitution(), $call->codigo_convocatoria, RegistroSesion::getInstitutionUrl());
			}

			activity()
				->performedOn(Auth::user())
				->withProperties([
					'attributes' => [
						'title' => $call->nombre_convocatoria,
						'user' => $user->nombre_usuario,
						'user_id' => $user->codigo_usuario
					] ])
				->log('activitylog.call.inscription');
		}

		return true;
	}

   	/**
	 * Custom validate before insert.
	 */
   	public function validate(UsuarioEncuesta $userSurvey, $request)
	{
		$response = new \stdClass();
		$response->success = false;

		// Others surveys
		if(in_array($this->codigo_encuesta, [Innpulsa::$challenge])) {
			// Aldea valid apply first challenge
			$valid = Innpulsa::validFirstChallenge($userSurvey, $request);
			if(!$valid->success) {
				$response->error = $valid->data;
				return $response;
			}

		}else if(in_array($this->codigo_encuesta, [Innpulsa::$challenge_innpulsa_20])) {
			// Aldea valid apply first challenge aldea 20
			$valid = Innpulsa::validFirstChallengeAldea($userSurvey, $request);
			if(!$valid->success) {
				$response->error = $valid->data;
				return $response;
			}

		}else if(in_array($this->codigo_encuesta, [Innpulsa::$challenge_empodera])) {
			// Aldea valid apply first challenge empodera
			$valid = Innpulsa::validFirstChallengeEmpodera($userSurvey, $request);
			if(!$valid->success) {
				$response->error = $valid->data;
				return $response;
			}

		}else if(in_array($this->codigo_encuesta, [Terpel::$challenge])) {
			// Terpel valid apply challenge
			$valid = Terpel::validApplyChallenge($userSurvey, $request);
			if(!$valid->success) {
				$response->error = $valid->data;
				return $response;
			}
		} else if (in_array($this->codigo_encuesta, [Compensar::$challenge])) {
			$valid = Compensar::validApplyChallenge($userSurvey, $request);
			if(!$valid->success) {
				$response->error = $valid->data;
				return $response;
			}
		} else if (in_array($this->codigo_encuesta, [Bolivar::$survey_diagnostic_emprende_2020, Bolivar::$survey_diagnostic_emprende_santander_2020, Bolivar::$survey_diagnostic_emprende_magdalena_2020])) {
			$valid = Bolivar::validApplyAutodiagnostic($userSurvey, $request);
			if(!$valid->success) {
				$response->error = $valid->data;
				return $response;
			}
		} else if(in_array($this->codigo_encuesta, [Innpulsa::$challenge_empodera_2020])) {
			// Aldea valid apply first challenge empodera 2020
			// $valid = Innpulsa::validFirstChallengeEmpodera2020($userSurvey, $request);
			// if(!$valid->success) {
			// 	$response->error = $valid->data;
			// 	return $response;
			// }

		} elseif (in_array($this->codigo_encuesta, [Rutan::$program_ruta_del_emprendimiento])) {
			//validacion program_ruta_del_emprendimiento
			$valid = Rutan::validFirstRutaEmprendimiento($userSurvey, $request);
			if(!$valid->success) {
				$response->error = $valid->data;
				return $response;
			}
		}

		$response->success = true;
		return $response;
	}

   	/**
	 * Custom actions before insert.
	 */
   	public function before($request)
	{
		$response = new \stdClass();
		$response->success = false;

		// Register surveys
		$surveyInstitution = $this->encuesta_institucion()->join('core.lugar_aplicacion', 'lugar_aplicacion.codigo_lugar_aplicacion', '=', 'encuesta_institucion.codigo_lugar_aplicacion')->where('codigo_institucion', RegistroSesion::getInstitution())->first();
		if($surveyInstitution instanceof EncuestaInstitucion && $surveyInstitution->codigo_lugar_aplicacion == LugarAplicacion::getPlace('register'))
		{
			// Prepare data user
			$data = [];
			$questions = PreguntaRegistroInstitucion::where('codigo_institucion', RegistroSesion::getInstitution())->where('codigo_estado', Estado::getState('active'))->get();
			// Prepare data user
			foreach ($questions as $question)
			{
				$data[$question->campo_pregunta_registro] =  isset($request["pregunta_{$question->codigo_pregunta_encuesta}"]) ? trim($request["pregunta_{$question->codigo_pregunta_encuesta}"]) :'';
			}

			$user = Usuario::getUserMail($data['correo_electronico']);
			if($user instanceof Usuario) {
				// Validate user
				$userSurvey = UsuarioEncuesta::where('codigo_encuesta', $this->codigo_encuesta)->where('codigo_usuario', $user->codigo_usuario)->where('codigo_modulo', $surveyInstitution->codigo_modulo)->where('id_recurso', $surveyInstitution->codigo_recurso)->first();
				if($userSurvey instanceof UsuarioEncuesta) {
					$response->data = "Ya se encuentra registrado un usuario con este correo electrónico.";
					return $response;
				}

				// Validate usuario institucion
				$userInstitution = UsuarioInstitucion::getUserInstitution($user->codigo_usuario);
				if(!$userInstitution instanceof UsuarioInstitucion) {
					$response->data = trans('app.exception');
					return $response;
				}
			}else{
				$user = Usuario::store($data);
			}
			$response->data = $user;

		}
		$response->success = true;
		return $response;
   	}

   	/**
	 * Custom resource and module.
	 */
   	public function getResource(Request $request)
	{
		$response = new \stdClass();
		$response->module = null;
		$response->resource = null;

		$surveyInstitution = null;

		// Programs
		if($request->has('codigo_convocatoria')) {
			// Decrypt src-params
			list($codigo_convocatoria) = TuProyecto::decryptSrcParams($request->codigo_convocatoria);
			if(!$codigo_convocatoria || !is_numeric($codigo_convocatoria)) {
				throw new \Exception(sprintf('%s:%s', 'Encuesta resource', "decryptSrcParams codigo_convocatoria $codigo_convocatoria"));
			}

			$surveyInstitution = $this->encuesta_institucion()->join('core.lugar_aplicacion', 'lugar_aplicacion.codigo_lugar_aplicacion', '=', 'encuesta_institucion.codigo_lugar_aplicacion')->where('codigo_institucion', RegistroSesion::getInstitution())->where('codigo_recurso', $codigo_convocatoria)->where('codigo_modulo', Modulo::getModule('calls'))->first();

		}else if($request->has('url_fase')) {
			// Find phase
			$fase = Fase::where('url_fase', $request->url_fase)->first();
			if(!$fase instanceof Fase) {
				throw new \Exception(sprintf('%s:%s', 'Encuesta resource', "Fase url_fase $request->url_fase"));
			}

			$surveyInstitution = $this->encuesta_institucion()->join('core.lugar_aplicacion', 'lugar_aplicacion.codigo_lugar_aplicacion', '=', 'encuesta_institucion.codigo_lugar_aplicacion')->where('codigo_institucion', RegistroSesion::getInstitution())->where('codigo_recurso', $fase->codigo_fase)->where('codigo_modulo', Modulo::getModule('phases'))->first();

		}else if($request->has('module')){
			// Default register
			$surveyInstitution = $this->encuesta_institucion()->join('core.lugar_aplicacion', 'lugar_aplicacion.codigo_lugar_aplicacion', '=', 'encuesta_institucion.codigo_lugar_aplicacion')->where('codigo_institucion', RegistroSesion::getInstitution())->where('codigo_recurso', RegistroSesion::getInstitution())->where('codigo_modulo', Modulo::getModule( $request->module ))->first();
		}else{
			// Default register
			$surveyInstitution = $this->encuesta_institucion()->join('core.lugar_aplicacion', 'lugar_aplicacion.codigo_lugar_aplicacion', '=', 'encuesta_institucion.codigo_lugar_aplicacion')->where('codigo_institucion', RegistroSesion::getInstitution())->first();
		}

		// Set module and resource
		if($surveyInstitution instanceof EncuestaInstitucion)
		{
	 		$response->module = $surveyInstitution->codigo_modulo;
	 		$response->resource = $surveyInstitution->codigo_recurso;
		}
		return $response;
	}

	/**
	* Custom custom store.
	*/
   	public function calculateScore(UsuarioEncuesta $userSurvey)
	{
		$score = 0;
		if(in_array($this->codigo_encuesta, [Innpulsa::$challenge])) {
			$score = Innpulsa::scoreChallenge_1($userSurvey);
		}else if(in_array($this->codigo_encuesta, [Innpulsa::$challenge_empodera])) {
			$score = Innpulsa::scoreChallengeEmpodera_1($userSurvey);
		}else if(in_array($this->codigo_encuesta, [Innpulsa::$challenge_empodera_2020])) {
			$score = Innpulsa::scoreEmpodera2020($userSurvey);
		} else if(in_array($this->codigo_encuesta, [Innpulsa::$challenge_innpulsa_20])) {
			$score = Innpulsa::scoringAldea20($userSurvey);
		} else if(in_array($this->codigo_encuesta, [Innpulsa::$final_evaluation_empresarios])) {
			$score = Innpulsa::changePhaseFour($userSurvey);
		} else if (in_array($this->codigo_encuesta, [Innpulsa::$program_appsco])) {
			$score = Innpulsa::scoringProgramAppsco($userSurvey);
		} else if (in_array($this->codigo_encuesta, [Propace::$surveySelectedCourses])) {
			Propace::notificationSelectedCourses($score, $userSurvey->codigo_usuario, $this->nombre_encuesta);
		} else if (!in_array($this->codigo_encuesta, Propace::$surveySelectExcept)) {
			$score = $this->generalScore($userSurvey);

			$userInstitution = UsuarioInstitucion::where('codigo_usuario', $userSurvey->codigo_usuario)
				->where('codigo_institucion', RegistroSesion::getInstitution())
				->first();

			switch ($userInstitution->codigo_institucion) {
				case Institucion::getInstitution('propace'):
					Propace::sendMailFirstSurveyCourse($score, $userSurvey->codigo_usuario, $this->nombre_encuesta);
				break;
			}
		}

		return $score;
	}

	/**
	 * Compute total score of evaluation anwswered by user
	 */
	public function generalScore(UsuarioEncuesta $userSurvey){

			$query = RespuestaEncuesta::query();
			$query->select(DB::raw('SUM(COALESCE(puntaje_respuesta_encuesta, 0) ) AS total_evaluation'));
			$query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
        	$query->where('respuesta_encuesta.codigo_estado', Estado::getState('active'));
			$query->where('respuesta_encuesta.codigo_usuario_encuesta', $userSurvey->codigo_usuario_encuesta);
			$scoring = $query->first()->total_evaluation;
		return $scoring;
	}

	public function validateScore(UsuarioEncuesta $userSurvey)
	{
		if(in_array($this->codigo_encuesta, [Innpulsa::$challenge_empodera_2020])) {
			Innpulsa::validateAssignPhaseTwoEmpodera2020($userSurvey);
		}
	}

   	/**
	 * Defining Relations
	*/
	public function usuario_encuesta()
    {
        return $this->hasOne('App\UsuarioEncuesta','codigo_usuario','codigo_usuario');
    }

    public function encuesta_institucion()
    {
        return $this->hasOne('App\EncuestaInstitucion','codigo_encuesta','codigo_encuesta');
    }

    public function questions()
    {
        return $this->hasMany('App\PreguntaEncuesta','codigo_encuesta','codigo_encuesta');
    }

    public function groups()
    {
        return $this->hasMany('App\GrupoPreguntaEncuesta','codigo_encuesta','codigo_encuesta');
    }
}
