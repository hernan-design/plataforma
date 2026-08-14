<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use TuProyecto;

use Validator, DB, Input, Auth, Log, Lang, URL, SendEmail;

class ComentarioDiscusion extends Model
{
   	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.comentario_discucion';

	public $incrementing = false;

	public $timestamps = false;

	protected $fillable = ['texto_comentario_discucion'];

	public function isValid($data)
    {
        $rules = array(
            'texto_comentario_discucion' => 'required|string'
        );

     	$validator = Validator::make($data, $rules);
        if ($validator->passes()) {
     		return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

	public static function getComment($codigo_discusion, $codigo_comentario)
   	{
   		$query = ComentarioDiscusion::query();
   		$query->select('comentario_discucion.codigo_comentario', 'comentario_discucion.codigo_discucion', 'comentario.texto_comentario', 'comentario.fecha_comentario', 'comentario.hora_comentario', 'comentario.contador_like', DB::raw("(CASE usuario.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '') ELSE nombre_usuario END) as nombre_usuario"), 'usuario.codigo_usuario', 'usuario.imagen_usuario', 'usuario.nickname_usuario');
		$query->join('core.comentario', 'comentario_discucion.codigo_comentario', '=', 'comentario.codigo_comentario');
   		$query->join('seguridad.usuario', 'comentario.codigo_usuario', '=', 'usuario.codigo_usuario');
		$query->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');

		$query->where('comentario_discucion.codigo_estado', Estado::getState('active'));
		$query->where('comentario_discucion.codigo_discucion', $codigo_discusion);
		$query->where('comentario_discucion.codigo_comentario', $codigo_comentario);
		return $query->first();
   	}

   	public static function getLastComment($codigo_discusion)
   	{
   		$query = ComentarioDiscusion::query();
   		$query->select('comentario.texto_comentario');
		$query->join('core.comentario', 'comentario_discucion.codigo_comentario', '=', 'comentario.codigo_comentario');
		$query->where('comentario_discucion.codigo_estado', Estado::getState('active'));
		$query->where('comentario_discucion.codigo_discucion', $codigo_discusion);
		$query->orderBy('comentario.codigo_comentario', 'desc');
		return $query->take(1)->first();
   	}

	/**
	 * Build comment.
	 */
   	public static function buildComment($comment)
   	{
		$object = new \stdClass();
		$object->cod = $comment->codigo_comentario;
		$object->codigo_comentario = TuProyecto::encryptSrcParams([$comment->codigo_comentario]);
		$object->codigo_discucion = TuProyecto::encryptSrcParams([$comment->codigo_discucion]);
		$object->id_comentario = $comment->codigo_comentario;
		$object->texto_comentario = $comment->texto_comentario;

		$object->imagen_usuario = $comment->imagen_usuario;
		$object->nickname_usuario = $comment->nickname_usuario;
		$object->contador_like = $comment->contador_like;
		$object->nombre_usuario = $comment->nombre_usuario;
		$object->codigo_usuario = $comment->codigo_usuario;

		$object->fecha_comentario = $comment->fecha_comentario;
		$object->hora_comentario = $comment->hora_comentario;
		$object->url_profile = $comment->usuario->getProfileUrl();
		$object->owner = Auth::check() ? (Auth::user()->codigo_usuario == $comment->codigo_usuario ? true : false) : false;

		// Secure srcparams
		$object->srcparams = TuProyecto::encryptSrcParams([$comment->codigo_comentario, Recurso::getResource('discusion.comentario')]);

		return $object;
   	}

	/**
	* Get comments Discussion.
	*/
  	public static function getComments($discussion)
   	{
   		$comments = [];
		$query = ComentarioDiscusion::query();
		$query->select('comentario.codigo_usuario','comentario_discucion.codigo_comentario', 'comentario_discucion.codigo_discucion', 'comentario.texto_comentario', 'comentario.fecha_comentario', 'comentario.hora_comentario', 'comentario.contador_like', 'usuario.imagen_usuario', 'usuario.nickname_usuario', DB::raw("(CASE usuario.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '') ELSE nombre_usuario END) as nombre_usuario"));

		$query->join('core.comentario', 'comentario_discucion.codigo_comentario', '=', 'comentario.codigo_comentario');
		$query->join('seguridad.usuario', 'comentario.codigo_usuario', '=', 'usuario.codigo_usuario');
		$query->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');

		$query-> where('comentario_discucion.codigo_estado', Estado::getState('active'));
		$query-> where('comentario_discucion.codigo_discucion', $discussion);

		if(Input::has('sort_by')){
   			$query->orderBy( Input::get('sort_by') == 'id_comentario' ? 'codigo_comentario' : Input::get('sort_by'), Input::has('order') ? Input::get('order'): 'asc');
		}
		$query->orderBy('comentario.fecha_comentario','asc');
		$query->orderBy('comentario.hora_comentario','asc');

		// Get total posts
		$total_entries = $query->get()->count();

		// Get posts
		$data = $query->skip(Input::get('offset'))->take(Input::get('limit'))->get();

		if(count($data) > 0) {
			foreach ($data as $comment) {
				$comments[] = ComentarioDiscusion::buildComment($comment);
			}
		}

		$response = new \stdClass();
		$response->total_entries = $total_entries;
		$response->items = $comments;
   		return $response;
   	}

	/**
	 * Job Queue notification mail.
	 */
   	public function notification($job, $data)
   	{
   		try{
			// Data discussion
            $discussion = Discusion::select('discucion.*', 'discucion_institucion.codigo_institucion as institucion', 
                DB::raw("(CASE usuario.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '') ELSE nombre_usuario END) as nombre_usuario"), 'usuario.correo_electronico')
				->join('param.discucion_institucion', function($join) use($data) {
		       		$join->on('discucion.codigo_discucion', '=', 'discucion_institucion.codigo_discucion')
						->where('discucion_institucion.codigo_institucion', '=', $data['codigo_institucion'])
						->where('discucion_institucion.codigo_estado', '=', Estado::getState('active'));
                })
                  // User Discussion
		        ->join('seguridad.usuario', 'discucion.codigo_usuario', '=', 'usuario.codigo_usuario')
		        ->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario')
		      	->where('discucion.codigo_discucion', $data['codigo_discucion'])
		      	->first();

			if(!$discussion instanceof Discusion) {
				throw new \Exception("Error recuperando discusion, notification comentario discusion. {$data['codigo_discucion']}");
			}
	   		// Data comment
   			$comment = Comentario::find($data['codigo_comentario']);
			if(!$comment instanceof Comentario) {
				throw new \Exception("Error recuperando comentario, notification comentario discusion. {$data['codigo_comentario']}");
			}

	   		//Data Comment Discussion
			$participants = ComentarioDiscusion::select(DB::raw('DISTINCT(comentario.codigo_usuario) as codigo_usuario'), DB::raw("(CASE usuario.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '') ELSE nombre_usuario END) as nombre_usuario"), 'correo_electronico')
				->join('core.comentario', 'comentario_discucion.codigo_comentario', '=', 'comentario.codigo_comentario')
				->join('seguridad.usuario', 'comentario.codigo_usuario', '=', 'usuario.codigo_usuario')
				->join('core.discucion', 'comentario_discucion.codigo_discucion', '=', 'discucion.codigo_discucion')
				->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario')

				->where('comentario_discucion.codigo_estado', Estado::getState('active'))
				->where('comentario_discucion.codigo_discucion', $discussion->codigo_discucion)
				->whereNotIn('comentario.codigo_usuario', [$comment->codigo_usuario, $discussion->codigo_usuario])
            	->get();

			// Mail notification
			$dataMail = [];
            $dataMail['_title'] = $data['title'];
			$dataMail['url_discusion'] = $data['url'];
            $dataMail['_owner_mail'] = $data['owner_mail'];
            $dataMail['_inst'] = $data['codigo_institucion'];
            $dataMail['_subject'] = 'Notificación comentario';
			$dataMail['_template'] = 'emails.discussion.comentarynotification';

			foreach ($participants as $partaker) {
                $dataMail['_to'] = $partaker->correo_electronico;
                $dataMail['_to_name'] = ucwords(strtolower($partaker->nombre_usuario));
				// Send Mail Notification
				SendEmail::notification($dataMail);
			}

			if($data['owner_mail_code'] != $discussion->codigo_usuario) {
				// Send Mail Owner post discussion
				$dataMail['_to'] = $discussion->correo_electronico;
                $dataMail['_to_name'] = ucwords(strtolower($discussion->nombre_usuario));
				SendEmail::notification($dataMail);
			}

		}catch(\Exception $e){
			Log::error(sprintf('%s:%s', 'ComentarioDiscusion notification', $e->getMessage()));
        }finally {
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
