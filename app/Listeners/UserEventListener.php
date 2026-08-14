<?php

namespace App\Listeners;

use Session, Cookie, Log;

use App\Events\CheckUser;

use App\RegistroSesion, App\UsuarioInstitucion, App\Institucion, App\Estado, App\AceptacionTerminos, App\TerminosCondiciones;

use App\Models\Bita\LogActivity;

class UserEventListener
{
    /**
     * Handle user login events.
     */
    public function onUserLogin($event)
    {
        try {
            // Get user
            $user = $event->user;

            // Compile style institution
            $institution = RegistroSesion::institution();
            Institucion::compileStyle($institution);

            // Data prepare
            RegistroSesion::dataPrepare($institution);

            // User status institution
            $userInstitution = UsuarioInstitucion::getUserInstitution($user->codigo_usuario, $user->codigo_institucion);
            
            $lastIncome = '';
            if(!empty($userInstitution->ultimo_ingreso_usuario)){
                $lastIncome = $userInstitution->ultimo_ingreso_usuario;
            }

            session(['last_income' => $lastIncome]);

			// Insert last income
			$userInstitution->ultimo_ingreso_usuario = date('Y-m-d H:i:s');
			$userInstitution->save();

            session(['_user_status' => $userInstitution->codigo_estado]);

            // Validate account activation
            if(in_array($userInstitution->codigo_estado, [Estado::getState('removed')])) {
                UsuarioInstitucion::where('codigo_institucion', $userInstitution->codigo_institucion)->where('codigo_usuario', $userInstitution->codigo_usuario)
                    ->update([ 'codigo_estado' => RegistroSesion::getInitState(), 'fecha_registro_usuario' => date('Y-m-d'), 'hora_registro_usuario' => date('H:i:s') ]);
                session(['_user_status' => RegistroSesion::getInitState()]);
            }

            // Acceptance terms
            $query = AceptacionTerminos::query();
            $query->join('param.version_terminos', 'aceptacion_terminos.codigo_version_terminos', '=', 'version_terminos.codigo_version_terminos');
            $query->join('param.terminos_condiciones', function($join) {
                $join->on('version_terminos.codigo_terminos_condiciones', '=', 'terminos_condiciones.codigo_terminos_condiciones')
                    ->on('terminos_condiciones.version_actual_terminos', '=', 'version_terminos.numero_version_terminos');
            });
            $query->where('aceptacion_terminos.codigo_usuario_institucion', $userInstitution->codigo_usuario_institucion);
            $query->where('terminos_condiciones.codigo_estado', Estado::getState('active'));
            $terms = $query->pluck('tipo_terminos')->toArray();

            session(['_acceptance_terms' => false]);
            if(in_array(TerminosCondiciones::getTypeTerms('terms'), $terms) && in_array(TerminosCondiciones::getTypeTerms('privacy'), $terms)){
                session(['_acceptance_terms' => true]);
            }

            // Log activity
			activity()
				->performedOn($user)
				->withProperties([
					'attributes' => [
						'user' => $user->nombre_usuario,
						'user_id' => $user->codigo_usuario
					] ])
				->log('activitylog.user.session.platform');

            // CheckUser on Broadcast
            event(new CheckUser($user));

        }catch(\Predis\Connection\ConnectionException $e){
            Log::error( sprintf('Broadcasting server: %s, %s.', $e->getMessage(), 'onUserLogin') );
        }
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     * @return array
     */
    public function subscribe($events)
    {
        $events->listen('Illuminate\Auth\Events\Login', 'App\Listeners\UserEventListener@onUserLogin');
    }
}
