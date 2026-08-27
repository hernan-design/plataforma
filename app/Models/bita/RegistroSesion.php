<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

use App\Voucher,
	App\TipoPagoInstitucion,
	App\Models\core\MensajeInstitucion,
	App\Custom\Rutan;

use Session, Cookie, Config, Auth, Cache, Log, DB;

class RegistroSesion extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'bita.sessions';

	// Cookies prepare
	public static function dataPrepare(Institucion $institution)
	{
		// Cookies prepare
		if(!Cookie::has('_inst_slug') || Cookie::get('_inst_slug') != $institution->slug_institucion) {
			Cookie::queue(Cookie::forever('_inst_key', $institution->codigo_institucion));
			Cookie::queue(Cookie::forever('_inst_url', $institution->url_institucion));
			Cookie::queue(Cookie::forever('_inst_privacy', $institution->privacidad_institucion));
			Cookie::queue(Cookie::forever('_inst_slug', $institution->slug_institucion));
			Cookie::queue(Cookie::forever('_inst_name', $institution->nombre_institucion));
			Cookie::queue(Cookie::forever('_inst_img', $institution->logo_institucion));
			Cookie::queue(Cookie::forever('_inst_url_homepage', $institution->url_homepage));

			// Social Links
			$social_links = Institucion::getSocialLinks($institution->codigo_institucion);
			Cookie::queue(Cookie::forever('_inst_facebook', isset($social_links->facebook) ? $social_links->facebook : Config::get('tuproyecto.social_facebook')));
			Cookie::queue(Cookie::forever('_inst_twitter', isset($social_links->twitter) ? $social_links->twitter : Config::get('tuproyecto.social_twitter')));
			Cookie::queue(Cookie::forever('_inst_youtube', isset($social_links->youtube) ? $social_links->youtube : Config::get('tuproyecto.social_youtube')));
		}

		// Auth user used Broadcast events
		if(Auth::check()) {
			Cookie::queue(Cookie::forever('_inst_id', $institution->codigo_institucion));
            Cookie::queue(Cookie::forever('_user_id', Auth::user()->codigo_usuario));
		}

		// Type Payment
		$type_payment = TipoPagoInstitucion::getTypePaymentInstitution($institution->codigo_institucion);

		if ($type_payment instanceof TipoPagoInstitucion) {
			Cookie::queue(Cookie::forever('_inst_coin', $type_payment->coin));
		}

		// Session prepare
		Session::put('_inst_key', $institution->codigo_institucion);
		Session::put('_inst_privacy', $institution->privacidad_institucion);
		Session::put('_inst_confirm_email', $institution->validacion_correo);
		Session::put('_inst_init_state', $institution->codigo_estado_inicial);
		Session::put('_inst_slug', $institution->slug_institucion);
		Session::put('_inst_name', $institution->nombre_institucion);
		Session::put('_inst_img', $institution->logo_institucion);
        Session::put('_inst_home', $institution->home);
		Session::put('_inst_url', $institution->url_institucion);
        Session::put('_inst_community_root', $institution->raiz_comunidad);
        Session::put('_inst_helpdesk', $institution->url_helpdesk_institucion);
        Session::put('_inst_recaptcha_key', $institution->clave_sitio_captcha ?: config('tuproyecto.grecatcha_api_key'));
		Session::put('_inst_voucher_encuesta_general', self::voucherGeneralEvaluation($institution->codigo_institucion) ?: NULL );
		Session::put('_inst_validate_identification', $institution->validacion_identificacion);
		Session::put('_inst_evaluation_temp', null);
		Session::put('_inst_url_homepage', $institution->url_homepage);

        Session::put('_google_analytics', $institution->google_analytics);
		Session::put('_login_social', $institution->login_social);
		Session::put('_votacion_entidad', $institution->votacion_entidades);
		Session::put('_fecha_cierre_votaciones', $institution->fecha_cierre_votaciones);

		//mensaje institucion
		$mensaje = MensajeInstitucion::select('texto', 'codigo_estado')
										->where('codigo_institucion', $institution->codigo_institucion)
										->first();

		if (isset($institution->id_facebook_pixel)) {
			Session::put('_id_facebook_pixel', $institution->id_facebook_pixel);
		}

		if (isset($institution->id_tag_manager)) {
			Session::put('_id_tag_manager', $institution->id_tag_manager);
		}

		if (isset($mensaje) && $mensaje->codigo_estado == Estado::getState('active')) {
			$mostrar = false;
			if (Auth::check()) {
				switch ($institution->codigo_institucion) {
					case 61:
						$mostrar = Rutan::validateApplication();
						break;
				}

				if ($mostrar) Session::put('_message_institution', $mensaje->texto);

			}
		}

		if ($type_payment instanceof TipoPagoInstitucion) {
			Session::put('_inst_coin', $type_payment->coin);
		}

		if (isset($institution->nombre_bienvenida)) {
			Session::put('_nombre_bienvenida', $institution->nombre_bienvenida);
		} else {
			Session::put('_nombre_bienvenida', null);
		}
	}

	public static function entrySteps()
	{
        $query = PasoIngresoInstitucion::query();
        $query->select("paso_ingreso_institucion.*");

        // Paso usuario
        $query->leftJoin('core.paso_usuario', function($join) {
            $join->on('paso_ingreso_institucion.codigo_paso_ingreso', '=', 'paso_usuario.codigo_paso_ingreso')
                ->on('paso_ingreso_institucion.codigo_institucion', '=', 'paso_usuario.codigo_institucion')
                ->where('paso_usuario.codigo_usuario', '=', Auth::user()->codigo_usuario);
        });

        // Usuario institucion
        $query->join('core.usuario_institucion', function($join) {
            $join->on('paso_ingreso_institucion.codigo_institucion', '=', 'usuario_institucion.codigo_institucion')
                ->where('usuario_institucion.codigo_usuario', '=', Auth::user()->codigo_usuario);
     	});

        $query->where('paso_ingreso_institucion.codigo_institucion', RegistroSesion::getInstitution());
        $query->where('paso_ingreso_institucion.codigo_estado', Estado::getState('active'));
        $query->whereNull('paso_usuario.fecha_paso_usuario');
		return $query->get();
	}

	public static function voucherGeneralEvaluation($institution){

		$query = Voucher::query();
		$query->select('encuesta.url_encuesta');
		$query->join('core.encuesta','voucher.codigo_encuesta','encuesta.codigo_encuesta');
		$query->where('voucher.codigo_institucion', $institution);
		$query->where('voucher.codigo_estado', Estado::getState('active'));
		$data = $query->first();

		return is_object($data) ?  $data->url_encuesta : NULL;
	}

	public static function getUrlHomePage() {
		return Session::get( '_inst_url_homepage', Cookie::get('_inst_url_homepage'));
	}

	public static function getInstitutionEvalTem() {
		return Session::get( '_inst_evaluation_temp', 'Prueba');
	}

	public static function getIntitutionTypeCoin() {
		return Session::get( '_inst_coin', Cookie::get('_inst_coin') );
	}

	public static function getInstitution() {
		return Session::get( '_inst_key', Cookie::get('_inst_key') );
	}

	public static function getVotation() {
		return Session::get( '_votacion_entidad', Cookie::get('_votacion_entidad') );
	}

	public static function getCierreVotation() {
		return Session::get( '_fecha_cierre_votaciones', Cookie::get('_fecha_cierre_votaciones') );
	}

	public static function getValidateIdentification() {
		return Session::get( '_inst_validate_identification', true );
	}

	public static function getInstitutionName() {
		return Session::get( '_inst_name', Cookie::get('_inst_name') );
	}

	public static function getInstitutionSlug() {
		return Session::get( '_inst_slug', Cookie::get('_inst_slug') );
	}

	public static function getInstitutionImg() {
		return Session::get( '_inst_img', Cookie::get('_inst_img') );
	}

	public static function getInstitutionHome() {
		$inst_home =  Session::get( '_inst_home', 'comunidad' );
		//dd($inst_home);
		switch ($inst_home) {
			case 'usuario/nickname':
				$nickname = Auth::user()->nickname_usuario;
				if(isset($nickname) && !empty(trim($nickname,'/'))){
					$inst_home = 'usuario/'.$nickname;
				}
				break;
		}
		return $inst_home;
	}

	public static function getInstitutionUrl() {
		return Session::get( '_inst_url', Cookie::get('_inst_url') );
	}

	public static function getPrivacy() {
		return Session::get( '_inst_privacy', Cookie::get('_inst_privacy') );
	}

	public static function getConfirmEmail() {
		return session('_inst_confirm_email', true);
	}

	public static function getInitState() {
		return Session::get( '_inst_init_state', Estado::getState('pending') );
	}

	public static function getGoogleAnalytics() {
		return session('_google_analytics', config('tuproyecto.google_analytics'));
	}

	public static function getIdFacebookPixel() {
		return session('_id_facebook_pixel');
	}

	public static function getIdTagManager() {
		return session('_id_tag_manager');
	}

	public static function getMessageInstitution() {
		return session('_message_institution');
	}

	public static function getWelcomeName() {
		if (session('_nombre_bienvenida') !== null) {
			return session('_nombre_bienvenida');
		} else {
			return $name = self::getInstitutionName();
		}
	}

    public static function getLoginSocial() {

    	return session('_login_social', true);
    }

	public static function getVoucherGeneralEvaluation() {
		return session('_inst_voucher_encuesta_general', NULL);
	}

	public static function getHelpDesk() {
	return session('_inst_helpdesk', self::institution()->url_helpdesk_institucion);
}

    public static function getRecaptchaKey() {
		return session('_inst_recaptcha_key', (self::institution()->clave_sitio_captcha ?: config('tuproyecto.grecatcha_api_key')) );
    }

    public static function getCommunityRoot() {
        $community_root = session('_inst_community_root', self::institution()->raiz_comunidad);
        if($community_root) {
            return route('comunidad.index');
        }
        return route('home');
    }

    public static function institution() {
    	return Institucion::findOrFail(RegistroSesion::getInstitution());
	}
}
