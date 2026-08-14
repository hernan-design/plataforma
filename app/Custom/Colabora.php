<?php

namespace App\Custom;

use Illuminate\Support\Collection;
use TuProyecto;
use Auth, Log, DB, URL, App, AWS;
use GuzzleHttp\Client;
use App\Curso, App\Usuario, App\Entidad;

class Colabora
{
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
			$response->message = "¡Te damos nuevamente una cordial bienvenida!<br><br>Registrate en COLABORA para acceder a este y otros beneficios de nuestra red. Déjanos tus datos y te contactaremos para ayudarte.";
			$response->link = "https://colaborainnovacion.compensar.com/";
			$response->text = "Registrate Aquí";

		}catch(\Exception $e) {
			Log::error(sprintf('%s:%s', 'Colabora verifyaccount', $e->getMessage()));

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