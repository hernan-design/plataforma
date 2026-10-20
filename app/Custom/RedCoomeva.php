<?php

namespace Custom;

// use Artisaninweb\SoapWrapper\SoapWrapper;

use TuProyecto, SendEmail, Log, AWS;

use App\Usuario, App\Institucion, App\Curso;

class RedCoomeva
{
	public static function soapConsultarAsociadoVida(Usuario $user, $soapWrapper = null)
	{
		$context = stream_context_create([
			// set some SSL/TLS specific options
			'ssl' => [
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			]
		]);
		$soapWrapper->add('RedCoomeva', function ($service) use($context) {
			$service->wsdl('https://secure.coomeva.com.co/WsAsociado/services/datosAsociadoVida?wsdl')
			->options([ 'stream_context' => $context ]);
		});

		// Without classmap
		$response = $soapWrapper->call('RedCoomeva.consultarAsociadoVida', [
			// 'identificacion' => '31264675',
			// 'identificacion' => '94412240',
			// 'identificacion' => '1023878024',
			'identificacion' => $user->identificacion_usuario,
			'tipDocumento' => $user->tipo_identificacion_usuario
		]);
	
		return $response;
	}

   	/**
	 * Custom actions register user.
	 */
	public static function register(Usuario $user, $soapWrapper = null)
	{
		// Usuario institucion
		$userinstitution = $user->institucion;

		// Estados suministrador por redcoomeva
		$response = self::soapConsultarAsociadoVida($user, $soapWrapper);
		if($response->codRetornoWS) {
			$userinstitution->usuario_asociado = true;
			$userinstitution->save();
		}

		return 'OK';
	}

	/**
	 * Verify account.
	 */
	public static function verifyaccount(Usuario $user, $soapWrapper = null)
	{
		$response = new \stdClass();
		$response->success = true;
		$response->message = null;
		$response->button = null;
		$response->link = null;

		try {
			// Evaluate status
			$soapResponse = self::soapConsultarAsociadoVida($user, $soapWrapper);
			if($soapResponse->codRetornoWS) {
				if(isset($soapResponse->estado) && in_array($soapResponse->estado, [10, 11])) {
					if( (!isset($soapResponse->email) || empty($soapResponse->email)) && (!isset($soapResponse->celular) ||empty($soapResponse->celular))  ) {
						$response->message = "No hemos podido consultar tu información, por favor comunicarse a cualquiera de los siguientes números de Coomeva para su actualización: 018000950123, 3330000 o al #464 digitando la tecla #1.";
						return $response; 
					}

					$response->button = "REENVIAR MENSAJE DE CONFIRMACIÓN";
					$message = "Se ha enviado un mensaje";
					if(isset($soapResponse->email) && !empty($soapResponse->email)) {
						$message .= " a la siguiente dirección de correo electrónico <b>".strtolower($soapResponse->email)."</b>";

						// Mail verification
						$data = [];
						$data['_subject'] = 'Verificación cuenta';
						$data['_template'] = 'emails.custom.redcoo.verification';
						$data['_to'] = strtolower($soapResponse->email);
						$data['_to_name'] = $user->nombre_usuario;

						$data['_url_action'] = route('verify.account.mail', ['email' => TuProyecto::encryptSrcParams([$user->codigo_usuario])]);
						SendEmail::notification($data);
					}

					// SMS verification
					if(isset($soapResponse->email) && isset($soapResponse->celular) && !empty($soapResponse->celular)) {
						$sns = AWS::createClient('sns');
				        $args = [
				            "SenderID" => 'RedCoomeva',
                            "SMSType" => 'Transactional',
                            "Message" => "Hemos registrado tu solicitud, enviamos un correo electrónico a {$soapResponse->email} para continuar con el proceso.",
				            "PhoneNumber" => "+57 {$soapResponse->celular}"
				        ];
				        $sns->publish($args);
				        if(isset($soapResponse->email) && !empty($soapResponse->email)) {
				        	$message .= " y";
				        }
				        $message .= " al número celular <b>{$soapResponse->celular}</b>";
					}
					$message .= ", si estos datos no son correctos por favor comunicarse a cualquiera de los siguientes números de Coomeva para su actualización: 018000950123, 3330000 o al #464 digitando la tecla #1.";
					$response->message = $message;
					
				}else{
					$response->message = "¡Te damos nuevamente una cordial bienvenida!<br>Actívate como asociado para acceder a este y otros beneficios de nuestra red. Déjanos tus datos y te contactaremos para ayudarte.";
					$response->link = "https://secure.coomeva.com.co/digautogestion/vinculacion/";
				}
			}else{
				$response->message = "Para verificar tu cuenta te invitamos a compartirnos tus datos para que un asesor te contacte y puedas aprovechar este y otros beneficios.";
				$response->link = "https://secure.coomeva.com.co/digautogestion/vinculacion/";
			}
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
	 * Custom actions verify acount.
	 */
	public static function verify(Usuario $user) {
		$user->attachRole(39);
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

		if( $user->hasRole('asociado') ){
			$response->success = true;
		}
		
		return $response;
	}
}