<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// use Laravel\Cashier\Billable; // Cashier no está instalado (provider deshabilitado en config/app.php)

use App\Models;

use App\RegistroSesion, App\Rol, App\Estado, App\TerminosCondiciones, App\AceptacionTerminos;

use Auth, SendEmail, URL, TuProyecto;

class UsuarioInstitucion extends Model {

	// use Billable;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'core.usuario_institucion';

   	protected $primaryKey = 'codigo_usuario_institucion';

	public $timestamps = false;

	/**
	 *
	 * @var array
 	 */
 	protected $dates = ['trial_ends_at', 'subscription_ends_at'];

	public static function getUserInstitution($codigo_usuario) {
		$userInstitution = UsuarioInstitucion::where('codigo_usuario', '=', $codigo_usuario)->where('codigo_institucion', '=', RegistroSesion::getInstitution())->first();
		if(!$userInstitution instanceof UsuarioInstitucion) {
			$userInstitution = new UsuarioInstitucion();
			$userInstitution->codigo_usuario = $codigo_usuario;
			$userInstitution->codigo_institucion = RegistroSesion::getInstitution();
			$userInstitution->codigo_estado = RegistroSesion::getInitState();
			$userInstitution->codigo_rol = Rol::getRole('user');
			$userInstitution->fecha_registro_usuario = date('Y-m-d');
			$userInstitution->hora_registro_usuario = date('H:i:s');
            $userInstitution->save();

            if(RegistroSesion::institution()->aceptacion_terminos_auto){
                // Terms
                $terms = TerminosCondiciones::termsAndConditions(TerminosCondiciones::getTypeTerms('terms'));
                if($terms instanceof TerminosCondiciones) {
                    $acceptanceTerms = AceptacionTerminos::where('codigo_usuario_institucion', $userInstitution->codigo_usuario_institucion)->where('codigo_version_terminos', $terms->codigo_version_terminos)->first();
                    if(!$acceptanceTerms instanceof AceptacionTerminos) {
                        $acceptanceTerms = new AceptacionTerminos();
                        $acceptanceTerms->codigo_usuario_institucion = $userInstitution->codigo_usuario_institucion;
                        $acceptanceTerms->codigo_version_terminos = $terms->codigo_version_terminos;
                        $acceptanceTerms->codigo_estado = Estado::getState('active');
                        $acceptanceTerms->fecha_aceptacion_terminos = date('Y-m-d H:i:s');
                        $acceptanceTerms->save();
                    }
                }

                // Privacy
                $privacy = TerminosCondiciones::termsAndConditions(TerminosCondiciones::getTypeTerms('privacy'));
                if($privacy instanceof TerminosCondiciones) {
                    $acceptanceTerms = AceptacionTerminos::where('codigo_usuario_institucion', $userInstitution->codigo_usuario_institucion)->where('codigo_version_terminos', $privacy->codigo_version_terminos)->first();
                    if(!$acceptanceTerms instanceof AceptacionTerminos) {
                        $acceptanceTerms = new AceptacionTerminos();
                        $acceptanceTerms->codigo_usuario_institucion = $userInstitution->codigo_usuario_institucion;
                        $acceptanceTerms->codigo_version_terminos = $privacy->codigo_version_terminos;
                        $acceptanceTerms->codigo_estado = Estado::getState('active');
                        $acceptanceTerms->fecha_aceptacion_terminos = date('Y-m-d H:i:s');
                        $acceptanceTerms->save();
                    }
                }
            }
		}
		return $userInstitution;
	}

	public function sendConfirmacionEmail($request)
	{
		// Mail notification
		$data = [];
		switch (RegistroSesion::getInstitution()) {
			case Institucion::getInstitution('redcoo'):
				$data['_template'] = 'emails.custom.redcoo.confirmmail';
				break;

			default:
				$data['_template'] = 'emails.user.confirmmail';
				$data['body'] = trans('app.confirm.mail.body');
				break;
		}

		$data['_subject'] = trans('app.confirm.mail.subject');
		$data['_to'] = $request['correo_electronico'];
		$data['_url_action'] = URL::route('usuario.confirmacion.confirmar', ['email' => TuProyecto::encryptSrcParams([$request['correo_electronico']])], false);

		SendEmail::notification($data);
	}

	/**
	 * Defining Relations
	*/
	public function institucion()
    {
        return $this->hasOne('App\Institucion', 'codigo_institucion', 'codigo_institucion');

   	}

    public function canales()
    {
		return $this->hasMany('App\CanalUsuario','codigo_usuario_institucion', 'codigo_usuario_institucion')->whereIn('codigo_estado', [ Estado::getState('active'), Estado::getState('inactive') ]);
    }
}

