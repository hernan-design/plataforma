<?php

namespace App\Observers;

use App\Events\Notification;
use App\Events\LeaveNotification;
use App\Models\mongodb\Notificacion as MDBNotificacion;
use App\Models\mongodb\Usuario as MDBUsuario;

use App\Like, App\Recurso, App\Estado;

use MongoDB\BSON\ObjectID;
use Log, Auth;

class LikeObserver
{
	public function created($model)
	{
		try{
			// Default values
			$receivedBy = $content = $url = null;
			$title = transtp('notifications.like.title.general');

			// Get source like
			$objResource = Like::getResourceLike($model->id_recurso, $model->codigo_recurso_modulo);
			
			if(is_null($objResource->resource)) {
				throw new \Exception("Error recuperando Recurso ($model->id_recurso) Modulo ($model->codigo_recurso_modulo)");
			}

			// Prepare
			switch ($model->id_recurso) {
				case Recurso::getResource('producto.gestion'):
					$title = transtp('notifications.like.title.product');
					$content = $objResource->resource->nombre_producto;
					$url = route('marketplace.show', ['marketplace' => $objResource->resource->url_producto]);
					$receivedBy = $objResource->resource->codigo_usuario;
				break;

				case Recurso::getResource('muro.gestion'):
					$title = transtp('notifications.like.title.wall');
					$content = $objResource->resource->texto_muro;
					$url = route('comunidad.index');
					$receivedBy = $objResource->resource->codigo_usuario;
				break;

				case Recurso::getResource('foro.gestion'):
					$title = transtp('notifications.like.title.forum');
					$content = $objResource->resource->titulo_foro;
					$url = route('foro.categoria.tema', [
						'category' => $objResource->resource->categoria->url_categoria_foro,
						'theme' => $objResource->resource->url_foro
					]);
					$receivedBy = $objResource->resource->codigo_usuario;
				break;

				case Recurso::getResource('mentoria.gestion'):
					$title = transtp('notifications.like.title.mentoring');
					$content = $objResource->resource->descripcion_asesoria;
					$url = route('mentoria.preguntas.show', ['pregunta' => sprintf("%s-%s", 'pregunta', $$objResource->resource->codigo_asesoria)]);
					$receivedBy = $objResource->resource->codigo_usuario;
				break;

				case Recurso::getResource('proyectos.gestion'):
					$title = transtp('notifications.like.title.entity');
					$content = $objResource->resource->nombre_proyecto;
					$url = route('proyecto.proyecto', ['proyecto' => $objResource->resource->url_proyecto]);
					$receivedBy = $objResource->resource->codigo_usuario;
				break;

				case Recurso::getResource('blog.gestion'):
					$title = transtp('notifications.like.title.article');
					$content = $objResource->resource->nombre_contenido;
					$url = route('blog.categoria.articulo', [
						'category' => $objResource->resource->categoria->url_tipo_contenido,
						'article' => $objResource->resource->url_contenido
					]);
					$receivedBy = $objResource->resource->codigo_usuario;
				break;

				case Recurso::getResource('discusion.gestion'):
					$title = transtp('notifications.like.title.discussion');
					$content = $objResource->resource->texto_discucion;
					$url = route('discusion.show', ['discusion' => sprintf("%s-%s", 'discusion', $objResource->resource->codigo_discucion)]);
					$receivedBy = $objResource->resource->codigo_usuario;
				break;

				case Recurso::getResource('discusion.comentario'):
					$title = transtp('notifications.like.title.discussion_comment');
					$content = $objResource->resource->texto_comentario;
					$url = route('discusion.show', ['discusion' => sprintf("%s-%s", 'discusion', $objResource->resource->discusion->codigo_discucion)]);
					$receivedBy = $objResource->resource->codigo_usuario;
				break;

				case Recurso::getResource('convocatoria.gestion'):
					$title = transtp('notifications.like.title.call');
					$content = $objResource->resource->nombre_convocatoria;
					$url = route('convocatoria.convocatoria', ['convocatoria' => $objResource->resource->url_convocatoria]);
					$receivedBy = $objResource->resource->codigo_usuario;
				break;

				case Recurso::getResource('eventos.gestion'):
					$title = transtp('notifications.like.title.event');
					$content = $objResource->resource->nombre_evento;
					$url = route('calendario.evento.show', ['evento' => $objResource->resource->url_evento]);
					$receivedBy = $objResource->resource->codigo_usuario;
				break;

				case Recurso::getResource('aprende.gestion'):
					$title = transtp('notifications.like.title.course');
					$content = $objResource->resource->nombre_curso;
					// $url = route('');
					$receivedBy = $objResource->resource->codigo_usuario;
				break;
			}

			// Only send notification $url and $receivedBy != null
			if( !is_null($url) && !is_null($receivedBy) )
			{
		    	// Get userReceivedBy
    			$userReceivedBy = MDBUsuario::where('cod', $receivedBy)->first();
    			if( $userReceivedBy instanceof MDBUsuario && $receivedBy !== Auth::user()->codigo_usuario)
    			{
				   	// Broadcasting event
					event(new Notification([
						'title' => $title,
						'content' => !is_null($content) ? $content : $title,
						'url' => $url,
						'receivedBy' => $receivedBy,
						'type' => MDBNotificacion::getType('like'),
						'module' => $model->id_recurso,
						'resource' => $model->codigo_recurso_modulo
					]));
				}
			}
		}catch(\Exception $e){
			Log::error( sprintf('%s:%s', 'LikeObserver:created', $e->getMessage()) );
		}
	}

	public function updated($model)
	{
		try{
			if($model->codigo_estado == Estado::getState('removed'))
			{
				$title = null;

				// Get source like
				$objResource = Like::getResourceLike($model->id_recurso, $model->codigo_recurso_modulo);
				if(is_null($objResource->resource)) {
					throw new \Exception("Error recuperando Recurso ($model->id_recurso) Modulo ($model->codigo_recurso_modulo)");
				}

				// Prepare
				switch ($model->id_recurso) {
					case Recurso::getResource('producto.gestion'):
						$title = transtp('notifications.like.title.product');
					break;

					case Recurso::getResource('muro.gestion'):
						$title = transtp('notifications.like.title.wall');
					break;

					case Recurso::getResource('foro.gestion'):
						$title = transtp('notifications.like.title.forum');
					break;

					case Recurso::getResource('mentoria.gestion'):
						$title = transtp('notifications.like.title.mentoring');
					break;

					case Recurso::getResource('proyectos.gestion'):
						$title = transtp('notifications.like.title.entity');
					break;

					case Recurso::getResource('blog.gestion'):
						$title = transtp('notifications.like.title.article');
					break;

					case Recurso::getResource('discusion.gestion'):
						$title = transtp('notifications.like.title.discussion');
					break;

					case Recurso::getResource('discusion.comentario'):
						$title = transtp('notifications.like.title.discussion_comment');
					break;

					case Recurso::getResource('convocatoria.gestion'):
						$title = transtp('notifications.like.title.call');
					break;

					case Recurso::getResource('eventos.gestion'):
						$title = transtp('notifications.like.title.event');
					break;

					case Recurso::getResource('aprende.gestion'):
						$title = transtp('notifications.like.title.course');
					break;
				}

		   		// Broadcasting event
				event(new LeaveNotification([
					'title' => $title,
					'type' => MDBNotificacion::getType('like'),
					'module' => $model->id_recurso,
					'resource' => $model->codigo_recurso_modulo
				]));
			}
		}catch(\Exception $e){
			Log::error( sprintf('%s:%s', 'LikeObserver:updated', $e->getMessage()) );
		}
	}
}
