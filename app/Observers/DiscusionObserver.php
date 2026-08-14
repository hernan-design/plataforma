<?php

namespace App\Observers;

use App\Events\Notification;
use App\Events\LeaveNotification;
use App\Models\mongodb\Notificacion as MDBNotificacion;
use App\Models\mongodb\Usuario as MDBUsuario;

use App\Discusion, App\Modulo, App\Estado, App\Usuario, App\RegistroSesion;

use MongoDB\BSON\ObjectID;
use Log, Auth, TuProyecto, SendEmail;

class DiscusionObserver
{
	public function created($model)
	{
		try {
			list($notifyOwner, $notifyParticipants) = $this->prepareNotification($model);

			// Get userReceivedBy
			$userReceivedBy = MDBUsuario::where('cod', $notifyOwner['receivedBy'])->first();
			if( $userReceivedBy instanceof MDBUsuario && $notifyOwner['receivedBy'] !== Auth::user()->codigo_usuario ) {
			   	// Broadcasting event
                event(new Notification($notifyOwner));
                
                // Send mail to owner resource
                if($notifyOwner['receivedBy'] != Auth::user()->codigo_usuario && !empty($notifyOwner['user_email'])){
                    $data = [];
                    $data['_title'] = $notifyOwner['title'];
                    $data['url_discusion'] = $notifyOwner['url'];
                    $data['_subject'] = 'Notificación comentario';
                    $data['_to'] = $notifyOwner['user_email'];
                    $data['_inst'] = RegistroSesion::getInstitution();
                    $data['_owner_mail'] = Auth::user()->nombre_usuario;                
                    $data['_template'] = 'emails.discussion.comentarynotification';
                    $data['_to_name'] = ucwords(strtolower($notifyOwner['user_name']));
                    SendEmail::notification($data);
                }
			}

			if(isset($notifyParticipants['receivedBy']) && is_array($notifyParticipants['receivedBy']) && count($notifyParticipants['receivedBy']) > 0) {
				// Broadcasting event
				event(new Notification($notifyParticipants));
			}

		} catch (\Exception $e) {
			Log::error( sprintf('%s:%s', 'DiscusionObserver:created ', $e->getMessage()) );
		}
	}

	public function updated($model)
	{
		try {
			if($model->codigo_estado == Estado::getState('removed')) {

				list($notifyOwner, $notifyParticipants) = $this->prepareNotification($model);

			   	// Broadcasting event
				event(new LeaveNotification($notifyOwner));

				if(is_array($notifyParticipants['receivedBy']) && count($notifyParticipants['receivedBy']) > 0) {
					// Broadcasting event
					event(new LeaveNotification($notifyParticipants));
				}

			}
		}catch(\Exception $e) {
			Log::error( sprintf('%s:%s', 'DiscusionObserver:updated', $e->getMessage()) );
		}
	}

	private function prepareNotification($model) {
		// Default values
		$title = transtp('notifications.discussion.title.general');

		// get type content data from discussion
		$discussion = Discusion::getDataDiscussion($model->codigo_discucion);
		if(!$discussion instanceof Discusion) {
			throw new \Exception("Error getting discussion for notify.");
        }
       
		$discussion = Discusion::buildDiscussion($discussion);
		$participants = Discusion::getContentParticipants($discussion->codigo_modulo, $discussion->origin);
       
		// prepare notification data
		$notifyOwner = [
			'type' => MDBNotificacion::getType('discussion'),
			'url' => route('discusion.show', ['discusion' => $discussion->url_discusion])
		];
		$notifyParticipants = [
			'type' => MDBNotificacion::getType('discussion'),
			'receivedBy' => $participants
		];
		if( !empty($discussion->origin) ) {
			$notifyOwner['receivedBy'] = $discussion->origin->usuario_origen;
			$notifyOwner['content'] = $notifyParticipants['content'] = $discussion->origin->titulo_origen ?: $discussion->origin->texto_origen;
			$notifyOwner['module'] = $notifyParticipants['module'] = $discussion->codigo_modulo;
			$notifyOwner['resource'] = $notifyParticipants['resource'] = $discussion->origin->codigo_origen;

			$notifyParticipants['url'] = $discussion->origin->url_origen ?: route('discusion.show', ['discusion' => $discussion->url_discusion]);

			if( !empty($discussion->origin->imagen_origen) ) {
				$notifyOwner['image'] = $notifyParticipants['image'] = $discussion->origin->imagen_origen;
			}
        }
        
        $userReceivedMail = $discussion->origin->usuario_origen;

		switch ($discussion->codigo_modulo) {
			case Modulo::getModule('wall'):
				$notifyOwner['title'] = transtp('notifications.discussion.title.wall');
				$notifyParticipants['title'] = transtp('notifications.discussion.titleAlt.wall');
			break;

			case Modulo::getModule('forum'):
				$notifyOwner['title'] = transtp('notifications.discussion.title.forum');
				$notifyParticipants['title'] = transtp('notifications.discussion.titleAlt.forum');
			break;

			case Modulo::getModule('blog'):
				$notifyOwner['title'] = transtp('notifications.discussion.title.article');
				$notifyParticipants['title'] = transtp('notifications.discussion.titleAlt.article');
			break;

			case Modulo::getModule('calendar'):
				$notifyOwner['title'] = transtp('notifications.discussion.title.event');
				$notifyParticipants['title'] = transtp('notifications.discussion.titleAlt.event');
			break;

			case Modulo::getModule('calls'):
				$notifyOwner['title'] = transtp('notifications.discussion.title.call');
				$notifyParticipants['title'] = transtp('notifications.discussion.titleAlt.call');
			break;

            case Modulo::getModule('mentoring'):
                $notifyOwner['receivedBy'] = $discussion->origin->usuario_origen == Auth::user()->codigo_usuario ? $discussion->origin->seg_usuario_origen : $discussion->origin->usuario_origen;
				$notifyOwner['title'] = transtp('notifications.discussion.title.mentoring');
                $notifyParticipants['title'] = transtp('notifications.discussion.titleAlt.mentoring');
                
                $userReceivedMail = $notifyOwner['receivedBy'];
			break;

			case Modulo::getModule('users'):
				$notifyOwner['title'] = transtp('notifications.discussion.title.entity');
				$notifyParticipants = [];
			break;

			case Modulo::getModule('marketplace'):
				$notifyOwner['title'] = transtp('notifications.discussion.title.marketplace');
				$notifyParticipants = [];
			break;

			case Modulo::getModule('learn'):
				$notifyOwner['title'] = transtp('notifications.discussion.title.course');
				$notifyParticipants['title'] = transtp('notifications.discussion.titleAlt.course');
			break;

			default:
				$notifyOwner = array_merge($dataNotification, [
					'title' => $title,
					'resource' => $discussion->id_discucion,
					'receivedBy' => $discussion->codigo_usuario,
					'content' => $discussion->texto_discucion,
					'module' => Modulo::getModule('discussion')
				]);
			break;
        }
        
        $user = Usuario::find($userReceivedMail);

        $notifyOwner['user_name'] = $user->nombre_usuario;
        $notifyOwner['user_email'] = $user->correo_electronico;

		return [$notifyOwner, $notifyParticipants];
	}
}
