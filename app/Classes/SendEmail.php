<?php

namespace App\Classes;

use Illuminate\Support\Facades\Mail;

use App\Institucion, App\RegistroSesion;

class SendEmail {

    /**
	 * Prepare and send email using SQS.
	 *
	 * @param data $array
     * @throws \Exception if _template is empty
     * @throws \Exception if _subject is empty
     * @throws \Exception if _to is empty
     * @throws \Exception if institution is not defined
	 */
    public static function notification($data)
    {
		// Validate params mail
		if(!isset($data['_template']) || trim($data['_template']) == '') {
			throw new \Exception('SendEmail Can not be empty _template');
		}

		if(!isset($data['_subject']) || trim($data['_subject']) == '') {
			throw new \Exception('SendEmail Can not be empty _subject');
		}

		if(!isset($data['_to']) || trim($data['_to']) == '') {
			throw new \Exception('SendEmail Can not be empty _to');
		}
        
		// Prepare data institution
		$institution = Institucion::find(RegistroSesion::getInstitution());
		if(!$institution instanceof Institucion) {
			if(isset($data['_inst']) && trim($data['_inst']) != '') {
				$institution = Institucion::find($data['_inst']);
			}
		}

		if(!$institution instanceof Institucion) {
			throw new \Exception('SendEmail Can not be undefined institution');
		}

		$data['_inst_color'] = Institucion::getColor($institution->codigo_institucion);
        $data['_inst_name'] = $institution->nombre_institucion;
        $data['_inst_slug'] = $institution->slug_institucion;
		$data['_inst_img'] =  $institution->imagen_notificacion_mail ?: $institution->logo_institucion;

		// Meta tags
		$meta_tags = Institucion::getMetaTags($institution->codigo_institucion);
		$inst_url = $institution->url_institucion ? $institution->url_institucion : config('tuproyecto.url');
		// En entorno local usar APP_URL para que los links apunten a localhost
		$data['_inst_url'] = app()->isLocal() ? config('app.url') : $inst_url;

		Mail::send($data['_template'], $data, function($message) use($data, $institution) {
 			$message->from(($institution->correo_envio_notificaciones ? $institution->correo_envio_notificaciones : config('tuproyecto.noreply')), $data['_inst_name']);
 			$message->subject($data['_subject']);
        	$message->to($data['_to'], isset($data['_to_name']) ? $data['_to_name'] : null);
		});
	}

}
