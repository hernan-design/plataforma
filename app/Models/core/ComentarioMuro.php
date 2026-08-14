<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

use Validator, DB, URL, Lang, Log;

use TuProyecto, SendEmail;

class ComentarioMuro extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.comentario_muro';

	public $incrementing = false;

	public $timestamps = false;

	protected $fillable = array('codigo_muro');

	public function isValid($data)
	{
		$rules = array(
			'codigo_muro' => 'required|regex:[^[0-9]*$]|numeric',
			'texto_comentario' => 'required',
		);

		$validator = Validator::make($data, $rules);
		if ($validator->passes()) {
			return true;
		}
		$this->errors = $validator->errors();
		return false;
	}

	public static function getComment($codigo_muro, $codigo_comentario)
   	{
   		$query = ComentarioMuro::query()
   			->join('core.comentario', 'comentario_muro.codigo_comentario', '=', 'comentario.codigo_comentario')
			->join('seguridad.usuario', 'comentario.codigo_usuario', '=', 'usuario.codigo_usuario')
			->where('core.comentario_muro.codigo_estado', Estado::getState('active'))
			->where('comentario_muro.codigo_muro', $codigo_muro)
			->where('comentario_muro.codigo_comentario', $codigo_comentario);
		return $query->first();
   	}

	/**
	 * Build comment.
	 */
   	public static function buildComment($comment)
   	{
		$object = new \stdClass();
		$object->codigo_muro = $comment->codigo_muro;
		$object->codigo_comentario = $comment->codigo_comentario;
		$object->texto_comentario = $comment->texto_comentario;
		$object->time_ago = TuProyecto::timeAgo($comment->fecha_comentario, $comment->hora_comentario);

		$object->imagen_usuario = $comment->imagen_usuario;
		$object->nickname_usuario = $comment->nickname_usuario;
		$object->contador_like = $comment->contador_like;
		$object->sigla_institucion = $comment->sigla_institucion;

		$object->url_profile = $comment->usuario->getProfileUrl();
		// Secure srcparams
		$object->srcparams = TuProyecto::encryptSrcParams([$comment->codigo_comentario, Recurso::getResource('muro.comentario')]);
		return $object;
   	}

   	/**
	 * Job Queue notification mail.
	 */
   	public function notification($job, $parameters)
   	{
   		try
   		{
			$wall = Muro::find($parameters['codigo_muro']);
			if(!$wall instanceof Muro) {
				throw new \Exception("Muro not found");
			}

			$commentwall = ComentarioMuro::where('codigo_muro', $wall->codigo_muro)->where('codigo_comentario', $parameters['codigo_comentario'])->first();
			if(!$commentwall instanceof ComentarioMuro) {
				throw new \Exception("ComentarioMuro not found");
			}

			$comment = Comentario::find($commentwall->codigo_comentario);
			if(!$comment instanceof Comentario) {
				throw new \Exception("Comentario not found");
			}

			$participants = ComentarioMuro::select(DB::raw('DISTINCT(comentario.codigo_usuario) as codigo_usuario'), 'nombre_usuario', 'muro_institucion.codigo_institucion', 'correo_electronico')
	   			->join('core.muro', 'comentario_muro.codigo_muro', '=', 'muro.codigo_muro')
	   			->join('core.muro_institucion', function($join) use($parameters) {
	       			$join->on('muro.codigo_muro', '=', 'muro_institucion.codigo_muro')
						->where('muro_institucion.codigo_institucion', '=', $parameters['codigo_institucion'])
						->where('muro_institucion.codigo_estado', '=', Estado::getState('active'));
		      	})
				->join('core.comentario', 'comentario_muro.codigo_comentario', '=', 'comentario.codigo_comentario')
	   			->join('seguridad.usuario', 'seguridad.usuario.codigo_usuario', '=', 'comentario.codigo_usuario')
				->where('comentario_muro.codigo_muro', $commentwall->codigo_muro)
	   			->whereNotIn('comentario.codigo_usuario', [$comment->codigo_usuario,$wall->codigo_usuario])
				->get();

			// Mail notification
			$data = [];
			$data['_template'] = 'emails.wall.notification';
			$data['_inst'] = $parameters['codigo_institucion'];
			// Data Template
			$data['owner'] = false;
			$data['comment'] = $comment->texto_comentario;
			$data['_url_user_action'] = $comment->usuario->getProfileUrl();
			$data['_name_user_action'] = $comment->usuario->nombre_usuario;

			foreach ($participants as $partaker) {
				$data['_subject'] = Lang::get('wall.mail.subject', array('user' => $comment->usuario->nombre_usuario, 'owner' => $wall->usuario->nombre_usuario));
				$data['_to'] = $partaker->correo_electronico;
				$data['_to_name'] = $partaker->nombre_usuario;
				// Send Mail Notification
				SendEmail::notification($data);
			}

			if($comment->codigo_usuario != $wall->codigo_usuario) {
				// Send Mail Owner post wall
				$data['owner'] = true;
				$data['_subject'] = Lang::get('wall.mail.subject.owner', array('user' => $comment->usuario->nombre_usuario));
				$data['_to'] = $wall->usuario->correo_electronico;
				$data['_to_name'] = $wall->usuario->nombre_usuario;
				SendEmail::notification($data);
			}

		}catch(\Exception $e) {
			Log::error(sprintf('%s:%s', 'ComentarioMuro notification', $e->getMessage()));

        } finally {
        	// Delete Job
			$job->delete();
		}
	}

	/**
	 * Defining Relations
	*/

	public function usuario()
    {
        return $this->hasOne('App\Usuario','codigo_usuario','codigo_usuario');
    }
}
