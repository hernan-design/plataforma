<?php

namespace Custom;

use Illuminate\Support\Collection;
use TuProyecto;
use Auth, Log, DB, URL, App, AWS, SendEmail;
use GuzzleHttp\Client;
use App\Curso, App\Usuario, App\Entidad, App\RegistroSesion;

class Propace
{
    public static $firstSurveyCourse = 125;
	public static $surveySelectedCourses = 166;
	public static $surveySelectExcept = [129, 133, 135, 136, 137, 139, 159, 160, 156, 166];

    public static function sendMailFirstSurveyCourse($score, $user, $survey) {

        $user = Usuario::find($user);
        if(!$user instanceof Usuario) {
            abort(403);
        }

        // Mail notification
        // $data = [];
        // $data['_subject'] = 'Puntaje obtenido';
        // $data['_template'] = 'emails.custom.propace.notification-score';
        // $data['_to'] = $user->correo_electronico;
        // $data['_to_name'] = $user->nombre_usuario;
        // $data['_inst'] = RegistroSesion::getInstitution();
        // $data['_survey'] = $survey;
        // $data['_score'] = $score;

        // SendEmail::notification($data);
    }

	public static function notificationSelectedCourses($score, $user, $survey) {

        $user = Usuario::find($user);
        if(!$user instanceof Usuario) {
            abort(403);
        }

        // Mail notification
        $data = [];
        $data['_subject'] = 'Puntaje obtenido';
        $data['_template'] = 'emails.custom.propace.notification-selected-courses';
        $data['_to'] = $user->correo_electronico;
        $data['_to_name'] = $user->nombre_usuario;
        $data['_inst'] = RegistroSesion::getInstitution();
        $data['_survey'] = $survey;
        $data['_score'] = $score;

        SendEmail::notification($data);
    }

    public static function verifyaccount(Usuario $user)
	{
		$response = new \stdClass();
		$response->success = true;
		$response->message = null;
		$response->button = null;
		$response->link = null;

		try {
			// Evaluate status
			$response->message = "¡Te damos nuevamente una cordial bienvenida!<br><br>Registrate en PROPACE para acceder a este y otros beneficios de nuestra red. Déjanos tus datos y te contactaremos para ayudarte.";
			$response->link = "http://propace.org/";
			$response->text = "Registrate Aquí";

		}catch(\Exception $e) {
			Log::error(sprintf('%s:%s', 'Propace verifyaccount', $e->getMessage()));

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
