<?php

namespace Custom;

use TuProyecto;

use Auth, Log, DB, URL, SendEmail;

use App\Usuario, App\Encuesta, App\ResultadoEvaluacionEmprendimiento, App\UsuarioInstitucion, App\RegistroConvocatoria, App\OrientacionConvocatoria, App\RegistroSesion, App\UsuarioEncuesta, App\RespuestaEncuesta, App\Entidad, App\Estado, App\Rol, App\ClaseEmprendimiento, App\DatoEntidad, App\PrivacidadContenido, App\OpcionPreguntaEncuesta, App\Tag, App\PreguntaEncuesta;

class Terpel
{
	public static $register = 31;

	public static $challenge = 120;

	public static $evaluation_terpel_20_first_moment = 25;

	public static $evaluation_terpel_20_second_moment = 26;

	public static $evaluation_terpel_20_three_moment = 27;

    public static function getClassEntrepreneurship($class) {
        switch ($class) :
            case 'entrepreneurship': return 3;
            default: return 'Not class identified';
        endswitch;
    }

   	/**
	 * Custom valid create survey apply.
	 *
 	 * @var Array request $request
 	 * @var Encuesta $survey data
	 */
	public static function validApplyChallenge(UsuarioEncuesta $userSurvey, $request)
	{
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
		// if(isset($request['pregunta_2152'])) {
		// 	$answer = RespuestaEncuesta::where('codigo_pregunta_encuesta', 2152)
		// 		->where('texto_respuesta_encuesta', $request['pregunta_2152'])
		// 		->where('codigo_usuario_encuesta', '!=', $userSurvey->codigo_usuario_encuesta)
		// 		->first();
		// 	if($answer instanceof RespuestaEncuesta) {
		// 		$response->success = false;
		// 		$response->data = "Ya se encuentra registrada una institución con este código DANE.";
		// 		return $response;
		// 	}
		// }

		if(isset($request['current_page']) && $request['current_page'] == 2) {
			// Validar maximo 1 tematicas por proyecto
			$query = OpcionPreguntaEncuesta::query();
			$query->select('opcion_encuesta.codigo_pregunta_encuesta', 'codigo_opcion_encuesta', 'texto_opcion_encuesta');
			$query->join('core.pregunta_encuesta', 'opcion_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
			$query->where('pregunta_encuesta.codigo_estado', Estado::getState('active'));
			$query->where('pregunta_encuesta.codigo_encuesta', $userSurvey->codigo_encuesta);
			$query->where('pregunta_encuesta.codigo_grupo_pregunta_encuesta', 313);
			$thematics = $query->get();

			$ctrThematics = 0;
			foreach ($thematics as $thematic) {
				if(isset($request["pregunta_{$thematic->codigo_pregunta_encuesta}_opcion_{$thematic->codigo_opcion_encuesta}"])) {
					$ctrThematics ++;
				}
			}			

			if($ctrThematics == 0) {
				$response->success = false;
				$response->data = "Seleccione una temática y/o subtemática abordar por el proyecto.";
				return $response;
			}

			if($ctrThematics > 1) {
				$response->success = false;
				$response->data = "No puede seleccionar más de una temática y/o subtemática abordar por el proyecto, por favor seleccione únicamente la principal.";
				return $response;
			}			

			RespuestaEncuesta::where('codigo_usuario_encuesta', $userSurvey->codigo_usuario_encuesta)->whereIn('codigo_pregunta_encuesta', [3293,3295,3297,3299,3300,3302,3304,3306,3307])->delete();
		}


		if(isset($request['current_page']) && $request['current_page'] == 5) {
			// Validar maximo 3 y minimo 1 ambito de cambio

			$query_spheres = OpcionPreguntaEncuesta::query();
			$query_spheres->select('opcion_encuesta.codigo_pregunta_encuesta', 'codigo_opcion_encuesta', 'texto_opcion_encuesta');
			$query_spheres->join('core.pregunta_encuesta', 'opcion_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
			$query_spheres->where('pregunta_encuesta.codigo_estado', Estado::getState('active'));
			$query_spheres->where('pregunta_encuesta.codigo_encuesta', $userSurvey->codigo_encuesta);
			$query_spheres->where('pregunta_encuesta.codigo_grupo_pregunta_encuesta', 318);
			$spheres = $query_spheres->get();

			$ctrSpheres = 0;

			foreach ($spheres as $sphere) {
				if(isset($request["pregunta_{$sphere->codigo_pregunta_encuesta}_opcion_{$sphere->codigo_opcion_encuesta}"])) {
					$ctrSpheres ++;
				}
			}			

			if($ctrSpheres != 3) {
				$response->success = false;
				$response->data = "Debe seleccionar 1 opción en cada ámbito.";
				return $response;
			}

			RespuestaEncuesta::where('codigo_usuario_encuesta', $userSurvey->codigo_usuario_encuesta)->whereIn('codigo_pregunta_encuesta', [3327,3337,3348])->delete();
		}
		return $response;
	}

	/**
	 * notification
	 * 
	 * Send notification email after complete the form to aply to challenge
	 * @var $job 
	 * @var string $parameters
	 */
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
			$data['_subject'] = trans('fundacionterpel.mail.program');
			$data['_template'] = 'emails.custom.fundacionterpel.program.notification';
			$data['_to'] = $user->correo_electronico;
			$data['_to_name'] = $user->nombre_usuario;
			$data['_inst'] = $parameters['codigo_institucion'];
            $data['program_name'] = $parameters['nombre_convocatoria'];
            $data['program_aplication_number'] = $program_aplication_number;
            $data['program_aplication_date'] = $program_aplication_date;
			$data['nombre_aplicante'] = $nombre_aplicante;

			SendEmail::notification($data);

			// Delete Job
			$job->delete();

		}catch(\Exception $e){
			Log::error(sprintf('%s:%s', 'Notification general', $e->getMessage()));
		}
	}

	public static function challenge(Usuario $user, UsuarioEncuesta $userSurvey)
	{
		$query = RespuestaEncuesta::query();
		$query->join('core.pregunta_encuesta', 'pregunta_encuesta.codigo_pregunta_encuesta', '=', 'respuesta_encuesta.codigo_pregunta_encuesta');
		$query->where('respuesta_encuesta.codigo_usuario_encuesta', $userSurvey->codigo_usuario_encuesta);
		$query->whereIn('respuesta_encuesta.codigo_pregunta_encuesta', [4005,4050,4051,4052,4054,4058,4094]);
		$query->orderBy('respuesta_encuesta.codigo_respuesta_encuesta', 'asc');
		$answers = $query->get();

		// Institucion
		$institution = $answers->where('codigo_pregunta_encuesta', 4005)->first();
		if(!is_null($institution) && $institution instanceof RespuestaEncuesta) {
			$user->cargo_entidad = $institution->texto_respuesta_encuesta;
		}

		// Info
		$html = '<dl>';
		foreach ($answers as $answer)
		{
			if(!in_array($answer->codigo_pregunta_encuesta, [3269])) {
				$html.= "<dt>{$answer->texto_pregunta_encuesta}</dt>";
				$html.= "<dd>{$answer->texto_respuesta_encuesta}</dd>";
			}
		}
		$html.= '</dl>';

		// Set aditional information
		$user->descripcion_adicional_usuario = $html;
		$user->save();
	}

	public static function calculateScore__Terpel_2020($register) {
		$query = ResultadoEvaluacionEmprendimiento::query();
        $query->select(DB::raw('SUM ( evaluacion_item_emprendimiento.puntaje_resul_eval_empren ) AS total'));
        $query->join('core.asignacion_jurado', 'asignacion_jurado.codigo_asignacion_jurado', '=', 'resultado_evaluacion_emprendimiento.codigo_asignacion_jurado');
        $query->join('core.evaluacion_item_emprendimiento', 'evaluacion_item_emprendimiento.codigo_resultado_evaluacion', '=', 'resultado_evaluacion_emprendimiento.codigo_resultado_evaluacion');
        $query->where('asignacion_jurado.codigo_registro_fase_usuario', '=', $register);

        return $query->first();
	}
}