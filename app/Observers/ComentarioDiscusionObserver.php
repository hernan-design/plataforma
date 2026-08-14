<?php

namespace App\Observers;

use App\Events\Notification;
use App\Events\LeaveNotification;
use App\Models\mongodb\Notificacion as MDBNotificacion;
use App\Models\mongodb\Usuario as MDBUsuario;

use App\RegistroSesion, App\ComentarioDiscusion, App\Discusion, App\Modulo, App\Estado, App\Usuario;

use Log, Queue, TuProyecto, Auth, SendEmail;

class ComentarioDiscusionObserver
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
			}

			if(isset($notifyParticipants['receivedBy']) && is_array($notifyParticipants['receivedBy']) && count($notifyParticipants['receivedBy']) > 0) {
				// Broadcasting event
				event(new Notification($notifyParticipants));
            }            

            // Mail notification
		    Queue::push('App\ComentarioDiscusion@notification',['codigo_comentario' => $model->codigo_comentario, 'codigo_discucion' => $model->codigo_discucion, 'codigo_institucion' => RegistroSesion::getInstitution(), 'url' => $notifyOwner['url'], 'title' => $notifyOwner['title'], 'owner_mail_code' => Auth::user()->codigo_usuario, 'owner_mail' => Auth::user()->nombre_usuario]);

		}catch (\Exception $e) {
			Log::error( sprintf('%s:%s', 'ComentarioDiscusionObserver:created', $e->getMessage()) );
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
			Log::error( sprintf('%s:%s', 'ComentarioDiscusionObserver:updated', $e->getMessage()) );
		}
	}

	private function prepareNotification($model) {
		// Default values
		$dataByMail = array();
		$participantCods = array();

		$discussion = Discusion::getDataDiscussion($model->codigo_discucion);
		$discussionComment = ComentarioDiscusion::getComment($model->codigo_discucion, $model->codigo_comentario);
		if(!$discussionComment instanceof ComentarioDiscusion) {
			throw new \Exception("Error: getting discussion comment for notify.");
		}
		if(!$discussion instanceof Discusion) {
			throw new \Exception("Error: comment does not belongs to a discussion");
        }

		$discussionComment = ComentarioDiscusion::buildComment($discussionComment);
		$participants = Discusion::getParticipants(['discussion' => $discussionComment->codigo_discucion]);
  
		foreach($participants as $participant) {
			list($codigo_usuario) = TuProyecto::decryptSrcParams($participant->codigo_usuario);
            
			if(is_numeric($codigo_usuario)) {
                $participantCods[] = $codigo_usuario;
			}
        }

		// prepare notification data
		$notifyOwner = [
			'title' => transtp('notifications.discussion_comment.title.general'),
			'type' => MDBNotificacion::getType('discussion'),
			'receivedBy' => $discussion->codigo_usuario,
			'url' => route('discusion.show', sprintf('%s-%s', 'discusion', $discussion->codigo_discucion)),
			'image' => $discussionComment->imagen_usuario,
			'content' => $discussion->texto_discucion,
			'resource' => $discussion->codigo_discucion,
            'module' => Modulo::getModule('discussion')
		];
		$notifyParticipants = [
			'title' => transtp('notifications.discussion_comment.titleAlt.general'),
			'type' => MDBNotificacion::getType('discussion'),
			'receivedBy' => $participantCods,
			'url' => route('discusion.show', sprintf('%s-%s', 'discusion', $discussion->codigo_discucion)),
			'image' => $discussionComment->imagen_usuario,
			'content' => $discussion->texto_discucion,
			'resource' => $discussion->codigo_discucion,
			'module' => Modulo::getModule('discussion')
        ];        
        
		return [$notifyOwner, $notifyParticipants];
	}
}
