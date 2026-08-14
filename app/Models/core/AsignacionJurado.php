<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

use Auth, DB, URL;

use App\Fase,
	App\EdicionEvaluacion,
	App\RegistroFaseUsuario;

use App\Custom\Rutan;

use TuProyecto, Custom\Innpulsa;

class AsignacionJurado extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.asignacion_jurado';

	protected $primaryKey = 'codigo_asignacion_jurado';

	public $timestamps = false;

	public static function getProjectsEvaluation(array $filters = [])
   	{
   		$projects = [];
		$query = AsignacionJurado::query();
		$query->select('registro_convocatoria.numero_registro_convocatoria as id_aplication', 'asignacion_jurado.codigo_asignacion_jurado', 'asignacion_jurado.lugar_evaluacion_jurado', 'asignacion_jurado.fecha_evaluacion_jurado', 'asignacion_jurado.codigo_usuario as owner', 'asignacion_jurado.codigo_convocatoria', 'convocatoria.url_convocatoria', 'asignacion_jurado.codigo_usuario', 'fecha_asignacion_jurado', 'imagen_usuario', 'nombre_usuario', 'nickname_usuario', 'convocatoria.nombre_convocatoria', DB::raw('(CASE  WHEN codigo_resultado_evaluacion IS NULL THEN false ELSE true END) as evaluation'), 'registro_fase_usuario.codigo_fase', 'fase.codigo_evaluacion_emprendimiento', 'registro_fase_usuario.fecha_registro_fase_usuario', 'registro_fase_usuario.hora_registro_fase_usuario', 'asignacion_jurado.codigo_registro_fase_usuario', 'fase.url_fase', 'fase.nombre_fase', 'asignacion_jurado.codigo_estado',
			DB::raw('current_date - fecha_registro_fase_usuario as postulation_days'));

		// User project
		$query->join('core.registro_fase_usuario', 'asignacion_jurado.codigo_registro_fase_usuario', '=', 'registro_fase_usuario.codigo_registro_fase_usuario');

		$query->join('core.fase', 'registro_fase_usuario.codigo_fase', '=', 'fase.codigo_fase');
		$query->join('seguridad.usuario', 'registro_fase_usuario.codigo_usuario', '=', 'usuario.codigo_usuario');
		$query->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');
		$query->join('core.convocatoria', 'fase.codigo_convocatoria', '=', 'convocatoria.codigo_convocatoria');
		$query->join('core.encuesta', 'convocatoria.codigo_encuesta', '=', 'encuesta.codigo_encuesta');

		// User institution
		$query->join('core.usuario_institucion', function($join) {
			$join->on('usuario_institucion.codigo_usuario', '=', 'usuario.codigo_usuario')
				->where('usuario_institucion.codigo_institucion', '=', RegistroSesion::getInstitution());
        });
        $query->join('core.dato_entidad', 'usuario_institucion.codigo_usuario_institucion', '=', 'dato_entidad.codigo_usuario_institucion');

		// Get Results Evaluation
		$query->leftjoin('core.resultado_evaluacion_emprendimiento', function($join) {
			$join->on('resultado_evaluacion_emprendimiento.codigo_evaluacion_emprendimiento', '=', 'fase.codigo_evaluacion_emprendimiento')
				->on('resultado_evaluacion_emprendimiento.codigo_asignacion_jurado', '=', 'asignacion_jurado.codigo_asignacion_jurado')
				->where('resultado_evaluacion_emprendimiento.codigo_usuario', '=', Auth::user()->codigo_usuario);
        });

        $query->join('core.registro_convocatoria', 'registro_fase_usuario.codigo_registro_convocatoria', '=', 'registro_convocatoria.codigo_registro_convocatoria');

        // Filters
        if(isset($filters['state']) && !empty($filters['state'])) {
			$query->where('asignacion_jurado.codigo_estado', $filters['state']);

		}else{
			$query->where('asignacion_jurado.codigo_estado', Estado::getState('active'));
		}

		if(isset($filters['industry']) && !empty($filters['industry'])){
			$query->where('dato_entidad.codigo_categoria_proyecto', $filters['industry']);
		}

		if(isset($filters['program']) && !empty($filters['program'])){
			$query->where('convocatoria.codigo_convocatoria', $filters['program']);
		}

		if(isset($filters['entrepreneurship']) && !empty($filters['entrepreneurship'])) {
            $query->whereRaw("usuario.nombre_usuario ilike '%".$filters['entrepreneurship']."%'");
        }

       	if(isset($filters['code']) && !empty($filters['code'])){
			$query->where('registro_convocatoria.numero_registro_convocatoria', $filters['code']);
		}
		$query->where('asignacion_jurado.codigo_usuario', Auth::user()->codigo_usuario);

		// Get total posts
		$total_entries = $query->count();

		// Get posts
   		$query->orderBy('registro_fase_usuario.fecha_registro_fase_usuario', 'asc');
   		$query->orderBy('registro_fase_usuario.hora_registro_fase_usuario', 'asc');
		$data = $query->skip($filters['offset'])->take($filters['limit'])->get();

		if(count($data) > 0) {
			foreach ($data as $project) {
				$entrepreneurship = new \stdClass();
				$entrepreneurship->url_asignacion_jurado = sprintf("%s-%s", 'evaluacion', $project->codigo_asignacion_jurado);
				$entrepreneurship->id_aplication = $project->id_aplication;
				$entrepreneurship->codigo_fase = $project->codigo_fase;
				$entrepreneurship->nombre_fase = $project->nombre_fase;
				$entrepreneurship->codigo_estado = $project->codigo_estado;
				$entrepreneurship->lugar_evaluacion_jurado = $project->lugar_evaluacion_jurado;
				$entrepreneurship->fecha_evaluacion_jurado = $project->fecha_evaluacion_jurado;
				$entrepreneurship->url_fase = $project->url_fase;
				$entrepreneurship->nickname_usuario_proyecto = $project->nickname_usuario;
				$entrepreneurship->imagen_usuario_proyecto = $project->imagen_usuario;
				$entrepreneurship->nombre_usuario_proyecto = $project->nombre_usuario;
				$entrepreneurship->nombre_convocatoria = $project->nombre_convocatoria;
				$entrepreneurship->fecha_asignacion_jurado = $project->fecha_asignacion_jurado;
				$entrepreneurship->fecha_registro_fase_usuario = $project->fecha_registro_fase_usuario;
				$entrepreneurship->hora_registro_fase_usuario = $project->hora_registro_fase_usuario;
				$entrepreneurship->evaluation = $project->evaluation;
				$entrepreneurship->codigo_evaluacion_emprendimiento = $project->codigo_evaluacion_emprendimiento;
				$entrepreneurship->postulation_days = $project->postulation_days;

				$projects[] = $entrepreneurship;
			}
		}

		$response = new \stdClass();
		$response->total_entries = $total_entries;
		$response->items = $projects;
   		return $response;
   	}

   	public static function getDataEvaluation($codigo_asignacion_jurado)
   	{
   		$query = AsignacionJurado::query();
		$query->select('asignacion_jurado.codigo_asignacion_jurado', 'fase.codigo_fase', 'entidad.facebook_entidad as facebook', 'entidad.twitter_entidad as twitter', 'entidad.linkedin_entidad as linkedin', 'entidad.instagram_entidad as instagram', 'usuario.pagina_web_usuario as pagina_web', 'evaluacion_emprendimiento.aceptacion_termnos_evaluacion', 'evaluacion_emprendimiento.sugerencias_marketplace', 'evaluacion_emprendimiento.observaciones_fase', 'evaluacion_emprendimiento.subgrupos_evaluacion_emprendimiento', 'evaluacion_emprendimiento.promedio_acumulado_evaluacion_emprendimiento', 'evaluacion_emprendimiento.visibilidad_aplicacion', 'asignacion_jurado.lugar_evaluacion_jurado', 'asignacion_jurado.fecha_evaluacion_jurado', 'fase.codigo_evaluacion_emprendimiento','asignacion_jurado.codigo_convocatoria','convocatoria.url_convocatoria','asignacion_jurado.codigo_usuario', 'registro_fase_usuario.codigo_usuario as seg_codigo_usuario', 'fecha_asignacion_jurado', 'convocatoria.codigo_encuesta', 'comentario_resultado_evaluacion', 'nombre_evaluacion_emprendimiento', 'codigo_resultado_evaluacion', DB::raw('COALESCE(puntaje_total_eval_emprendi, 0) AS puntaje_total_eval_emprendi'), DB::raw('(CASE WHEN codigo_resultado_evaluacion IS NULL THEN false ELSE true END) as evaluation'), 'encuesta.url_encuesta', 'asignacion_jurado.codigo_registro_fase_usuario', 'fase.nombre_fase', 'fase.url_fase', 'fase_cancelacion', 'fase_entidad_editable', 'usuario.nickname_usuario as nickname_usuario_proyecto', 'usuario.nombre_usuario as nombre_usuario_proyecto',
			DB::raw("(jurado.nombre_usuario || ' ' || COALESCE(pjurado.primer_apellido_persona, '') || ' ' || COALESCE(pjurado.segundo_apellido_persona, '')) as nombre_usuario_jurado"), 'registro_convocatoria.codigo_usuario_encuesta'
		);

		// User project
		$query->join('core.registro_fase_usuario', 'asignacion_jurado.codigo_registro_fase_usuario', '=', 'registro_fase_usuario.codigo_registro_fase_usuario');
		$query->join('core.registro_convocatoria', 'registro_fase_usuario.codigo_registro_convocatoria', '=', 'registro_convocatoria.codigo_registro_convocatoria');
		$query->join('core.fase', 'registro_fase_usuario.codigo_fase', '=', 'fase.codigo_fase');
		$query->join('core.evaluacion_emprendimiento', 'evaluacion_emprendimiento.codigo_evaluacion_emprendimiento', '=', 'fase.codigo_evaluacion_emprendimiento');

		$query->join('seguridad.usuario', 'registro_fase_usuario.codigo_usuario', '=', 'usuario.codigo_usuario');
		$query->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');
		$query->leftJoin('core.entidad', 'registro_fase_usuario.codigo_usuario', '=', 'entidad.codigo_usuario');

		$query->join('seguridad.usuario as jurado', 'asignacion_jurado.codigo_usuario', '=', 'jurado.codigo_usuario');
		$query->leftJoin('core.persona as pjurado', 'jurado.codigo_usuario', '=', 'pjurado.codigo_usuario');

		// User institution
		$query->join('core.usuario_institucion', function($join) {
			$join->on('usuario_institucion.codigo_usuario', '=', 'usuario.codigo_usuario')
				->where('usuario_institucion.codigo_institucion', '=', RegistroSesion::getInstitution());
        });

        $query->join('core.convocatoria', 'fase.codigo_convocatoria', '=', 'convocatoria.codigo_convocatoria');
		$query->join('core.encuesta', 'convocatoria.codigo_encuesta', '=', 'encuesta.codigo_encuesta');
		$query->leftjoin('core.resultado_evaluacion_emprendimiento', 'resultado_evaluacion_emprendimiento.codigo_asignacion_jurado', '=', 'asignacion_jurado.codigo_asignacion_jurado');

		$query->where('asignacion_jurado.codigo_asignacion_jurado', $codigo_asignacion_jurado);
		$query->whereIn('asignacion_jurado.codigo_estado', [Estado::getState('active'), Estado::getState('evaluated')]);
		$query->where('asignacion_jurado.codigo_usuario', Auth::user()->codigo_usuario);
   		$query->orderBy('registro_fase_usuario.codigo_usuario','desc');
		return $query->first();
   	}

   	/**
	* Build Projects Evaluation.
	*/
   	public static function buildEvaluation($evaluation)
   	{
		$object = new \stdClass();
		$object->codigo_usuario = TuProyecto::encryptSrcParams([$evaluation->codigo_usuario]);
		$object->seg_codigo_usuario = TuProyecto::encryptSrcParams([$evaluation->seg_codigo_usuario]);
		$object->codigo_usuario_encuesta = TuProyecto::encryptSrcParams([$evaluation->codigo_usuario_encuesta]);
		$object->codigo_fase = $evaluation->codigo_fase;
		$object->id_proyecto = $evaluation->seg_codigo_usuario;
		$object->fecha_asignacion_jurado = $evaluation->fecha_asignacion_jurado;
		$object->lugar_evaluacion_jurado = $evaluation->lugar_evaluacion_jurado;
		$object->fecha_evaluacion_jurado = $evaluation->fecha_evaluacion_jurado;
		$object->nombre_usuario = $evaluation->nombre_usuario;
		$object->url_encuesta = $evaluation->url_encuesta;
		$object->nickname_usuario_proyecto = $evaluation->nickname_usuario_proyecto;
		$object->nombre_usuario_proyecto = $evaluation->nombre_usuario_proyecto;
		$object->nombre_usuario_jurado = $evaluation->nombre_usuario_jurado;
		$object->facebook = $evaluation->facebook;
		$object->twitter = $evaluation->twitter;
		$object->linkedin = $evaluation->linkedin;
		$object->instagram = $evaluation->instagram;
		$object->pagina = $evaluation->pagina_web;
		$object->extraQuestions = Innpulsa::getExtraQuestionsEvaluation($evaluation);

		if ($evaluation->codigo_fase === Fase::getIdPhase('moment_3__Aldea20')) {
			$register = RegistroFaseUsuario::find($evaluation->codigo_registro_fase_usuario);

			$object->respuestas = Innpulsa::get__Aldea20__IndicatorsTotalScore_1_3($register);
		}

		$object->codigo_evaluacion_emprendimiento = $evaluation->codigo_evaluacion_emprendimiento;
		$object->codigo_registro_fase_usuario = $evaluation->codigo_registro_fase_usuario;
		$object->nombre_fase = $evaluation->nombre_fase;
		$object->fase_cancelacion = $evaluation->fase_cancelacion;
		$object->fase_entidad_editable = $evaluation->fase_entidad_editable;
		$object->url_fase = $evaluation->url_fase;
		$object->subgrupos_evaluacion_emprendimiento = $evaluation->subgrupos_evaluacion_emprendimiento;
		$object->promedio_acumulado_evaluacion_emprendimiento = $evaluation->promedio_acumulado_evaluacion_emprendimiento;
		$object->visibilidad_aplicacion = $evaluation->visibilidad_aplicacion;

		$object->aceptacion_termnos_evaluacion = $evaluation->aceptacion_termnos_evaluacion;
		if($evaluation->aceptacion_termnos_evaluacion) {
			$object->terminos_evaluacion = transtp('evaluations.terms.link', ['route' => route('evaluacion.terminos', "evaluacion-$evaluation->codigo_asignacion_jurado")]);
		}

		// Categorias producto
		$object->categorias_producto = $evaluation->sugerencias_marketplace ? CategoriaProducto::getCategories(): null;

		// Get Items Evatualition
		$query = $evaluation->questions();
		$query->select('item_evaluacion_emprendimiento.codigo_grupo_item_eval','grupo_item_eval.nombre_grupo_item_eval', 'item_evaluacion_emprendimiento.codigo_item_evaluacion', 'item_evaluacion_emprendimiento.codigo_tipo_evaluacion_item','item_evaluacion_emprendimiento.codigo_grup_opc_eval_pregunta', 'item_evaluacion_emprendimiento.nombre_item_evaluacion', 'nombre_grup_opc_eval_pregunta');
		$query->leftJoin('core.grup_opc_eval_pregunta', 'item_evaluacion_emprendimiento.codigo_grup_opc_eval_pregunta', '=', 'grup_opc_eval_pregunta.codigo_grup_opc_eval_pregunta');
		$query->leftJoin('core.grupo_item_eval', 'item_evaluacion_emprendimiento.codigo_grupo_item_eval', '=', 'grupo_item_eval.codigo_grupo_item_eval');
		$query->where('core.item_evaluacion_emprendimiento.codigo_estado', '=', Estado::getState('active'));
		$query->orderBy('item_evaluacion_emprendimiento.orden_item_eval_emprendi','asc');
		$arItems = $query->get();

		// Get Results Evaluation
		$object->evaluation = $evaluation->evaluation;
		$object->comentario_evaluacion = $evaluation->comentario_resultado_evaluacion;
		$object->nombre_evaluacion = $evaluation->nombre_evaluacion_emprendimiento;

		$califications = [];
		if($evaluation->evaluation && $evaluation->codigo_resultado_evaluacion != null) {
			// Get Califications
			$query = EvaluacionItemEmprendimiento::query();
			$query->select(
				'evaluacion_item_emprendimiento.codigo_item_evaluacion',
				'valor_evaluacion_item',
				'item_evaluacion_emprendimiento.codigo_grupo_item_eval',
				DB::raw('COALESCE(opc_eval_pregunta.valor_opc_eval_pregunta, 0) AS valor_opc_eval_pregunta'),
				'comentario_adicional',
				'puntajes_resul_eval_empren',
				'valores_evaluacion_item'
			);
			$query->join('core.item_evaluacion_emprendimiento', 'item_evaluacion_emprendimiento.codigo_item_evaluacion', '=', 'evaluacion_item_emprendimiento.codigo_item_evaluacion');
			$query->leftJoin('core.opc_eval_pregunta', function($join) {
	       		$join->on('evaluacion_item_emprendimiento.valor_evaluacion_item', '=', 'opc_eval_pregunta.codigo_opc_eval_pregunta');
			});
			$query->where('codigo_resultado_evaluacion', $evaluation->codigo_resultado_evaluacion);
			$califications = $query->get();
		}

		// Get Answers
		$query = RespuestaEncuesta::query();
		$query->select('pregunta_encuesta.codigo_pregunta_encuesta', 'respuesta_encuesta.texto_respuesta_encuesta', 'respuesta_encuesta.codigo_opcion_encuesta', 'respuesta_encuesta.cor_codigo_opcion_encuesta');
		$query->join('core.pregunta_encuesta', 'respuesta_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
		$query->where('pregunta_encuesta.codigo_encuesta', $evaluation->codigo_encuesta);
		$query->where('respuesta_encuesta.codigo_usuario_encuesta', $evaluation->codigo_usuario_encuesta);
		$query->where('respuesta_encuesta.codigo_estado', Estado::getState('active'));


		$answers = $query->get();

		// Groups Item Evaluation
		$query = GrupoItemEval::query();
		$query->select('item_evaluacion_emprendimiento.codigo_grupo_item_eval','nombre_grupo_item_eval', 'promedio_conmutado', 'sigla_grupo_item_eval');
		$query->join('core.item_evaluacion_emprendimiento', 'grupo_item_eval.codigo_grupo_item_eval', '=', 'item_evaluacion_emprendimiento.codigo_grupo_item_eval');
		$query->where('item_evaluacion_emprendimiento.codigo_evaluacion_emprendimiento', $evaluation->codigo_evaluacion_emprendimiento);
		$query->where('item_evaluacion_emprendimiento.codigo_estado', Estado::getState('active'));
		$query->orderBy('grupo_item_eval.codigo_grupo_item_eval','asc');
		$query->groupBy('grupo_item_eval.codigo_grupo_item_eval','item_evaluacion_emprendimiento.codigo_grupo_item_eval','nombre_grupo_item_eval');
		$groups = $query->get();

		// Get phase register
		$register = RegistroFaseUsuario::find($evaluation->codigo_registro_fase_usuario);

		// Recomendaciones fase anterior
		$object->recomendacion_fase = null;
		if($evaluation->observaciones_fase) {
			if ($evaluation->codigo_evaluacion_emprendimiento == 10) {

				$query = ResultadoEvaluacionEmprendimiento::query();
				$query->join('core.asignacion_jurado', 'asignacion_jurado.codigo_asignacion_jurado', '=', 'resultado_evaluacion_emprendimiento.codigo_asignacion_jurado');
				$query->join('core.registro_fase_usuario', 'registro_fase_usuario.codigo_registro_fase_usuario', '=', 'asignacion_jurado.codigo_registro_fase_usuario');
				$query->where('resultado_evaluacion_emprendimiento.codigo_evaluacion_emprendimiento', 9);
				$query->where('registro_fase_usuario.codigo_usuario', $evaluation->seg_codigo_usuario);
				$query->orderBy('resultado_evaluacion_emprendimiento.codigo_resultado_evaluacion', 'desc');
				$evaluacion_anterior = $query->first();
				$object->recomendacion_fase = $evaluacion_anterior->comentario_resultado_evaluacion;

			}
		}

		// Promedio general evaluaciones
		if($evaluation->promedio_acumulado_evaluacion_emprendimiento)
		{
			$object->promedio_acumulado = null;
			$object->promedio_total_acumulado = null;
			if ($evaluation->codigo_evaluacion_emprendimiento == 10) {
				$promedio_total_acumulado = 0;
				foreach ($groups as $group) {
					$item = new \stdClass();
					$item->nombre_item = $group->nombre_grupo_item_eval;
					if( in_array($group->codigo_grupo_item_eval, [GrupoItemEval::getGroup('enterprising_team')]) ) {
						$item->promedio_item = sprintf('%s %s', $group->generalAverageGroup($register), '%');
						$promedio_total_acumulado += ( ($group->generalAverageGroup($register) / 100) * 40);
					}elseif ( in_array($group->codigo_grupo_item_eval, [GrupoItemEval::getGroup('market'), GrupoItemEval::getGroup('product')]) ) {
						$item->promedio_item = sprintf('%s %s', $group->generalAverageGroup($register), '%');
						$promedio_total_acumulado += ( ($group->generalAverageGroup($register) / 100) * 25);
					}elseif ( in_array($group->codigo_grupo_item_eval, [GrupoItemEval::getGroup('productive_chains')]) ) {
						$item->promedio_item = sprintf('%s %s', $group->generalAverageGroup($register), '%');
						$promedio_total_acumulado += ( ($group->generalAverageGroup($register) / 100) * 10);
					}
					$object->promedio_acumulado[] = $item;
				}

				// Total
				$object->promedio_total_acumulado = sprintf('%s %s', round($promedio_total_acumulado), '%');
			} else if($evaluation->codigo_evaluacion_emprendimiento == 24){
				$promedio_total_acumulado = 0;
				foreach ($groups as $group) {
					$item = new \stdClass();
					$item->nombre_item = $group->nombre_grupo_item_eval;
					if( in_array($group->codigo_grupo_item_eval, [GrupoItemEval::getGroup('innovation_component')]) ) {
						$item->promedio_item = sprintf('%s', $group->generalAverageGroupAldea2020($register));
						$promedio_total_acumulado += ( ($group->generalAverageGroupAldea2020($register)));
					}elseif ( in_array($group->codigo_grupo_item_eval, [GrupoItemEval::getGroup('market_2020')])) {
						$item->promedio_item = sprintf('%s', $group->generalAverageGroupAldea2020($register));
						$promedio_total_acumulado += ( ($group->generalAverageGroupAldea2020($register)));
					}elseif ( in_array($group->codigo_grupo_item_eval, [GrupoItemEval::getGroup('enterprising_team_2020')]) ) {
						$item->promedio_item = sprintf('%s', (($group->generalAverageGroupAldea2020($register))));
						$promedio_total_acumulado += ( ($group->generalAverageGroupAldea2020($register)));
					}elseif ( in_array($group->codigo_grupo_item_eval, [GrupoItemEval::getGroup('objetives')]) ) {
						$item->promedio_item = sprintf('%s', $group->generalAverageGroupAldea2020($register));
						$promedio_total_acumulado += ( ($group->generalAverageGroupAldea2020($register)));
					}elseif ( in_array($group->codigo_grupo_item_eval, [GrupoItemEval::getGroup('recomendations')]) ) {
						$item->promedio_item = sprintf('%s', $group->generalAverageGroupAldea2020($register));
						$promedio_total_acumulado += ( ($group->generalAverageGroupAldea2020($register)));
					}
					$object->promedio_acumulado[] = $item;
				}

				// Total
				$object->promedio_total_acumulado = sprintf('%s', round($promedio_total_acumulado));
			}
		}

		$groupsItem = [];
		foreach ($groups as $group) {

			$itemgroup = new \stdClass();
			$itemgroup->codigo_grupo_item_eval = $group->codigo_grupo_item_eval;
			$itemgroup->nombre_grupo_item_eval = $group->nombre_grupo_item_eval;
            $itemgroup->promedio_conmutado = $group->promedio_conmutado ? $group->averageGroup($register): null;
			$itemgroup->sigla_grupo_item_eval = $group->sigla_grupo_item_eval;

			$itemgroup->items = [];
			$questions = [];
			$itemsEval = $arItems->where('codigo_grupo_item_eval', $group->codigo_grupo_item_eval);

			if($itemsEval->count() > 0) {
				foreach ($itemsEval as $itemeval) {
					$item = new \stdClass();
					$item->codigo_item_evaluacion = $itemeval->codigo_item_evaluacion;
					$item->nombre_item_evaluacion = $itemeval->nombre_item_evaluacion;
					$item->codigo_tipo_evaluacion_item = $itemeval->codigo_tipo_evaluacion_item;
					$item->codigo_grup_opc_eval_pregunta = $itemeval->codigo_grup_opc_eval_pregunta;
					$item->nombre_grup_opc_eval_pregunta = $itemeval->nombre_grup_opc_eval_pregunta;

					$item->preguntas = [];
					$query = AgrupacionItemEval::query();
					$query->select('pregunta_encuesta.*', 'agrupacion_item_ejex', 'agrupacion_item_ejey', 'sigla_moneda');
					$query->join('core.pregunta_encuesta', 'agrupacion_item_eval.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
					$query->leftJoin('core.moneda', 'pregunta_encuesta.codigo_moneda', '=', 'moneda.codigo_moneda');
					$query->where('codigo_item_evaluacion',$itemeval->codigo_item_evaluacion);
					$query->where('agrupacion_item_eval.codigo_estado', Estado::getState('active'));
					$argquestions = $query->get();

					if($argquestions instanceof Collection && $argquestions->count() > 0) {
						$questiongroups = [];
						foreach ($argquestions as $q) {
							if($q->codigo_pregunta_encuesta != ''){
								$itemq = new \stdClass();
								$itemq->codigo_pregunta_encuesta = $q->codigo_pregunta_encuesta;
								$itemq->tipo_campo_pregunta = $q->tipo_campo_pregunta;
								$itemq->texto_pregunta_encuesta = $q->texto_pregunta_encuesta;
								$itemq->codigo_moneda = $q->codigo_moneda;
								$itemq->sigla_moneda = $q->sigla_moneda;
								$itemq->clase_pregunta_encuesta = $q->clase_pregunta_encuesta;
								$itemq->codigo_opcion_encuesta = $q->codigo_opcion_encuesta;
								$itemq->tipo_pregunta_encuesta = $q->tipo_pregunta_encuesta;
								$itemq->agrupacion_item_ejex = $q->agrupacion_item_ejex;
								$itemq->agrupacion_item_ejey = $q->agrupacion_item_ejey;

								$itemq->respuesta = [];
								$options = [];
								// Build answer
								if($answers instanceof Collection) {
									$itemq->respuesta = RespuestaEncuesta::buildAnswer($answers, $q->tipo_pregunta_encuesta, $q->codigo_pregunta_encuesta);
								}
								// Options questions closed, unique or mulplique answer (y-axis)
								if(in_array($q->tipo_pregunta_encuesta, [PreguntaEncuesta::getType('single'), PreguntaEncuesta::getType('multiple'), PreguntaEncuesta::getType('matriz')])) {
									// Choices closed questions
									$arChoicesy = OpcionPreguntaEncuesta::where('codigo_pregunta_encuesta',$q->codigo_pregunta_encuesta)->where('codigo_estado', Estado::getState('active'))->where('eje_opcion', OpcionPreguntaEncuesta::getAxis('y'))->orderBy('orden_opcion_encuesta', 'asc')->orderBy('codigo_opcion_encuesta', 'asc')->get();
									if($arChoicesy->count() > 0) {
										foreach ($arChoicesy as $choice) {
											$choiceItem = new \stdClass();
											$choiceItem->codigo_opcion_encuesta = $choice->codigo_opcion_encuesta;
											$choiceItem->texto_opcion_encuesta = $choice->texto_opcion_encuesta;
											$choiceItem->calculado_opcion_encuesta = $choice->calculado_opcion_encuesta;
											$choiceItem->referencia_opcion_encuesta = $choice->referencia_opcion_encuesta;
											$choiceItem->tipo_campo_opcion = $choice->tipo_campo_opcion;
											if($choice->calculado_opcion_encuesta == true){
												$choiceItem->formula_opcion_encuesta = $choice->formula_opcion_encuesta;
											}
											$options[] = $choiceItem;
										}
									}
								}
								$itemq->opciones = $options;

								// Options questions matriz (x-axis)
								$campos_opciones = [];
								if(in_array($q->tipo_pregunta_encuesta, [PreguntaEncuesta::getType('matriz')])) {
									// Choices closed questions
									$arChoicesx = OpcionPreguntaEncuesta::where('eje_opcion', OpcionPreguntaEncuesta::getAxis('x'))
									->where('codigo_pregunta_encuesta', $q->codigo_pregunta_encuesta)
									->orderBy('orden_opcion_encuesta', 'asc')->orderBy('codigo_opcion_encuesta', 'asc')
									->get();
									if($arChoicesx->count() > 0) {
										foreach ($arChoicesx as $choice) {
											$choiceItem = new \stdClass();
											$choiceItem->codigo_opcion_encuesta = $choice->codigo_opcion_encuesta;
											$choiceItem->texto_opcion_encuesta = $choice->texto_opcion_encuesta;
											$choiceItem->calculado_opcion_encuesta = $choice->calculado_opcion_encuesta;
											$choiceItem->referencia_opcion_encuesta = $choice->referencia_opcion_encuesta;
											$choiceItem->tipo_campo_opcion = $choice->tipo_campo_opcion;
											if($choice->calculado_opcion_encuesta == true){
												$choiceItem->formula_opcion_encuesta = $choice->formula_opcion_encuesta;
											}
											$campos_opciones[] = $choiceItem;
										}
									}
								}
								$itemq->campos_opciones = $campos_opciones;
								$questiongroups[] = $itemq;
							}
						}
						$item->preguntas = $questiongroups;
					}

					$item->calification = [];
					// Values calification
					if($califications instanceof Collection) {
						$item->calification = $califications->where('codigo_item_evaluacion', $itemeval->codigo_item_evaluacion)->pluck('valor_evaluacion_item')->first();
						$item->comentario_adicional = $califications->where('codigo_item_evaluacion', $itemeval->codigo_item_evaluacion)->pluck('comentario_adicional')->first();
						$item->valores_evaluacion_item = json_decode($califications->where('codigo_item_evaluacion', $itemeval->codigo_item_evaluacion)->pluck('valores_evaluacion_item')->first());
					}

					// Add item
					$questions[] = $item;
				}

				// Options Evaluation
				$query = OpcionEvaluacionPregunta::query();
				$query->select('codigo_grup_opc_eval_pregunta', 'codigo_opc_eval_pregunta', 'nombre_opc_eval_pregunta');
				$query->whereIn('codigo_grup_opc_eval_pregunta', $arItems->unique('codigo_grup_opc_eval_pregunta')->pluck('codigo_grup_opc_eval_pregunta')->all());
				$query->where('codigo_estado', Estado::getState('active'));
				$query->orderBy('codigo_opc_eval_pregunta', 'asc');
				$object->options = $query->get();
			}

			$itemgroup->items = $questions;
			$itemgroup->extraQuestions = Innpulsa::getExtraQuestionsEvaluation($evaluation);
			// Add itemgroup
			$groupsItem[] = $itemgroup;
		}

		// Calculo total evaluacion
		$object->valor_total_evaluacion = null;
		$object->recomendacion_evaluacion = null;
		if($evaluation->codigo_evaluacion_emprendimiento == Innpulsa::$evaluation_challenge_1_2)
		{
			$valor_total_evaluacion = 0;
			foreach ($groups as $group) {
				$scroring = $valor_total_evaluacion = Innpulsa::averageGroup($group, $register);
				if($califications instanceof Collection) {
					$evaluationsgrop = $califications->where('codigo_grupo_item_eval', $group->codigo_grupo_item_eval);
					$calification = $evaluationsgrop->sum('valor_opc_eval_pregunta');
					if($evaluationsgrop->count() > 0){
						$valor_total_evaluacion = ($scroring + $calification) /2;
					}
				}
				$object->valor_total_evaluacion += $valor_total_evaluacion;
			}

			if($object->valor_total_evaluacion >= 60) {
				$object->recomendacion_evaluacion = "Se recomienda para Reto 2: Conversa Con Expertos";
			}else{
				$object->recomendacion_evaluacion = "Aunque tienes un producto (bien o servicio) validado comercialmente, te recomendamos analizar  el valor agregado que tu producto o servicio aporta a los clientes, para que puedas identificar cómo tu  producto resuelve la necesidad de tu cliente, qué beneficios debe esperar el cliente de tu producto y por qué te debe elegir a ti y no a tu competencia.";
			}

		}elseif ($evaluation->codigo_evaluacion_emprendimiento == Innpulsa::$evaluation_challenge_empodera_1_2) {
			$valor_total_evaluacion = 0;
			foreach ($groups as $group) {
				$scroring = $valor_total_evaluacion = Innpulsa::averageGroup($group, $register);
				if($califications instanceof Collection) {
					$evaluationsgrop = $califications->where('codigo_grupo_item_eval', $group->codigo_grupo_item_eval);
					$calification = $evaluationsgrop->sum('valor_opc_eval_pregunta');
					if($evaluationsgrop->count() > 0){
						$valor_total_evaluacion = ($scroring + $calification) /2;
					}
				}
				$object->valor_total_evaluacion += $valor_total_evaluacion;
			}

			if($object->valor_total_evaluacion >= 60) {
				$object->recomendacion_evaluacion = "Se recomienda para Reto 2: Conversa Con Expertos";
			}else{
				$object->recomendacion_evaluacion = "Aunque tienes un producto (bien o servicio) validado comercialmente, te recomendamos analizar  el valor agregado que tu producto o servicio aporta a los clientes, para que puedas identificar cómo tu  producto resuelve la necesidad de tu cliente, qué beneficios debe esperar el cliente de tu producto y por qué te debe elegir a ti y no a tu competencia.";
			}

		}elseif ($evaluation->codigo_evaluacion_emprendimiento == Innpulsa::$evaluation_challenge_2) {
			foreach ($groups as $group) {
				if( in_array($group->codigo_grupo_item_eval, [GrupoItemEval::getGroup('enterprising_team')]) ) {
					$object->valor_total_evaluacion += ($group->averageGroup($register) / 100) * 40;
				}elseif ( in_array($group->codigo_grupo_item_eval, [GrupoItemEval::getGroup('market'), GrupoItemEval::getGroup('product')]) ) {
					$object->valor_total_evaluacion += ($group->averageGroup($register) / 100) * 25;
				}elseif ( in_array($group->codigo_grupo_item_eval, [GrupoItemEval::getGroup('productive_chains')]) ) {
					$object->valor_total_evaluacion += ($group->averageGroup($register) / 100) * 10;
				}
			}
		} elseif ($evaluation->codigo_evaluacion_emprendimiento == Rutan::$codigo_evaluacion_preincubacion ||
				$evaluation->codigo_evaluacion_emprendimiento == Rutan::$codigo_evaluacion_incubacion ||
				$evaluation->codigo_evaluacion_emprendimiento == Rutan::$codigo_evaluacion_aceleracion ||
				$evaluation->codigo_evaluacion_emprendimiento == Rutan::$codigo_evaluacion_consolidacion) {

			$data_logs = EdicionEvaluacion::getRegisters($evaluation);

			$object->data_logs = $data_logs;
		}

		$object->grupos = $groupsItem;
		return $object;
   	}

   	public function getAllowedUsers()
  	{
  		// by default, the evaluator of the resource is allowed
  		return [$this->attributes['codigo_usuario']];
  	}
	/**
     * Obtiene respuestas evaluación.
     *
     * @access private
     * @static function
     * @param int $id_register_phase_usuariocode
     * @return array|object $answers|$data
     */
    public static function getAnswerEvaluation(int $id_register_phase_usuario, $id_evaluation)
	{
        $query = AsignacionJurado::query();
        $query->join('core.resultado_evaluacion_emprendimiento as re', 'asignacion_jurado.codigo_asignacion_jurado', '=', 're.codigo_asignacion_jurado');
        $query->join('core.evaluacion_item_emprendimiento as evi', 're.codigo_resultado_evaluacion','=', 'evi.codigo_resultado_evaluacion');
        $query->join('core.opc_eval_pregunta as opc', 'opc.codigo_opc_eval_pregunta', '=', 'evi.valor_evaluacion_item');
        $query->where('asignacion_jurado.codigo_registro_fase_usuario', $id_register_phase_usuario);
        $query->orderBy('evi.codigo_item_evaluacion', 'asc');
        $data = $query->get();

		switch (RegistroSesion::getInstitutionSlug()) {
			case 'siinova':
				if ($id_evaluation == 29) //Evaluación datos básicos.
				{
					$answers = [];
					foreach ($data as $key => $value) {
						if ($value['codigo_item_evaluacion'] == 266) {
							$answers[266] = mb_convert_case($value['nombre_opc_eval_pregunta'], MB_CASE_TITLE, "UTF-8");
						}
					}
					return $answers;
				}
			break;
		}

		return $data;

    }
	/**
	 * Defining Relations
	*/

	public function usuario()
    {
        return $this->hasOne('App\Usuario','codigo_usuario','owner');
    }

    public function questions()
    {
        return $this->hasMany('App\ItemEvaluacionEmprendimiento','codigo_evaluacion_emprendimiento','codigo_evaluacion_emprendimiento');
    }
}
