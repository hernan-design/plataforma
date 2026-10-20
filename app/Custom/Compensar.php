<?php

namespace App\Custom;

use App\UsuarioEncuesta, App\Estado, App\Encuesta, App\PreguntaEncuesta, App\OpcionPreguntaEncuesta, App\Usuario, App\RespuestaEncuesta, App\VerPregEncuesta, App\Curso, App\Entidad;
use JpGraph\JpGraph, RadarGraph, RadarPlot, DB, TuProyecto, App, GuzzleHttp\Client, Log, AWS, SendEmail;
use Illuminate\Support\Collection;
use Auth;

class Compensar
{
	public static $evaluation = 17;
	public static $city = 2257;
	public static $challenge = 109;
	public static $diagnostic = 121;


	public static function validApplyChallenge(UsuarioEncuesta $userSurvey, $request) {
		$response = new \stdClass();
		$response->success = true;

		// Valid user
		$user = Usuario::find($userSurvey->codigo_usuario);
		if(!$user instanceof Usuario) {
			$response->success = false;
			$response->data = trans('app.exception');
			return $response;
		}

		// Valid survey
		 if(isset($request['pregunta_3670'])) {
		 	$answer = RespuestaEncuesta::where('codigo_pregunta_encuesta', 3670)
		 		->where('texto_respuesta_encuesta', $request['pregunta_3670'])
		 		->where('codigo_usuario_encuesta', '!=', $userSurvey->codigo_usuario_encuesta)
		 		->first();
		 	if($answer instanceof RespuestaEncuesta) {
		 		$response->success = false;
		 		$response->data = "Ya se encuentra registrado un proyecto con este numero de identificación";
		 		return $response;
		 	}
		 }

		 return $response;
	}

	public static function diagnostic(Usuario $user, UsuarioEncuesta $userSurvey, $inst, $call, $url_inst) {
		try {
			// Init Graph
			$graph = new JpGraph();
			$graph->load();
			$graph->module('radar');

			// call api report
			$user_survey = TuProyecto::encryptSrcParams([$userSurvey->codigo_usuario_encuesta]);
			$api_url = sprintf('%s/api/convocatoria/informe/%s', (App::environment('local') ? 'http://localhost/plataforma/public' : $url_inst), $user_survey);

			$client = new Client;
			$report = $client->request('GET', $api_url)->getBody()->getContents();
			$report = json_decode($report);

			$survey = Encuesta::find($userSurvey->codigo_encuesta);
			if(!$survey instanceof Encuesta){
				abort(404);
			}

			// Answers
			$query = RespuestaEncuesta::query();
			$query->select('respuesta_encuesta.*', 'texto_opcion_encuesta','puntaje_opcion_encuesta', 'pregunta_encuesta.codigo_pregunta_encuesta', 'pregunta_encuesta.codigo_pregunta_encuesta', 'tipo_pregunta_encuesta', 'codigo_usuario_encuesta');
			$query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
			$query->leftjoin('core.opcion_encuesta','respuesta_encuesta.codigo_opcion_encuesta','=','opcion_encuesta.codigo_opcion_encuesta');
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
			$query->leftJoin('core.subpregunta_encuesta as pregunta', function($join) {
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
				if(!in_array($question->tipo_campo_pregunta, [6, 7])) {
					switch ($question->clase_pregunta_encuesta) {
						case VerPregEncuesta::surveyQuestionClass('question'):
							if(isset($question->codigo_grupo_pregunta_encuesta) && !empty($question->codigo_grupo_pregunta_encuesta)) {
								$questions[$question->codigo_grupo_pregunta_encuesta][$question->codigo_pregunta_encuesta] = $question;
							}else{
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

			// Groups
			$groupings = $survey->groups()->select('codigo_grupo_pregunta_encuesta', 'nombre_grupo_pregunta_encuesta', 'desc_grupo_pregunta_encuesta', 'pagina_grupo_pregunta')->orderBy('pagina_grupo_pregunta', 'asc')->orderBy('codigo_grupo_pregunta_encuesta', 'asc')->get();

			$data = [];
			$data['title'] = 'Mis competencias emprendedoras';
			$data['proyect'] = $user;
			$data['nombre_encuesta'] = $survey->nombre_encuesta;
			$data['survey'] = $survey;
			$data['report'] = $report->report;

			$data['userSurvey'] = $userSurvey;
			$data['answers'] = $answers;
			$data['questions'] = $questions;
			$data['subquestions'] = $subquestions;
			$data['groupings'] = $groupings;

			$titles = $report->report->data_general->titulos_grupo;
			$titles_trans = $report->report->data_general->titulos_grupo_trans;
			$totalGroups = $report->report->data_general->total_grupos;
			$score = [];
			foreach ($totalGroups as $totalScore) {
				array_push($score, $totalScore->result);
			}

			$graph = new RadarGraph (950,400);
			$graph->img->SetImgFormat('jpeg');
			$graph->title->Set(utf8_decode("Resultado por área de la empresa"));

			$graph->SetTitles($titles_trans);
			$graph->SetCenter(0.5,0.55);
			$graph->HideTickMarks();
			$graph->axis->SetColor('darkgray@0.7');
			$graph->grid->Show();

			$graph->SetGridDepth(DEPTH_BACK);

			// Score plot
			$scoreGroups = new RadarPlot($score);
			$scoreGroups->SetColor('blue@0.1');
			$scoreGroups->SetLineWeight(1);
			$scoreGroups->SetFillColor('blue@0.9');
			$scoreGroups->mark->SetType(MARK_IMG_SBALL,'navy');

			$graph->Add($scoreGroups);

			// Prepare file
			$filename = sprintf('%s_%s.jpeg', 'image_result', $userSurvey->codigo_usuario_encuesta);
			$filepath = sprintf('%s/temp/%s', public_path(), $filename);

			// Save temp file
			$graph->Stroke(_IMG_HANDLER);
			$graph->img->Stream($filepath);
			$data['graph'] = asset("temp/$filename");

			$pdf = App::make('dompdf.wrapper');
			$pdf->loadHTML(view('reports.compensar.diagnostico', $data));

			$s3 = AWS::createClient('s3');

			$bucket = env('AWS_BUCKET_NAME', 'static-dev.tuproyecto.com');

			$filename = sprintf('%s_%s.pdf', 'diagnostico', date('YmdHms'));
			$key = sprintf('%s/%d/%d/%s', 'documents', date('Y'), date('m'), $filename);

			$result = $s3->putObject([
				'Bucket' =>  $bucket,
				'Key'    =>  $key,
				'Body'   =>  $pdf->output(),
				'ACL'    => 'public-read'
			]);

			// Mail notification
			$dataMail = [];
			$dataMail['_subject'] = 'Resultados diagnostico Compensar';
			$dataMail['_template'] = 'emails.custom.compensar.notification';
			$dataMail['_to'] = $user->correo_electronico;
			$dataMail['_to_name'] = $user->nombre_usuario;
			$dataMail['_inst'] = $inst;
			$dataMail['_url_action'] = $result['ObjectURL'];

			SendEmail::notification($dataMail);

		} catch (\Exception $e) {
			Log::error(sprintf('%s:%s', 'Compensar notification', $e->getMessage()));
		}
	}

	public static function diagnosticReport(Collection $answers, UsuarioEncuesta $userSurvey) {
		$query = RespuestaEncuesta::query();
		$query->select('grupo_pregunta_encuesta.codigo_grupo_pregunta_encuesta as codigo_grupo', DB::raw( "trim( upper( regexp_replace(grupo_pregunta_encuesta.nombre_grupo_pregunta_encuesta, E'<.*?>', '', 'g' )) ) as nombre_grupo"), DB::raw('round(SUM(opcion_encuesta.puntaje_opcion_encuesta), 0) as result'), DB::raw( "trim( upper( regexp_replace(grupo_pregunta_encuesta.nombre_grupo_pregunta_encuesta, E'<.*?>', '', 'g' )) ) as nombre_grupo_trans"));
		$query->join('core.opcion_encuesta', 'opcion_encuesta.codigo_opcion_encuesta', '=', 'respuesta_encuesta.codigo_opcion_encuesta');
		$query->join('core.pregunta_encuesta', 'pregunta_encuesta.codigo_pregunta_encuesta', '=', 'respuesta_encuesta.codigo_pregunta_encuesta');
		$query->join('core.grupo_pregunta_encuesta', 'grupo_pregunta_encuesta.codigo_grupo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_grupo_pregunta_encuesta');
		$query->where('opcion_encuesta.codigo_estado', '=', Estado::getState('active'));
		$query->where('respuesta_encuesta.codigo_usuario_encuesta', '=', $userSurvey->codigo_usuario_encuesta);
		$query->groupBy('grupo_pregunta_encuesta.codigo_grupo_pregunta_encuesta');
		$totalGroups = $query->get();

		// Diagnostic

		$report = new \stdClass();
		$report->data_general = self::getResultGeneral($totalGroups);
		return $report;
	}

	public static function getResultGeneral($totalGroups) {
		$result = new \stdClass();
		$titulos_grupo = [];
		$titulos_grupo_trans = [];

		foreach ($totalGroups as $groups) {
			array_push($titulos_grupo, $groups->nombre_grupo);
			array_push($titulos_grupo_trans, TuProyecto::accents($groups->nombre_grupo_trans));
		}

		$result->titulos_grupo = $titulos_grupo;
		$result->titulos_grupo_trans = $titulos_grupo_trans;
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
			$response->message = "¡Te damos nuevamente una cordial bienvenida!<br><br>Actívate en el programa de emprendimiento para acceder a este y otros beneficios de nuestra red. Déjanos tus datos y te contactaremos para ayudarte.";
			$response->link = "https://form.jotformz.com/compensar_info/inscripcin-emprendimiento#xd_co_f=ZTg2MzJjMmYtYTU2OS00MGFhLTk4MjQtZWFiNzk2ZGVmNGFh~";
			$response->text = "Registrate Aquí";

		}catch(\Exception $e) {
			Log::error(sprintf('%s:%s', 'RedCoomeva verifyaccount', $e->getMessage()));

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

		// Bypass subscription check in local development
		if (\App::environment('local')) {
			$response->success = true;
			return $response;
		}

		if(in_array($request->segment(2), ['aprende'])) {
			$course = Curso::getCourseUrl($request->segment(4));
			if($course->curso_gratis) {
				$response->success = true;
				return $response;
			}
		}

		if(in_array($request->segment(1), ['proyecto'])) {
			if($request->segment(2)!="create" && $request->segment(2)!=""){
				$proyecto = Entidad::getEntityUrl($request->segment(2));
				if($proyecto->seg_codigo_usuario == Auth::user()->codigo_usuario){
					if( $user->hasRole('seller') ){
						$response->success = true;
					}
				}
			}
		}

		if( $user->hasRole('asociado') ){
			$response->success = true;
		}

		return $response;
	}
}
