<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models;

use Input, Validator;

use TuProyecto;

use App\Estado, App\TipoAdjunto;

class AdjuntoCurso extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'aprende.adjunto_curso';

	public $incrementing = false;

	public $timestamps = false;


	public static function getAttachedCourse($course)
   	{
		$query = AdjuntoCurso::query();
		$query->select('adjunto_curso.codigo_adjunto','codigo_tipo_adjunto','direccion_adjunto','nombre_adjunto','codigo_curso', 'privacidad_adjunto','codigo_privacidad_contenido');

		$query->join('core.adjunto', 'adjunto_curso.codigo_adjunto', '=', 'adjunto.codigo_adjunto');
    
		$query->where('adjunto_curso.codigo_estado', '=', Estado::getState('active'));
		$query->where('adjunto.codigo_tipo_adjunto', '=', TipoAdjunto::getTypeAttached('document'));
	 	$query->where('adjunto_curso.codigo_curso', '=', $course);
 	
		$query->orderBy('adjunto_curso.codigo_adjunto','asc');

		// Get total posts
		$total_entries = $query->get()->count();

		// Get posts
		$data = $query->skip(Input::get('offset'))->take(Input::get('limit'))->get();

		$attachedCourse = [];
		if(count($data) > 0) {
			foreach ($data as $attached) {
				$attachedCourse[] = AdjuntoCurso::buildAttached($attached);
			}
		}

		$response = new \stdClass();
		$response->total_entries = $total_entries;
		$response->items = $attachedCourse;
   		return $response;
   	}

   	/**
	 * Build Attached Course.
	 */
   	public static function buildAttached($attached)
   	{
		$object = new \stdClass();
		$object->codigo_adjunto = TuProyecto::encryptSrcParams([$attached->codigo_adjunto]);
		$object->codigo_curso = TuProyecto::encryptSrcParams([$attached->codigo_curso]);
		$object->codigo_tipo_adjunto = $attached->codigo_tipo_adjunto;
		$object->codigo_privacidad_contenido = $attached->codigo_privacidad_contenido;
		$object->direccion_adjunto = $attached->direccion_adjunto;
		$object->nombre_adjunto = $attached->nombre_adjunto;
		return $object;
   	}
}
