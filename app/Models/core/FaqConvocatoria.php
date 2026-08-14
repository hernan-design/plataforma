<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB, Input, Log, Auth, Lang;

use TuProyecto;

class FaqConvocatoria extends Model
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'core.faq_convocatoria';

	public $incrementing = false;

	public $timestamps = false;


	public static function getFaqProgram($program)
   	{
   		$faqprograms = [];
		$query = FaqConvocatoria::query();
		$query->select('preguntas_frecuentes.texto_preguntas_frecuentes', 'preguntas_frecuentes.respuesta_preguntas_frecuentes');

		$query->join('core.preguntas_frecuentes', 'faq_convocatoria.codigo_preguntas_frecuentes', '=', 'preguntas_frecuentes.codigo_preguntas_frecuentes');
		$query->join('core.convocatoria', 'faq_convocatoria.codigo_convocatoria', '=', 'convocatoria.codigo_convocatoria');

		$query->join('core.convocatoria_institucion', function($join) {
       		$join->on('convocatoria.codigo_convocatoria', '=', 'convocatoria_institucion.codigo_convocatoria')
				->where('convocatoria_institucion.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('convocatoria_institucion.codigo_estado', '=', Estado::getState('active'));
      	});

		$query-> where('faq_convocatoria.codigo_convocatoria', $program);
		$query-> where('convocatoria.codigo_estado', Estado::getState('active'));
		$query-> where('preguntas_frecuentes.codigo_estado', Estado::getState('active'));

   		$query->orderBy('preguntas_frecuentes.codigo_preguntas_frecuentes','asc');
		// Get total posts
		$total_entries = $query->get()->count();

		// Get posts
		$data = $query->skip(Input::get('offset'))->take(Input::get('limit'))->get();

		if(count($data) > 0) {
			foreach ($data as $faq) {
				$faqprograms[] = FaqConvocatoria::buildFaqProgram($faq);
			}
		}

		$response = new \stdClass();
		$response->total_entries = $total_entries;
		$response->items = $faqprograms;
   		return $response;
   	}

   	/**
	* Build FaqProgram.
	*/
   	public static function buildFaqProgram($post)
   	{
		$object = new \stdClass();
		$object->codigo_preguntas_frecuentes = TuProyecto::encryptSrcParams([$post->codigo_preguntas_frecuentes]);
		$object->texto_preguntas_frecuentes = $post->texto_preguntas_frecuentes;
		$object->respuesta_preguntas_frecuentes = $post->respuesta_preguntas_frecuentes;
		return $object;
   	}
}
