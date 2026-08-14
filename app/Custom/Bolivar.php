<?php


namespace App\Custom;


use App\Entidad, App\Usuario, App\UsuarioEncuesta, App\OpcionPreguntaEncuesta, App\Estado;

use SendEmail;

class Bolivar
{
	public static $survey_emprende_2020 = 110;
	public static $survey_diagnostic_emprende_2020 = 117;
	public static $survey_diagnostic_emprende_santander_2020 = 118;
	public static $survey_diagnostic_emprende_magdalena_2020 = 119;

	public static function sendMailEndApplication($user) {

		$entity = Entidad::where('codigo_usuario', '=', $user->codigo_usuario)->first();
		$userCreator = Usuario::find($entity->seg_codigo_usuario);

		// Send notification
		$data = [];
		$data['_template'] = 'emails.user.callregister';
		$data['_inst'] = 38;
		$data['_subject'] = ' ¡Gracias por inscribirte a Emprende País!';
		$data['_to'] = $userCreator->correo_electronico;
		$data['_to_name'] = ucwords(strtolower($userCreator->nombre_usuario));

		SendEmail::notification($data);
	}

	public static function validApplyAutodiagnostic(UsuarioEncuesta $userSurvey, $request)
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
			// $query->where('pregunta_encuesta.codigo_grupo_pregunta_encuesta', 290);
			$query->whereIn('pregunta_encuesta.codigo_pregunta_encuesta', [3815,3899,3970]);
			$areas = $query->get();

			$ctrAreas = 0;
			foreach ($areas as $area) {
				if(isset($request["pregunta_{$area->codigo_pregunta_encuesta}_opcion_{$area->codigo_opcion_encuesta}"])) {
					$ctrAreas ++;
				}
			}			

			if($ctrAreas == 0) {
				$response->success = false;
				$response->data = "Seleccione dos áreas que usted lidera (pregunta 29).";
				return $response;
			}

			if($ctrAreas != 2) {
				$response->success = false;
				$response->data = "Debe seleccionar dos áreas que usted lidera, por favor seleccione dos opciones en la pregunta 29.";
				return $response;
			}			
		}

		if(isset($request['current_page']) && $request['current_page'] == 2) {
			// Validar maximo 1 tematicas por proyecto
			$query = OpcionPreguntaEncuesta::query();
			$query->select('opcion_encuesta.codigo_pregunta_encuesta', 'codigo_opcion_encuesta', 'texto_opcion_encuesta');
			$query->join('core.pregunta_encuesta', 'opcion_encuesta.codigo_pregunta_encuesta', '=', 'pregunta_encuesta.codigo_pregunta_encuesta');
			$query->where('pregunta_encuesta.codigo_estado', Estado::getState('active'));
			$query->where('pregunta_encuesta.codigo_encuesta', $userSurvey->codigo_encuesta);
			// $query->where('pregunta_encuesta.codigo_grupo_pregunta_encuesta', 290);
			$query->whereIn('pregunta_encuesta.codigo_pregunta_encuesta', [3817,3897,3968]);
			$debiles = $query->get();

			$ctrDebiles = 0;
			foreach ($debiles as $debil) {
				if(isset($request["pregunta_{$debil->codigo_pregunta_encuesta}_opcion_{$debil->codigo_opcion_encuesta}"])) {
					$ctrDebiles ++;
				}
			}			

			if($ctrDebiles == 0) {
				$response->success = false;
				$response->data = "Seleccione dos áreas de la empresa usted se siente más débil (pregunta 30).";
				return $response;
			}

			if($ctrDebiles != 2) {
				$response->success = false;
				$response->data = "Debe seleccionar dos áreas de la empresa usted se siente más débil, por favor seleccione dos opciones en la pregunta 30.";
				return $response;
			}			
		}
		
		return $response;
	}

}
