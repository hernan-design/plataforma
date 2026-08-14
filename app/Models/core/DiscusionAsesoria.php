<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Validator, TuProyecto, DB, Input, Auth, Log, Lang, URL, SendEmail;

class DiscusionAsesoria extends Model
{
     /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'core.discusion_asesoria';

	public $incrementing = false;

	public $timestamps = false;


	public static function getUserDiscussions($advice)
   	{
   		$discussions = [];
		$query = Discusion::query();
		$query->select('discucion.codigo_discucion', 'discucion.texto_discucion', 'discucion.codigo_usuario', 'usuario.nickname_usuario', 'usuario.imagen_usuario',  DB::raw("(CASE usuario.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '') ELSE nombre_usuario END) as nombre_usuario"), 'discusion_asesoria.fecha_discusion','discucion.contador_comentarios_discucion','discucion.contador_like');

		$query->join('core.discusion_asesoria', 'discucion.codigo_discucion', '=', 'discusion_asesoria.codigo_discucion');
		$query->join('core.estado', 'discusion_asesoria.codigo_estado', '=', 'estado.codigo_estado');

		// User Discussion
		$query->join('seguridad.usuario', 'discucion.codigo_usuario', '=', 'usuario.codigo_usuario');
		$query->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');

		$query->join('param.discucion_institucion', function($join) {
       		$join->on('discucion.codigo_discucion', '=', 'discucion_institucion.codigo_discucion')
				->where('discucion_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('discucion_institucion.codigo_estado', '=', Estado::getState('active'));
      	});

		$query-> where('discusion_asesoria.codigo_asesoria', $advice);
		$query-> where('discucion_institucion.codigo_estado', Estado::getState('active'));
		$query-> where('discucion.codigo_estado', Estado::getState('active'));

   		$query->orderBy('discucion.codigo_discucion','desc');
		// Get total posts
		$total_entries = $query->get()->count();

		// Get posts
		$data = $query->skip(Input::get('offset'))->take(Input::get('limit'))->get();

		if(count($data) > 0) {
			foreach ($data as $discussion) {
				$discussions[] = DiscusionUsuario::buildDiscussion($discussion);
			}
		}

		$response = new \stdClass();
		$response->total_entries = $total_entries;
		$response->items = $discussions;
   		return $response;
   	}

   	public static function getDataDiscussion($discussion)
   	{
   		$query = Discusion::query();
		$query->select('discucion.codigo_discucion', 'discucion.texto_discucion', 'discucion.codigo_usuario', 'usuario.nickname_usuario', 'usuario.imagen_usuario',  DB::raw("(CASE usuario.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '') ELSE nombre_usuario END) as nombre_usuario"), 'discusion_asesoria.codigo_asesoria', 'discusion_asesoria.fecha_discusion','discucion.contador_comentarios_discucion','discucion.contador_like');
		$query->join('core.discusion_asesoria', 'discucion.codigo_discucion', '=', 'discusion_asesoria.codigo_discucion');
		// User Discussion
		$query->join('seguridad.usuario', 'discucion.codigo_usuario', '=', 'usuario.codigo_usuario');
		$query->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');
		
		$query->join('param.discucion_institucion', function($join) {
       		$join->on('discucion.codigo_discucion', '=', 'discucion_institucion.codigo_discucion')
				->where('discucion_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('discucion_institucion.codigo_estado', '=', Estado::getState('active'));
      	});
		$query->where('discucion.codigo_discucion', '=', $discussion);
		$query->where('discucion_institucion.codigo_estado', '=', Estado::getState('active'));
		$query->where('discucion.codigo_estado', Estado::getState('active'));

		$query->orderBy('discucion.codigo_discucion','desc');

		return $query->first();
   	}

   	/**
	* Build Discussion.
	*/
   	public static function buildDiscussion(Discusion $discussion)
   	{
		$object = new \stdClass();
		$object->codigo_discucion = TuProyecto::encryptSrcParams([$discussion->codigo_discucion]);
		$object->codigo_usuario = $discussion->codigo_usuario;
		$object->texto_discucion = $discussion->texto_discucion;

		$object->nombre_usuario = $discussion->nombre_usuario;
		$object->imagen_usuario = $discussion->imagen_usuario;
		$object->nickname_usuario = $discussion->nickname_usuario;
		$object->fecha_discusion = $discussion->fecha_discusion;

		$object->contador_comentarios_discucion = $discussion->contador_comentarios_discucion;
		$object->contador_like = $discussion->contador_like;
		$object->owner = (Auth::check() && in_array(Auth::user()->codigo_usuario, [$discussion->codigo_usuario])) ? true : false;
		
		$object->url_profile = $discussion->usuario->getProfileUrl();
		$object->srcparams = TuProyecto::encryptSrcParams([$discussion->codigo_discucion, Recurso::getResource('discusion.gestion')]);

		return $object;
   	}

   	/**
	 * Job Queue notification mail.
	 */
   	public function notification($job, $data)
   	{
   		try
   		{
	   		//Data advice
	   		$advice = Asesoria::select('asesoria.*', 'asesoria_institucion.codigo_institucion as institucion',

	   			// Entrepreneur data
				DB::raw("emprendedor.codigo_usuario as pemprendedor"),
				DB::raw("emprendedor.correo_electronico as pecorreo"),
				DB::raw("emprendedor.nombre_usuario as penombre"),
	   			
	   			// Mentor data
				DB::raw("mentor.codigo_usuario as pmentor"),
				DB::raw("mentor.correo_electronico as pmcorreo"),
				DB::raw("mentor.nombre_usuario as pmnombre"))

	   			->where('asesoria.codigo_asesoria', $data['codigo_asesoria'] )
				->join('aprende.asesoria_institucion', function($join) use($data) {
	       			$join->on('asesoria.codigo_asesoria', '=', 'asesoria_institucion.codigo_asesoria')
						->where('asesoria_institucion.codigo_institucion', '=', $data['codigo_institucion'])
						->where('asesoria_institucion.codigo_estado', '=', Estado::getState('active'));
		      	})
	        	->join('seguridad.usuario as emprendedor', 'asesoria.codigo_usuario', '=', 'emprendedor.codigo_usuario')
	        	->join('seguridad.usuario as mentor', 'asesoria.seg_codigo_usuario', '=', 'mentor.codigo_usuario')
	   			->where('asesoria.codigo_asesoria', $data['codigo_asesoria'] )
				->first();

			// Data discussion
			$discussion = Discusion::find($data['codigo_discucion']);			
			if(!$discussion instanceof Discusion) {
				throw new \Exception("Error recuperando discusion, notification discusion asesoria. {$data['codigo_discucion']}");
			}

		 	// Mail notification
			$data = [];
			$data['_template'] = 'emails.mentoring.notification';
			$data['_subject'] = Lang::get('mentoring.mail.comment.subject',['user' => $discussion->usuario->nombre_usuario]);
			// Data Template
			$data['comment'] = $discussion->texto_discucion;
			$data['_url_user_action'] = $discussion->usuario->getProfileUrl();
			$data['url_discusion'] = URL::route('discusion.show', ['discusion' => sprintf("%s-%s", 'discusion', $discussion->codigo_discucion)], false);
			$data['_name_user_action'] = $discussion->usuario->nickname_usuario;

			if(Auth::user()->codigo_usuario == $advice->pemprendedor ){
				$data['_to'] = $advice->pmcorreo;
				$data['_to_name'] = $advice->pmnombre;
			}else{
				$data['_to'] = $advice->pecorreo;
				$data['_to_name'] = $advice->penombre;
			}
			$data['_inst'] = $advice->institucion;
			SendEmail::notification($data);
			
			// Delete Job
			$job->delete();

		}catch(\Exception $e){
			Log::error(sprintf('%s:%s', 'DiscusionAsesoria notification', $e->getMessage()));
        }
	}
}
