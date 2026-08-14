<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models;

use Input, Auth, Lang, DB;

use TuProyecto;

class Like extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.like';

	protected $primaryKey = 'codigo_like';

	public $timestamps = false;

	protected $fillable = array('id_recurso', 'codigo_recurso_modulo');

	public function isValid($data)
	{
		$rules = array(
			'id_recurso' => 'required|numeric',
			'codigo_recurso_modulo' => 'required|numeric'
		);

		$validator = Validator::make($data, $rules);
		if ($validator->passes()) {
			return true;
		}
		$this->errors = $validator->errors();
		return false;
	}

	/**
	 * Search like resource.
	 */
   	public static function search()
   	{
		// Decrypt src-params
		list($codigo_recurso_modulo, $id_recurso) = TuProyecto::decryptSrcParams(Input::get('srcparams'));
		if(!$codigo_recurso_modulo || !is_numeric($codigo_recurso_modulo)) {
			throw new \Exception(Lang::get('app.exception.srcparams',['field' => 'codigo_recurso_modulo']));
		}
		if(!$id_recurso || !is_numeric($id_recurso)) {
			throw new \Exception(Lang::get('app.exception.srcparams',['field' => 'id_recurso']));
		}

 		$query = Like::query();
 		$query->select('codigo_like', 'like.codigo_usuario', 'fecha_like', 'hora_like', 'nickname_usuario', 'imagen_usuario',
 			DB::raw("(CASE usuario.tipo_usuario WHEN ".Usuario::typeUser('person')." THEN nombre_usuario || ' ' || COALESCE(persona.primer_apellido_persona, '') || ' ' || COALESCE(persona.segundo_apellido_persona, '') ELSE nombre_usuario END) as nombre_usuario")
 		);
		$query->join('seguridad.usuario', 'like.codigo_usuario', '=', 'usuario.codigo_usuario');
		$query->leftJoin('core.persona', 'usuario.codigo_usuario', '=', 'persona.codigo_usuario');
		$query->where('like.codigo_recurso_modulo', $codigo_recurso_modulo);
		$query->where('like.id_recurso', $id_recurso);
		$query->where('like.codigo_estado', Estado::getState('active'));
		$query->where('like.codigo_institucion', RegistroSesion::getInstitution());

   		if(Input::has('offset') && Input::has('limit')) {
			// Get total likes
  	 		$total_entries = $query->count();
	   		// Get likes
	   		$data = $query->skip(Input::get('offset'))->take(Input::get('limit'))->get();
   		}else{
	   		$data = $query->get();
   		}

		$likes = [];
		if(isset($data)) {
   			if(count($data) > 0) {
				foreach ($data as $like) {
					$likes[] = Like::buildLike($like);
				}
	   		}
   		}

   		if(Input::has('offset') && Input::has('limit')) {
	   		$response = new \stdClass();
			$response->total_entries = $total_entries;
			$response->items = $likes;
	   		return $response;
   		}
		return $likes;
   	}

	/**
	 * Build like.
	 */
   	public static function buildLike($like)
   	{
		$object = new \stdClass();
		$object->cod = $like->codigo_like;
		$object->codigo_like = $like->codigo_like;
		$object->codigo_usuario = $like->codigo_usuario;
		$object->fecha_like = $like->fecha_like;
		$object->hora_like = $like->hora_like;

		// Validate like session user
		$object->auth_like = Auth::check() ? (Auth::user()->codigo_usuario == $like->codigo_usuario ? true : false) : false;
		$object->value_txt = Auth::check() ? (Auth::user()->codigo_usuario == $like->codigo_usuario ? Lang::get('like.unlike') : Lang::get('like.like')) : '';

		// User like data
		$object->nickname_usuario = $like->nickname_usuario;
		$object->nombre_usuario = $like->nombre_usuario;
		$object->imagen_usuario = $like->imagen_usuario;

		$object->url_profile = $like->usuario->getProfileUrl();

		// Secure srcparams
		$object->srcparams = TuProyecto::encryptSrcParams([$like->codigo_like]);
		return $object;
   	}

   	/**
	 * Get object like resource.
	 */
   	public static function getResourceLike($id_recurso, $codigo_recurso_modulo)
   	{
		$object = new \stdClass();
   		$object->gamification_class = null;
		$object->resource = null;

   		// Gamification (Depending of resource)
		$objResource = null;
		if($id_recurso === Recurso::getResource('muro.gestion')) {
			// Comentario Muro
			$objResource = Muro::find($codigo_recurso_modulo);
			if(!$objResource instanceof Muro) {
				throw new \Exception(Lang::get('app.exception.srcparams', ['field' => 'id_recurso: does not exist the resource wall']));
			}
			$object->gamification_class = 'muro.gestion.like';

		}elseif ($id_recurso === Recurso::getResource('foro.gestion')) {
			// Entrada Foro
			$objResource = Foro::find($codigo_recurso_modulo);
			if(!$objResource instanceof Foro) {
				throw new \Exception(Lang::get('app.exception.srcparams', ['field' => 'id_recurso does not exist resource forum']));
			}
			$object->gamification_class = 'foro.gestion.like';

		}elseif ($id_recurso === Recurso::getResource('mentoria.gestion')) {
			// Entrada Mentoria
			$objResource = Asesoria::find($codigo_recurso_modulo);
			if(!$objResource instanceof Asesoria) {
				throw new \Exception(Lang::get('app.exception.srcparams', ['field' => 'id_recurso not exists resource mentoring']));
			}
			$object->gamification_class = 'mentoria.gestion.like';

		}elseif ($id_recurso === Recurso::getResource('proyectos.gestion')) {
			// Proyecto
			$objResource = Proyecto::find($codigo_recurso_modulo);
			if(!$objResource instanceof Proyecto) {
				throw new \Exception(Lang::get('app.exception.srcparams', ['field' => 'id_recurso not exists resource project']));
			}
			$object->gamification_class = 'proyectos.gestion.like';

		}elseif ($id_recurso === Recurso::getResource('blog.gestion')) {
			// Blog
			$objResource = Contenido::find($codigo_recurso_modulo);
			if(!$objResource instanceof Contenido) {
				throw new \Exception(Lang::get('app.exception.srcparams', ['field' => 'id_recurso not exists resource blog']));
			}
			$object->gamification_class = 'blog.gestion.like';

		}elseif ($id_recurso === Recurso::getResource('discusion.gestion')) {
			// Discussion
			$objResource = Discusion::find($codigo_recurso_modulo);
			if(!$objResource instanceof Discusion) {
				throw new \Exception(Lang::get('app.exception.srcparams', ['field' => 'id_recurso not exists resource discussion']));
			}
			$object->gamification_class = 'discusion.gestion.like';

		}elseif ($id_recurso === Recurso::getResource('discusion.comentario')) {
			// Comentario Discussion
			$objResource = Comentario::find($codigo_recurso_modulo);
			if(!$objResource instanceof Comentario) {
				throw new \Exception(Lang::get('app.exception.srcparams', ['field' => 'id_recurso not exists resource comment discussion']));
			}
			$object->gamification_class = 'discusion.comentario.like';

		}elseif ($id_recurso === Recurso::getResource('producto.gestion')) {
			// Product
			$objResource = Producto::find($codigo_recurso_modulo);
			if(!$objResource instanceof Producto) {
				throw new \Exception(Lang::get('app.exception.srcparams', ['field' => 'id_recurso not exists resource product']));
			}
			$object->gamification_class = 'marketplace.gestion.like';

		}elseif ($id_recurso === Recurso::getResource('convocatoria.gestion')) {
			// Programs
			$objResource = Convocatoria::find($codigo_recurso_modulo);
			if(!$objResource instanceof Convocatoria) {
				throw new \Exception(Lang::get('app.exception.srcparams', ['field' => 'id_recurso ']));
			}
		}elseif ($id_recurso === Recurso::getResource('eventos.gestion')) {
			// Events
			$objResource = Evento::find($codigo_recurso_modulo);
			if(!$objResource instanceof Evento) {
				throw new \Exception(Lang::get('app.exception.srcparams', ['field' => 'id_recurso ']));
			}
		}elseif ($id_recurso === Recurso::getResource('aprende.gestion')) {
			// Learn
			$objResource = Curso::find($codigo_recurso_modulo);
			if(!$objResource instanceof Curso) {
				throw new \Exception(Lang::get('app.exception.srcparams', ['field' => 'id_recurso ']));
			}
		}

		if(!is_null($objResource)) {
			$object->resource = $objResource;
		}

		// Return
		return $object;
	}

	public static function contador($likeObj = null)
	{
		$likeObj = is_object($likeObj) ? $likeObj : (new Like);
		$likes = 0;
		$selects = ['contador_like'];
   		switch ($likeObj->id_recurso) {
   			case Recurso::getResource('muro.gestion'):
				$objResource = MuroInstitucion::select($selects)
					->where('codigo_muro', $likeObj->codigo_recurso_modulo)
					->where('codigo_institucion', $likeObj->codigo_institucion)
					->first();
				if($objResource instanceof MuroInstitucion) {
					$likes = $objResource->contador_like;
				}
			break;

			case Recurso::getResource('foro.gestion'):
				$objResource = ForoInstitucion::select($selects)
					->where('codigo_foro', $likeObj->codigo_recurso_modulo)
					->where('codigo_institucion', $likeObj->codigo_institucion)
					->first();
				if($objResource instanceof ForoInstitucion) {
					$likes = $objResource->contador_like;
				}
			break;

            case Recurso::getResource('proyectos.gestion'):
				$objResource = Entidad::find($likeObj->codigo_recurso_modulo);
				if($objResource instanceof Entidad) {
					$likes = $objResource->contador_like;
				}
			break;

			case Recurso::getResource('blog.gestion'):
				$objResource = ContenidoInstitucion::select($selects)
					->where('codigo_contenido', $likeObj->codigo_recurso_modulo)
					->where('codigo_institucion', $likeObj->codigo_institucion)
					->first();
				if($objResource instanceof ContenidoInstitucion) {
					$likes = $objResource->contador_like;
				}
			break;

			case Recurso::getResource('discusion.gestion'):
				$objResource = Discusion::find($likeObj->codigo_recurso_modulo);
				if($objResource instanceof Discusion) {
					$likes = $objResource->contador_like;
				}
			break;

			case Recurso::getResource('discusion.comentario'):
				$objResource = Comentario::find($likeObj->codigo_recurso_modulo);
				if($objResource instanceof Comentario) {
					$likes = $objResource->contador_like;
				}
			break;

			case Recurso::getResource('producto.gestion'):
				$objResource = Producto::find($likeObj->codigo_recurso_modulo);
				if($objResource instanceof Producto) {
					$likes = $objResource->contador_like;
				}
			break;

			case Recurso::getResource('convocatoria.gestion'):
				$objResource = ConvocatoriaInstitucion::select($selects)
					->where('codigo_convocatoria', $likeObj->codigo_recurso_modulo)
					->where('codigo_institucion', $likeObj->codigo_institucion)
					->first();
				if($objResource instanceof ConvocatoriaInstitucion) {
					$likes = $objResource->contador_like;
				}
			break;

			case Recurso::getResource('eventos.gestion'):
				$objResource = EventoInstitucion::select($selects)
					->where('codigo_evento', $likeObj->codigo_recurso_modulo)
					->where('codigo_institucion', $likeObj->codigo_institucion)
					->first();
				if($objResource instanceof EventoInstitucion) {
					$likes = $objResource->contador_like;
				}
			break;

			case Recurso::getResource('mentoria.gestion'):
				$objResource = MentoriaInstitucion::select($selects)
					->where('codigo_asesoria', $likeObj->codigo_recurso_modulo)
					->where('codigo_institucion', $likeObj->codigo_institucion)
					->first();
				if($objResource instanceof MentoriaInstitucion) {
					$likes = $objResource->contador_like;
				}
			break;

			case Recurso::getResource('aprende.gestion'):
				$objResource = CursoInstitucion::select($selects)
					->where('codigo_curso', $likeObj->codigo_recurso_modulo)
					->where('codigo_institucion', $likeObj->codigo_institucion)
					->first();
				if($objResource instanceof CursoInstitucion) {
					$likes = $objResource->contador_like;
				}
			break;
   		}

   		return $likes;
	}

	/**
	 * Defining Relations
	*/
	public function usuario()
    {
        return $this->hasOne('App\Usuario','codigo_usuario','codigo_usuario');
    }
}
