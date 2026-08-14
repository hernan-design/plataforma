<?php

namespace Custom;

use Auth, Log, DB, URL, SendEmail, Lang;

use App\Encuesta, App\RespuestaEncuesta, App\Usuario, App\Convocatoria;

class RedBavaria
{
	public static $abierta = 48;
	public static $climatica = 50;
	public static $transicion = 51;
	public static $mujer = 52;
	public static $reto = 53;

   	/**
	 * Custom actions insert apply.
	 *
 	 * @var Array request $request
 	 * @var Encuesta $survey data
	 */
	public static function apply(Encuesta $survey, $request)
	{
		$response = new \stdClass();
		$response->success = true;

		// Valid survey
		$query = RespuestaEncuesta::query();
		$query->whereIn('respuesta_encuesta.codigo_pregunta_encuesta', [1417, 1458, 1415, 1414, 1408]);
		switch ($survey->codigo_encuesta) {
			case RedBavaria::$abierta:
				$query->where('respuesta_encuesta.texto_respuesta_encuesta', $request['pregunta_1417']);
			break;
			case RedBavaria::$climatica:
				$query->where('respuesta_encuesta.texto_respuesta_encuesta', $request['pregunta_1458']);
			break;
			case RedBavaria::$transicion:
				$query->where('respuesta_encuesta.texto_respuesta_encuesta', $request['pregunta_1415']);
			break;
			case RedBavaria::$mujer:
				$query->where('respuesta_encuesta.texto_respuesta_encuesta', $request['pregunta_1414']);
			break;
			case RedBavaria::$reto:
				$query->where('respuesta_encuesta.texto_respuesta_encuesta', $request['pregunta_1408']);
			break;
		}
		$answer = $query->first();

		if($answer instanceof RespuestaEncuesta) {
			$response->success = false;
			$response->data = 'Ya se encuentra registrado un emprendimiento asociado a este numero de identificación. Recuerda que solo se puede aplicar a una categoría por persona o por emprendimiento.';
		}
		return $response;
	}

   	/**
	 * Custom actions send mail challenge.
	 *
	 */
   	public function notification($job, $parameters)
   	{
   		try {
   			// Data User
   			$query = Usuario::query();
			$query->select('owner.nombre_usuario as nombre_usuario', 'owner.correo_electronico as correo_electronico', 'usuario.nombre_usuario as nombre_entidad', 'nombre_clase_emprendimiento', 'clase_emprendimiento.codigo_clase_emprendimiento as codigo_clase_emprendimiento');

			$query->join('core.entidad', 'usuario.codigo_usuario', '=', 'entidad.codigo_usuario');
			$query->join('core.clase_emprendimiento_insti', 'entidad.codigo_clase_empre_insti', '=', 'clase_emprendimiento_insti.codigo_clase_empre_insti');
			$query->join('core.clase_emprendimiento', 'clase_emprendimiento_insti.codigo_clase_emprendimiento', '=', 'clase_emprendimiento.codigo_clase_emprendimiento');
			$query->join('seguridad.usuario as owner', 'entidad.seg_codigo_usuario', '=', 'owner.codigo_usuario');

			$query->where('usuario.codigo_usuario', $parameters['codigo_usuario']);
			$user = $query->first();

   			// Program
   			$program = Convocatoria::find($parameters['codigo_convocatoria']);

			// Mail notification
			$data = [];
			$data['_subject'] = Lang::get('redemprendedoresbavaria.mail.subject');
	        $data['_template'] = 'emails.custom.reb.notification';
			$data['_to'] = $user->correo_electronico;
			$data['_to_name'] = $user->nombre_usuario;
			$data['_inst'] = $parameters['codigo_institucion'];

			$data['_program'] = $program->nombre_convocatoria;
			$data['_project'] = sprintf('%s %s (%s)', ($user->codigo_clase_emprendimiento == 2 ? 'con el' : 'con la'), strtolower($user->nombre_clase_emprendimiento), $user->nombre_entidad);
			SendEmail::notification($data);

			// Delete Job
			$job->delete();

		}catch(\Exception $e){
			Log::error(sprintf('%s:%s', 'RedBavaria notification', $e->getMessage()));
        }
	}
}
