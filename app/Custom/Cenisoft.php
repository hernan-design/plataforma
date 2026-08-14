<?php


namespace App\Custom;


use App\ConvocatoriaEtapa;
use App\Encuesta;
use App\Estado;
use App\OpcionPreguntaEncuesta;
use App\PreguntaEncuesta;
use App\RegistroSesion;
use App\RespuestaEncuesta;
use App\Usuario;
use App\UsuarioEncuesta;
use App\VerPregEncuesta, App\Curso;
use Illuminate\Support\Collection;
use TuProyecto;
use Auth, Log, DB, URL, App, AWS;
use GuzzleHttp\Client;
use JpGraph\JpGraph;
use RadarGraph;
use RadarPlot;
use SendEmail;

class Cenisoft
{
	public static $diagnostic = 114;

	public static function diagnostic(Usuario $user, UsuarioEncuesta $userSurvey, $inst, $call) {

		try {

			// Init Graph
			$graph = new JpGraph();
			$graph->load();
			$graph->module('radar');

			$queryUser = Usuario::query();
			$queryUser->select('owner.nombre_usuario as nombre_usuario', 'usuario.codigo_usuario', 'usuario.imagen_usuario', 'usuario.biografia_usuario', 'owner.correo_electronico as correo_electronico', 'usuario.nombre_usuario as nombre_entidad', 'nombre_clase_emprendimiento', 'clase_emprendimiento.codigo_clase_emprendimiento as codigo_clase_emprendimiento', 'categoria_proyecto.nombre_categoria_proyecto', 'ciudad.nombre_ciudad', 'ciudad.distrito_ciudad',
				DB::raw("(CASE WHEN owner.tipo_usuario = " . Usuario::typeUser('person') . " THEN (trim(owner.nombre_usuario) || ' ' || trim(personaf.primer_apellido_persona) || ' ' || trim(personaf.segundo_apellido_persona)) ELSE owner.nombre_usuario END) as nombre_founder"),
				DB::raw("trim(initcap(ciudadf.nombre_ciudad)) as ciudad_founder"),
				DB::raw("COALESCE(initcap(ciudadf.distrito_ciudad), '') as distrito_ciudad_founder"));
			$queryUser->join('core.entidad', 'usuario.codigo_usuario', '=', 'entidad.codigo_usuario');
			$queryUser->join('core.usuario_institucion', 'usuario_institucion.codigo_usuario', '=', 'usuario.codigo_usuario');
			$queryUser->join('core.dato_entidad', 'dato_entidad.codigo_usuario_institucion', '=', 'usuario_institucion.codigo_usuario_institucion');
			$queryUser->leftJoin('core.ciudad', 'ciudad.codigo_ciudad', '=', 'usuario.codigo_ciudad');
			$queryUser->leftJoin('core.categoria_proyecto', 'categoria_proyecto.codigo_categoria_proyecto', '=', 'dato_entidad.codigo_categoria_proyecto');
			$queryUser->leftJoin('core.clase_emprendimiento_insti', 'entidad.codigo_clase_empre_insti', '=', 'clase_emprendimiento_insti.codigo_clase_empre_insti');
			$queryUser->leftJoin('core.clase_emprendimiento', 'clase_emprendimiento_insti.codigo_clase_emprendimiento', '=', 'clase_emprendimiento.codigo_clase_emprendimiento');
			$queryUser->leftJoin('seguridad.usuario as owner', 'entidad.seg_codigo_usuario', '=', 'owner.codigo_usuario');
			$queryUser->leftjoin('core.ciudad as ciudadf', 'owner.codigo_ciudad', '=', 'ciudadf.codigo_ciudad');
			$queryUser->leftjoin('core.pais as paisf', 'ciudadf.codigo_pais', '=', 'paisf.codigo_pais');
			$queryUser->leftjoin('core.persona as personaf', 'personaf.codigo_usuario', '=', 'owner.codigo_usuario');
			$queryUser->where('usuario.codigo_usuario', $user->codigo_usuario);
			$resultUser = $queryUser->first();

			// call api report
			$user_survey = TuProyecto::encryptSrcParams([$userSurvey->codigo_usuario_encuesta]);
			$api_url = sprintf('%s/api/convocatoria/informe/%s', (App::environment('local') ? 'http://localhost/plataforma/public' : RegistroSesion::getInstitutionUrl()), $user_survey);

			$client = new Client;
			$report = $client->request('GET', $api_url)->getBody()->getContents();
			$report = json_decode($report);

			$survey = Encuesta::find($userSurvey->codigo_encuesta);
			if (!$survey instanceof Encuesta) {
				abort(404);
			}

			// Answers
			$query = RespuestaEncuesta::query();
			$query->select('respuesta_encuesta.*', 'texto_opcion_encuesta', 'puntaje_opcion_encuesta', 'pregunta_encuesta.codigo_pregunta_encuesta', 'pregunta_encuesta.codigo_pregunta_encuesta', 'tipo_pregunta_encuesta', 'codigo_usuario_encuesta');
			$query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
			$query->leftjoin('core.opcion_encuesta', 'respuesta_encuesta.codigo_opcion_encuesta', '=', 'opcion_encuesta.codigo_opcion_encuesta');
			$query->where('respuesta_encuesta.codigo_usuario_encuesta', $userSurvey->codigo_usuario_encuesta);
			$query->where('respuesta_encuesta.codigo_estado', Estado::getState('active'));
			$arAnswers = $query->get();

			// Preparar respuestas
			$answers = [];
			foreach ($arAnswers as $answer) {
				switch ($answer->tipo_pregunta_encuesta) {
					case PreguntaEncuesta::getType('open'):
						$answers["{$answer->codigo_usuario_encuesta}_{$answer->codigo_pregunta_encuesta}"] = $answer;
						break;
					case PreguntaEncuesta::getType('single'):
						$answers["{$answer->codigo_usuario_encuesta}_{$answer->codigo_pregunta_encuesta}"] = $answer;
						break;
					case PreguntaEncuesta::getType('multiple'):
						$answers["{$answer->codigo_usuario_encuesta}_{$answer->codigo_pregunta_encuesta}"][$answer->codigo_opcion_encuesta] = $answer;
						break;
					case PreguntaEncuesta::getType('upload'):
						$answers["{$answer->codigo_usuario_encuesta}_{$answer->codigo_pregunta_encuesta}"] = $answer;
						break;
					case PreguntaEncuesta::getType('matriz'):
						$answers["{$answer->codigo_usuario_encuesta}_{$answer->codigo_pregunta_encuesta}_x{$answer->cor_codigo_opcion_encuesta}_y{$answer->codigo_opcion_encuesta}"] = $answer;
						break;
				}
			}

			// Questions
			$query = $survey->questions();
			$query->select('pregunta_encuesta.*', 'ver_preg_encuesta.numero_pregunta_version as numero_pregunta_encuesta', 'pregunta.cor_codigo_pregunta_encuesta as pregunta_padre', 'pregunta.codigo_opcion_encuesta', 'ver_preg_encuesta.clase_pregunta_encuesta', 'pregunta.codigo_subpregunta_encuesta', 'pregunta.orden_subpregunta_encuesta');
			$query->join('core.ver_preg_encuesta', 'pregunta_encuesta.codigo_pregunta_encuesta', '=', 'ver_preg_encuesta.codigo_pregunta_encuesta');
			$query->leftJoin('core.subpregunta_encuesta as pregunta', function ($join) {
				$join->on('pregunta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
				$join->on('pregunta.codigo_version_encuesta', '=', 'ver_preg_encuesta.codigo_version_encuesta');
				$join->where('pregunta.codigo_estado', '=', Estado::getState('active'));
			});

			$query->where('pregunta_encuesta.codigo_estado', Estado::getState('active'));
			$query->where('ver_preg_encuesta.codigo_estado', Estado::getState('active'));
			$query->where('ver_preg_encuesta.codigo_version_encuesta', $userSurvey->codigo_version_encuesta);
			$query->orderBy('ver_preg_encuesta.numero_pregunta_version', 'asc');
			$query->orderBy('pregunta.orden_subpregunta_encuesta', 'asc');
			$query->orderBy('pregunta_encuesta.codigo_pregunta_encuesta', 'asc');
			$arQuestions = $query->get();

			$matriz = $questions = $subquestions = [];
			foreach ($arQuestions as $question) {
				if (!in_array($question->tipo_campo_pregunta, [6, 7])) {
					switch ($question->clase_pregunta_encuesta) {
						case VerPregEncuesta::surveyQuestionClass('question'):
							if (isset($question->codigo_grupo_pregunta_encuesta) && !empty($question->codigo_grupo_pregunta_encuesta)) {
								$questions[$question->codigo_grupo_pregunta_encuesta][$question->codigo_pregunta_encuesta] = $question;
							} else {
								$questions['detached'][$question->codigo_pregunta_encuesta] = $question;
							}
							break;
						case VerPregEncuesta::surveyQuestionClass('subquestion'):
							$subquestions["{$question->pregunta_padre}_{$question->codigo_opcion_encuesta}"][$question->codigo_pregunta_encuesta] = $question;
							break;
					}
					switch ($question->tipo_pregunta_encuesta) {
						case PreguntaEncuesta::getType('matriz'):
							// Choices closed questions
							$matriz["{$question->codigo_pregunta_encuesta}_x"] = opcionPreguntaEncuesta::select('opcion_encuesta.*')
								->join('core.pregunta_encuesta', 'opcion_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta')
								->join('core.encuesta', 'pregunta_encuesta.codigo_encuesta', '=', 'encuesta.codigo_encuesta')
								->where('encuesta.codigo_encuesta', $question->codigo_encuesta)
								->where('pregunta_encuesta.codigo_pregunta_encuesta', $question->codigo_pregunta_encuesta)
								->where('eje_opcion', OpcionPreguntaEncuesta::getAxis('x'))
								->where('opcion_encuesta.codigo_estado', Estado::getState('active'))
								->orderBy('orden_opcion_encuesta', 'asc')
								->orderBy('codigo_opcion_encuesta', 'asc')
								->get();
							$matriz["{$question->codigo_pregunta_encuesta}_y"] = OpcionPreguntaEncuesta::select('opcion_encuesta.*')
								->join('core.pregunta_encuesta', 'opcion_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta')
								->join('core.encuesta', 'pregunta_encuesta.codigo_encuesta', '=', 'encuesta.codigo_encuesta')
								->where('encuesta.codigo_encuesta', $question->codigo_encuesta)
								->where('pregunta_encuesta.codigo_pregunta_encuesta', $question->codigo_pregunta_encuesta)
								->where('eje_opcion', OpcionPreguntaEncuesta::getAxis('y'))
								->where('opcion_encuesta.codigo_estado', Estado::getState('active'))
								->orderBy('orden_opcion_encuesta', 'asc')
								->orderBy('codigo_opcion_encuesta', 'asc')
								->get();
							break;
					}
				}
			}

			$groupings = $survey->groups()->select('codigo_grupo_pregunta_encuesta', 'nombre_grupo_pregunta_encuesta', 'desc_grupo_pregunta_encuesta', 'pagina_grupo_pregunta')->orderBy('pagina_grupo_pregunta', 'asc')->orderBy('codigo_grupo_pregunta_encuesta', 'asc')->get();

//			$program_register = RegistroConvocatoria::getUsersPrograms($call, $resultUser->codigo_usuario);
//			$program_register->codigo_registro_convocatoria;

			$data = [];
			$data['title'] = 'INSTRUMENTO DE DIAGNÓSTICO DEL NIVEL DE INNOVACIÓN DE SU EMPRESA';
			$data['proyect'] = $resultUser;
			$data['nombre_encuesta'] = $survey->nombre_encuesta;
			$data['survey'] = $survey;
			$data['report'] = $report->report;


			$data['userSurvey'] = $userSurvey;
			$data['answers'] = $answers;
			$data['questions'] = $questions;
			$data['subquestions'] = $subquestions;
			$data['groupings'] = $groupings;

			$titles = $report->report->data_general->titulos_grupo;
			$totalGroups = $report->report->data_general->total_grupos;
			$score = [];
			foreach ($totalGroups as $totalScore) {
				array_push($score, $totalScore->result);
			}

			$graph = new RadarGraph (950, 400);
			$graph->img->SetImgFormat('jpeg');
			$graph->title->Set(utf8_decode("Resultado por área de la empresa"));

			$graph->SetTitles($titles);
			$graph->SetCenter(0.5, 0.55);
			$graph->HideTickMarks();
			$graph->axis->SetColor('darkgray@0.7');
			$graph->grid->Show();

			$graph->SetGridDepth(DEPTH_BACK);

			// Score plot
			$scoreGroups = new RadarPlot($score);
			$scoreGroups->SetColor('blue@0.1');
			$scoreGroups->SetLineWeight(1);
			$scoreGroups->SetFillColor('blue@0.9');
			$scoreGroups->mark->SetType(MARK_IMG_SBALL, 'navy');


			$graph->Add($scoreGroups);

			// Prepare file
			$filename = sprintf('%s_%s.jpeg', 'image_result', $userSurvey->codigo_usuario_encuesta);
			$filepath = sprintf('%s/temp/%s', public_path(), $filename);

			// Save temp file
			$graph->Stroke(_IMG_HANDLER);
			$graph->img->Stream($filepath);
			$data['graph'] = asset("temp/$filename");

			$pdf = App::make('dompdf.wrapper');
			$pdf->loadHTML(view('reports.cenisoft.diagnostico', $data));


			$s3 = AWS::createClient('s3');

			$bucket = env('AWS_BUCKET_NAME', 'static-dev.tuproyecto.com');

			$filename = sprintf('%s_%s_%s.pdf', 'diagnostico', 'cenisoft', date('YmdHms'));
			$key = sprintf('%s/%d/%d/%s', 'documents', date('Y'), date('m'), $filename);

			$result = $s3->putObject([
				'Bucket' => $bucket,
				'Key' => $key,
				'Body' => $pdf->output(),
				'ACL' => 'public-read'
			]);

			// Mail notification
			$dataMail = [];
			$dataMail['_subject'] = 'Resultados diagnostico Cenisoft';
			$dataMail['_template'] = 'emails.custom.cenisoft.notification';
			$dataMail['_to'] = $resultUser->correo_electronico;
			$dataMail['_to_name'] = $resultUser->nombre_usuario;
			$dataMail['_inst'] = $inst;
			$dataMail['_url_action'] = $result['ObjectURL'];

			SendEmail::notification($dataMail);
		} catch (\Exception $e) {
			Log::error(sprintf('%s:%s', 'Cenisoft notification', $e->getMessage()));
		}
	}

	public static function diagnosticReport(Collection $answers, UsuarioEncuesta $userSurvey) {

		$query = RespuestaEncuesta::query();
		$query->select('grupo_pregunta_encuesta.codigo_grupo_pregunta_encuesta as codigo_grupo', DB::raw( "trim( upper( regexp_replace(grupo_pregunta_encuesta.nombre_grupo_pregunta_encuesta, E'<.*?>', '', 'g' )) ) as nombre_grupo"),
			DB::raw('round(SUM(opcion_encuesta.puntaje_opcion_encuesta), 0) as result'));
		$query->join('core.opcion_encuesta', 'opcion_encuesta.codigo_opcion_encuesta', '=', 'respuesta_encuesta.codigo_opcion_encuesta');
		$query->join('core.pregunta_encuesta', 'pregunta_encuesta.codigo_pregunta_encuesta', '=', 'respuesta_encuesta.codigo_pregunta_encuesta');
		$query->join('core.grupo_pregunta_encuesta', 'grupo_pregunta_encuesta.codigo_grupo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_grupo_pregunta_encuesta');
		$query->where('opcion_encuesta.codigo_estado', '=', Estado::getState('active'));
		$query->where('respuesta_encuesta.codigo_usuario_encuesta', '=', $userSurvey->codigo_usuario_encuesta);
		$query->whereIn('grupo_pregunta_encuesta.codigo_grupo_pregunta_encuesta', array(272, 273, 274));
		$query->groupBy('grupo_pregunta_encuesta.codigo_grupo_pregunta_encuesta');
		$totalGroups = $query->get();

		$report = new \stdClass();
		// Diagnostico
		$report->data_general = self::getResultGeneral($totalGroups);
		return $report;
	}

	public static function getResultGeneral($totalGroups) {
		$result = new \stdClass();
		$texto_respuesta = '';
		$titulos_grupo = [];

		$texto_a = "Es menor o igual que 3";
		$texto_b = "Es menor de 4";
		$texto_c = "Es mayor o igual de 4";


		foreach ($totalGroups as $groups) {
			array_push($titulos_grupo, $groups->nombre_grupo);

			switch (strtoupper((string)$groups->nombre_grupo)) {
				case "PILAR BASE":
					$texto_a = " Empresas que no tienen una solidez en su propósito, cultura y estructura para incentivar los temas de innovación.	En este sentido tienes que fortalecer cómo la organización está visualizando la innovación y crear un conocimiento adecuado para poder abordarla con más sentido.";
					$texto_b = "Empresas que tienen cierta claridad en su propósito, cultura y estructura para incentivar los temas de innovación pero todavía tienen que asentarlos en la organización. En este sentido tienes que identificar esos elementos a fortalecer en tu base para poderla reforzarla y hacerla más sólida.";
					$texto_c = "Empresas que tienen una solidez en su propósito, cultura y estructura para incentivar los temas de innovación. En ese sentido tu ya has trabajado bien las bases de la organización y ahora lo que tienes es que seguir manteniendo y ampliando para que un mayor número de personas estén involucrados en esas bases.";

					if ($groups->result > 0 && $groups->result <= 23) {
						$texto_respuesta .= "
						<h2> <p> <strong> $groups->nombre_grupo </strong> </p> </h2
						<br>
						<p class='justify'> $texto_a </p>
						<br>
					";
					} else if ($groups->result >= 24 && $groups->result <= 32) {
						$texto_respuesta .= "
						<h2> <p> <strong> $groups->nombre_grupo </strong> </p> </h2>
						<br>
						<p class='justify'> $texto_b </p>
						<br>
					";
					} else {
						$texto_respuesta .= "
						<h2> <p> <strong> $groups->nombre_grupo </strong> </p> </h2>
						<br>
						<p class='justify'> $texto_c </p>
						<br>
					";
					}
					break;
				case "PILAR ACCIÓN":

					$texto_a = "Empresas que no están haciendo acciones para empoderar a los colaboradores, invertir en personas y proyectos ni desarrollan un relacionamiento con los actores del ecosistema. En este sentido tienes que revisar detalladamente qué entendemos por innovación y cómo quieres conseguirla. La implementa es imprescindible para que la innovación suceda.";
					$texto_b = "Empresas que están haciendo algunas acciones para empoderar a los colaboradores, invertir algo en personas y proyectos y están empezando a desarrollar su relacionamiento con los actores del ecosistema. En ese sentido sería importante identificar si las acciones que estas realizando son estratégicas y el impacto que están generando.";
					$texto_c = "Empresas que están haciendo acciones para empoderar a los colaboradores, invertir en personas y proyectos y desarrollan un relacionamiento con los actores del ecosistema. En este sentido tu ya estás poniendo en movimiento la innovación a todos sus niveles. Sigue manteniendo ese nivel para que la innovación no sea cosa de un momento.";


					if ($groups->result > 0 && $groups->result <= 23) {
						$texto_respuesta .= "
						<h2> <p> <strong> $groups->nombre_grupo </strong> </p> </h2
						<br>
						<p class='justify'> $texto_a </p>
						<br>
					";
					} else if ($groups->result >= 24 && $groups->result <= 32) {
						$texto_respuesta .= "
						<h2> <p> <strong> $groups->nombre_grupo </strong> </p> </h2>
						<br>
						<p class='justify'> $texto_b </p>
						<br>
					";
					} else {
						$texto_respuesta .= "
						<h2> <p> <strong> $groups->nombre_grupo </strong> </p> </h2>
						<br>
						<p class='justify'> $texto_c </p>
						<br>
					";
					}
					break;
				case "PILAR RESULTADOS":
					$texto_a = "Empresas que no han conseguido que sus innovaciones sean apropiadas, generen impacto y que este provoque transformaciones internamente, en usuarios y el entorno. En ese sentido es importante revisar que tipo de bases y acciones estás realizando para conseguir ese nivel. Preguntar y reevaluar las acciones que la organización está haciendo.";
					$texto_b = "Empresas que están empezando a conseguir que sus innovaciones sean apropiadas, generen impacto y que este provoque transformaciones internamente, en usuarios y el entorno. En ese sentido este es el camino. Reconoce los logros, aprende de los errores y sigue el camino de la implementación.";
					$texto_c = "Empresas que han conseguido que sus innovaciones sean apropiadas, generen impacto y que este provoque transformaciones internamente, en usuarios y el entorno. En este sentido tu ya estás consiguiendo lo que todas buscan a la hora de implementar la innovación. No bajes el nivel y mira cómo hacer que esos resultados cada vez estén más integrados con el propósito.";

					if ($groups->result > 0 && $groups->result <= 30) {
						$texto_respuesta .= "
						<h2> <p> <strong> $groups->nombre_grupo </strong> </p> </h2
						<br>
						<p class='justify'> $texto_a </p>
						<br>
					";
					} else if ($groups->result >= 31 && $groups->result <= 42) {
						$texto_respuesta .= "
						<h2> <p> <strong> $groups->nombre_grupo </strong> </p> </h2>
						<br>
						<p class='justify'> $texto_b </p>
						<br>
					";
					} else {
						$texto_respuesta .= "
						<h2> <p> <strong> $groups->nombre_grupo </strong> </p> </h2>
						<br>
						<p class='justify'> $texto_c </p>
						<br>
					";
					}
					break;
//				default:
//					if ($groups->result <= 3) {
//						$texto_respuesta .= "
//						<h2> <p> <strong> $groups->nombre_grupo </strong> </p> </h2
//						<br>
//						<p class='justify'> $texto_a </p>
//						<br>
//					";
//					} else if ($groups->result < 4) {
//						$texto_respuesta .= "
//						<h2> <p> <strong> $groups->nombre_grupo </strong> </p> </h2>
//						<br>
//						<p class='justify'> $texto_b </p>
//						<br>
//					";
//					} else {
//						$texto_respuesta .= "
//						<h2> <p> <strong> $groups->nombre_grupo </strong> </p> </h2>
//						<br>
//						<p class='justify'> $texto_c </p>
//						<br>
//					";
//					}
//					break;
			}
		}


		$result->texto_respuesta = $texto_respuesta;
		$result->titulos_grupo = $titulos_grupo;
		$result->total_grupos = $totalGroups;
		return $result;
	}

	/**
	 * Verify account.
	 */
	public static function verifyaccount(Usuario $user)
	{
		$response = new \stdClass();
		$response->success = true;
		$response->message = null;
		$response->button = null;
		$response->link = null;

		try {
			// Evaluate status
			$response->message = "¡Te damos nuevamente una cordial bienvenida!<br><br>Afíliate a FEDESOFT para acceder a este y otros beneficios de nuestra red. Déjanos tus datos y te contactaremos para ayudarte.";
			$response->link = "https://afiliaciones.fedesoft.org/";
			$response->text = "Registrate Aquí";

		}catch(\Exception $e) {
			Log::error(sprintf('%s:%s', 'Cenisoft verifyaccount', $e->getMessage()));

			$response->success = false;
			$response->button = "INTERTARLO DE NUEVO";
			$response->message = "No hemos podido consultar la información de tu registro en la base de datos de la Coomeva, puedes intentarlo de nuevo.";
		} finally {
			return $response;
		}
	}

		/**
	 * Custom evaluate subscription.
	 */
	public static function subscription($request, Usuario $user) {
		$response = new \stdClass();
		$response->success = false;

		if(in_array($request->segment(1), ['aprende'])) {
			$course = Curso::getCourseUrl($request->segment(3));
			if($course->curso_gratis) {
				$response->success = true;
				return $response;
			}
		}

		if( $user->hasRole('asociado') ){
			$response->success = true;
		}

		return $response;
	}
}
