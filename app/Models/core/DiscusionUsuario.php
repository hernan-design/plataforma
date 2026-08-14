<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Validator, TuProyecto, DB, Input, Auth;

class DiscusionUsuario extends Model
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'core.discusion_usuario';

	public $incrementing = false;

	public $timestamps = false;


	public static function getUserDiscussions($user)
   	{
   		$discussions = [];
		$query = Discusion::query();
		$query->select('discucion.codigo_discucion', 'discucion.texto_discucion', 'discucion.codigo_usuario', 'usuario.nickname_usuario', 'usuario.imagen_usuario',  DB::raw("(CASE usuario.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '') ELSE nombre_usuario END) as nombre_usuario"), 'discusion_usuario.fecha_discusion','discucion.contador_comentarios_discucion','discucion.contador_like');

		$query->join('core.discusion_usuario', 'discucion.codigo_discucion', '=', 'discusion_usuario.codigo_discucion');
		$query->join('core.estado', 'discusion_usuario.codigo_estado', '=', 'estado.codigo_estado');

		// User Discussion
		$query->join('seguridad.usuario', 'discucion.codigo_usuario', '=', 'usuario.codigo_usuario');
		$query->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');

		$query->join('param.discucion_institucion', function($join) {
       		$join->on('discucion.codigo_discucion', '=', 'discucion_institucion.codigo_discucion')
				->where('discucion_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('discucion_institucion.codigo_estado', '=', Estado::getState('active'));
      	});

		$query-> where('discusion_usuario.codigo_usuario', $user);
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
		$query->select('discucion.codigo_discucion', 'discucion.texto_discucion', 'discucion.codigo_usuario', 'usuario.nickname_usuario', 'usuario.imagen_usuario',  DB::raw("(CASE usuario.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '') ELSE nombre_usuario END) as nombre_usuario"), 'discusion_usuario.codigo_usuario', 'discusion_usuario.fecha_discusion','discucion.contador_comentarios_discucion','discucion.contador_like');
		$query->join('core.discusion_usuario', 'discucion.codigo_discucion', '=', 'discusion_usuario.codigo_discucion');
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
}
