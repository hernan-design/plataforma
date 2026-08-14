<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Validator, TuProyecto, DB, Input, Auth;

class DiscusionProducto extends Model
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'core.discucion_producto';

	public $incrementing = false;

	public $timestamps = false;


	public static function getProductDiscussions($product)
   	{
   		$discussions = [];
		$query = Discusion::query();
		$query->select('discucion.codigo_discucion', 'discucion.texto_discucion', 'discucion.codigo_usuario', 'usuario.nickname_usuario', 'usuario.imagen_usuario', DB::raw("(CASE usuario.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '') ELSE nombre_usuario END) as nombre_usuario"), 'discucion_producto.fecha_discusion','discucion.contador_comentarios_discucion','discucion.contador_like');

		$query->join('core.discucion_producto', 'discucion.codigo_discucion', '=', 'discucion_producto.codigo_discucion');
		$query->join('core.producto', 'discucion_producto.codigo_producto', '=', 'producto.codigo_producto');
		$query->join('core.estado', 'discucion_producto.codigo_estado', '=', 'estado.codigo_estado');

		// User Discussion
		$query->join('seguridad.usuario', 'discucion.codigo_usuario', '=', 'usuario.codigo_usuario');
		$query->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');

		$query->join('param.discucion_institucion', function($join) {
       		$join->on('discucion.codigo_discucion', '=', 'discucion_institucion.codigo_discucion')
				->where('discucion_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('discucion_institucion.codigo_estado', '=', Estado::getState('active'));
      	});

		$query-> where('discucion_producto.codigo_producto', $product);
		$query-> where('discucion_institucion.codigo_estado', Estado::getState('active'));
		$query-> where('discucion.codigo_estado', Estado::getState('active'));

   		$query->orderBy('discucion.codigo_discucion','desc');
		// Get total posts
		$total_entries = $query->get()->count();

		// Get posts
		$data = $query->skip(Input::get('offset'))->take(Input::get('limit'))->get();

		if(count($data) > 0) {
			foreach ($data as $discussion) {
				$discussions[] = DiscusionProducto::buildDiscussion($discussion);
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
		$query->select('discucion.codigo_discucion', 'discucion.texto_discucion', 'discucion.codigo_usuario', 'usuario.nickname_usuario', 'usuario.imagen_usuario', DB::raw("(CASE usuario.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '') ELSE nombre_usuario END) as nombre_usuario"), 'discucion_producto.codigo_producto', 'discucion_producto.fecha_discusion','discucion.contador_comentarios_discucion','discucion.contador_like');
		$query->join('core.discucion_producto', 'discucion.codigo_discucion', '=', 'discucion_producto.codigo_discucion');
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

		//$query->orderBy('discucion_producto.fecha_discusion','asc');
		$query->orderBy('discucion.codigo_discucion','desc');

		return $query->first();
   	}

   	/**
	* Build Discussion.
	*/
   	public static function buildDiscussion($post)
   	{
		$object = new \stdClass();
		$object->codigo_discucion = TuProyecto::encryptSrcParams([$post->codigo_discucion]);
		$object->codigo_usuario = $post->codigo_usuario;
		$object->texto_discucion = $post->texto_discucion;

		$object->nombre_usuario = $post->nombre_usuario;
		$object->imagen_usuario = $post->imagen_usuario;
		$object->nickname_usuario = $post->nickname_usuario;
		$object->fecha_discusion = $post->fecha_discusion;

		$object->contador_comentarios_discucion = $post->contador_comentarios_discucion;
		$object->contador_like = $post->contador_like;
		$object->owner = (Auth::check() && Auth::user()->codigo_usuario == $post->codigo_usuario) ? true : false;
		$object->url_profile = $post->usuario->getProfileUrl();

		$object->srcparams = TuProyecto::encryptSrcParams([$post->codigo_discucion, Recurso::getResource('discusion.gestion')]);
		return $object;
   	}
}
