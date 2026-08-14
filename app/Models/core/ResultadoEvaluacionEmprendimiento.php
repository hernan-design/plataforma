<?php

namespace App;

use App\Custom\Compensar, Custom\Terpel;
use App\Usuario, App\PuntajeRegistroFase;
use Illuminate\Database\Eloquent\Model,
	Illuminate\Http\Request;

use Validator, SendEmail;

use Custom\Innpulsa,
	App\Custom\Rutan;

//use App\ResultadoEvaluacionEmprendimiento;

class ResultadoEvaluacionEmprendimiento extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.resultado_evaluacion_emprendimiento';

	protected $primaryKey = 'codigo_resultado_evaluacion';

	public $timestamps = false;

	public function isValid($data)
	{
		$rules = array(
			// 'comentario_resultado_evaluacion' => 'required|string'
		);

		$validator = Validator::make($data, $rules);
		if ($validator->passes()) {
			return true;
		}
		$this->errors = $validator->errors();
		return false;
	}

	/**
	 * Callback response resource.
	 */
	public function callback(RegistroFaseUsuario $register, $code_evaluation = null)
	{
		// Validate code evaluation
		if ($code_evaluation == Compensar::$evaluation) {
			$user = Usuario::find($register->codigo_usuario);
			if (!$user instanceof Usuario) {
				abort(404);
			}

			$city = Ciudad::find($user->codigo_ciudad);
			if (!$city instanceof Ciudad) {
				abort(404);
			}

			if ($city->codigo_ciudad != Compensar::$city) {
				$register->codigo_estado = Estado::getState('rejected');
			}
		}

		// Calculate score survey
		$this->puntaje_total_eval_emprendi = $this->calculateScore($register);
		$this->save();

		// Calculate total keys
		$register->valor_asignacion_rfu = $this->calculateKeyassignment($register);
		$register->save();
	}

	public function calculateScore(RegistroFaseUsuario $register)
	{

		$score = 0;
		switch ($this->codigo_evaluacion_emprendimiento) {
			case Innpulsa::$evaluation_challenge_1_2:
				$score = Innpulsa::scoreChallenge_1_2($register);
                break;
            case Innpulsa::$evaluation_challenge_empodera_1_2:
                $score = Innpulsa::scoreChallengeEmpodera_1_2($register);
				break;
			case Innpulsa::$evaluation_challenge_2:
				$score = Innpulsa::scoreChallenge_2($register);
				break;
			case Innpulsa::$evaluaction_empodera_2020:
				$score = Innpulsa::scoreEvaluationEmpodera2020($register);
				break;
			case Innpulsa::$evaluation_aldea_20:
				$score = Innpulsa::scoreEvaluationAldea20($register);
				if ($score > 0) {
					$register->codigo_estado = Estado::getState('forward');
					$register->visualizacion_usuario = true;
					$register->notificacion_cambio_registro_fase = date('Y-m-d H:m:s');
					$register->notificacion_registro_fase_usuario = true;
					$register->seg_codigo_usuario = 45352;
					$register->save();

					$registerPhase = new RegistroFaseUsuario();
					$registerPhase->codigo_fase = Fase::getIdPhase('moment_3__Aldea20');
					$registerPhase->codigo_estado = Estado::getState('active');
					$registerPhase->codigo_usuario = $register->codigo_usuario;
					$registerPhase->fecha_registro_fase_usuario = date('Y-m-d');
					$registerPhase->hora_registro_fase_usuario = date('H:i:s');
					$registerPhase->codigo_registro_convocatoria = $register->codigo_registro_convocatoria;
					$registerPhase->notificacion_registro_fase_usuario = false;
					$registerPhase->visualizacion_usuario = false;
					$registerPhase->save();
				} else {
					$register->codigo_estado = Estado::getState('rejected');
					$register->visualizacion_usuario = true;
					$register->notificacion_cambio_registro_fase = date('Y-m-d H:m:s');
					$register->notificacion_registro_fase_usuario = true;
					$register->seg_codigo_usuario = 45352;
					$register->save();

					//Se apaga correo de rechazo en reto 1.2 aldea 2.0
					\Log::info('se apaga correo emails.evaluation.returned-aldea20');
					/* $data_user = self::getEntityOwner($register->codigo_usuario);
					$data = [];
					$data['_template'] = 'emails.evaluation.returned-aldea20';
					$data['_inst'] = 51;
					$data['_subject'] = 'Resultados de evaluación';
					$data['_to'] = $data_user->correo_electronico;
					$data['_emprendimiento'] = $data_user->emprendimiento;
					$data['_fecha_aplicacion'] = date("Y-m-d",strtotime($data_user->fecha_registro_convocatoria."+ 180 days"));
					$data['_to_name'] = ucwords(strtolower($data_user->nombre_usuario));
					SendEmail::notification($data); */
				}

			break;
			case Innpulsa::$evaluation_aldea_20_moment_3:
				$score = round(EvaluacionItemEmprendimiento::where('codigo_resultado_evaluacion', $this->codigo_resultado_evaluacion)->avg('puntaje_resul_eval_empren'), 1);
				$total_score = Innpulsa::getScoring__Aldea20__Moment__Three($register);

				$scoreRegisterPhase = PuntajeRegistroFase::where('codigo_registro_fase_usuario', '=', $register->codigo_registro_fase_usuario)->first();
				if($scoreRegisterPhase instanceof PuntajeRegistroFase) {
					$scoreRegisterPhase->codigo_registro_fase_usuario = $register->codigo_registro_fase_usuario;
					$scoreRegisterPhase->codigo_estado = Estado::getState('active');
					$scoreRegisterPhase->valor_puntaje_registro_fase = $total_score;
					$scoreRegisterPhase->save();
				} else {
					$newScoreRegisterPhase = new PuntajeRegistroFase();
					$newScoreRegisterPhase->codigo_registro_fase_usuario = $register->codigo_registro_fase_usuario;
					$newScoreRegisterPhase->codigo_estado = Estado::getState('active');
					$newScoreRegisterPhase->valor_puntaje_registro_fase = $total_score;
					$newScoreRegisterPhase->save();
				}
			break;
			case Innpulsa::$evaluation_aldea_20_moment_4:
				$register = RegistroFaseUsuario::getRegisterPhase($register->codigo_registro_fase_usuario);
				$scoring = Innpulsa::getScoring__Aldea20__Moment__Four($register);
			break;
			case Terpel::$evaluation_terpel_20_first_moment:
				$scoring = Terpel::calculateScore__Terpel_2020($register->codigo_registro_fase_usuario);

				$registerScore = PuntajeRegistroFase::where('codigo_registro_fase_usuario', $register->codigo_registro_fase_usuario)->first();
				if($registerScore instanceof PuntajeRegistroFase) {
					$registerScore->valor_puntaje_registro_fase = (double)$scoring->total;
					$registerScore->codigo_estado = Estado::getState('active');
					$registerScore->codigo_registro_fase_usuario = $register->codigo_registro_fase_usuario;
					$registerScore->save();
				} else {
					$newRegisterScore = new PuntajeRegistroFase();
					$newRegisterScore->codigo_estado = Estado::getState('active');
					$newRegisterScore->codigo_registro_fase_usuario = $register->codigo_registro_fase_usuario;
					$newRegisterScore->valor_puntaje_registro_fase = (double)$scoring->total;
					$newRegisterScore->save();
				}
			break;
			case Terpel::$evaluation_terpel_20_second_moment:
				$scoring = Terpel::calculateScore__Terpel_2020($register->codigo_registro_fase_usuario);

				$registerScore = PuntajeRegistroFase::where('codigo_registro_fase_usuario', $register->codigo_registro_fase_usuario)->first();
				if($registerScore instanceof PuntajeRegistroFase) {
					$registerScore->valor_puntaje_registro_fase = (double)$scoring->total;
					$registerScore->codigo_estado = Estado::getState('active');
					$registerScore->codigo_registro_fase_usuario = $register->codigo_registro_fase_usuario;
					$registerScore->save();
				} else {
					$newRegisterScore = new PuntajeRegistroFase();
					$newRegisterScore->codigo_estado = Estado::getState('active');
					$newRegisterScore->codigo_registro_fase_usuario = $register->codigo_registro_fase_usuario;
					$newRegisterScore->valor_puntaje_registro_fase = (double)$scoring->total;
					$newRegisterScore->save();
				}
			break;
			case Terpel::$evaluation_terpel_20_three_moment:
				$scoring = Terpel::calculateScore__Terpel_2020($register->codigo_registro_fase_usuario);

				$registerScore = PuntajeRegistroFase::where('codigo_registro_fase_usuario', $register->codigo_registro_fase_usuario)->first();
				if($registerScore instanceof PuntajeRegistroFase) {
					$registerScore->valor_puntaje_registro_fase = (double)$scoring->total;
					$registerScore->codigo_estado = Estado::getState('active');
					$registerScore->codigo_registro_fase_usuario = $register->codigo_registro_fase_usuario;
					$registerScore->save();
				} else {
					$newRegisterScore = new PuntajeRegistroFase();
					$newRegisterScore->codigo_estado = Estado::getState('active');
					$newRegisterScore->codigo_registro_fase_usuario = $register->codigo_registro_fase_usuario;
					$newRegisterScore->valor_puntaje_registro_fase = (double)$scoring->total;
					$newRegisterScore->save();
				}
			break;
			default:
				$score = round(EvaluacionItemEmprendimiento::where('codigo_resultado_evaluacion', $this->codigo_resultado_evaluacion)->avg('puntaje_resul_eval_empren'), 1);
			break;
		}
		return $score;
	}

	public static function getEntityOwner($user) {
		$query = Usuario::query();
		$query->select('usuario.nombre_usuario', 'usuario.correo_electronico', 'user_e.nombre_usuario as emprendimiento', 'registro_convocatoria.fecha_registro_convocatoria');
		$query->join('core.entidad', 'entidad.seg_codigo_usuario', '=', 'usuario.codigo_usuario');
		$query->leftJoin('seguridad.usuario as user_e', 'user_e.codigo_usuario', '=', 'entidad.codigo_usuario');
		$query->leftJoin('core.registro_convocatoria', 'registro_convocatoria.codigo_usuario', '=', 'user_e.codigo_usuario');
		$query->where('entidad.codigo_usuario', '=', $user);

		return $query->first();
	}

	public function calculateKeyassignment(RegistroFaseUsuario $register)
	{
		$keys = 0;
		if(in_array($this->codigo_evaluacion_emprendimiento, [Innpulsa::$evaluation_challenge_2])) {
			$keys = Innpulsa::keysChallenge_2($register);
		} else if(in_array($this->codigo_evaluacion_emprendimiento, [Innpulsa::$evaluation_aldea_20_moment_4])) {
			$keys = Innpulsa::keysMomentFour__Aldea20($register);
		}
		return $keys;
	}

	/**
	 * envia notificaciones al evaluar emprendimiento
	 */
	public static function sendNotificationsOfEvaluation($data, Usuario $user_project, $codigo_registro_convocatoria)
	{
		switch ($data['codigo_evaluacion_emprendimiento']) {
			case Rutan::$codigo_evaluacion_emprendimiento_rutan: //codigo_evaluacion_emprendimiento 28
				Rutan::notificationsOfEvaluation(Rutan::$codigo_evaluacion_emprendimiento_rutan, $data, $user_project, $codigo_registro_convocatoria);
				break;
			default:
				return;
		}
	}
	   /**
     * Obtiene puntaje para el diagnóstico por grupo de preguntas.
	 *
     * @access public
	 * @static function
     * @param int $id_answer_evaluation, $id_group
     * @return object|boolean $answers|false
     */
    public static function getScoring($id_answer_evaluation, $id_group)
    {
        if ( !is_null($id_answer_evaluation) ) {

            $query = ResultadoEvaluacionEmprendimiento::query();
            $query->select('resultado_evaluacion_emprendimiento.codigo_resultado_evaluacion',
                'opc_eval_pregunta.nombre_opc_eval_pregunta as respuesta', 'grup_opc_eval_pregunta.nombre_grup_opc_eval_pregunta',
                'opc_eval_pregunta.valor_opc_eval_pregunta as puntaje', 'item_evaluacion_emprendimiento.codigo_item_evaluacion',
                'item_evaluacion_emprendimiento.codigo_grupo_item_eval',
                'resultado_evaluacion_emprendimiento.comentario_resultado_evaluacion as observacion',
				'evaluacion_item_emprendimiento.comentario_adicional'
            );
            $query->leftJoin('core.evaluacion_item_emprendimiento', 'evaluacion_item_emprendimiento.codigo_resultado_evaluacion', '=', 'resultado_evaluacion_emprendimiento.codigo_resultado_evaluacion');
            $query->leftJoin('core.item_evaluacion_emprendimiento', 'item_evaluacion_emprendimiento.codigo_item_evaluacion', '=', 'evaluacion_item_emprendimiento.codigo_item_evaluacion');
            $query->leftJoin('core.opc_eval_pregunta', 'opc_eval_pregunta.codigo_opc_eval_pregunta', '=', 'evaluacion_item_emprendimiento.valor_evaluacion_item');
            $query->leftJoin('core.grup_opc_eval_pregunta', 'grup_opc_eval_pregunta.codigo_grup_opc_eval_pregunta', '=', 'item_evaluacion_emprendimiento.codigo_grup_opc_eval_pregunta');
            $query->where('resultado_evaluacion_emprendimiento.codigo_resultado_evaluacion', $id_answer_evaluation);
            $query->whereIn('item_evaluacion_emprendimiento.codigo_grupo_item_eval', $id_group);
            $query->orderBy('item_evaluacion_emprendimiento.codigo_item_evaluacion','ASC');
            $answers = $query->get();

            return $answers;
        } else {
            return false;
        }
	}
}
