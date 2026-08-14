<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use TuProyecto, Input;

class PatrocinadorEntidad extends Model
{
      /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'core.patrocinador_entidad';

	public $incrementing = false;

	public $timestamps = false;

	
	public static function getSponsorsEntity()
	{
		$sponsors = [];
		$query = PatrocinadorEntidad::query();
		$query->select('patrocinador_entidad.codigo_patrocinador', 'nombre_patrocinador', 'imagen_patrocinador', 'url_patrocinador', 'codigo_entidad');
		$query->join('aprende.patrocinador', 'patrocinador_entidad.codigo_patrocinador', '=', 'patrocinador.codigo_patrocinador');
		$query->where('patrocinador_entidad.codigo_estado', '=', Estado::getState('active'));

		if(Input::has('codigo_entidad')) {
			// Decrypt src-params
			list($codigo_entidad) = TuProyecto::decryptSrcParams(Input::get('codigo_entidad'));
			if(!$codigo_entidad || !is_numeric($codigo_entidad)) {
				App::abort(403);
			}
			$query->where('patrocinador_entidad.codigo_entidad', '=', $codigo_entidad);

			// Get count posts 
			$total_entries = $query->count();

			// Get posts
			$data = $query->skip(Input::get('offset'))->take(Input::get('limit'))->get();

			if(count($data) > 0) {
				foreach ($data as $sponsor) {
					$sponsors[] = PatrocinadorEntidad::buildEntitySponsor($sponsor);
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
	 * Build Sponsor Entity.
	 */
   	public static function buildEntitySponsor($sponsor)
   	{
		$object = new \stdClass();
		$object->nombre_patrocinador = $sponsor->nombre_patrocinador;
		$object->imagen_patrocinador = $sponsor->imagen_patrocinador;
		$object->url_patrocinador = $sponsor->url_patrocinador;
		
		$object->codigo_entidad = TuProyecto::encryptSrcParams([$sponsor->codigo_entidad]);
		$object->codigo_patrocinador = $sponsor->codigo_patrocinador;
		return $object;
   	}
}
