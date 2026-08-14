<?php

namespace Custom;

use App\ConvocatoriaEtapa;
use App\Estado;
use App\EtapaMentoria;
use App\EtapaProyecto;
use App\VerPregEncuesta;
use GuzzleHttp\Client, JpGraph\JpGraph, RadarGraph, RadarPlot;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use stdClass;
use TuProyecto;
use Auth, Log, DB, URL, App, AWS;
use SendEmail;

use App\Usuario, App\Encuesta, App\RespuestaEncuesta, App\OpcionPreguntaEncuesta, App\PreguntaEncuesta, App\Persona, App\UsuarioEncuesta;

class Dinamiza
{
	public static $challenge = 87;
	public static $mentor_provider = 111;
	public static $diagnostic = 107;
	public static $diagnostic_call = 232;
	public static $diagnostic_group_excluded = 260;

   	/**
	 * Custom valid create survey apply.
	 *
 	 * @var Array request $request
 	 * @var Encuesta $survey data
	 */

	public static function challenge(Usuario $user, UsuarioEncuesta $userSurvey)
	{
        $query = RespuestaEncuesta::query();
        $query->select('respuesta_encuesta.codigo_pregunta_encuesta','respuesta_encuesta.codigo_opcion_encuesta','opcion_encuesta.equivalente_tabla');
        $query->join('core.pregunta_encuesta', 'pregunta_encuesta.codigo_pregunta_encuesta', '=', 'respuesta_encuesta.codigo_pregunta_encuesta');
        $query->join('core.opcion_encuesta', 'respuesta_encuesta.codigo_opcion_encuesta', '=', 'opcion_encuesta.codigo_opcion_encuesta');
		$query->where('respuesta_encuesta.codigo_usuario_encuesta', $userSurvey->codigo_usuario_encuesta);
		$query->whereIn('respuesta_encuesta.codigo_pregunta_encuesta', [2684, 2693,2681,2680,2685,2689, 2690, 2691, 2692, 2688]);
		$query->orderBy('respuesta_encuesta.codigo_respuesta_encuesta', 'asc');
		$answers = $query->get();

        // jefe_hogar 2684
        // discapacidad 2693
        // codigo_tipo_vivienda 2681
        // codigo_estrato 2680
        // codigo_lista_ocupacion 2685
        // codigo_autodenominacion 2689
        // codigo_grupo_poblacional 2690
        // codigo_grupo_comunitario 2691
        // codigo_grupo_social 2692
        // codigo_sector_trabajo 2688

		// Info

        $persona = Persona::where('codigo_usuario', $user->codigo_usuario)->first();
        if($persona instanceof Persona){
            foreach ($answers as $answer)
            {
                $pregunta = $answer->codigo_pregunta_encuesta;
                $opcion = $answer->codigo_opcion_encuesta;
                $equivalencia = $answer->equivalente_tabla;
                if($pregunta == 2684 && $opcion == 3610){
                    $persona->jefe_hogar = true;
                }
                if($pregunta == 2693 && $opcion == 3688){
                    $persona->discapacidad = true;
                }
                if($pregunta == 2681 && $equivalencia != ""){
                    $persona->codigo_tipo_vivienda = $equivalencia;
                }
                if($pregunta == 2680 && $equivalencia != ""){
                    $persona->codigo_estrato = $equivalencia;
                }
                if($pregunta == 2685 && $equivalencia != ""){
                    $persona->codigo_lista_ocupacion = $equivalencia;
                }
                if($pregunta == 2689 && $equivalencia != ""){
                    $persona->codigo_autodenominacion = $equivalencia;
                }
                if($pregunta == 2690 && $equivalencia != ""){
                    $persona->codigo_grupo_poblacional = $equivalencia;
                }
                if($pregunta == 2691 && $equivalencia != ""){
                    $persona->codigo_grupo_comunitario = $equivalencia;
                }
                if($pregunta == 2692 && $equivalencia != ""){
                    $persona->codigo_grupo_social = $equivalencia;
                }
                if($pregunta == 2688 && $equivalencia != ""){
                    $persona->codigo_sector_trabajo = $equivalencia;
                }
                $persona->save();
            }
        }
	}

	public static function diagnostic(Usuario $user, UsuarioEncuesta $userSurvey, $inst, $call) {
		try {
			// Init Graph
			$graph = new JpGraph();
			$graph->load();
			$graph->module('radar');

			$queryUser = Usuario::query();
			$queryUser->select('owner.nombre_usuario as nombre_usuario', 'usuario.codigo_usuario', 'usuario.imagen_usuario', 'usuario.biografia_usuario', 'owner.correo_electronico as correo_electronico', 'usuario.nombre_usuario as nombre_entidad', 'nombre_clase_emprendimiento', 'clase_emprendimiento.codigo_clase_emprendimiento as codigo_clase_emprendimiento', 'categoria_proyecto.nombre_categoria_proyecto', 'ciudad.nombre_ciudad', 'ciudad.distrito_ciudad',
				DB::raw("(CASE WHEN owner.tipo_usuario = ".Usuario::typeUser('person')." THEN (trim(owner.nombre_usuario) || ' ' || trim(personaf.primer_apellido_persona) || ' ' || trim(personaf.segundo_apellido_persona)) ELSE owner.nombre_usuario END) as nombre_founder"),
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
			$api_url = sprintf('%s/api/convocatoria/informe/%s', (App::environment('local') ? 'http://localhost/plataforma/public' : session('institution')->url_institucion), $user_survey);

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

//			$program_register = RegistroConvocatoria::getUsersPrograms($call, $resultUser->codigo_usuario);
//			$program_register->codigo_registro_convocatoria;

			$data = [];
			$data['title'] = 'Diagnostico dinamiza';
			$data['proyect'] = $resultUser;
			$data['nombre_encuesta'] = $survey->nombre_encuesta;
			$data['survey'] = $survey;
			$data['report'] = $report->report;
			$data['oportunidades'] = $report->report->oportunidades;


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

			$graph = new RadarGraph (950,400);
			$graph->img->SetImgFormat('jpeg');
			$graph->title->Set(utf8_decode("Resultado por área de la empresa"));

			$graph->SetTitles($titles);
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
			$pdf->loadHTML(view('reports.dinamiza.diagnostico', $data));


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
			$dataMail['_subject'] = 'Resultados diagnostico Dinamiza';
			$dataMail['_template'] = 'emails.custom.dinamiza.notification';
			$dataMail['_to'] = $resultUser->correo_electronico;
			$dataMail['_to_name'] = $resultUser->nombre_usuario;
			$dataMail['_inst'] = $inst;
			$data['_attach'] = [ $result['ObjectURL'] => $filename ];
			$data['url_action'] = $result['ObjectURL'];

			SendEmail::notification($dataMail);

		} catch (\Exception $e) {
			Log::error(sprintf('%s:%s', 'Dinamiza notification', $e->getMessage()));
		}
	}

	public static function diagnosticReport (Collection $answers, UsuarioEncuesta $userSurvey)
	{
		$query = RespuestaEncuesta::query();
		$query->select('grupo_pregunta_encuesta.codigo_grupo_pregunta_encuesta as codigo_grupo', DB::raw( "trim( upper( regexp_replace(grupo_pregunta_encuesta.nombre_grupo_pregunta_encuesta, E'<.*?>', '', 'g' )) ) as nombre_grupo"),
			DB::raw('round(SUM(opcion_encuesta.puntaje_opcion_encuesta)/COUNT(pregunta_encuesta.codigo_pregunta_encuesta), 2) as result'));
		$query->join('core.opcion_encuesta', 'opcion_encuesta.codigo_opcion_encuesta', '=', 'respuesta_encuesta.codigo_opcion_encuesta');
		$query->join('core.pregunta_encuesta', 'pregunta_encuesta.codigo_pregunta_encuesta', '=', 'respuesta_encuesta.codigo_pregunta_encuesta');
		$query->join('core.grupo_pregunta_encuesta', 'grupo_pregunta_encuesta.codigo_grupo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_grupo_pregunta_encuesta');
		$query->where('opcion_encuesta.codigo_estado', '=', Estado::getState('active'));
		$query->where('respuesta_encuesta.codigo_usuario_encuesta', '=', $userSurvey->codigo_usuario_encuesta);
		$query->where('grupo_pregunta_encuesta.codigo_grupo_pregunta_encuesta', '!=', self::$diagnostic_group_excluded);
		$query->groupBy('grupo_pregunta_encuesta.codigo_grupo_pregunta_encuesta');
		$totalGroups = $query->get();

		$report = new \stdClass();
		// Diagnostico
		$report->data_general = self::getResultGeneral($totalGroups);
		$report->oportunidades = self::getOportunidades($answers, $totalGroups);
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

			switch (strtoupper((string) $groups->nombre_grupo)) {
				case "TÁCTICA":
					$texto_a = "El funcionamiento de tu empresa depende en gran medida de lo que tú como emprendedor puedes hacer, y tu equipo de colaboradores (si lo tienes) no está en capacidad de producir resultados de forma autónoma. Adicionalmente tienes grandes retos de crecimiento en cuanto a retención de clientes actuales y consecución de clientes nuevos.";
					$texto_b = "Las capacidades de tu equipo de trabajo permiten que tu empresa se mantenga, y tu gestión de clientes está en un nivel aceptable; sin embargo hay leves oportunidades de mejora que pueden impulsar tu labor comercial.";
					$texto_c = "El talento humano de tu organización trabaja de forma articulada y alineada con la estrategia de la empresa; además, tus clientes son leales y recomiendan tus productos y/o servicios, y los precios que has establecido corresponden con el valor que tus clientes perciben.";

					if ($groups->result <= 3) {
						$texto_respuesta .= "
						<h2> <p> <strong> $groups->nombre_grupo </strong> </p> </h2
						<br>
						<p class='justify'> $texto_a </p>
						<br>
					";
					} else if ($groups->result < 4) {
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
				case "ESTRATEGIA":

					$texto_a = "La estrategia se trata de decisiones y renuncias, y según tus respuestas aún existen elecciones que debes hacer para que tu negocio tenga un mayor potencial de crecimiento. Tienes retos en la definición de los segmentos donde las fortalezas de tu empresa te llevarán a vencer a tus competidores ofreciendo una propuesta de valor altamente interesante para el mercado.";
					$texto_b = "Los elementos estratégicos de tu modelo de negocio están parcialmente resueltos, sin embargo puedes tener oportunidades de mejora en los siguientes frentes: refinar la segmentación de tu mercado objetivo, encontrar nuevos puntos de encuentro entre las necesidades de los segmentos que actualmente atiendes y las características con las que tu producto soluciona dichas necesidades, ajustar algún componente de tus productos para hacerlos más valiosos para tus segmentos objetivo.";
					$texto_c = "La definición de propuesta de valor, la identificación de necesidades no resueltas en los segmentos objetivo, la claridad sobre los segmentos a atender son lo suficientemente claras y no tienes retos de crecimiento en el eje estratégico.";


					if ($groups->result <= 3) {
						$texto_respuesta .= "
						<h2> <p> <strong> $groups->nombre_grupo </strong> </p> </h2
						<br>
						<p class='justify'> $texto_a </p>
						<br>
					";
					} else if ($groups->result < 4) {
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
				case "OPERATIVA":
					$texto_a = "Los procesos administrativos y operativos de tu empresa están algo desarticulados y es difícil que puedas crecer debido al traumatismo que se generaría y la baja capacidad de respuesta de tus procesos. Es necesario trabajar para delegar funciones, asignar tareas, estandarizar procedimientos, medir indicadores clave, entre otros.";
					$texto_b = "En tu empresa los procesos diarios de operaciones y administración funcionan de forma aceptable. Si bien algunos procesos parecen estar estandarizados y articulados con la estrategia de tu negocio, aún existen oportunidades de mejora en la estructuración de la operación diaria, la protección jurídica de tu sociedad, y la medición de resultados, entre otros.";
					$texto_c = "Tu negocio, en sus actividades cotidianas tiene un nivel superior de articulación y alineación con la estrategia; esto garantiza que tu empresa no sufrirá traumatismos bajo un escenario de crecimiento moderado.";

					if ($groups->result <= 3) {
						$texto_respuesta .= "
						<h2> <p> <strong> $groups->nombre_grupo </strong> </p> </h2
						<br>
						<p class='justify'> $texto_a </p>
						<br>
					";
					} else if ($groups->result < 4) {
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
				default:
					if ($groups->result <= 3) {
						$texto_respuesta .= "
						<h2> <p> <strong> $groups->nombre_grupo </strong> </p> </h2
						<br>
						<p class='justify'> $texto_a </p>
						<br>
					";
					} else if ($groups->result < 4) {
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

			}
		}
		$result->texto_respuesta = $texto_respuesta;
		$result->titulos_grupo = $titulos_grupo;
		$result->total_grupos = $totalGroups;
	 	return $result;
	}

	public static function getOportunidades(Collection $answers, $totalGroups)
	{
		$codigo_etapa = null;
		$codigo_eje = null;
		$codigo_etapa_respuesta = 3634;
		$result_etapa = $answers->where('question_id', $codigo_etapa_respuesta)->first();
		$resultado_opcion_encuesta = $result_etapa->option_code_y;

		$data_score_eje = [];
		$object = new stdClass();

		foreach ($totalGroups as $totalScore) {
			$object->score = $totalScore->result . '_' . $totalScore->codigo_grupo;
			array_push($data_score_eje, $totalScore->result);
		}
		$min_value_eje = min($data_score_eje);
		$min_value_eje_dates = [];
		foreach ($totalGroups as $min_dates) {
			if ($min_dates->result == $min_value_eje) {
				array_push($min_value_eje_dates, $min_dates->codigo_grupo);
			}
		}

		if ($min_value_eje_dates[0] == 261) {
			$codigo_eje = 1;
		}

		if ($min_value_eje_dates[0] == 262) {
			$codigo_eje = 2;
		}

		if ($min_value_eje_dates[0] == 263) {
			$codigo_eje = 3;
		}

		if ($resultado_opcion_encuesta == 5464) {
			$codigo_etapa = 56;
		}

		if ($resultado_opcion_encuesta == 5465) {
			$codigo_etapa = 57;
		}

		if ($resultado_opcion_encuesta == 5466) {
			$codigo_etapa = 58;
		}

		if ($resultado_opcion_encuesta == 5467) {
			$codigo_etapa = 67;
		}

		return ConvocatoriaEtapa::getStagePrograms($codigo_etapa, $codigo_eje);
	}



	/**
 * Custom data report.
 *
 */
	public static function diagnosticSurveyReport(UsuarioEncuesta $userSurvey)
	{
		$report = new \stdClass();

		switch ($userSurvey->codigo_encuesta) {
			case self::$diagnostic:
				// Empresa
				$report = self::getResultDiagnostic($userSurvey);
				return $report;
				break;
		}

	}

	/**
	 * Results
	 *
	 */
	public static function getResultDiagnostic(UsuarioEncuesta $userSurvey)
	{
		$query = RespuestaEncuesta::query();
		$query->select(DB::raw("SUM(opcion_encuesta.puntaje_opcion_encuesta) as total_grupo"), DB::raw( "trim( upper( regexp_replace(grupo_pregunta_encuesta.nombre_grupo_pregunta_encuesta, E'<.*?>', '', 'g' )) ) as nombre_grupo_pregunta_encuesta")  );
		$query->join('core.opcion_encuesta','opcion_encuesta.codigo_opcion_encuesta','respuesta_encuesta.codigo_opcion_encuesta');
		$query->join('core.pregunta_encuesta','pregunta_encuesta.codigo_pregunta_encuesta','respuesta_encuesta.codigo_pregunta_encuesta');
		$query->join('core.grupo_pregunta_encuesta','grupo_pregunta_encuesta.codigo_grupo_pregunta_encuesta','pregunta_encuesta.codigo_grupo_pregunta_encuesta');
		$query->where('opcion_encuesta.codigo_estado',Estado::getState('active'));
		$query->where('respuesta_encuesta.codigo_usuario_encuesta', $userSurvey->codigo_usuario_encuesta );
		$query->groupBy('grupo_pregunta_encuesta.codigo_grupo_pregunta_encuesta');
		$result =$query->get();
		return $result;
	}

	public static function addValuesOfMentorProvider($user, Request $request) {
		$userUp = Usuario::find($user->codigo_usuario);
		$userUp->experiencia_usuario = $request->pregunta_3686;
		$userUp->linkedin_usuario = $request->pregunta_3689;
		$userUp->save();

		$person = Persona::where('codigo_usuario', $user->codigo_usuario)->first();
		$person->forma_ayuda_mentoria = $request->pregunta_3705;
		$person->save();

		// Option Survey
		$option_survey = OpcionPreguntaEncuesta::query();
		$option_survey->select('codigo_opcion_encuesta', 'codigo_pregunta_encuesta');
		$option_survey->where('codigo_pregunta_encuesta', '=', 3706);
		$data_options = $option_survey->get();

		foreach ($data_options as $option) {
			if ($request->has('pregunta_3706_opcion_'.$option->codigo_opcion_encuesta)) {
				switch ($option->codigo_opcion_encuesta) {
					case 5599:
						$stage = 57;
					break;
					case 5600:
						$stage = 56;
					break;
					case 5601:
						$stage = 58;
					break;
					case 5602:
						$stage = 67;
					break;
				}

				$stageMentorinUser = EtapaMentoria::where('codigo_usuario', '=', $user->codigo_usuario)->where('codigo_etapa_proyecto', $stage)->first();
				if(!$stageMentorinUser instanceof EtapaMentoria){
					$stageMentoring = new EtapaMentoria();
					$stageMentoring->codigo_usuario = $user->codigo_usuario;
					$stageMentoring->codigo_etapa_proyecto = $stage;
					$stageMentoring->codigo_estado = Estado::getState('active');
					$stageMentoring->save();
				}
			}
		}
	}
}
