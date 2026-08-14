<?php

namespace App\Http\Controllers;

use App\Custom\Cenisoft;
use Custom\Dinamiza;
use App\Custom\Compensar;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth, Cache, DB, Log, Lang, URL;

use TuProyecto, Custom\Terpel, Custom\Innpulsa;

use App\Encuesta,
	App\PasoIngresoInstitucion,
	App\PasoUsuario,
	App\RegistroSesion,
	App\Estado,
	App\Modulo,
	App\RequisitoFase,
	App\OrientacionConvocatoria,
	App\Proyecto,
	App\UsuarioEncuesta,
	App\PreguntaEncuesta,
	App\RespuestaEncuesta,
	App\Usuario,
	App\Adjunto,
	App\TipoAdjunto,
	App\AdjuntoRespuestaEncuesta,
	Appcatoria,
	App\Fase,
	App\RegistroFaseUsuario,
	App\OpcionPreguntaEncuesta,
	App\RegistroConvocatoria,
	App\AsignacionJurado,
	App\Convocatoria,
	App\AsignacionEvaluadores;

class EncuestaController extends Controller
{
	/**
	 * Instantiate a new EncuestaController instance.
	 */
	public function __construct()
	{
		$this->middleware('auth', ['except' => ['index', 'register', 'update']]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		if($request->ajax()) {
            if($request->has('user')) {
            	// Decrypt src-params
		        list($codigo_usuario) = TuProyecto::decryptSrcParams($request->user);
		        if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
		            abort(403);
		        }
                $user = Usuario::find($codigo_usuario);
                if(!$user instanceof Usuario) {
                    abort(404);
                }
                return response()->json(Encuesta::getSurveyEntity($user->codigo_usuario));
            }
        }
		$error = "encuesta no encontrada";

        abort(404, $error);

		return response()->json(['success' => false, 'errors' => $error]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(Request $request, $id)
	{
		$data = $request->all();

        $survey = Encuesta::getSurveyUrl($id);

		if(!$survey instanceof Encuesta) {
            Log::error(sprintf('%s:%s', 'EncuestaController show', 'survey not found'));
            if ($request->ajax()) {
                return response()->json(['success' => false, 'errors' => 'survey not found']);
            }

			abort(404,'Survey not found');
		}

		if ($request->ajax()) {
			$user = $userSurvey = $answers = null;
			if($request->has('codigo_usuario_encuesta')) {
				// Detail form
				list($codigo_usuario_encuesta) = TuProyecto::decryptSrcParams($request->codigo_usuario_encuesta);
				if(!$codigo_usuario_encuesta || !is_numeric($codigo_usuario_encuesta)) {
					abort(403);
				}
                $userSurvey = UsuarioEncuesta::find($codigo_usuario_encuesta);
			}else{
				// Decrypt src-params
				if($request->has('codigo_usuario')) {

					list($codigo_usuario) = TuProyecto::decryptSrcParams($request->codigo_usuario);
					if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
						abort(403);
                    }
                    $user = Usuario::findOrfail($codigo_usuario);
				}

				// Active form
				$codigo_usuario = (isset($user) && $user instanceof Usuario) ? $user->codigo_usuario : Auth::user()->codigo_usuario;
                $resource = $survey->getResource($request);
                $states =  [ Estado::getState('active')];
                if ($request->has('completed')) {
                    array_push($states, Estado::getState('complete'));
                }
				if(!is_null($resource->resource) && !is_null($resource->module)) {
                    // Usuario encuesta
                    $userSurvey = UsuarioEncuesta::where('codigo_encuesta', $survey->codigo_encuesta)->where('codigo_usuario', $codigo_usuario)->where('codigo_modulo', $resource->module)->where('id_recurso',$resource->resource)->whereIn('codigo_estado', $states)->first();
				}else{
                    $userSurvey = UsuarioEncuesta::where('codigo_encuesta', $survey->codigo_encuesta)->where('codigo_usuario', $codigo_usuario)->whereIn('codigo_estado', $states)->first();
				}
            }

			if(Auth::check() && $userSurvey instanceof UsuarioEncuesta)
			{
				$query = RespuestaEncuesta::query();
				$query->select('pregunta_encuesta.codigo_pregunta_encuesta', 'respuesta_encuesta.texto_respuesta_encuesta', 'respuesta_encuesta.codigo_opcion_encuesta', 'respuesta_encuesta.cor_codigo_opcion_encuesta');
				$query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
				$query->where('respuesta_encuesta.codigo_usuario_encuesta', $userSurvey->codigo_usuario_encuesta);
				$query->where('respuesta_encuesta.codigo_estado', Estado::getState('active'));
				$answers = $query->get();
            }


			return response()->json(Encuesta::buildSurvey($survey, $userSurvey, $answers));
		}
		$error = "encuesta no encontrada";

        abort(404, $error);

		return response()->json(['success' => false, 'errors' => $error]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{

		if ($request->ajax()) {
			// Decrypt src-params
			list($codigo_encuesta) = TuProyecto::decryptSrcParams($id);
			if(!$codigo_encuesta || !is_numeric($codigo_encuesta)) {
				$message = 'error con el código de encuesta: ' . $codigo_encuesta;
				Log::error(sprintf('%s:%s', 'EncuestaController update', $message));
				abort(403, $message);
			}

			$survey = Encuesta::find($codigo_encuesta);
			if(!$survey instanceof Encuesta) {
				$message = 'no se encuentra la encuesta de codigo: ' . $codigo_encuesta;
                Log::error(sprintf('%s:%s', 'EncuestaController update', $message));
				abort(404, $message);
			}


			$response = new \stdClass();
			$response->message = $survey->respuesta_encuesta;

			$answers = [];
            $questions = $survey->questions()->where('pregunta_encuesta.codigo_estado', Estado::getState('active'))->get();

			if($questions->count()) {

				// Custom actions before insert survey
				try {
					// Resources
					$userSurvey = $user = null;

					// Before
					$result = $survey->before($request->all());
					if(!$result->success){
                        Log::error(sprintf('%s:%s', 'EncuestaController update', $result->data));
						return response()->json(['success' => false, 'errors' => $result->data]);
					}


					// User manual
					if($request->has('codigo_usuario')) {
						// Decrypt src-params
						list($codigo_usuario) = TuProyecto::decryptSrcParams($request->codigo_usuario);

						if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
							throw new \Exception(sprintf('%s:%s', 'EncuestaController update', "decryptSrcParams codigo_usuario $codigo_usuario"));
						}

						$user = Usuario::find($codigo_usuario);
						if(!$user instanceof Usuario) {
							throw new \Exception(sprintf('%s:%s', 'EncuestaController update', "find codigo_usuario $codigo_usuario"));
						}


					}

					// User auto
					if(!$user instanceof Usuario) {
						// Define user response survey
						$user = Auth::check() ? ((isset($result->data) && $result->data instanceof Usuario) ? $result->data : Auth::user()) : $result->data;
						if(!$user instanceof Usuario) {
							throw new \Exception(sprintf('%s:%s', 'EncuestaController update', "Usuario no identificado para encuesta"));
						}
					}



					// Usuario encuesta
					if($request->has('codigo_usuario_encuesta')) {
						// Decrypt src-params
						list($codigo_usuario_encuesta) = TuProyecto::decryptSrcParams($request->codigo_usuario_encuesta);
						if(!$codigo_usuario_encuesta || !is_numeric($codigo_usuario_encuesta)) {
							throw new \Exception(sprintf('%s:%s', 'Encuesta usuario encuesta', "decryptSrcParams codigo_usuario_encuesta $codigo_usuario_encuesta"));
						}

						$userSurvey = UsuarioEncuesta::find($codigo_usuario_encuesta);
						$user = Usuario::find($userSurvey->codigo_usuario);

					}else{
						$resource = $survey->getResource($request);

						if(is_null($resource->resource) || is_null($resource->module)) {
							throw new \Exception(sprintf('%s:%s', 'Encuesta resource', "No es posible definir modulo ($resource->resource) y recurso ($resource->module)"));
						}

						$userSurvey = UsuarioEncuesta::where('codigo_encuesta', $survey->codigo_encuesta)->where('codigo_usuario', $user->codigo_usuario)->where('codigo_modulo', $resource->module)->where('id_recurso', $resource->resource)->where('codigo_estado', Estado::getState('active'))->first();
						if(!$userSurvey instanceof UsuarioEncuesta) {
							$userSurvey = new UsuarioEncuesta;
							$userSurvey->codigo_encuesta = $survey->codigo_encuesta;
							$userSurvey->codigo_usuario = $user->codigo_usuario;
							$userSurvey->codigo_modulo = $resource->module;
							$userSurvey->id_recurso = $resource->resource;
							$userSurvey->codigo_estado = Estado::getState('active');
							$userSurvey->fecha_usuario_encuesta = date('Y-m-d');
							$userSurvey->hora_usuario_encuesta = date('H:i:s');
							$userSurvey->save();
						}
					}


					if(!$userSurvey instanceof UsuarioEncuesta) {
						throw new \Exception(sprintf('%s:%s', 'Encuesta resource', "No es posible definir usuario encuesta"));
					}


                    if ($survey->redirect_encuesta) {
                        $response->redirect_to = $survey->redirect_encuesta ?: null;
                    }

					if ($survey->redireccion_usuario) {
						$response->redirect = $survey->redireccion_usuario;

						switch ($survey->codigo_orientacion_encuesta) {
							case 1:
								$response->orientacion = 'Entidades';
								$response->url_redirect = 'proyecto/'.$user->nickname_usuario.'/convocatorias#project-programs';
								break;
							case 2:
								$response->orientacion = 'Personas';
								$response->url_redirect = 'usuario/'.$user->nickname_usuario.'/convocatorias';
								break;
						}
                    } else {
						$response->redirect = false;
					}


					// Validations
                    $result = $survey->validate($userSurvey, $request->all());


					if(!$result->success){
						Log::error(sprintf('%s:Invalid Survey! %s', 'EncuestaController update',  $result->error));
						return response()->json(['success' => false,  'errors' => $result->error]);
					}
				}catch(\Exception $e){
                    Log::error(sprintf('%s: %s (File: %s, Line: %s)', 'EncuestaController update', $e->getMessage(),$e->getFile(),$e->getLine()));
					return response()->json(['success' => false, 'errors' => Lang::get('app.exception')]);
				}

				// Init save survey
				DB::beginTransaction();
				try {
                    foreach ($questions as $question)
					{

						// Prepare answer response
						$answerResponse = new \stdClass();
						$answerResponse->codigo_pregunta_encuesta = $question->codigo_pregunta_encuesta;

						switch ($question->tipo_pregunta_encuesta) {
							// Case open questions
							case PreguntaEncuesta::getType('open'):
								if($request->has("pregunta_$question->codigo_pregunta_encuesta"))
								{
									$answer = RespuestaEncuesta::where('codigo_pregunta_encuesta', $question->codigo_pregunta_encuesta)->where('codigo_usuario', $user->codigo_usuario)->where('codigo_usuario_encuesta', $userSurvey->codigo_usuario_encuesta)->first();

									if(!$answer instanceof RespuestaEncuesta) {
										$answer = new RespuestaEncuesta;
										$answer->codigo_usuario_encuesta = $userSurvey->codigo_usuario_encuesta;
										$answer->codigo_pregunta_encuesta = $question->codigo_pregunta_encuesta;
										$answer->codigo_usuario = $user->codigo_usuario;
									}

									$answer->codigo_estado = Estado::getState('active');
									$answer->texto_respuesta_encuesta = trim($request->input("pregunta_$question->codigo_pregunta_encuesta"));
									$answer->periodo_respuesta_encuesta = $question->periodo_pregunta_encuesta;
									$answer->fecha_respuesta_encuesta = date('Y-m-d');
									$answer->hora_respuesta_encuesta = date('H:i:s');
									$answer->save();

									// Add answer response
									$answerResponse->respuesta = $answer->texto_respuesta_encuesta;
									$answers[] = $answerResponse;
								}
							break;

							// Case single questions
							case PreguntaEncuesta::getType('single'):
								if($request->has(sprintf("pregunta_%s_opcion", $question->codigo_pregunta_encuesta)))
								{
									$choice = OpcionPreguntaEncuesta::find($request->input(sprintf("pregunta_%s_opcion", $question->codigo_pregunta_encuesta)));
									if(!$choice instanceof OpcionPreguntaEncuesta) {
										throw new \Exception(sprintf('%s:%s', 'EncuestaController update', "Error recuperando opción para $question->codigo_pregunta_encuesta single"));
									}

									$answer = RespuestaEncuesta::where('codigo_pregunta_encuesta', $question->codigo_pregunta_encuesta)->where('codigo_usuario', $user->codigo_usuario)->where('codigo_usuario_encuesta', $userSurvey->codigo_usuario_encuesta)->first();
									if(!$answer instanceof RespuestaEncuesta) {
										$answer = new RespuestaEncuesta;
										$answer->codigo_usuario_encuesta = $userSurvey->codigo_usuario_encuesta;
										$answer->codigo_pregunta_encuesta = $question->codigo_pregunta_encuesta;
										$answer->codigo_usuario = $user->codigo_usuario;
									}
									$answer->codigo_estado = Estado::getState('active');
									$answer->codigo_opcion_encuesta = $choice->codigo_opcion_encuesta;
									$answer->puntaje_respuesta_encuesta = $choice->puntaje_opcion_encuesta;
									$answer->periodo_respuesta_encuesta = $question->periodo_pregunta_encuesta;
									$answer->fecha_respuesta_encuesta = date('Y-m-d');
									$answer->hora_respuesta_encuesta = date('H:i:s');
									$answer->save();

									// Add answer response
									$answerResponse->respuesta = $answer->codigo_opcion_encuesta;
									$answers[] = $answerResponse;
								}
							break;

							// Case multiple questions
							case PreguntaEncuesta::getType('multiple'):
								$choices = $question->choices()->where('opcion_encuesta.codigo_estado', Estado::getState('active'))->where('eje_opcion', OpcionPreguntaEncuesta::getAxis('y'))->get();
								$flag = true;

								$answerChoices = [];
								foreach ($choices as $choice) {
									if($request->has(sprintf("pregunta_%s_opcion_%s", $question->codigo_pregunta_encuesta, $choice->codigo_opcion_encuesta))) {
										if($flag){
											$answer = RespuestaEncuesta::where('codigo_pregunta_encuesta', $question->codigo_pregunta_encuesta)->where('codigo_usuario', $user->codigo_usuario)->where('codigo_usuario_encuesta', $userSurvey->codigo_usuario_encuesta)->delete();
											$flag = false;
										}
										$answer = new RespuestaEncuesta;
										$answer->codigo_usuario_encuesta = $userSurvey->codigo_usuario_encuesta;
										$answer->codigo_pregunta_encuesta = $question->codigo_pregunta_encuesta;
										$answer->codigo_usuario = $user->codigo_usuario;
										$answer->codigo_estado = Estado::getState('active');
										$answer->codigo_opcion_encuesta = intval($request->input(sprintf("pregunta_%s_opcion_%s", $question->codigo_pregunta_encuesta, $choice->codigo_opcion_encuesta)));
										$answer->puntaje_respuesta_encuesta = $choice->puntaje_opcion_encuesta;
										$answer->periodo_respuesta_encuesta = $question->periodo_pregunta_encuesta;
										$answer->fecha_respuesta_encuesta = date('Y-m-d');
										$answer->hora_respuesta_encuesta = date('H:i:s');
										$answer->save();

										$answerChoices[] = $answer->codigo_opcion_encuesta;
									}
								}

								// Add answer response
								if(count($answerChoices) > 0) {
									$answerResponse->respuesta = $answerChoices;
									$answers[] = $answerResponse;
								}
							break;

							case PreguntaEncuesta::getType('upload'):
								if($request->has("pregunta_$question->codigo_pregunta_encuesta")) {
									$answer = RespuestaEncuesta::where('codigo_pregunta_encuesta', $question->codigo_pregunta_encuesta)->where('codigo_usuario', $user->codigo_usuario)->where('codigo_usuario_encuesta', $userSurvey->codigo_usuario_encuesta)->first();

									if(!$answer instanceof RespuestaEncuesta) {
										$answer = new RespuestaEncuesta;
										$answer->codigo_usuario_encuesta = $userSurvey->codigo_usuario_encuesta;
										$answer->codigo_pregunta_encuesta = $question->codigo_pregunta_encuesta;
										$answer->codigo_usuario = $user->codigo_usuario;
									}
									$answer->codigo_estado = Estado::getState('active');
									$answer->texto_respuesta_encuesta = $request->input("pregunta_$question->codigo_pregunta_encuesta");
									$answer->periodo_respuesta_encuesta = $question->periodo_pregunta_encuesta;
									$answer->fecha_respuesta_encuesta = date('Y-m-d');
									$answer->hora_respuesta_encuesta = date('H:i:s');
									$answer->save();

									// Add answer response
									$answerResponse->respuesta = $answer->texto_respuesta_encuesta;
									$answers[] = $answerResponse;

									if(in_array($question->tipo_campo_pregunta, [Encuesta::getFieldType('file')])) {

										// Prepare filename
										$filename = explode('/', $request->input("pregunta_$question->codigo_pregunta_encuesta"));
										$attachedAnswer = AdjuntoRespuestaEncuesta::where('codigo_respuesta_encuesta', $answer->codigo_respuesta_encuesta)->first();
										if(!$attachedAnswer instanceof AdjuntoRespuestaEncuesta) {
											// Adjunto
								   			$attached = new Adjunto();
											$attached->codigo_tipo_adjunto = TipoAdjunto::getTypeAttached('document');
											$attached->nombre_adjunto = urldecode(end($filename));
								   			$attached->direccion_adjunto = $request->input("pregunta_$question->codigo_pregunta_encuesta");
                                            $attached->fecha_adjunto = date('Y-m-d H:i:s');
								   			$attached->save();

											// Adjunto Usuario
											$attachedAnswer = new AdjuntoRespuestaEncuesta;
											$attachedAnswer->codigo_adjunto = $attached->codigo_adjunto;
											$attachedAnswer->codigo_respuesta_encuesta = $answer->codigo_respuesta_encuesta;
											$attachedAnswer->codigo_estado = Estado::getState('active');
								   			$attachedAnswer->save();
								   		}else{

								   			$attached = Adjunto::find($attachedAnswer->codigo_adjunto);
								   			if($attached instanceof Adjunto){
												$attached->nombre_adjunto = urldecode(end($filename));
								   				$attached->direccion_adjunto = $request->input("pregunta_$question->codigo_pregunta_encuesta");
								   				$attached->save();
								   			}
								   		}
									}
								}
							break;

							case PreguntaEncuesta::getType('matriz'):
								// Y-Axis
								$choices = $question->choices()->where('opcion_encuesta.codigo_estado', Estado::getState('active'))->where('eje_opcion', OpcionPreguntaEncuesta::getAxis('y'))->get();

								// X-Axis
								$fields = $question->choices()->where('opcion_encuesta.codigo_estado', Estado::getState('active'))->where('eje_opcion', OpcionPreguntaEncuesta::getAxis('x'))->get();

								$answersMatriz = [];
								foreach ($choices as $choice) {
									foreach ($fields as $field) {
										if( $request->has(sprintf("pregunta_%s_opcion_%s_campo_%s", $question->codigo_pregunta_encuesta, $choice->codigo_opcion_encuesta, $field->codigo_opcion_encuesta)) ) {

											$answer = RespuestaEncuesta::where('codigo_usuario', $user->codigo_usuario)->where('codigo_pregunta_encuesta', $question->codigo_pregunta_encuesta)->where('codigo_opcion_encuesta', $choice->codigo_opcion_encuesta)->where('cor_codigo_opcion_encuesta', $field->codigo_opcion_encuesta)->where('codigo_usuario_encuesta', $userSurvey->codigo_usuario_encuesta)->first();
											if(!$answer instanceof RespuestaEncuesta) {
												$answer = new RespuestaEncuesta;
												$answer->codigo_usuario_encuesta = $userSurvey->codigo_usuario_encuesta;
												$answer->codigo_pregunta_encuesta = $question->codigo_pregunta_encuesta;
												$answer->codigo_usuario = $user->codigo_usuario;
												$answer->codigo_opcion_encuesta = $choice->codigo_opcion_encuesta;
												$answer->cor_codigo_opcion_encuesta = $field->codigo_opcion_encuesta;
											}
											$answer->codigo_estado = Estado::getState('active');
											$answer->texto_respuesta_encuesta = $request->get(sprintf("pregunta_%s_opcion_%s_campo_%s", $question->codigo_pregunta_encuesta, $choice->codigo_opcion_encuesta, $field->codigo_opcion_encuesta));
											$answer->periodo_respuesta_encuesta = $question->periodo_pregunta_encuesta;
											$answer->fecha_respuesta_encuesta = date('Y-m-d');
											$answer->hora_respuesta_encuesta = date('H:i:s');
											$answer->save();

											$answersMatriz["{$choice->codigo_opcion_encuesta}_{$field->codigo_opcion_encuesta}"] = $answer->texto_respuesta_encuesta;
										}
									}
								}

								// Add answer response
								if(count($answersMatriz) > 0) {
									$answerResponse->respuesta = $answersMatriz;
									$answers[] = $answerResponse;
								}
							break;
						}
					}

					// custom actions after insert survey

					if ($request->has('ended')) {
						$survey->callback($user, $request, $userSurvey);
						// DB::rollback();
						// return response()->json(['success' => false,'errors' => 'Prueba Error: ' . $total]);
					}

					if($survey->tipo_porcentaje_avance == Encuesta::getAdvanceType('questions')) {
						if(Auth::check() && $userSurvey instanceof UsuarioEncuesta) {
							$response->total_respuestas_padre = $userSurvey->answers( ($userSurvey instanceof UsuarioEncuesta && $userSurvey->codigo_estado == Estado::getState('complete')) ? $userSurvey->codigo_version_encuesta : $survey->codigo_version_encuesta );
						}
					}

					$response->success = true;
                    $response->respuestas = $answers;


					// Commit Transaction
					//DB::commit();


					if ($request->has('ended')) {
						$survey->afterApplyDiagnostic($user, $request, $userSurvey);
						//Add evaluador automaticamente cuando se registra,  validamos si codigo_convocatoria existe
						//para determinar si se està postulando a convocatoria
						if($request->has('codigo_convocatoria')){
							$this->evaluatorAssignment($userSurvey);
						}
						// DB::commit();

						// DB::rollback();
						// return response()->json(['success' => false,'errors' => 'Prueba Error: '.$respuesta]);
					}

					DB::commit();

					// DB::rollback();
					// return response()->json(['success' => false,'errors' => trans('app.exception')]);
					return response()->json($response);
				}catch(\Exception $e){
					DB::rollback();
					Log::error(sprintf('%s: %s (File: %s, Line: %s)', 'EncuestaController update', $e->getMessage(),$e->getFile(),$e->getLine()));
					return response()->json(['success' => false,'errors' => trans('app.exception')]);
				}
			}
        }
        Log::error(sprintf('%s:%s', 'EncuestaController update', 'Recurso no encontrado'));
		abort(404);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}

	/**
	 * Get register survey session institution.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function register(Request $request)
	{
		if ($request->ajax()) {
			$survey = Encuesta::getSurveyApplication(Modulo::getModule('register'));
			if(!$survey instanceof Encuesta) {
				abort(404);
			}

			return response()->json(Encuesta::buildSurvey($survey));
		}
		abort(404);
	}

	/**
	 * Display the specified resource version review.
	 *
	 * @param  string  $url
	 * @return \Illuminate\Http\Response
	 */
	public function revision(Request $request, $url, $userSurvey)
	{

		$survey = Encuesta::getSurveyUrl($url);
		if(!$survey instanceof Encuesta) {
			abort(404);
		}

		// Decrypt src-params
		list($codigo_usuario_encuesta) = TuProyecto::decryptSrcParams($userSurvey);
		if(!$codigo_usuario_encuesta || !is_numeric($codigo_usuario_encuesta)) {
			abort(403);
		}

		$userSurvey = UsuarioEncuesta::find($codigo_usuario_encuesta);
		if(!$userSurvey instanceof UsuarioEncuesta) {
			abort(404);
		}

		return view('core.survey.main');
	}

		/**
	 * Display the specified resource version review.
	 *
	 * @param  string  $url
	 * @return \Illuminate\Http\Response
	 */
	public function aplicar(Request $request, $survey, $user)
	{
		$survey = Encuesta::getSurveyUrl($survey);
		if(!$survey instanceof Encuesta) {
			abort(404);
		}

		// Decrypt src-params
		list($codigo_usuario) = TuProyecto::decryptSrcParams($user);
		if(!$codigo_usuario || !is_numeric($codigo_usuario)) {
			abort(403);
		}

		$user = Usuario::find($codigo_usuario);
		if(!$user instanceof Usuario) {
			abort(404);
		}

		return view('core.survey.main');
	}

	public function responder(Request $request, $survey)
	{
		$survey = Encuesta::getSurveyUrl($survey);
		if(!$survey instanceof Encuesta) {
			abort(404);
		}

		$codigo_usuario = Auth::user()->codigo_usuario;

		$user = Usuario::find($codigo_usuario);
		if(!$user instanceof Usuario) {
			abort(404);
		}

		return view('core.survey.main');
	}

	/**
	 * Display the specified resource version review.
	 *
	 * @param  string  $url
	 * @return \Illuminate\Http\Response
	 */
	public function cancelar(Request $request, $id)
	{
		// Decrypt src-params
		list($codigo_encuesta) = TuProyecto::decryptSrcParams($id);
		if(!$codigo_encuesta || !is_numeric($codigo_encuesta)) {
			abort(403);
		}

		$survey = Encuesta::find($codigo_encuesta);
		if(!$survey instanceof Encuesta) {
			abort(404);
		}

		// Inactive user survey
		UsuarioEncuesta::where('codigo_usuario', Auth::user()->codigo_usuario)->where('codigo_encuesta', $survey->codigo_encuesta)->update(['codigo_estado' => Estado::getState('pending')]);

		return redirect()->route('muro.index');
    }

    /**
	 * Check estatus from survey.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function respondida(Request $request)
	{
		if($request->ajax())
    	{
			if($request->has('codigo_usuario_encuesta'))
    		{
				// Decrypt src-params
	            list($codigo_usuario_encuesta) = TuProyecto::decryptSrcParams($request->codigo_usuario_encuesta);
	            if(!$codigo_usuario_encuesta || !is_numeric($codigo_usuario_encuesta)) {
	                abort(403);
	            }

	            $userSurvey = UsuarioEncuesta::find($codigo_usuario_encuesta);
	            if(!$userSurvey instanceof UsuarioEncuesta){
	            	abort(403);
	            }

	            $user = Usuario::find($userSurvey->codigo_usuario);
	            if(!$user instanceof Usuario) {
	            	abort(403);
	            }

	            // Get data
        		$answers = RespuestaEncuesta::getUserResponseSurvey($userSurvey);


        		// Prepare response
        		$response = new \stdClass();

				switch ($userSurvey->codigo_encuesta) {
					case Innpulsa::$challenge:
						$response->identificacion_usuario = $user->identificacion_usuario;
						$response->report = Innpulsa::aldeaReport($answers, $userSurvey);
                    break;
                    case Innpulsa::$challenge_empodera:
						$response->identificacion_usuario = $user->identificacion_usuario;
						$response->report = Innpulsa::aldeaReport($answers, $userSurvey);
					break;
					case Dinamiza::$diagnostic:
						$response->identificacion_usuario = $user->identificacion_usuario;
						$response->report = Dinamiza::diagnosticReport($answers,$userSurvey);
						break;
					case Cenisoft::$diagnostic:
						$response->identificacion_usuario = $user->identificacion_usuario;
						$response->report = Cenisoft::diagnosticReport($answers, $userSurvey);
						break;
				}
            	return response()->json($response);
    		}
    	}
    	abort(404,'no existe la ruta ajax');
	}

	/**
	 * Display the report from survey.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function informe(Request $request)
	{
		if($request->ajax())
    	{
			if($request->has('codigo_usuario_encuesta'))
    		{
				// Decrypt src-params
	            list($codigo_usuario_encuesta) = TuProyecto::decryptSrcParams($request->codigo_usuario_encuesta);
	            if(!$codigo_usuario_encuesta || !is_numeric($codigo_usuario_encuesta)) {
	                abort(403);
	            }

	            $userSurvey = UsuarioEncuesta::find($codigo_usuario_encuesta);
	            if(!$userSurvey instanceof UsuarioEncuesta){
	            	abort(403);
	            }

	            $user = Usuario::find($userSurvey->codigo_usuario);
	            if(!$user instanceof Usuario) {
	            	abort(403);
	            }

	            // Get data
        		$answers = RespuestaEncuesta::getUserResponseSurvey($userSurvey);

        		// Prepare response
        		$response = new \stdClass();

				switch ($userSurvey->codigo_encuesta) {
					case Innpulsa::$challenge:
						$response->identificacion_usuario = $user->identificacion_usuario;
						$response->report = Innpulsa::aldeaReport($answers, $userSurvey);
                    break;
                    case Innpulsa::$challenge_empodera:
						$response->identificacion_usuario = $user->identificacion_usuario;
						$response->report = Innpulsa::aldeaReport($answers, $userSurvey);
					break;
					case Dinamiza::$diagnostic:
						$response->identificacion_usuario = $user->identificacion_usuario;
						$response->report = Dinamiza::diagnosticReport($answers,$userSurvey);
						break;
					case Cenisoft::$diagnostic:
						$response->identificacion_usuario = $user->identificacion_usuario;
						$response->report = Cenisoft::diagnosticReport($answers, $userSurvey);
						break;
					case Compensar::$diagnostic:
						$response->identificacion_usuario = $user->identificacion_usuario;
						$response->report = Compensar::diagnosticReport($answers,$userSurvey);
					break;
				}
            	return response()->json($response);
    		}
    	}
    	abort(404,'no existe la ruta ajax');
	}

	public function evaluatorAssignment($userSurvey): void
	{
		$registro_convocatoria = RegistroConvocatoria::where('codigo_usuario_encuesta', $userSurvey->codigo_usuario_encuesta)->first();
		$convocatoria = Convocatoria::find($registro_convocatoria->codigo_convocatoria);
		$evaluador = $this->selectEvaluator($convocatoria->codigo_convocatoria);

		//evaluador configurado para convocatoria?
		if (!$evaluador instanceof Usuario) {
			return;
		}

		// Valid fase
		$registroFase = RegistroFaseUsuario::join('core.registro_convocatoria', 'registro_convocatoria.codigo_registro_convocatoria', '=', 'registro_fase_usuario.codigo_registro_convocatoria')
							->join('core.fase', 'registro_fase_usuario.codigo_fase', '=', 'fase.codigo_fase')
							->where('registro_fase_usuario.codigo_registro_convocatoria', $registro_convocatoria->codigo_registro_convocatoria)
							->first();
		if(!$registroFase instanceof RegistroFaseUsuario) {
			return;
		}

		$assignmentJury = AsignacionJurado::where('codigo_usuario', '=', $evaluador->codigo_usuario)
                    ->where('codigo_registro_fase_usuario', '=', $registroFase->codigo_registro_fase_usuario)
					->where('codigo_convocatoria', $convocatoria->codigo_convocatoria)
                    ->whereIn('codigo_estado', [Estado::getState('active'), Estado::getState('evaluated')])
                    ->first();

		//Este jurado ya se encuentra asignado?
		if( ($assignmentJury instanceof AsignacionJurado) && in_array($assignmentJury->codigo_estado, [Estado::getState('active'), Estado::getState('evaluated')]) ) {
			return;
		}

		$assignmentJury = new AsignacionJurado;
		$assignmentJury->codigo_usuario =  $evaluador->codigo_usuario;
		$assignmentJury->codigo_registro_fase_usuario = $registroFase->codigo_registro_fase_usuario;
		$assignmentJury->asignacion_jurado_virtual = true;
		$assignmentJury->codigo_convocatoria = $convocatoria->codigo_convocatoria;
		$assignmentJury->codigo_estado = Estado::getState('active');
		$assignmentJury->fecha_asignacion_jurado = date('Y-m-d');
		$assignmentJury->hora_asignacion_jurado = date('H:i:s');
		$assignmentJury->hora_desarrollo_asignacion =  date('H:i:s');
		$assignmentJury->save();
	}

	private function selectEvaluator(int $codigo_convocatoria)
	{
		$evaluadores = AsignacionEvaluadores::where('codigo_convocatoria', $codigo_convocatoria)
										->oldest('updated_at')
                                        ->first();
		if (isset($evaluadores)) {
			//to update updated_at
			$evaluadores->asignaciones = $evaluadores->asignaciones + 1;
			$evaluadores->save();
			return $evaluadores->user;
		}
		return;
	}
}
