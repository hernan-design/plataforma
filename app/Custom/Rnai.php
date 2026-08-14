<?php

namespace Custom;

use TuProyecto;

use Auth, Log, DB, URL;

use App\Encuesta, App\Usuario, App\UsuarioEncuesta;

class Rnai
{
	public static $register = 46;

   	/**
	 * Custom actions insert register rnai.
	 *
 	 * @var Array request $request
 	 * @var Encuesta $survey data
	 */
	public static function register(Encuesta $survey, $request)
	{
		// prepare data user
		$data = [];
		$data['correo_electronico'] =  isset($request['pregunta_1170']) ? trim($request['pregunta_1170']) :'';
		$data['nombre_usuario'] =  isset($request['pregunta_1166']) ? trim($request['pregunta_1166']) :'';
		$data['primer_apellido_persona'] =  isset($request['pregunta_1167']) ? trim($request['pregunta_1167']) :'';

		$user = Usuario::getUserMail($data['correo_electronico']);
		if($user instanceof Usuario) {
			$userSurvey = UsuarioEncuesta::where('codigo_encuesta', '=', $survey->codigo_encuesta)->where('codigo_usuario', '=', $user->codigo_usuario)->first();
			if($userSurvey instanceof UsuarioEncuesta) {
				return "Ya se encuentra registrado un emprendedor con este correo electrónico.";
			}
		}else{
			$user = Usuario::store($data);
		}
		return $user;

	}
}
