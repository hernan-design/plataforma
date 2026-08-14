<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use TuProyecto;
use Input, App;

class PatrocinadorProyecto extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.patrocinador_proyecto';

	public $incrementing = false;

	public $timestamps = false;

	
	public static function getSponsorsProject()
	{
		$sponsors = [];
		$query = PatrocinadorProyecto::query();
		$query->select('patrocinador_proyecto.codigo_patrocinador', 'nombre_patrocinador', 'imagen_patrocinador', 'url_patrocinador', 'codigo_proyecto');
		$query->join('aprende.patrocinador', 'patrocinador_proyecto.codigo_patrocinador', '=', 'patrocinador.codigo_patrocinador');
		$query->where('patrocinador_proyecto.codigo_estado', '=', Estado::getState('active'));

		if(Input::has('codigo_proyecto')) {
			// Decrypt src-params
			list($codigo_proyecto) = TuProyecto::decryptSrcParams(Input::get('codigo_proyecto'));
			if(!$codigo_proyecto || !is_numeric($codigo_proyecto)) {
				App::abort(403);
			}
			$query->where('patrocinador_proyecto.codigo_proyecto', '=', $codigo_proyecto);

	    	// $query->orderBy('nombre_patrocinador','asc');

			// Get count posts 
			$total_entries = $query->count();

			// Get posts
			$data = $query->skip(Input::get('offset'))->take(Input::get('limit'))->get();

			if(count($data) > 0) {
				foreach ($data as $sponsor) {
					$sponsors[] = PatrocinadorProyecto::buildProjectSponsor($sponsor);
				}
			}

			$response = new \stdClass();
			$response->total_entries = $total_entries;
			$response->items = $sponsors;
	   		return $response;
		}
		return $sponsors;
	}

	/**
	 * Build Sponsor Project.
	 */
   	public static function buildProjectSponsor($sponsor)
   	{
		$object = new \stdClass();
		$object->nombre_patrocinador = $sponsor->nombre_patrocinador;
		$object->imagen_patrocinador = $sponsor->imagen_patrocinador;
		$object->url_patrocinador = $sponsor->url_patrocinador;
		
		$object->codigo_proyecto = TuProyecto::encryptSrcParams([$sponsor->codigo_proyecto]);
		$object->codigo_patrocinador = $sponsor->codigo_patrocinador;
		return $object;
   	}
}
