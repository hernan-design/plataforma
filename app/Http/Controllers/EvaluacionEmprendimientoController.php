<?php

namespace App\Http\Controllers;

use App\Ciudad;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Custom\Innpulsa;

use TuProyecto, SendEmail, Auth, DB, Log, Lang, App;

use App\EvaluacionEmprendimiento,
	App\ResultadoEvaluacionEmprendimiento,
	App\RegistroSesion,
	App\EvaluacionItemEmprendimiento,
	App\Estado,
	App\ItemEvaluacionEmprendimiento,
	App\AsignacionJurado,
	App\Usuario,
	App\Convocatoria,
	App\RegistroFaseUsuario,
	App\OpcionEvaluacionPregunta,
	App\DatoEntidad,
	App\Entidad,
	App\UsuarioInstitucion,
	App\CategoriaProyecto,
	App\Custom\Rutan,
	App\Custom\SiinovaBolivar;

class EvaluacionEmprendimientoController extends Controller
{
	/**
	 * Instantiate a new EvaluacionEmprendimientoController instance.
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		if($request->ajax()) {
            return response()->json(AsignacionJurado::getProjectsEvaluation( $request->all() ));
        }
		return view('core.evaluator.main');
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
		 // Decrypt url
		list($url, $codigo_asignacion_jurado) = explode('-', $id);
		if(!$codigo_asignacion_jurado || !is_numeric($codigo_asignacion_jurado)) {
			abort(403);
		}

		$assignment = AsignacionJurado::getDataEvaluation($codigo_asignacion_jurado);
		if(!$assignment instanceof AsignacionJurado) {
            abort(404);
		}

		if ($request->ajax()) {
			return response()->json( AsignacionJurado::buildEvaluation($assignment) );
		}
		return view('core/evaluator/main');
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
    		 // Decrypt url
			list($url, $codigo_asignacion_jurado) = explode('-', $id);
			if(!$codigo_asignacion_jurado || !is_numeric($codigo_asignacion_jurado)) {
				abort(403);
			}

			// Assignment
			$assignment = AsignacionJurado::select('asignacion_jurado.*', 'fase.codigo_evaluacion_emprendimiento')->join('core.registro_fase_usuario', 'registro_fase_usuario.codigo_registro_fase_usuario', '=', 'asignacion_jurado.codigo_registro_fase_usuario')->join('core.fase', 'fase.codigo_fase', '=', 'registro_fase_usuario.codigo_fase')->find($codigo_asignacion_jurado);
			if(!$assignment instanceof AsignacionJurado) {
	            abort(404);
			}

			// Get phase register
			$register = RegistroFaseUsuario::find($assignment->codigo_registro_fase_usuario);
			if(!$register instanceof RegistroFaseUsuario) {
				abort(404);
			}

			$user_project = Usuario::find($register->codigo_usuario);
			if (!$user_project instanceof Usuario) {
				abort(404);
			}

			// Validate evaluator
			if(!in_array($assignment->codigo_usuario, [Auth::user()->codigo_usuario])) {
				abort(403);
			}

			$evaluacion_emprendimieto = EvaluacionEmprendimiento::find($assignment->codigo_evaluacion_emprendimiento);

			if(!$evaluacion_emprendimieto instanceof EvaluacionEmprendimiento){
				abort(404);
			}

			if($evaluacion_emprendimieto->comentario_obligatorio_evaluacion){
				if(trim($request->input('comentario_resultado_evaluacion'))==""){
					return response()->json(['success' => false, 'errors' => "El comentario en la evaluación es obligatorio"]);
				}
			}

			// Evaluation
            $evalEntrepreneurship = ResultadoEvaluacionEmprendimiento::where('codigo_asignacion_jurado', $assignment->codigo_asignacion_jurado)->first();
            if(!$evalEntrepreneurship instanceof ResultadoEvaluacionEmprendimiento) {
				$evalEntrepreneurship = new ResultadoEvaluacionEmprendimiento;
				$evalEntrepreneurship->codigo_estado = Estado::getState('active');
				$evalEntrepreneurship->codigo_usuario = Auth::user()->codigo_usuario;
				$evalEntrepreneurship->codigo_asignacion_jurado = $assignment->codigo_asignacion_jurado;
				$evalEntrepreneurship->codigo_evaluacion_emprendimiento = $assignment->codigo_evaluacion_emprendimiento;
			}

            $code_evaluation = $assignment->codigo_evaluacion_emprendimiento;
        	$data = $request->all();
            if ($evalEntrepreneurship->isValid($data))
            {
            	// Get items
                $items = ItemEvaluacionEmprendimiento::where('codigo_estado' , Estado::getState('active'))
														->where('codigo_evaluacion_emprendimiento', $code_evaluation)
														->orderBy('codigo_item_evaluacion', 'asc')->get();
                $answers = [];
                $response = new \stdClass();
                DB::beginTransaction();
                try {
                    $evalEntrepreneurship->fecha_resultado_evaluacion = date('Y-m-d');
					$evalEntrepreneurship->hora_resultado_evaluacion = date('H:i:s');
					if(trim($request->input('comentario_resultado_evaluacion'))!="")
	                	$evalEntrepreneurship->comentario_resultado_evaluacion = $request->input('comentario_resultado_evaluacion');
					$evalEntrepreneurship->save();
				
                    foreach ($items as $item)
                    {
                        if($request->has("codigo_evaluacion_item_$item->codigo_item_evaluacion"))
                        {
							
                        	$evalItemEntrepreneurship = EvaluacionItemEmprendimiento::where('evaluacion_item_emprendimiento.codigo_resultado_evaluacion', $evalEntrepreneurship->codigo_resultado_evaluacion)->where('evaluacion_item_emprendimiento.codigo_item_evaluacion', $item->codigo_item_evaluacion)->first();

							if(!$evalItemEntrepreneurship instanceof EvaluacionItemEmprendimiento) {
								// Evaluation Item Entrepreneurship
	                            $evalItemEntrepreneurship = new EvaluacionItemEmprendimiento();
	                            $evalItemEntrepreneurship->codigo_resultado_evaluacion = $evalEntrepreneurship->codigo_resultado_evaluacion;
	                            $evalItemEntrepreneurship->codigo_estado = Estado::getState('active');
	                            $evalItemEntrepreneurship->codigo_item_evaluacion = $item->codigo_item_evaluacion;
							}

							switch ($item->codigo_tipo_evaluacion_item) {
								case 1: //pregunta selector

									$choice = OpcionEvaluacionPregunta::find($request->input('codigo_evaluacion_item_'.$item->codigo_item_evaluacion));
									if(!$choice instanceof OpcionEvaluacionPregunta) {
										throw new \Exception(sprintf('%s:%s', 'EvaluacionEmprendimientoController update', "Recuperando opción evaluación pregunta"));
									}

									$evalItemEntrepreneurship->comentario_adicional = null;
									$evalItemEntrepreneurship->puntaje_resul_eval_empren = $choice->valor_opc_eval_pregunta;
									$evalItemEntrepreneurship->valor_evaluacion_item = $choice->codigo_opc_eval_pregunta;
									$evalItemEntrepreneurship->save();
									unset($choice);
								break;
								case 5: //pregunta campo abierto
									$evalItemEntrepreneurship->puntaje_resul_eval_empren = 0;
									$evalItemEntrepreneurship->valor_evaluacion_item = 0;
									$evalItemEntrepreneurship->comentario_adicional = trim($request->input('codigo_evaluacion_item_'.$item->codigo_item_evaluacion));
									$evalItemEntrepreneurship->save();
								break;
								case 6: //pregunta checkbox (multiple)

									$values_options = [];
									$options_selected = [];
									$options_selected = $request->input('codigo_evaluacion_item_'.$item->codigo_item_evaluacion);

									if (is_array($options_selected)) {
										foreach ($options_selected as $key => $value) {

											$choice = OpcionEvaluacionPregunta::find($value);
											if(!$choice instanceof OpcionEvaluacionPregunta) {
												throw new \Exception(sprintf('%s:%s', 'EvaluacionEmprendimientoController update', "Recuperando opción evaluación pregunta"));
											}

											array_push($values_options, $choice->valor_opc_eval_pregunta);
										}
										
										$puntajes_resul_eval_empren = json_encode($values_options);
										$valores_evaluacion_item = json_encode($options_selected);

										$evalItemEntrepreneurship->puntaje_resul_eval_empren = 0;
										$evalItemEntrepreneurship->valor_evaluacion_item = 0;
										$evalItemEntrepreneurship->comentario_adicional = null;
										$evalItemEntrepreneurship->puntajes_resul_eval_empren = $puntajes_resul_eval_empren;
										$evalItemEntrepreneurship->valores_evaluacion_item = $valores_evaluacion_item;
										$evalItemEntrepreneurship->save();
										unset($choice);
									} else {

										$choice = OpcionEvaluacionPregunta::find($request->input('codigo_evaluacion_item_'.$item->codigo_item_evaluacion));
										if(!$choice instanceof OpcionEvaluacionPregunta) {
											throw new \Exception(sprintf('%s:%s', 'EvaluacionEmprendimientoController update', "Recuperando opción evaluación pregunta"));
										}
										
										$evalItemEntrepreneurship->puntaje_resul_eval_empren = 0;
										$evalItemEntrepreneurship->valor_evaluacion_item = 0;
										$evalItemEntrepreneurship->comentario_adicional = null;
										$evalItemEntrepreneurship->puntajes_resul_eval_empren = $choice->valor_opc_eval_pregunta;
										$evalItemEntrepreneurship->valores_evaluacion_item = $choice->codigo_opc_eval_pregunta;
										$evalItemEntrepreneurship->save();
										unset($choice);
									}
								break;
								default: //opción única (selector, estrellas, etc)
									$choice = OpcionEvaluacionPregunta::find($request->input('codigo_evaluacion_item_'.$item->codigo_item_evaluacion));
									if(!$choice instanceof OpcionEvaluacionPregunta) {
										throw new \Exception(sprintf('%s:%s', 'EvaluacionEmprendimientoController update', "Recuperando opción evaluación pregunta"));
									}

									$evalItemEntrepreneurship->puntaje_resul_eval_empren = $choice->valor_opc_eval_pregunta;
									$evalItemEntrepreneurship->valor_evaluacion_item = $choice->codigo_opc_eval_pregunta;
									$evalItemEntrepreneurship->save();
									unset($choice);
								break;
							}
                        }
                    }

                 	// Set state evaluation
                 	$assignment->codigo_estado = Estado::getState('evaluated');
                 	$assignment->save();

                    // callback
					$evalEntrepreneurship->callback($register, $code_evaluation);

					// Validate if is attach

					if (!empty(RegistroSesion::getInstitutionEvalTem()) && RegistroSesion::getInstitutionEvalTem() != null) {
						// Evaluation Item Entrepreneurship
						$evalItemEntrepreneurship = new EvaluacionItemEmprendimiento();
						$evalItemEntrepreneurship->codigo_resultado_evaluacion = $evalEntrepreneurship->codigo_resultado_evaluacion;
						$evalItemEntrepreneurship->codigo_estado = Estado::getState('active');
						$evalItemEntrepreneurship->codigo_item_evaluacion = $item->codigo_item_evaluacion;
						$evalItemEntrepreneurship->comentario_evaluacion_item = RegistroSesion::getInstitutionEvalTem();
						$evalItemEntrepreneurship->save();

						$request->session()->put('_inst_evaluation_temp', null);
					}

                    // Prepare response
                    $response = AsignacionJurado::buildEvaluation(AsignacionJurado::getDataEvaluation($assignment->codigo_asignacion_jurado));
                    $response->success = true;
                    $response->message = transtp('evaluations.success');

					activity()
						->performedOn($assignment)
						->withProperties([
							'attributes' => [
								'project' => $user_project->nombre_usuario
							] ])
						->log('activitylog.assign.evaluated');

					//se hace llamado de método con codigo de respuesta
					ResultadoEvaluacionEmprendimiento::sendNotificationsOfEvaluation($data, $user_project, $register->codigo_registro_convocatoria);

					// Commit Transaction
					DB::commit();

					//guarda ediciones de evaluacion, Rutan
					if (RegistroSesion::getInstitution() == 61) {
						Rutan::storeEvaluations($register, $data, $user_project, $evalEntrepreneurship->codigo_resultado_evaluacion);
					}
					//Envía pdf diagnóstico Siinova Bolivar.
					elseif (RegistroSesion::getInstitution() == 62) {
						SiinovaBolivar::sendDiagnosis($register, $data, $user_project, $evalEntrepreneurship->codigo_resultado_evaluacion);
					}
					return response()->json($response);

                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => Lang::get('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $evalEntrepreneurship->errors]);
        }
        abort(404);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, $id)
	{
        if ($request->ajax()) {
    		 // Decrypt url
			list($url, $codigo_asignacion_jurado) = explode('-', $id);
			if(!$codigo_asignacion_jurado || !is_numeric($codigo_asignacion_jurado)) {
				abort(403);
			}

			// Assignment
			$assignment = AsignacionJurado::select('asignacion_jurado.*', 'fase.codigo_fase', 'fase.codigo_evaluacion_emprendimiento', 'fase.fase_cancelacion')->join('core.registro_fase_usuario', 'registro_fase_usuario.codigo_registro_fase_usuario', '=', 'asignacion_jurado.codigo_registro_fase_usuario')->join('core.fase', 'fase.codigo_fase', '=', 'registro_fase_usuario.codigo_fase')->find($codigo_asignacion_jurado);
			if(!$assignment instanceof AsignacionJurado) {
	            abort(404);
			}

			// Validate evaluator
			if(!in_array($assignment->codigo_usuario, [Auth::user()->codigo_usuario])) {
				abort(403);
			}

            DB::beginTransaction();
            try {
            	// Valid
            	if(!$assignment->fase_cancelacion) {
					throw new \Exception("La fase $assignment->codigo_fase no permite cancelacion.");
				}

				// register
				$register = RegistroFaseUsuario::find($assignment->codigo_registro_fase_usuario);
				if(!$register instanceof RegistroFaseUsuario) {
					throw new \Exception("No es posible recuperar registro fase usuario $assignment->codigo_registro_fase_usuario.");
				}

				$user = Usuario::getUserByEntity($register->codigo_usuario);
				if(!$user instanceof Usuario) {
					throw new \Exception("No es posible recuperar registro usuario $register->codigo_usuario.");
				}

				$register->visualizacion_usuario = true;
				$register->notificacion_registro_fase_usuario = true;
				$register->notificacion_cambio_registro_fase = date('Y-m-d H:m:s');
				$register->seg_codigo_usuario = Auth::user()->codigo_usuario;
				$register->codigo_estado = Estado::getState('returned');
				$register->save();

				$assignment->codigo_estado = Estado::getState('returned');
				$assignment->save();

				switch ($assignment->codigo_fase) {
					case Innpulsa::$stage_challenge_1_2:
						// Registro fase - reto 1
						$registerOne = RegistroFaseUsuario::where('codigo_registro_convocatoria', $register->codigo_registro_convocatoria)->where('codigo_fase', Innpulsa::$stage_challenge)->first();
						if(!$registerOne instanceof RegistroFaseUsuario) {
							throw new \Exception("No es posible recuperar registro fase usuario para la reto 1.");
						}

						$registerOne->visualizacion_usuario = true;
						$registerOne->save();
				}

                // Mail notification
                $data = [];
                $data['_subject'] = transtp('evaluations.emails.returned.subject');
                $data['_template'] = 'emails.evaluation.returned';
                $data['_to'] = $user->correo_electronico;
                $data['_to_name'] = $user->user_name;

                SendEmail::notification($data);

	    		// Commit Transaction
				DB::commit();
                return response()->json(['success' => true, 'message' => transtp('evaluations.return')]);

            }catch(\Exception $e){
                DB::rollback();
				Log::error(sprintf('%s:%s', 'EvaluacionEmprendimientoController destroy', $e->getMessage()));
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }

       	}
        abort(404);
	}

	/**
	 * Update entity in evaluation.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function entity(Request $request, $id)
	{
		if ($request->ajax()) {
			// Decrypt src-params
	        list($codigo_entidad) = TuProyecto::decryptSrcParams($id);
	        if(!$codigo_entidad || !is_numeric($codigo_entidad)) {
	      		abort(403);
	        }

	        // Entity
            $entity = Entidad::find($codigo_entidad);
			if(!$entity instanceof Entidad) {
	            abort(403);
			}

			// User institution
			$userInstitution = UsuarioInstitucion::getUserInstitution($entity->codigo_usuario);

			// Data entity
			$entityData = DatoEntidad::where('codigo_usuario_institucion', $userInstitution->codigo_usuario_institucion)->where('codigo_estado', Estado::getState('active'))->first();
			if($entityData instanceof DatoEntidad)
			{
   				if($request->has('cor_codigo_categoria_proyecto') && $request->cor_codigo_categoria_proyecto != 0 ) {
					$category = CategoriaProyecto::find($request->cor_codigo_categoria_proyecto);
					if(!$category instanceof CategoriaProyecto) {
						abort(500);
					}

					$entityData->cor_codigo_categoria_proyecto = $category->codigo_categoria_proyecto;
				}
				$entityData->save();

		     	return response()->json(['success' => true, 'codigo_entidad' => TuProyecto::encryptSrcParams([$entity->codigo_entidad]), 'cor_codigo_categoria_proyecto' => $category->codigo_categoria_proyecto, 'cor_nombre_categoria_proyecto' => $category->nombre_categoria_proyecto]);
			}
			abort(500);
  	 	}
        abort(404);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function terminos(Request $request, $asignacion_jurado)
	{
		// Decrypt src-params
		list($url, $asignacion_jurado) = explode('-', $asignacion_jurado);
        if(!$asignacion_jurado || !is_numeric($asignacion_jurado)) {
      		abort(403);
        }

   		$query = AsignacionJurado::query();
   		$query->select('fecha_evaluacion_jurado', 'lugar_evaluacion_jurado', DB::raw("(usuario.nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '')) as nombre_jurado"));
		$query->join('seguridad.usuario', 'asignacion_jurado.codigo_usuario', '=', 'usuario.codigo_usuario');
		$query->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');
		$query->where('asignacion_jurado.codigo_asignacion_jurado', $asignacion_jurado);
		$query->where('asignacion_jurado.codigo_usuario', Auth::user()->codigo_usuario);
   		$asignacion = $query->first();

   		if(!$asignacion instanceof AsignacionJurado) {
   			abort(404);
   		}

		$data = [];
		$data['title'] = transtp('evaluations.terms.title');
		$data['asignacion'] = $asignacion;

		// Export pdf
		$pdf = App::make('dompdf.wrapper');
		$pdf->loadHTML(view('core.evaluator.terms', $data)->render());
		return @$pdf->stream(sprintf('%s.pdf', str_slug($data['title'])));
	}
}
